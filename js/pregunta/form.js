// JavaScript Document

jQuery(function($){
				
	var $form=$('#frm_question');
	
	$('#add-question').on('click',function(e){
		pyro.add_question();
	});
	$('#btn_action').on('click',function(){
										 
		if(confirm('¿Desea guardar el siguiente registro y sus cambios?'))
			pyro.save_question();
	});
	$('#add_option').on('click',function(){
		pyro.add_option();
		
	});
	$('.btn-del').on('click',function(e){
			$(this).closest('li').remove();
	});

	pyro.add_question=function(){
		
		//$('#modal-question').modal();
		/*$('#modal-upload').on('hide',function(){
			if (pyro.files.upload_to === pyro.files.current_level) {
				pyro.files.folder_contents(pyro.files.upload_to);
			}
	    });*/
	};
	
	$('.sortable').sortable(pyro.ui_sortable);
	pyro.save_question=function()
	{
		var data=[];
		var band=true;
		var box=$('div#pregunta');
		$.each($('#respuestas ul li'),function(index,item){
			
			
				var option={
					respuesta:$(item).find('.respuesta').val(),
					marcado:$(item).find('.marcado').is(":checked")?'1':'0'
				}
				data.push(option);
			
		     
		});
		info={
			option:data,
			titulo:box.find('.titulo').val(),
			obligatorio:box.find('.obligatorio').val(),
			tipo:box.find('.tipo').val(),
		}
		$.post($form.attr('action'),info,function(response){
			if(response=='success')
			{
				
				location.href = window.location;
			}
			else
			{
				$('div#notices-modal').find('div').remove();
				
				$('div#notices-modal').append(response);
			}
				//$('#notices-modal').append(response.message);
			
		});
	};
	pyro.add_option=function()
	{
		$('<li><input type="checkbox" class="marcado"/> <input type="text" class="respuesta" name="Respuestas[]" placeholder="Respuesta"/> <a href="javascript:void(0);" class="btn-del red"><i class="icon-trash bigger-130"></i></a></li>').appendTo('#respuestas ul');
		$('.btn-del').on('click',function(e){
			$(this).closest('li').remove();
		});
	};
	
	
	
});
pyro.ui_sortable={
		
		
	
			
	
			update: function(){
				
				var order = [];
				
				$(this).children('li').each(function(){					
					order.push($(this).attr('id'));
				});
	
				$.post(SITE_URL + 'admin/cuestionario/pregunta/sorter', { order: order.join(',') });
			}
		
};