<?php defined('BASEPATH') or exit('No direct script access allowed');

class Opciones_m extends MY_Model {

	private $folder;

	public function __construct()
	{
		parent::__construct();
		$this->_table = 'cat_cuestionario_opciones';
		
	}
	function create($input)
	{
		$this->delete_by('id_pregunta',$input['id_pregunta']);
		foreach($input['option'] as $row)
		{
			$this->insert(array(
				'id_pregunta'=> $input['id_pregunta'],
				'respuesta'=> $row['respuesta'],
				'marcado'=> $row['marcado'],
			));
			
		}
		return true;
	}
	function agregar($respuestas=array(),$marcados=array(),$id_pregunta=false){
		$band=true;
		
		if(is_numeric($id_pregunta)){
			for($i=0;$i<count($respuestas);$i++){
				$dato["Marcado"]='No';
				$dato["Respuesta"]=$respuestas[$i];
				if(is_array($marcados)&& in_array($i,$marcados))
					$dato["Marcado"]="Si";
				$dato["IdPregunta"]=$id_pregunta;
				if($band && !$this->insert($dato))
					$band=false;
					
			}
			return $band;
		}else
			return false;
	}
	function modificar($respuestas=array(),$marcados=array(),$id_pregunta=false){
		$band=true;
		
		if(is_numeric($id_pregunta)){
			$this->delete_by(array('IdPregunta'=>$id_pregunta));
			for($i=0;$i<count($respuestas);$i++){
				$dato["Marcado"]='No';
				$dato["Respuesta"]=$respuestas[$i];
				if(is_array($marcados)&& in_array($i,$marcados))
					$dato["Marcado"]="Si";
				
				$dato["IdPregunta"]=$id_pregunta;
				if($band && !$this->insert($dato))
					$band=false;
					
			}
			return $band;
		}else
			return false;
	}
	
	
}
?>