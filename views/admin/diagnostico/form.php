<div class="row-fluid">
	<div class="span6">
    	<div class="ui-question">
            <section class="title">
                <h3 class="grey">Preguntas</h3>
                <hr>
            </section>
            <section class="ui-question">
               
                    <ul>
                        <?php foreach($preguntas['all'] as $row){?>
                            <li id="question_<?=$row->id?>" data-id="<?=$row->id?>"  data-titulo="<?=$row->titulo?>" class="box-question<?=in_array($row->id,$preguntas['no_draggables'])?' no-sortable':''?>"><span><?=$row->titulo?></span></li>
                        <?php }?>
                    </ul>
              
           </section>
        </div>
    </div>
    <div class="span6">
    	<div class="panel-group" id="accordion-diagnostic">
             <?php $this->load->view('admin/diagnostico/ajax/list_diagnostico');?>
              
              
        </div>
    </div>
</div>
<div id="modal-diagnostico" class="modal fade" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id="myModalLabel"><?php echo $template['title']; ?> :: Detalles</h4>
        </div>
        <div class="modal-body" id="item-estatus">
        	<?php echo  form_open('','id="form-diagnostic"')?>
                    <div id="notices-modal"></div>
                    
                    <div class="control-group">
                        <label class="control-label">Color:</label> 
                        <div class="controls">
                              <input id="colorpicker1" type="text" class="input-mini" name="color" />
    
                              <span class="help-block">Permite definir el color de la barra o area</span>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Titulo:</label> 
                        <div class="controls">                  
                            <textarea class="titulo span10" rows="1" id="titulo" name="titulo"></textarea>
                        </div>
                    </div>
                    <div class="control-group">
                    
                        <label class="control-label">Descripción:</label> 
                        <div class="controls">                  
                            <textarea class="titulo span10" rows="2" id="descripcion" name="descripcion"></textarea>
                        </div>
                        
                    </div>
                    <?=form_hidden('id_cuestionario',$id_cuestionario)?>
            <?php echo form_close();?>
           
        </div>
        <div class="modal-footer">
            <div class="action-buttons">
            	
                   <button type="button" class="btn btn-default" data-dismiss="modal" value="cancel">Cancelar</button>
                   <button type="submit" class="btn btn-danger confirm" id="btn_action" value="save">Guardar</button>
               
            </div>	 
        </div>
     </div>
   </div>
</div>