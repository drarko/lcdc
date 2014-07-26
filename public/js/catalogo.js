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
			$("#overlay").show(200);
		});
   	 });
     });
});
