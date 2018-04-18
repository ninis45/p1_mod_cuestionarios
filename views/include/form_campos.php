<?php $campos=array('Sexo','Escolaridad','Estado Civil','Ocupacion','Estado','Municipio','Localidad','Colonia','Edad','Sede');?>
<div layout="row" layout-wrap flex>

      <div class="standard" flex="30">
          <md-checkbox ng-model="checkbox.cb1" aria-label="Checkbox 1" disabled checked> Fecha Aplicación</md-checkbox>
      </div>
        
        
        
        
      
<?php foreach($campos as $row => $field){?>
	   <div class="standard" flex="30">
            <md-checkbox value="<?=$field?>" ng-model="checkbox_<?=$row?>" name="campos_habilitados[]" aria-label="Checkbox 1"> <?=$field?> </md-checkbox>
       </div>
		
        
      
<?php }?>
</div>
