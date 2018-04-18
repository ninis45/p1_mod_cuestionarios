<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Admin_Diagnostico extends Admin_Controller {
	protected $section='diagnostico';
	public function __construct()
	{
		parent::__construct();
		
		$this->lang->load('cuestionario');
		$this->load->model(array('cuestionario_m','pregunta_m','diagnostico_m'));
		
		$this->template->set_breadcrumb('Cuestionarios','cuestionario')
			->set_breadcrumb('Diagnosticos');
		$this->rules = array(
				
					array(
						'field' => 'titulo',
						'label' => 'Titulo',
						'rules' => 'trim|required'
						),
					array(
						'field' => 'color',
						'label' => 'Color',
						'rules' => 'trim|required'
						),
					
					array(
						'field' => 'id_cuestionario',
						'label' => 'Cuestionario',
						'rules' => 'integer'
						)
		);
		
		$this->input->is_ajax_request() AND $this->template->set_layout(FALSE);

	}
	public function index()
	{
		$cuestionarios=$this->cuestionario_m->get_many_by(array('tipo'=>'Diagnostico'));
		$this->template->title($this->module_details['name'])
			->set('cuestionarios',$cuestionarios)	
			->build('admin/diagnostico/index');
	}
	function config($id=0)
	{
		
		$diagnosticos=$this->diagnostico_m->get_many($id);
		
		$preguntas=array(
				'all'=> $this->pregunta_m->get_many_by(array('id_cuestionario'=>$id)),
				'no_draggables'=> array_for_select($this->pregunta_m->join('cuestionario_relacion','cuestionario_relacion.id_pregunta=cat_cuestionario_pregunta.id')->get_many_by(array('id_cuestionario'=>$id)),'id_pregunta','id_pregunta')
		);
		
		$this->input->is_ajax_request() and $this->template->set_layout(FALSE);
		
		$this->input->is_ajax_request()
			? $this->template
				->set('diagnosticos',$diagnosticos)
				->set('preguntas',$preguntas)
				->build('admin/diagnostico/ajax/list_diagnostico')
			: $this->template->title($this->module_details['name'])
		    ->append_js('bootstrap-colorpicker.min.js')
			->append_metadata('<script type="text/javascript">var id_cuestionario='.$id.';</script>')
			->enable_parser(true)
			->set('diagnosticos',$diagnosticos)
			->set('preguntas',$preguntas)
			->set('id_cuestionario',$id)
			->append_css('colorpicker.css')
			->append_js('module::diagnostico/form.js')
			->append_css('module::diagnostico.css')
			->build('admin/diagnostico/form');
	}
	function create($id=0)
	{
		$this->form_validation->set_rules($this->rules);
		if($this->form_validation->run())
		{
			if($id=$this->diagnostico_m->create($this->input->post()))
			{
				$status='success';
				$message='Diagnostico agregado correctamente';
				
				
			}
			else
			{
				$status='error';
				$message='Error al tratar de agregar el registro';
				
				
			}
			
		}
		elseif (validation_errors())
		{
			$status='error';
			$message=$this->load->view('admin/partials/notices',false,true);
			
			return $this->template->build_json(array(
					'status'	=> $status,
					'message'	=> $message
			));
		}
		$data['messages'][$status] = $message;
		$message = $this->load->view('admin/partials/notices', $data, TRUE);
		
		return $this->template->build_json(array(
					'status'	=> $status,
					'message'	=> $message,
					'data'		=> $status=='success'?array('id'=>$id,'titulo'=>$this->input->post('titulo')):false,
					'html'      => $status=='success'?'<div class="panel panel-default"><div class="panel-heading"><h4 class="panel-title box" data-color="'.$this->input->post('color').'" data-titulo="'.$this->input->post('titulo').'" ><a data-toggle="collapse" data-parent="#accordion-diagnostic" href="#collapse'.$id.'">'.$this->input->post('titulo').'</a><div class="action-buttons pull-right" ><a href="'.base_url('admin/cuestionario/diagnostico/edit/'.$id).'" class="btn-edit"><i class="icon-edit"></i></a> <a class="btn-delete-diagnostico" href="'.base_url('admin/cuestionario/diagnostico/delete/'.$id).'" ><i class="icon-trash"></i></a></div></h4></div><div id="collapse'.$id.'" class="panel-collapse collapse area-diagnostic"><div class="panel-body list-diagnostic" id="ui_'.$id.'"><ul data-diagnostico="'.$id.'"><li class="empty-drop-item no-sortable"></li></ul> </div></div>':''
					
				));
	}
	function list_items($id=0)
	{
		$items=$this->pregunta_m->join('cuestionario_relacion','cuestionario_relacion.id_pregunta=cat_cuestionario_pregunta.id')
							->get_many_by(array('cuestionario_relacion.id_diagnostico'=>$id));
		
		
		$this->template->set('items',$items)
			->build('admin/pregunta/ajax/list_question');
	}
	function add()
	{
		$data=array(
			'id_pregunta' => $this->input->post('id_pregunta'),
			'id_diagnostico' => $this->input->post('id_diagnostico')
		);
		
		if($data['id_pregunta'] && $data['id_diagnostico'])
		{			
			
			if($this->pregunta_m->join('cuestionario_relacion','cuestionario_relacion.id_pregunta=cat_cuestionario_pregunta.id')->get_by(array('id_pregunta'=>$data['id_pregunta'])))
			{
				$data['messages']['error']='Error al tratar de agregar la pregunta, talvez se encuentra agregada';
				
				$message = $this->load->view('admin/partials/notices', $data, TRUE);
				
				return $this->template->build_json(array(
					'status'	=> 'error',
					'message'	=> $message,
				
				));
			}
			if($this->db->insert('cuestionario_relacion',$data))
			{
				echo 'success';
			}
		}
	}
	function edit($id=0)
	{
		$this->form_validation->set_rules($this->rules);
		if($this->form_validation->run())
		{
			if($this->diagnostico_m->update($id,$this->input->post()))
			{
				$status='success';
				$message='Diagnostico modificado correctamente';
				
				
			}
			else
			{
				$status='error';
				$message='Error al tratar de modificar el registro';
				
				
			}
			
		}
		elseif (validation_errors())
		{
			$status='error';
			$message=$this->load->view('admin/partials/notices',false,true);
			
			
		}
		
		$data['messages'][$status] = $message;
		$message = $this->load->view('admin/partials/notices', $data, TRUE);
		
		return $this->template->build_json(array(
					'status'	=> $status,
					'message'	=> $message,
					'data'		=> $status=='success'?array('id'=>$id,'titulo'=>$this->input->post('titulo'),'color'=>$this->input->post('color')):false,
					'html'      => $status=='success'?'<h4 class="panel-title box" data-titulo="'.$this->input->post('titulo').'" data-color="'.$this->input->post('color').'" ><a href="#collapse'.$id.'" data-parent="#accordion-diagnostic" data-toggle="collapse">'.$this->input->post('titulo').'</a><div class="action-buttons pull-right" ><a href="'.base_url('admin/cuestionario/diagnostico/edit/'.$id).'" class="btn-edit"><i class="icon-edit"></i></a> <a href="#" ><i class="icon-trash"></i></a></div></h4>':false
 				
					
				));
	}
	function delete($id=0)
	{
		if($this->diagnostico_m->delete($id))
		{
			$status = 'success';
			$message = 'El diagnostico y sus componentes han sido eliminados satisfactoriamente';
		}
		else
		{
			$status = 'error';
			$message = 'Error al tratar de eliminar el diagnostico';
			
		}
		$data['messages'][$status] = $message;
		$message = $this->load->view('admin/partials/notices', $data, TRUE);
		
		return $this->template->build_json(array(
					'status'	=> $status,
					'message'	=> $message,));
	}
	function delete_item($id=0)
	{
		$this->db->where('id',$id)->delete('cuestionario_relacion');
		echo 'success';
	}
	
}
?>