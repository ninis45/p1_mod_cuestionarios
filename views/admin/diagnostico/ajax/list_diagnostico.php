<?php if($diagnosticos):?>
	 <?php foreach($diagnosticos as $row){?>
      <div class="panel panel-default">
         <div class="panel-heading">
            <h4 class="panel-title box" data-titulo="<?=$row->titulo?>" data-descripcion="<?=$row->descripcion?>" data-color="<?=$row->color?>"><a data-toggle="collapse" data-parent="#accordion-diagnostic" href="#collapse<?=$row->id?>"><?=$row->titulo?></a><div class="action-buttons pull-right" ><a href="<?=base_url('admin/cuestionario/diagnostico/edit/'.$row->id)?>" class="btn-edit"><i class="icon-edit"></i></a> <a href="<?=base_url('admin/cuestionario/diagnostico/delete/'.$row->id)?>" class="btn-delete-diagnostico" ><i class="icon-trash"></i></a></div></h4>
            
         </div>
         <div id="collapse<?=$row->id?>" class="panel-collapse collapse area-diagnostic">
            <div class="panel-body list-diagnostic" id="ui_<?=$row->id?>">
                <ul data-diagnostico="<?=$row->id?>" >
                    <?php foreach($row->preguntas as $row_question){?>
                        <li class="item" data-pregunta="<?=$row_question->id_pregunta?>" data-id="<?=$row_question->id?>"><span><?=$row_question->titulo?></span><button type="submit" class="pull-right btn btn-mini btn-delete confirm" value="delete">Eliminar</button></li>
                       
                    <?php }?>
                     <li class="empty-drop-item no-sortable"></li>
                </ul>
             </div>
         </div>
      </div>
      <?php }?>
<?php else:?>
	<div class="alert alert-info">
    	Al parecen no hay dianosticos, agrega al menos uno para que tenga validez el cuestionario
    </div>
<?php endif;?>