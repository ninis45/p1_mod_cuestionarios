<?php defined('BASEPATH') or exit('No direct script access allowed');

class Cuestionario_m extends MY_Model {

	private $folder;

	public function __construct()
	{
		parent::__construct();
		$this->_table = 'cat_cuestionarios';
		
	}
    function get_cuestionario($id=0)
    {
        $cuestionario = $this->get($id);
        if($cuestionario)
        {
            $cuestionario->campos    = $cuestionario->campos?json_decode($cuestionario->campos):array();
            $cuestionario->preguntas = $this->db->where('id_cuestionario',$id)
                                        ->order_by('ordering')
                                        ->get('cat_preguntas')->result();
                                        
            foreach($cuestionario->preguntas as &$pregunta)
            {
                $pregunta->opciones = $this->db->where('id_pregunta',$pregunta->id)
                                            ->get('cat_pregunta_opciones')->result();
            }
            return $cuestionario;
        }
        return false;
    }
	function delete_many($ids)
	{
		
		
		$preguntas=$this->pregunta_m->where_in('IdCuestionario',$ids)->get_all();
		if($preguntas)
		{
			foreach($preguntas as $row)
			{
				//Eliminamos las opciones
				$this->db->where(array('IdPregunta'=>$row->Id))->delete('cat_opciones');
				
				//Eliminamos la pregunta
				$this->db->where(array('Id'=>$row->Id))->delete('cat_pregunta');
					
			}
		}
		if(!$this->db->where_in('Id',$ids)->delete('cat_cuestionario'))
			return false;
		return true;
	}
	/*function update($id=0,$input)
	{
		return parent::update($id,array(
			   		'nombre'      => $input['nombre'],
					'slug'        => $input['slug'],
					'descripcion' => $input['descripcion'],
					'id_proyecto' => $input['id_proyecto'],
					'campos'      =>isset($input['campos'])? json_encode($input['campos']):NULL,
					'tipo'        => $input['tipo'],
                    'publicar'    => $input['publicar']
			   ));
	}*/
	function create2($input)
	{
		$this->db->trans_start();
		
		
		
		$id=$this->insert(array(
				'titulo'      => $input['nombre'],
				'slug'        => $input['slug'],
				'descripcion' => $input['descripcion'],
				
				'campos_habilitados'      =>isset($input['campos_habilitados'])? json_encode($input['campos_habilitados']):NULL,
				'tipo'        => $input['tipo'],
                'publicar'    => $input['publicar']
			));
		
		if ( ! $id) return false;
		
		
		$this->db->trans_complete();

		return ($this->db->trans_status() === false) ? false : $id;
	}
    
    /*
	function get($id=0)
	{
		if($result=$this->db->where('id',$id)->get('cat_cuestionario')->row())
		{
			
			$result->campos=$result->campos?json_decode($result->campos):array();
			
			return $result;
		}
		return false;
		
	}
	
	function modificar($id=false,$dato=array()){
		if(is_numeric($id)&&count($dato)>0){
			$dato['Campos'][]='Fecha Aplicacion';
			$dato['Campos']=isset($dato['Campos'])?json_encode($dato['Campos']):'';
			return $this->update($id,$dato);
		}
		return false;
	}*/
}
?>