
<?php echo form_open('admin/cuestionario/operacion');?>

<?php 

if($items){
?>

<table   class="table table-striped" summary="catalogos"  width="100%">
     <thead>
         <tr>
           <th width="2%">
		   		<?php echo  form_checkbox(array(
							
							'class'=>'check-all'
							));?>
           </th>
           <th>Cuestionario</th>  
           <th width="7%">Publicar</th>
           <th width="10%"><i class="icon-list"></i> Preguntas</th>     
              
           <th width="16%">Acciones</th>
         </tr>
	</thead>
    <?php 
	if($items){
		
	?>
    <tbody>  
    	<?php 
		foreach($items as $row){
			
		?>      	
        <tr class="row-table">
            <td align="center">
			    <?php echo  form_checkbox(array(
							
							'name'=>'action_to[]',
							'value'=>$row->id
							
					  ));
		   
		   		?>			</td>
            <td width=""><?=$row->titulo?></td>
            <td class="center<?=$row->publicar?'':' red'?>"><?=$row->publicar?'Si':'No'?></td>
            <td width="" class="center"><?=get_badge_pregunta($row->id);?></td>
         
            <td class="center">
                <div class="hidden-phone visible-desktop action-buttons">
                <?php 
                if(group_has_role('cuestionarios','edit')):
                ?>
                <a href="<?=base_url('admin/cuestionarios/edit/'.$row->id)?>" class="green" title="Editar">Modificar</a>   
                <?php endif;
                if(group_has_role('cuestionarios','delete')):
                ?>   |          
                 <a href="<?=base_url('admin/cuestionario/eliminar/'.$row->id)?>"  class="btn-delete  red" title="Eliminar este elemento">Eliminar</a>
                <?php endif;?>
                </div>
            </td>
        </tr>   
        <?php }?>     	
     </tbody>
     <tfoot>
     	<tr>
        	<td colspan="5" class="paginacion">
            	<?php echo utf8_encode($pagination);?>               
           </td>
        </tr>
     </tfoot>
    <?php }?>
</table>

<?php }else{?>
<div class="alert alert-info text-center"><?=lang('global:not_found')?></div>
<?php }?>
<?php echo form_close();?>