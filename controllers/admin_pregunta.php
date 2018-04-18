<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Admin_Pregunta extends Admin_Controller {
	protected $section='preguntas';
	public function __construct()
	{
		parent::__construct();
		$this->lang->load('cuestionario');
		$this->load->model(array('pregunta_m','opciones_m','cuestionario_m'));
		$this->rules = array(
				
					array(
						'field' => 'titulo',
						'label' => 'Titulo',
						'rules' => 'trim|required'
						),
					array(
						'field' => 'obligatorio',
						'label' => 'Obligatorio',
						'rules' => 'trim|required'
						),
					array(
						'field' => 'tipo',
						'label' => 'Tipo',
						'rules' => 'trim|required'
						),
					array(
						'field' => 'option',
						'label' => 'Opciones',
						'rules' => 'callback__verify_option'
						)
		);
		$this->template->set_breadcrumb('Cuestionarios','cuestionario');
	}
	function _verify_option($option)
	{
		$error=false;
		if(!$option)
		{
			$this->form_validation->set_message('_verify_option','La pregunta debe tener al menos una Respuesta');
			return false;
		}
		
		foreach($option as $row)
		{
			if($row['respuesta']=='')
			{
				$error=true;
				
				break;
			}
		}
		
		
		if($error)
		{
			$this->form_validation->set_message('_verify_option','Los campos de Respuestas no deben estar en blanco');
			
			return false;
		}
		else
			return true;
	}
	function sorter($id_cuestionario=false){
		$i = 0;
		$ids=explode(',',$this->input->post('order'));
		
		foreach($ids as $id)
		{
			$this->pregunta_m->update_order($id,$i++);
		}
	
	}
    function index()
    {
        
    }
	function load($id_cuestionario=false,$page=1)
	{
		if(!$cuestionario=$this->cuestionario_m->get($id_cuestionario))
		{
			$this->session->set_flashdata('error','Los datos del cuestionario no estan disponibles o fue borrada');
			redirect('cuestionario');
		}
		$preguntas=$this->pregunta_m->order_by('ordering')
				->get_many_by(array('id_cuestionario'=>$id_cuestionario));
				
		$this->template->title($this->module_details['name'])
			->set_breadcrumb('Preguntas  para '.$cuestionario->titulo)
			->enable_parser(true)
			//->append_css('module::pregunta.css')
			//->append_js('jquery.ui.accordion.js')
			//->append_js('module::pregunta/form.js')	
			
			//->append_js('validate.js')			
			->set('preguntas',$preguntas)
			->set('id_cuestionario',$id_cuestionario)
			->set('cuestionario',$cuestionario)
			->build('admin/pregunta/index');
	}
	
	function edit($id=false){
		if(!$pregunta=$this->pregunta_m->get($id))
		{
		}
	
		$this->form_validation->set_rules($this->rules);
		if($this->form_validation->run())
		{
			if($this->pregunta_m->update($id,$this->input->post()))
			{
				$this->session->set_flashdata('success','Pregunta modificada satisfactoriamente');
				echo 'success';
			}
			else
			{
				$this->session->set_flashdata('error','Error al tratar de agregar la pregunta');
				echo 'error';
			}
			return;
		}
		if (validation_errors())
		{
			echo $this->load->view('admin/partials/notices');
			return;
		}
		$this->template->set_layout('modal')
					->append_js('module::pregunta/form.js')
					->set('buttons',array('cancel','save'))
					->set('pregunta',$pregunta)
					->set('id_cuestionario',$pregunta->id_cuestionario)
					->build('admin/pregunta/form');

	}
	function eliminar($id=false){
		if(!$pregunta = $this->pregunta_m->get($id))
		{
			$this->session->set_flashdata('error','Los datos de la pregunta no estan disponibles o fue borrada');
			redirect('admin/cuestionario');
		}
		if($this->pregunta_m->eliminar($id))
		{
			$this->session->set_flashdata('success','La pregunta ha sido eliminada satisfactoriamente');
			redirect('admin/pregunta/'.$pregunta->IdCuestionario);
		}
		else
		{
			$this->session->set_flashdata('success','Error al tratar de eliminar la pregunta');
			redirect('admin/pregunta/'.$pregunta->IdCuestionario);
		}
	}
	function save()
	{
		$this->form_validation->set_rules($this->rules);
		if($this->form_validation->run())
		{
			$this->pregunta_m->create($this->input->post());
		}
		if (validation_errors())
		{
			echo $this->load->view('admin/partials/notices');
			return;
		}
		//echo json_encode(array('status'=>'error','message'=>'<div class="alert alert-important">Error</div>'));
	}
	function create($id_cuestionario=0)
	{
		$pregunta=new StdClass();
		$this->form_validation->set_rules($this->rules);
		if($this->form_validation->run())
		{
			$_POST['id_cuestionario']=$id_cuestionario;
			
			if($this->pregunta_m->create($this->input->post()))
			{
				$this->session->set_flashdata('success','Pregunta agregada satisfactoriamente');
				echo 'success';
			}
			else
			{
				$this->session->set_flashdata('error','Error al tratar de agregar la pregunta');
				echo 'error';
			}
			return;
		}
		if (validation_errors())
		{
			echo $this->load->view('admin/partials/notices');
			return;
		}
		foreach ($this->rules as $rule)
		{
			$pregunta->{$rule['field']} = $this->input->post($rule['field']);
		}
		$this->template
					->append_js('module::pregunta/form.js')
					->set('buttons',array('cancel','save'))
					->set('id_cuestionario',$id_cuestionario)
					->set('pregunta',$pregunta)
					->build('admin/pregunta/form');
	}
	function delete($id=0)
	{
		if(!$pregunta=$this->pregunta_m->get_by(array('id'=>$id)))
		{
			
			$this->session->set_flashdata('error','La pregunta no existe o fue borrada');
			redirect('admin/cuestionario');
		}
	
		if($this->pregunta_m->delete($id))
		{
			$this->session->set_flashdata('success','La pregunta ha sido borrada satisfactoriamente y sus componentes');
			redirect('admin/cuestionario/pregunta/'.$pregunta->id_cuestionario);
		}
		else
		{
			$this->session->set_flashdata('error','Error al tratar de eliminar la pregunta y sus componentes');
			redirect('admin/cuestionario/pregunta/'.$pregunta->id_cuestionario);
		}
		
		
	}
}
?>