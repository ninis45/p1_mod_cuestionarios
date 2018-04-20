<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Admin extends Admin_Controller {
	protected $section='cuestionarios';
	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('cuestionario_m'));
		$this->lang->load('cuestionario');
		$this->load->helper('cuestionarios/pregunta');
        $this->load->library('Cuestionario');
		$this->rules = array(
			array(
				'field' => 'titulo',
				'label' => 'Nombre',
				'rules' => 'trim|required'
				),
			array(
				'field' => 'tipo',
				'label' => 'Tipo',
				'rules' => 'required'
				),
		
		
			
            array(
				'field' => 'slug',
				'label' => 'Slug',
				'rules' => 'trim|required'
				),
            array(
				'field' => 'descripcion',
				'label' => 'Descripcion',
				'rules' => 'trim'
				),
            array(
				'field' => 'publicar',
				'label' => 'Publicar',
				'rules' => 'trim|integer|required'
				),                
			array(
				'field' => 'preguntas',
				'label' => 'Preguntas',
				'rules' => ''
				),
            array(
				'field' => 'campos',
				'label' => 'Campos',
				'rules' => ''
				)
		);
		$this->template->set_breadcrumb('Cuestionarios','cuestionario');
	}
	function index(){
		$this->load();
	}
	function load($page=1){
		
		$this->template->title($this->module_details['name'])
			->set('items',$this->cuestionario_m->get_all())
			->set('pagination',false)
			->build('admin/index');
	}
	function eliminar($id=0){
		role_or_die('cuestionario', 'delete');
		$ids = ($id) ? $id : $this->input->post('action_to');
		//Verificar que el cuestionario no este asignado a alguna encuesta
		if($encuestas=$this->encuesta_m->where_in('IdCuestionario',$ids)->get_all())
		{
			$this->session->set_flashdata('error','Error al tratar de eliminar el(los) cuestionario(s), favor de verificar que no se encuentre asignado a alguna encuesta.');
			redirect('admin/cuestionario');
		}
		if($this->cuestionario_m->delete_many($ids))
		{
			$this->session->set_flashdata('success','El cuestionario ha sido eliminado satisfactoriamente');
			redirect('admin/cuestionario');
		}
		else
		{
			$this->session->set_flashdata('error','Error al tratar de eliminar el cuestionario');
			redirect('admin/cuestionario');
		}
	}
	function create(){
		$cuestionario=new StdClass();
		$this->form_validation->set_rules($this->rules);
		if($this->form_validation->run()){
			unset($_POST['btnAction']);
            
            $data = array(
                'titulo'    => $this->input->post('titulo'),
                'tipo'      => $this->input->post('tipo'),
                'slug'      => $this->input->post('slug'),
                'publicar'  => $this->input->post('publicar'),
                'descripcion' => $this->input->post('descripcion'),
                'campos'      => $this->input->post('campos')?json_encode($this->input->post('campos')):null,
            );
            
			if($id=$this->cuestionario_m->insert($data))
			{
				Cuestionario::SavePreguntas($id,$this->input->post('preguntas'));    
				$this->session->set_flashdata('success','El cuestionario ha sido agregado satisfactoriamente');
				redirect('admin/cuestionarios/edit/'.$id);
			}
			else
			{
				$this->session->set_flashdata('error','Error al tratar de guardar los datos del  cuestionario');
				redirect('admin/cuestionarios/create');
			}
		}
		foreach ($this->rules as $rule)
		{
		    
			$cuestionario->{$rule['field']} = $this->input->post($rule['field']);
            if(!$_POST)
            {
                $cuestionario->campos = array();
            }
		}
		$this->template->set_partial('buttons','partials/buttons',array('buttons'=>array('create','cancel')))
			->set_breadcrumb('Agregar cuestionario','admin/cuestionario/create')
			->title($this->module_details['name'],'Agregar cuestionario')
             ->append_metadata('<script type="text/javascript">var preguntas='.($cuestionario->preguntas?json_encode($cuestionario->preguntas):'[]').';</script>')	
			->append_js('module::cuestionario.directive.js')
            ->append_js('module::cuestionario.controller.js')
            ->append_css('module::pregunta.css')
			->set('cuestionario',$cuestionario)
			->build('admin/form');
	}
	function edit($id=0){
		
		if(!$cuestionario = $this->cuestionario_m->get_cuestionario($id))
		{
			$this->session->set_flashdata('error','Los datos del  cuestionario no estan disponibles o fue borrada');
			redirect('admin/cuestionario');
		}
		
		$this->form_validation->set_rules($this->rules);
		
		if($this->form_validation->run()){
			unset($_POST['btnAction']);
            $data = array(
                'titulo'    => $this->input->post('titulo'),
                'tipo'      => $this->input->post('tipo'),
                'slug'      => $this->input->post('slug'),
                'publicar'  => $this->input->post('publicar'),
                'descripcion' => $this->input->post('descripcion'),
                'campos'      => $this->input->post('campos')?json_encode($this->input->post('campos')):null,
            );
			if($this->cuestionario_m->update($id,$data))
			{
			 
                
			     Cuestionario::SavePreguntas($id,$this->input->post('preguntas'));    
			 
				$this->session->set_flashdata('success',lang('cuestionario:save_success'));
				redirect('admin/cuestionarios/edit/'.$id);
			}
			else
			{
				$this->session->set_flashdata('error',lang('global:save_error'));
				redirect('admin/cuestionarios/create');
			}
		}
		if($_POST)
		{
			$cuestionario=(object)$_POST;
			
		}
		
		$this->template->set_partial('buttons','partials/buttons',array('buttons'=>array('save','cancel')))
			->set_breadcrumb('Modificar cuestionario')
			->title($this->module_details['name'],'Modificar cuestionario')	
            ->append_metadata('<script type="text/javascript">var preguntas='.json_encode($cuestionario->preguntas).';</script>')
			->append_js('module::cuestionario.controller.js')
            ->append_css('module::pregunta.css')
			->set('cuestionario',$cuestionario)
			->build('admin/form',false);
	}
	function operacion()
	{
		
		switch ($this->input->post('btnAction'))
		{
			case 'publish':
				$this->publish();
			break;
			
			case 'eliminar':
				$this->eliminar();
			break;
			
			default:
				redirect('dependencia');
			break;
		}
	}
    
    function order()
    {
        
        $order       = $this->input->post('order');
        $result=array(
            'status'  => true,
            'message' => ''
        );
        if(is_array($order))
        {
            foreach($order as $i=>$item)
            {
                if(!$item)
                {
                    $result['message'] = lang('pregunta:order_error');
                    $result['status'] = false;
                   
                    return $this->template->build_json($result);
                    exit();
                }
                $this->db->where(array(
                    'id'=>$item,
                    
                    
                ))->set(array('ordering'=>$i))
                ->update('cat_preguntas');
            }
            $result['message'] = lang('pregunta:order_success');
        }
        else
        {
            $result['status'] = false;
            $result['message'] = lang('pregunta:order_error');
        }
        
        return $this->template->build_json($result);
    }
}
?>