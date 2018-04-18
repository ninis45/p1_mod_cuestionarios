<?php echo form_open($this->uri->uri_string(),'id="frm_question"');?>
             <div id="notices-modal"></div>
             
             <div class="ui-tab-container ui-tab-horizontal">
        
        
            	<uib-tabset justified="false" class="ui-tab">
            	        <uib-tab heading="Pregunta">
                            <div class="form-group">
                                <label>Pregunta</label>
                                <div  class="controls">
                                    <textarea class="titulo form-control" id="txtTitulo" name="titulo" ><?=$pregunta->titulo?></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Obligatorio</label>
                                <div  class="controls">
                                   
                                    <?=form_dropdown('obligatorio',array('0'=>'No','1'=>'Si'),$pregunta->obligatorio,'class="obligatorio form-control"');?>
                                </div>
                            </div>
                            <div class="control-group">
                                <label>Tipo</label>
                                <div  class="controls">
                                   
                                    <?=form_dropdown('tipo',array('checkbox'=>'Checkbox','radio'=>'Radio','text'=>'Text'),$pregunta->tipo,'class="tipo form-control"');?>
                                </div>
                            </div>
                        </uib-tab>
                        <uib-tab heading="Respuestas">
                        </uib-tab>
                 </uib-tabset>
             </div>
			 <!--div class="tabbable">

                <ul class="nav nav-tabs" id="myTab">
                    <li class="active"><a data-toggle="tab" href="#pregunta"><span><i class="icon-user"></i> Pregunta</span></a></li>
                    <li><a data-toggle="tab" href="#respuestas"><span>Respuestas</span></a></li>
                    
                   
            
                </ul>
                <div class="tab-content">
                   
                    <div class="tab-pane active" id="pregunta"> 
                        <div class="form-group">
                            <label>Pregunta</label>
                            <div  class="controls">
                                <textarea class="titulo form-control" id="txtTitulo" name="titulo" ><?=$pregunta->titulo?></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Obligatorio</label>
                            <div  class="controls">
                               
                                <?=form_dropdown('obligatorio',array('0'=>'No','1'=>'Si'),$pregunta->obligatorio,'class="obligatorio form-control"');?>
                            </div>
                        </div>
                        <div class="control-group">
                            <label>Tipo</label>
                            <div  class="controls">
                               
                                <?=form_dropdown('tipo',array('checkbox'=>'Checkbox','radio'=>'Radio','text'=>'Text'),$pregunta->tipo,'class="tipo form-control"');?>
                            </div>
                        </div>
                     </div>
                     <div class="tab-pane" id="respuestas">
                     	  <ul class="unstyled">
                     	  <?php $inc=0; if(!isset($pregunta->opciones)){?>
                             <li data-id="0">
                               <input type="checkbox" value="0"  name="marcado" class="marcado" /> <input type="text" class="respuesta" name="respuesta" value="" placeholder="Respuesta"/> <a href="javascript:void(0);" class="btn-del red"><i class="icon-trash bigger-130"></i></a>
                             </li>
                        <?php }else{?>
                            <?php foreach($pregunta->opciones as $row){ ?>
                            <li data-id="<?=$inc?>">
                            <input type="checkbox"   name="marcado" <?=$row->marcado?'checked':''?> class="marcado" value="<?=$inc?>"/> <input type="text" class="respuesta" name="respuesta" value="<?=$row->respuesta?>" placeholder="Respuesta" /> <a href="javascript:void(0);" class="btn-del red"><i class="icon-trash bigger-130"></i></a>
                            </li>
                            <?php $inc++; }?>
                            
                        <?php }?>
                            </ul>
                            <p>
    
                                <a href="javascript:void(0)" id="add_option" class="grey"><i class="icon-plus bigger-130"></i>Agregar opcion</a>
                            </p> 
    
                     </div>
                 </div>
            </div-->
			
<?php echo form_close();?>			
			
		