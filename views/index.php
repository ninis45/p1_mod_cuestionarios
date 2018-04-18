
<?php echo form_open('admin/cuestionario/operacion');?>

<?php 

if($items){
?>

<table   class="table table-bordered" summary="catalogos"  width="100%">
     <thead>
         <tr>
           <th width="2%">
		   		<?php echo  form_checkbox(array(
							
							'class'=>'check-all'
							));?>
           </th>
           <th>Cuestionario</th>  
           <th width="10%"><i class="icon-list"></i> Preguntas</th>     
              
           <th width="6%">Acciones</th>
         </tr>
	</thead>
    <?php 
	if($items){
		
	?>
    <tbody>  
    	<?php 
		foreach($items as $row){
			
		?>      	
        <tr>
            <td align="center">
			    <?php echo  form_checkbox(array(
							
							'name'=>'action_to[]',
							'value'=>$row->id
							
					  ));
		   
		   		?>			</td>
            <td width=""><?=$row->nombre?></td>
            <td width="" class="center"><?=get_badge_pregunta($row->id);?>dd</td>
            
            <td align="center">dd
            <?php 
			if(group_has_role('cuestionarios','edit')):
			?>
            <a href="<?=base_url('admin/cuestionario/modificar/'.$row->id)?>" class="" title="Editar">Modificar</a>   |
            <?php endif;
			if(group_has_role('cuestionarios','delete')):
			?>             
             <a href="<?=base_url('admin/cuestionario/eliminar/'.$row->id)?>"  class="" title="Eliminar este elemento">Eliminar</a>
            <?php endif;?>
            </td>
        </tr>   
        <?php }?>     	
     </tbody>
     <tfoot>
     	<tr>
        	<td colspan="4" class="paginacion">
            	<?php echo utf8_encode($pagination);?>               
           </td>
        </tr>
     </tfoot>
    <?php }?>
</table>

<?php }else{?>
<div class="alert alert-info" align="center"><?=lang('not_found')?></div>
<?php }?>
<?php echo form_close();?>