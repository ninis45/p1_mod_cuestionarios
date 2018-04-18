<table border="0" class="table table-bordered">
		<thead>
			<tr>
				<th>Cuestionario</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
        <?php foreach($cuestionarios as $row){?>
			<tr>
				<td><?=$row->nombre?></td>
				<td class="buttons actions">
						<a href="<?=base_url('admin/cuestionario/diagnostico/config/'.$row->id)?>" class="button green"><i class="icon-list"></i> Configuracion</a>									
                </td>
			</tr>
		<?php }?>			
	    </tbody>
</table>