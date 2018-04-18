<?php defined('BASEPATH') OR exit('No direct script access allowed');
function get_badge_pregunta($id_cuestionario=0){
	$Ci = & get_instance();
	//$Ci->load->model('pregunta/pregunta_m');
	$class='label label-default';
	//$num=$Ci->pregunta_m->count_by(array('IdCuestionario'=>$id_cuestionario));
	$num=$Ci->db->where('id_cuestionario',$id_cuestionario)->count_all_results('cat_preguntas');

	if($num>0)
		$class.=' label-default';
    return '<span class="'.$class.'">'.$num.'</span>';
	//return '<a href="'.base_url('admin/cuestionarios/preguntas/'.$id_cuestionario).'" class="'.$class.'">'.$num.'</a>';
}
?>