<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Blog module
 *
 * @author PyroCMS Dev Team
 * @package PyroCMS\Core\Modules\Blog
 */
class Module_Cuestionarios extends Module {

	public $version = '1.0';

	public function info()
	{
		return array(
			'name' => array(
				'es' => 'Cuestionarios',
				'en' => 'Questions'
				
			),
			'description' => array(
				'es' => 'Administración de herramientas para la recopilacion de datos estadisticos a través de preguntas',
				'en' => 'Management tools for the collection of statistical data through questions'
				
			),
			'frontend'	=> true,
			'backend'	=> true,
			'skip_xss'	=> true,
			'menu'		=> 'content',

			'roles' => array(
				'create', 'edit', 'delete'
			),
            'slug'=>'cuestionarios',
			'sections' => array(
			    'cuestionarios' => array(
					'name' => 'Cuestionarios',
				    'uri' => 'admin/cuestionarios',
					'shortcuts' => array(
								array(
									'name' => 'cuestionario:create',
									'uri' => 'admin/cuestionarios/create',
									'class' => 'btn btn-mini btn-success',
									
								),
					 )
				),
			
				 /*'diagnosticos' => array(
					'name' => 'Diagnostico',
				    'uri' => 'admin/cuestionario/diagnostico',
					'shortcuts' => array(
								array(
									'name' => 'diagnostico:create',
									'uri' => $this->uri->uri_string().'#',
									'class' => 'btn btn-mini btn-danger',
									'id' =>'add-diagnostic',
									
									
								),
					 )
					
				),*/
			)
		);
	}

	public function install()
	{
		$this->dbforge->drop_table('cat_cuestionarios');
        $this->dbforge->drop_table('cat_preguntas');
        $this->dbforge->drop_table('cat_pregunta_opciones');
		

		$tables = array(
			'cat_cuestionarios' => array(
				'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true, 'primary' => true),				
				'titulo' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => false),
				'tipo' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => false),
                'descripcion' => array('type' => 'TEXT', 'null' => false),
                'slug' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => false),				
				'publicar' => array('type' => 'INT', 'constraint' => 11, 'default' => 0),
			),
            'cat_preguntas' => array(
				'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true, 'primary' => true),
                'id_cuestionario' => array('type' => 'INT', 'constraint' => 11),				
				'titulo' => array('type' => 'TEXT',  'null' => false),
                'tipo' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => false),
                'ordering'    => array('type' => 'INT', 'constraint' => 11),
                'obligatorio' => array('type' => 'INT', 'constraint' => 11),
				
			),
            'cat_pregunta_opciones' => array(
				'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true, 'primary' => true),
                'id_pregunta' => array('type' => 'INT', 'constraint' => 11),				
				'respuesta' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => false),
                'valor' => array('type' => 'INT', 'constraint' => 11, 'default' => 0),
                'correcta' => array('type' => 'INT', 'constraint' => 11, 'default' => 0),
				
			)
			
		);

		return $this->install_tables($tables);
	}

	public function uninstall()
	{
		// This is a core module, lets keep it around.
 	    $this->dbforge->drop_table('cat_cuestionarios');
        $this->dbforge->drop_table('cat_preguntas');
        $this->dbforge->drop_table('cat_pregunta_opciones');
		return true;
	}

	public function upgrade($old_version)
	{
		return true;
	}
}
?>