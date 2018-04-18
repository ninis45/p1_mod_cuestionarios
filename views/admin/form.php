<section ng-controller="InputCtrl">
    <div class="lead text-success"><?=lang('cuestionario:'.$this->method)?></div>
     <?php echo form_open($this->uri->uri_string(),'id="frm" class=""')?>   
    <div class="ui-tab-container ui-tab-horizontal">
      
        
    	<uib-tabset justified="false" class="ui-tab">
            <uib-tab heading="Cuestionario">
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
                            <?=form_input('titulo',$cuestionario->titulo,'class="form-control span6" ng-init="title=\''.$cuestionario->titulo.'\'" ng-model="title"')?>
                            
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
                        <label class="control-label">Descripción:</label>
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
                            
                            <p class="help-block">Agrega una breve descripción acerca del cuestionario, al momento de levantar la encuesta</p>
                        </div>
                    </div> 
                    <div class="form-group">
                        <label class="control-label"><span class="required">*</span> Tipo:</label>
                        <div class="controls">
                            <?=form_dropdown('tipo',array(''=>' [ Elegir ] ','Normal'=>'Normal','PrePost'=>'PrePost','Diagnostico'=>'Diagnostico'),$cuestionario->tipo,'class="form-control" ');?>
                            
                        </div>
                    </div>
                    <hr />
                    <div class="form-group">
                        <label class="control-label">Campos:</label><br />
                        <?php $extra = array('edad'=>'Edad','sexo'=>'Sexo','email'=>'Correo electrónico','telefono'=>'Teléfono','social_facebook'=>'Facebook','social_twitter'=>'Twitter','social_instagram'=>'Instagram','social_whatsapp'=>'Whatsapp','social_otro'=>'Otra red social');?>
                        <?php foreach($extra as $field=>$label):?>
                        
                        <label class="checkbox-inline">
                            
                            <input type="checkbox" value="<?=$field?>" name="campos[]" <?=in_array($field,$cuestionario->campos)?'checked':''?> />
                            <?=$label?> 
                       </label>
                       
                      
                    
                       <?php endforeach;?>
                       <label class="checkbox-inline">
                            
                            <input type="checkbox" disabled="" checked=""/>
                            IP
                       </label>
                    </div>
                    <div class="form-group">
                        <label class="control-label"><span class="required">*</span> Publicar:</label>
                        <div class="controls">
                            <?=form_dropdown('publicar',array('0'=>'No','1'=>'Si'),$cuestionario->publicar,'class="form-control"');?>
                            
                        </div>
                    </div>
            </uib-tab>
            
            <uib-tab heading="Preguntas">
                <div class="divider clearfix">
                    <a href="#" ng-click="prepend_add()" class="btn btn-primary pull-right">Agregar pregunta</a>
                    <a href="#" ng-click="ordenar=true"   ng-hide="ordenar" class="btn btn-default pull-right">Ordenar preguntas</a>
                    
                    <a href="#" ng-click="ordenar=false" ng-hide="!ordenar"  class="btn btn-default pull-right">Editar preguntas</a>
                </div>
                <div id="block-sorter" ui-tree="options" ng-if="ordenar">
                    <ol ui-tree-nodes ng-model="preguntas" class="list-unstyled">
                        <li ui-tree-node class="ui-pregunta sorter" ng-repeat="(i,pregunta) in preguntas">
                            <div class="row">
                                <div class="col-md-10">
                                    <strong>{{$index+1}} .- {{pregunta.titulo}}</strong>
                                    <p>{{pregunta.tipo}}</p>
                                    
                                </div>
                                                          
                            </div>
                           
                           
                        </li>
                    </ol>
                </div>
                <div id="block-preguntas" ng-if="!ordenar">
                    
                    <ul  class="list-unstyled">
                        <li  class="ui-pregunta" ng-repeat="(i,pregunta) in preguntas">
                            <div class="row">
                                <div class="col-md-10">
                                    <strong>{{$index+1}} .- {{pregunta.titulo}}</strong>
                                    <p>{{pregunta.tipo}}</p>
                                    
                                    <input type="hidden" name="preguntas[{{$index}}][titulo]" value="{{pregunta.titulo}}" />
                                    <input type="hidden" name="preguntas[{{$index}}][tipo]" value="{{pregunta.tipo}}" />
                                    <input type="hidden" name="preguntas[{{$index}}][id]" value="{{pregunta.id}}" />
                                    <input type="hidden" name="preguntas[{{$index}}][obligatorio]" value="{{pregunta.obligatorio}}" />
                                    <input type="hidden" name="preguntas[{{$index}}][muestra]" value="{{pregunta.muestra}}" />
                                    <div ng-repeat="(j,opcion) in pregunta.opciones">
                                   
                                        <input type="hidden" name="preguntas[{{i}}][opciones][{{j}}][respuesta]" value="{{opcion.respuesta}}" />
                                        <input type="hidden" name="preguntas[{{i}}][opciones][{{j}}][valor]" value="{{opcion.valor}}" />
                                        <input  type="hidden" name="preguntas[{{i}}][opciones][{{j}}][correcta]" value="{{opcion.correcta}}" />
                                        <input type="hidden" name="preguntas[{{i}}][opciones][{{j}}][id]" value="{{opcion.id}}" />
                                       
                                    </div>
                                </div>
                                <div class="col-md-2">
                                     <a href="#" ng-click="prepend_edit(pregunta)" class="btn-icon btn-icon-sm btn-primary ui-wave"><i class="fa fa-pencil"></i></a>
                                     
                                     <a href="#" ng-click="remove(i)" class="btn-icon btn-icon-sm btn-danger ui-wave"><i class="fa fa-remove"></i></a>
                                </div>                            
                            </div>
                           
                           
                        </li>
                    </ul>
                </div>
            </uib-tab>
        </uib-tabset>
        
   
    </div>
    <div class="buttons divider clearfix">
			<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel') )) ?>
     </div>
     <?php echo form_close();?>
