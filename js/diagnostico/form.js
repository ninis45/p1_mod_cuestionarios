var diagnostico={};
jQuery(function($){
	
	
	$('#add-diagnostic').on('click',function(e){
		e.preventDefault();
		
		diagnostico.prep_instance_form(this,$('#accordion-diagnostic'));
	});
	$('#accordion-diagnostic').delegate('.btn-edit','click',function(e){
		
		e.preventDefault();
		diagnostico.prep_instance_form(this,$(this).closest('h4.panel-title'),'edit');
		
	});
	
	$('#accordion-diagnostic').delegate('.btn-delete-diagnostico','click',function(e){
		
		e.preventDefault();
		if(confirm('¿Desea eliminar el siguiente registro?'))
			diagnostico.delete_diagnostic(this);
		
		
	});
	
	$('.ui-question > ul > li').draggable(diagnostico.ui_options.draggable);
    $('.area-diagnostic').droppable(diagnostico.ui_options.droppable);
	
	$('body').delegate('button[value=delete]','click-confirmed',function(e){
		
		diagnostico.delete_item(this);
	});
	
	


});

diagnostico={
	
	selector:{
		area:'',
		box:$('.ui-question > ul > li'),
		$container	: $('#accordion-diagnostic'),
	},
	create_diagnostic:function(){
		
		var $form=$('#form-diagnostic'),
			data=$form.serialize(),
			$accordion=$('#accordion-diagnostic'),
			url=BASE_URL+'admin/cuestionario/diagnostico/create';
		
		$.post(url,data,function(response){
			
			if(response.status=='success')
			{
				$('#modal-diagnostico').modal('hide');
				
				var html=' <div class="panel panel-default"><div class="panel-heading"><h4 class="panel-title box"><a data-toggle="collapse" data-parent="#accordion-diagnostic" href="#collapse'+response.data.id+'">'+response.data.titulo+'</a></h4></div><div id="collapse'+response.data.id+'" class="panel-collapse collapse area-diagnostic"><div class="panel-body list-diagnostic" id="ui_'+response.data.id+'"><ul data-diagnostico="'+response.data.id+'"><li class="empty-drop-item no-sortable"></li></ul> </div></div>';
				
				$accordion.append(html);
				
				 $('#collapse'+response.data.id).droppable(diagnostico.ui_options.droppable);
				
			}
			pyro.add_notification(response.message);
		});
	},
	load_data:function($form,data)
	{
	
		$form.find('input[name="color"]').val(data.color);
		$('#colorpicker1').colorpicker('setValue',data.color);
        
		$form.find('textarea[name="titulo"]').val(data.titulo);
 	    $form.find('textarea[name="descripcion"]').val(data.descripcion);
		
	},
	prep_instance_form:function(item, container, action)
	{
			action || (action = 'add');
			
			var url	  = (action == 'add') ? SITE_URL + 'admin/cuestionario/diagnostico/create/'  : $(item).attr('href');
			
			var $form		= $('#form-diagnostic'),				
				$cancel		= $('.action-buttons button[value=cancel]'),
				$modal      = $form.closest('#modal-diagnostico'),
				$submit	    = $('button[value=save]'),	
				
				data={
					titulo:(action == 'edit') ?container.data('titulo'):'',
					color: (action == 'edit') ?container.data('color'):'',
                    descripcion: (action == 'edit') ?container.data('descripcion'):'',
					
				},
				method      = (action == 'add') ?'append':'html';			
				
			diagnostico.load_data($form,data);
			
			$('#modal-diagnostico').modal();
			
			
			
			$submit.off('click-confirmed').on('click-confirmed',function(){
				
				
				$.post(url,$form.serialize(),function(response){
					
					if(response.status=='success')
					{
						$('#modal-diagnostico').modal('hide');
						
						
						
						 var callback=false;
						 if(action=='edit')
						 {
							 container.parent('div.panel-heading').html(response.html);
							
						 }
						 else
						 {
							container[method](response.html);
						 }
					
						var collapse  = $('#collapse'+response.data.id); 
						
					 	collapse.droppable(diagnostico.ui_options.droppable);						
						
					
						
						
						
						
						pyro.add_notification(response.message,{},callback);
					}
					else
					{
						$('#notices-modal').html(response.message);
					}
					
				});
				
			});
			
			$cancel.on('click',function(){
				
			});
			
	},
	delete_item:function(item)
	{
		var $item=$(item),
			$li=$item.parent('li.item'),
			$pregunta=$('.ui-question ul > li#question_'+$li.data('pregunta')),
			url=BASE_URL+'admin/cuestionario/diagnostico/delete_item/'+$li.data('id');
		
		$.post(url,{},function(response){
			if(response=='success')
			{
				$li.remove();
				$pregunta.removeClass('no-sortable');
			}
		});
		
	},
	delete_diagnostic:function(anchor)
	{
		var url   = $(anchor).attr('href')
		    parent = $(anchor).closest('div.panel-default')
			preguntas = parent.find('ul > li.item');
		
		$.post(url,{},function(response){
			if(response.status=='success')
			{
				$.each(preguntas,function(index,item){
					$('.ui-question ul > li#question_'+$(item).data('pregunta')).removeClass('no-sortable');
				});
				parent.remove();
			}
			
			pyro.add_notification(response.message);
		});
	},
	add_question:function(item,container)
	{
		var  $item=$(item);		
	    var	 data={
		 	id_pregunta:$item.data('id'),
			id_diagnostico:$(container).data('diagnostico')
		 
		};
		
		$item.addClass('no-sortable');
		$.post(BASE_URL+'admin/cuestionario/diagnostico/add',data,function(response){
			if(response=='success')
			{			
				
				
				container.load(BASE_URL+'admin/cuestionario/diagnostico/list_items/'+data['id_diagnostico']);
			}
			else
			{
				$item.removeClass('no-sortable');
				pyro.add_notification(response);
			}
		});
	},
	
	ui_options: {
			// Widget Areas
			accordion: {
				collapsible	: true,
				header		: '> section > header',
				autoHeight	: false,
				clearStyle	: true
			},
			// Widget Instances List
			sortable: {
				cancel		: '.no-sortable, a, :input, option',
				placeholder	: 'empty-drop-item',

				start: function(){
					pyro.widgets.$areas.accordion('refresh');
				},

				stop: function(){
					pyro.widgets.$areas.accordion('refresh');
					
				},

				update: function(){
					var order = [];
					
					$(this).children('li').each(function(){					
						order.push($(this).attr('id'));
					});

					$.post(SITE_URL + 'widgets/ajax/update_order', { order: order.join(',') });
				}
			},
			// Widget Box
			draggable: {
				cancel:'.no-sortable',
				revert		: 'invalid',
				cursor		: 'move',
				helper		: 'clone',
				cursorAt	: {left: 100},
				refreshPositions: true,

				start : function(e, ui){
					// Grab our desired width from the widget area list
					var width = $('.list-diagnostic > ul').width() - 22;

					// Setup our new dragging object
					$(this).addClass('question-drag')
					$(ui.helper).css('width', width );
				},
				stop: function() {
					
					$(this).removeClass('question-drag');
				}
			},
			// Widget Instances List
			droppable: {
				hoverClass	: 'drop-hover',
				accept		: '.box-question',
				greedy		: true,
				tolerance	: 'pointer',

				over : function(){
					//pyro.widgets.$areas.accordion('refresh');
				},
				out : function(){
					//pyro.widgets.$areas.accordion('refresh');
				},
				drop : function(e, ui){
					
					$('li.empty-drop-item', this).show().addClass('loading');
					//diagnostico.prep_instance_form(ui.draggable);
					diagnostico.add_question(ui.draggable,$('.list-diagnostic > ul',this));
				

				}
			}
	},
};
