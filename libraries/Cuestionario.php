<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * PyroCMS File library. 
 *
 * This handles all file manipulation 
 * both locally and in the cloud
 * 
 * @author		Jerel Unruh - PyroCMS Dev Team
 * @package		PyroCMS\Core\Modules\Files\Libraries
 */
class Cuestionario
{
    public function __construct()
	{
	   ci()->load->model('pregunta_m');
    }
    
    public static function SavePreguntas($id_cuestionario,$preguntas = array())
    {
        
        if(empty($preguntas) == false)
        {
            $ids_pregunta = array();
            foreach($preguntas  as $pregunta)
            {
                $data_pregunta = array(
                    'id_cuestionario' => $id_cuestionario,
                    'titulo'          => $pregunta['titulo'],
                    'tipo'            => $pregunta['tipo'],
                    'obligatorio'     => $pregunta['obligatorio'],
                    'muestra'         => $pregunta['muestra']
                    //'ordering'        => now()
                 );
                 
                 if($pregunta['id'] && ci()->pregunta_m->get($pregunta['id']))
                 {
                    $ids_pregunta[] = $pregunta['id'];
                    ci()->db->set($data_pregunta)->where('id',$pregunta['id'])
                                ->update('cat_preguntas');
                 }
                 else
                 {
                    $data_pregunta['ordering'] = now();
                    $ids_pregunta[]   =   $pregunta['id']       = ci()->pregunta_m->insert($data_pregunta);
                    
                 }
                 /*if($data_pregunta['tipo'] == 'text')
                 {
                    unset($pregunta['opciones']);
                 }*/
                 
                 $pregunta['id'] AND ci()->db->where('id_pregunta',$pregunta['id'])
                            //->where('id_cuestionario',$id_cuestionario)
                            ->delete('cat_pregunta_opciones');
                            
                 if(empty($pregunta['opciones']) == false && $pregunta['tipo']!= 'text' )
                 {
                    $ids_opciones = array(0);
                    foreach($pregunta['opciones'] as $opcion)
                    {
                        $data_opcion = array(
                            'id_pregunta' => $pregunta['id'],
                            'respuesta'   => $opcion['respuesta'],
                            'valor'       => $opcion['valor']?$opcion['valor']:0,
                            'correcta'    => isset($opcion['correcta'])?($opcion['correcta']?1:0):0,
                            

                        );
                        /*if($opcion['id']  && ci()->db->where('id',$opcion['id'])->get('cat_pregunta_opciones'))
                        {
                            $ids_opciones[] = $opcion['id'];
                            ci()->db->where('id',$opcion['id'])
                                    ->set($data_opcion)
                                    ->update('cat_pregunta_opciones');
                        }
                        else
                        {*/
                           // print_r($data_opcion);
                            ci()->db->set($data_opcion)->insert('cat_pregunta_opciones');
                            $ids_opciones[] = ci()->db->insert_id();
                        //}
                        
                        
                    }
                    
                    //Eliminar opciones
            
                     ci()->db->where_not_in('id',$ids_opciones)
                            ->where('id_pregunta',$pregunta['id'])
                            ->delete('cat_pregunta_opciones');
                 }
                
                
            }
            //Eliminar preguntas del contenedor
            ci()->db->where('id_cuestionario',$id_cuestionario)
                            ->where_not_in('id',$ids_pregunta)
                            ->delete('cat_preguntas');
                            
            //Eliminar opciones
            
             //ci()->db->where_not_in('id_pregunta',$ids_pregunta)
               //            ->delete('cat_pregunta_opciones');
        }
        return false;
    }
}
?>