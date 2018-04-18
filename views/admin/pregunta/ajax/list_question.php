<?php foreach($items as $row_question){?>
  <li class="item" data-pregunta="<?=$row_question->id_pregunta?>" data-id="<?=$row_question->id?>"><span><?=$row_question->titulo?></span><button type="submit" class="pull-right btn btn-mini btn-delete confirm" value="delete">Eliminar</button></li>
 
<?php }?>
<li class="empty-drop-item no-sortable"></li>