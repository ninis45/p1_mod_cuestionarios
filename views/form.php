
<?php echo form_open($this->uri->uri_string(),'id="frm" class="form-horizontal"')?>  
<div class="tabbable">

		<ul class="nav nav-tabs" id="myTab">
			<li class="active"><a data-toggle="tab" href="#tab1"><span> Cuestionario </span></a></li>
			<li><a data-toggle="tab" href="#tab2"><span>Preguntas</span></a></li>
            
           
	
		</ul>
        <div class="tab-content">
			<!-- Content tab -->
            <div class="tab-pane active" id="tab1"> 
                <fieldset>
                    <legend><small>Datos generales</small></legend>
                    <div class="control-group">
                        <label class="control-label"><span class="required">*</span> Proyecto:</label>
                        <div class="controls">
                        	<select name="id_proyecto">
                            	<?=cmb_proyecto()?>
                            </select>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label"><span class="required">*</span> Nombre:</label>
                        <div class="controls">
                            <?php 
                            $data = array(
                              'name'        => 'nombre',
                              'id'          => 'txt_area',
                              'value'       => $cuestionario->nombre,
                              'rows'        => '3',
                              'cols'        => '10',
                              'class'       => 'span6',
                            );?>
                            <?=form_textarea($data)?>
                            <?=form_error('NombreCuestionario','<span class="error">','</span>')?>
                        </div>
                    </div> 
                    <div class="control-group">
                        <label class="control-label"><span class="required">*</span> Tipo:</label>
                        <div class="controls">
                            <?=form_dropdown('tipo',array(''=>' [ Elegir ] ','Normal'=>'Normal','PrePost'=>'PrePost','Diagnostico'=>'Diagnostico'),$cuestionario->tipo);?>
                            <?=form_error('Tipo','<span class="error">','</span>')?>
                        </div>
                    </div>
                    <legend><small>Campos</small></legend>
                     <div class="control-group">
                        
                        <div class="controls">
                            
                            <?php $this->load->view('include/form_campos')?>
                        </div>
                    </div>
                    <legend><small>Datos de Asignacion</small></legend>
                    
                    <? //=$this->load->view('perfil/include/cmb_proyecto',array('IdProyecto'=>$cuestionario->IdProyecto,'IdVertiente'=>$cuestionario->IdVertiente,'IdMeta'=>$cuestionario->IdMeta,'name'=>array('IdProyecto','IdVertiente','IdMeta')))?>
                   
                </fieldset>
             </div>
             <div  class="tab-pane" id="tab2">
             	<fieldset>
                   <p align="right"><a href="#" id="add-question" class="red"><i class="icon-plus-sign"></i> Nueva pregunta</a></p>
             	   <ul>
                   	  <li class="box">
                      		<div class="row-fluid">
                            	<div class="span6"><a href="#">Quien fue Venustiano carranza</a></div>
                                <div class="span5"><input type="checkbox" /> Obligatorio</div>
                                <div class="span1">
                                	<div class="hidden-phone visible-desktop action-buttons">
                                		<a href="#" class="green"><i class="icon-edit bigger-130"></i></a> | <a href="#" class="red"><i class="icon-trash bigger-130"></i></a>
                                    </div>
                                </div>
                            </div>
                      
                      </li>
                      
                     
                   </ul>
                </fieldset>
             </div>
        </div>
        <p class="form-actions">
            <?php template_partial('buttons');?>
        </p>
<?php  echo form_close();?>
<div id="modal-question" class="modal fade" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id="myModalLabel"><?php echo $template['title']; ?> :: Preguntas</h4>
        </div>
	    <div class="modal-body">
			 <div class="tabbable">

                <ul class="nav nav-tabs" id="myTab">
                    <li class="active"><a data-toggle="tab" href="#pregunta"><span><i class="icon-user"></i> Pregunta</span></a></li>
                    <li><a data-toggle="tab" href="#respuestas"><span>Respuestas</span></a></li>
                    
                   
            
                </ul>
                <div class="tab-content">
                    <!-- Content tab -->
                    <div class="tab-pane active" id="pregunta"> 
                        <div class="control-group">
                            <label class="control-label">Pregunta</label>
                            <div  class="controls">
                                <textarea class="validate[required] span10" id="txtTitulo" name="Dato[Titulo]"><? //=$pregunta->Titulo?></textarea>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Obligatorio</label>
                            <div  class="controls">
                                <select class="validate[required] lst" id="txtObligatorio" name="Dato[Obligatorio]">
                                    <option value=""> [ Elegir ]</option>
                                    <option value="Si" <? //=seleccionar($pregunta->Obligatorio,'Si')?>>Si</option>
                                    <option value="No" <? //=seleccionar($pregunta->Obligatorio,'No')?>>No</option>
                                </select>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Tipo</label>
                            <div  class="controls">
                                <select class="validate[required] lst" id="txt_tipo" name="Dato[Tipo]" >
                                    <option value=""> [ Elegir ]</option>
                                    <option value="checkbox" <? //=seleccionar($pregunta->Tipo,'checkbox')?>>Multiple</option>
                                    <option value="radio" <? //=seleccionar($pregunta->Tipo,'radio')?>>Unica</option>
                                    <option value="text" <? //=seleccionar($pregunta->Tipo,'text')?>>Abierta</option>
                                </select>
                            </div>
                        </div>
                     </div>
                     <div class="tab-pane" id="respuestas">
                     	  <?php if(!@$opciones){?>
                             <p>
                               <input type="checkbox" value="0"  name="Marcados[]" /> <input type="text" class="validate[required]" name="Respuestas[]" value="" placeholder="Respuesta" id="preg_0"/> <a href="javascript:void(0);" class="btn-del"><i class="icon-trash"></i></a>
                             </p>
                        <?php }else{?>
                            <?php foreach($opciones as $row){ ?>
                            <p>
                            <input type="checkbox"   name="Marcados[]" <?=seleccionar($row->Marcado,'Si','checked')?> value="<?=$inc?>"/> <input type="text" class="validate[required]" name="Respuestas[]" value="<?=$row->Respuesta?>" placeholder="Respuesta" id="preg_0"/> <a href="javascript:void(0);" class="btn-del"><i class="icon-trash"></i></a>
                            </p>
                            <?php $inc++; }?>
                        <?php }?>
                            <p>
    
                                <a href="javascript:void(0)" id="add_option"><i class="icon-plus"></i>Agregar opcion</a>
                            </p> 
    
                     </div>
                 </div>
            </div>
			
			
			
		</div>
        <div class="modal-footer">
        	<button class="btn btn-danger" id="save-question">Guardar</button>
        </div>
     </div>
   </div>
</div>