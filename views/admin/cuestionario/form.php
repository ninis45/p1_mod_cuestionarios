
<?php echo form_open($this->uri->uri_string(),'id="frm" class=""')?>  

                <fieldset>
                     <h4 class="text-success">Datos generales</h4>
                    
                    <div class="form-group">
                        <label class="control-label"><span class="required">*</span> Nombre:</label>
                        <div class="controls">
                            <?php 
                            $data = array(
                              'name'        => 'titulo',
                              'id'          => 'txt_area',
                              'value'       => $cuestionario->titulo,
                              'rows'        => '3',
                              'cols'        => '10',
                              'class'       => 'span6',
                              
                            );?>
                            <?=form_input('nombre',$cuestionario->titulo,'class="form-control span6" ng-init="title=\''.$cuestionario->titulo.'\'" ng-model="title"')?>
                            
                        </div>
                    </div> 
                     <div class="form-group">
                        <label class="control-label"><span class="required">*</span> Slug:</label>
                        <div class="controls">
                            
                           <slug from="title" to="slug" >
                            <?=form_input('slug',$cuestionario->slug,'class="form-control span6" ng-model="slug" readonly ')?>
                           </slug>
                        </div>
                    </div> 
                    <div class="form-group">
                        <label class="control-label"><span class="required">*</span> Descripcion:</label>
                        <div class="controls">
                            <?php 
                            $data = array(
                              'name'        => 'descripcion',
                              'id'          => 'txt_area2',
                              'value'       => $cuestionario->descripcion,
                              'rows'        => '3',
                              'cols'        => '10',
                              'class'       => 'form-control span6',
                            );?>
                            <?=form_textarea($data,'','class="form-control"')?>
                            
                            <p class="help-block">Permite una breve descripción acerca del cuestionario, al momento de levantar la encuesta</p>
                        </div>
                    </div> 
                     
                    <div class="form-group">
                        <label class="control-label"><span class="required">*</span> Tipo:</label>
                        <div class="controls">
                            <?=form_dropdown('tipo',array(''=>' [ Elegir ] ','Normal'=>'Normal','PrePost'=>'PrePost','Diagnostico'=>'Diagnostico'),$cuestionario->tipo,'class="form-control"');?>
                            
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label"><span class="required">*</span> Publicar:</label>
                        <div class="controls">
                            <?=form_dropdown('publicar',array('0'=>'No','1'=>'Si'),$cuestionario->publicar,'class="form-control"');?>
                            
                        </div>
                    </div>
                
                
                   <div class="divider divider-lg divider-dashed"></div>
                    <h4 class="text-success">Campos</h4>
                    <div class="form-group">
                        
                        <div class="controls">
                            
                            <?php $this->load->view('include/form_campos')?>
                        </div>
                    </div>
                   
                   
                </fieldset>
             
       
        <div class="buttons float-right padding-top">
			<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel') )) ?>
		</div>
