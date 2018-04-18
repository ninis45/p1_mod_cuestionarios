<?php defined('BASEPATH') or exit('No direct script access allowed');

class Diagnostico_m extends MY_Model {

	private $folder;

	public function __construct()
	{
		parent::__construct();
		$this->_table = 'cuestionario_diagnostico';
		
	}
	function create($input)
	{
		return $this->insert(array(
			   		'color' => $input['color'],
					'titulo' => $input['titulo'],
                    'descripcion' => $input['descripcion'],
					'id_cuestionario'=>$input['id_cuestionario'],
                    
			   ));
	}
	function update($id=0,$input='')
	{
		return parent::update($id,array(
			   		'color' => $input['color'],
					'titulo' => $input['titulo'],
                    'descripcion' => $input['descripcion'],
					
			   ));
	}
	function get_many($id_cuestionario=0)
	{
		$result=$this->get_many_by(array('id_cuestionario'=>$id_cuestionario));
		
		foreach($result as &$row)
		{
			$row->preguntas=$this->db->select('*,cuestionario_relacion.id AS id')->where('id_diagnostico',$row->id)->join('cat_cuestionario_pregunta','cat_cuestionario_pregunta.id=cuestionario_relacion.id_pregunta')->get('cuestionario_relacion')->result();
		}
		
		return $result;
	}
	function delete($id=0)
	{
		$this->db->trans_start();
		
		$this->db->where('id_diagnostico',$id)->delete('cuestionario_relacion');
		$this->db->where('id',$id)->delete('cuestionario_diagnostico');
		
		$this->db->trans_complete();

		return ($this->db->trans_status() !== false) ? $id : false;
	}
}
?>