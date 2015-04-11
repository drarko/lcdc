// script creado para mostrar los productos de catalogos

$(document).ready(function(){
    $('.producto').each(function(item) {
	var id = $(this).first().attr('id');
	id = id.replace("producto-","");
	$(this).first().click(function(e){
		$.ajax({
			url: "/producto/"+id,
			cache: false
		}).done(function( html ) {
			$( "#response" ).html( html );
			var scrollTop = $(window).scrollTop();
			$("#overlay").css({'top': scrollTop+'px'})
			$("#overlay").show(200);
		});
   	 });
     });
    $('.linkno').each(function(item) {
	var id = $(this).first().attr('imagen-id');
	id = id.replace("imagen-","");
	$(this).first().click(function(e){
		$.ajax({
			url: "/yaoino/"+id,
			cache: false
		}).done(function( html ) {
		      $("#imagen-"+id).remove();  
		});
		if($('.linkno').length == 0) { 
			window.location.reload(true);
		}
		return false;
   	 });
     });     
    $('.linksi').each(function(item) {
	var id = $(this).first().attr('imagen-id');
	id = id.replace("imagen-","");
	$(this).first().click(function(e){
		$.ajax({
			url: "/yaoisi/"+id,
			cache: false
		}).done(function( html ) {
		      $("#imagen-"+id).remove();  
		});
		if($('.linksi').length == 0) { 
			window.location.reload(true);
		}
		return false;
   	 });
     });    
});
