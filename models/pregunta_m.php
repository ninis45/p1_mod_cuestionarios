<?php defined('BASEPATH') or exit('No direct script access allowed');

class Pregunta_m extends MY_Model {

	private $folder;

	public function __construct()
	{
		parent::__construct();
		$this->_table = 'cat_preguntas';
		
	}
	function delete($id=0)
	{
		$this->db->trans_start();
		
		$this->db->where('id',$id)->delete('cat_cuestionario_pregunta');
		
		$this->db->where('id_pregunta',$id)->delete('cat_cuestionario_opciones');
		$this->db->trans_complete();

		return (bool) $this->db->trans_status();
	}
	function delete_many($ids='')
	{
		/*$preguntas=$this->pregunta_m->where_in('IdCuestionario',$ids)->get_all();
		if($preguntas)
		{
			foreach($preguntas as $row)
			{
				if($this->db->where(array('IdPregunta'=>$row->Id))->delete('cat_opciones')){
					return false;
					break;
				}
			}
		}
		if(!$this->db->where_in('IdCuestionario',$ids)->delete('cat_pregunta'))
			return false;
		return true;*/
		//return $this->where_in('Id',$ids)->delete('cat_cuestionario');
		
	}
	
	function create($input)
	{
		$this->db->trans_start();
		
		$id=$this->insert(array(
				'id_cuestionario' => $input['id_cuestionario'],
				'titulo'          => $input['titulo'],
				'obligatorio'     => $input['obligatorio'],
				'tipo'            => $input['tipo'],
			));
	    
		if ( ! $id) return false;

		

		
		$input['id_pregunta'] = $id;
		
		$this->opciones_m->create($input);
		
		$this->db->trans_complete();

		return ($this->db->trans_status() === false) ? false : $id;
	}
	function update_order($id=0,$order=0)
	{
		$this->db->where('id', $id);

		return $this->db->update('cat_cuestionario_pregunta', array(
        	'order' => (int) $order
		));
	}
	function get($id=0)
	{
		if($result=$this->get_by('id',$id))
		{
			
			//$result->opciones=$this->db->order_by('id','desc')->where('id_pregunta',$id)->get('cat_cuestionario_opciones')->result();
			return $result;
		}
		return false;
		
	}
	/*function update($id,$input)
	{
		$this->db->trans_start();
		
		$result=parent::update($id,array(
			
				'titulo'          => $input['titulo'],
				'obligatorio'     => $input['obligatorio'],
				'tipo'            => $input['tipo'],
			));
	    
		if ( ! $result) return false;
		
		$input['id_pregunta'] = $id;
		
		$this->opciones_m->create($input);
		
		$this->db->trans_complete();

		return (bool) $this->db->trans_status();
	}*/
	
	
}
?>