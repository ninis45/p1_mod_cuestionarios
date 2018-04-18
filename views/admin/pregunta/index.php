
<?php if($preguntas):?>
	<ol class="sortable">
	<?php foreach($preguntas as $row){?>
    	<li class="box ui-pregunta" id="<?=$row->id?>"><div class="span11"><?=$row->titulo?></div><div class="span1"><div class="hidden-phone visible-desktop action-buttons"><a href="<?=base_url('admin/cuestionario/pregunta/edit/'.$row->id)?>" class="green" data-toggle="imec-modal"><i class="icon-edit bigger-130"></i></a> <a href="<?=base_url('admin/cuestionario/pregunta/delete/'.$row->id)?>" class="confirm red"><i class="icon-trash bigger-130"></i></a></div></div></li>
	<?php }?>
    </ol>
<?php else:?>
<div class="alert alert-info text-center">
	<?=lang('global:not_found')?>
</div>
<?php endif;?>