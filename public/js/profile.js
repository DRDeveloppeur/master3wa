$(document).ready(function() {
    $('.panel-toggle').click(function(e) {
		e.preventDefault();
		$('.panel-toggle').removeClass('active');
		$('.panel-content').removeClass('active');
	  	$(this).toggleClass('active');
	  	var panelTarget = $(this).attr('data-to');
	  	$(panelTarget).addClass('active');
	});
	$('button.details').click(function(e) {
		e.preventDefault();
		let orderList = $(this).parent().parent().parent()
		let items =  orderList.children().children(".items")
		orderList.toggleClass('active')
		items.toggle("slow")
	})
});