</section>

<script type="text/ng-template" id="ModalPrepend.html">
    <div class="modal-header">
                                <h3>Actualizar preguntas</h3>
    </div>
    <div class="modal-body">
    <?php echo form_open();?>
        <div class="ui-tab-container ui-tab-horizontal">
        
        
        	<uib-tabset justified="false" class="ui-tab">
                <uib-tab heading="Pregunta">
                    <div class="form-group">
                        
                            <label>Titulo</label>
                            <input type="text" class="form-control" ng-model="form.titulo"/>
                                
                    </div>
                    <div class="form-group">
                        <label>Tipo</label>
                         <select class="form-control" ng-model="form.tipo">
                            <option value="">Ninguno</option>
                            <option  value="checkbox">Opción múltiple con una o más respuestas</option>
                            <option  value="radio">Opción múltiple con una respuesta</option>
                            <option  value="image">Opción múltiple con imágenes</option>
                            <option  value="text">Campo abierto</option>
                         </select> 
                                        
                    </div>
                    
                    <div class="form-group" >
                        <label>Muestra</label>
                         <input type="text" class="form-control" ng-model="form.muestra" />
                           
                                        
                    </div>
                     <div class="form-group">
                        <label>Obligatorio</label>
                         <select class="form-control" ng-model="form.obligatorio">
                            <option  value="0">No</option>
                            <option  value="1">Si</option>
                         </select> 
                     </div>
                </uib-tab>
                <uib-tab heading="Respuestas" ng-if="form.tipo!='text' && form.tipo!='' ">
                    <div class="form-group" ng-repeat="opcion in form.opciones">
                        <div class="row">
                            <div class="col-md-1"><input ng-model="opcion.correcta" type="checkbox" ng-checked="opcion.correcta==1"  ng-true-value="'1'" ng-false-value="'0'"/></div>
                            <div class="col-md-7">
                                <input type="text" class="form-control" placeholder="Respuesta" ng-model="opcion.respuesta"/>
                            </div>
                            
                           
                           
                             <div class="col-md-2">
                                <a href="#" ng-if="$index > 0" ng-click="remove_opciones($index)" title="Eliminar este elemento" class="btn-icon btn-icon-sm btn-danger ui-wave"><i class="fa fa-remove"></i></a>
                                <a href="#" ng-if="form.opciones.length == ($index+1)" title="Agregar nuevo elemento" ng-click="add_opciones()" class="btn-icon btn-icon-sm btn-linkedin ui-wave"><i class="fa fa-plus"></i></a>
                             </div>
                        </div>        
                    </div>
                    
                </uib-tab>
             </uib-tabset>
         </div>       
    <?php echo form_close();?>
    </div>
    <div class="modal-footer">
                                <button ui-wave class="btn btn-flat" ng-click="cancel()">Cancelar</button>
                                <button ui-wave class="btn btn-flat btn-primary"  ng-click="save()">Aceptar</button>
    </div>
</script>