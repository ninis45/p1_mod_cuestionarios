jQuery(function($){
	$item_list	= $('ul.sortable');
	$url		= 'admin/pages/order';
	$cookie		= 'open_pages';
	pyro.sort_tree($item_list, $url, $cookie);
	
})(jQuery);