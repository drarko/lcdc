/* Inicialización en español para la extensión 'UI date picker' para jQuery. */
/* Traducido por Vester (xvester@gmail.com). */
jQuery(function($){
	$.datepicker.regional['es'] = {
		closeText: 'Cerrar',
		prevText: '&#x3C;Ant',
		nextText: 'Sig&#x3E;',
		currentText: 'Hoy',
		monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio',
		'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
		monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun',
		'Jul','Ago','Sep','Oct','Nov','Dic'],
		dayNames: ['Domingo','Lunes','Martes','Miércoles','Jueves','Viernes','Sábado'],
		dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
		dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
		weekHeader: 'Sm',
		dateFormat: 'dd/mm/yy',
		firstDay: 1,
		isRTL: false,
		showMonthAfterYear: false,
		yearSuffix: ''};
	$.datepicker.setDefaults($.datepicker.regional['es']);
});

$(document).ready(function() {

  $("#send").click(function(e) {
    e.preventDefault();
    $("#activeform").submit();
  });
  $("a[rel^='prettyPhoto']").prettyPhoto({social_tools: false});
  
    tinymce.init({
    content_css : "/css/styles.css",    // resolved to http://domain.mine/mycontent.css
    selector: "textarea",
    theme: "modern",
    plugins: [
        "advlist autolink lists link image charmap print preview hr anchor pagebreak",
        "searchreplace wordcount visualblocks visualchars code fullscreen",
        "insertdatetime media nonbreaking save table contextmenu directionality",
        "emoticons template paste textcolor colorpicker textpattern"
    ],
    toolbar1: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
    toolbar2: "print preview media | forecolor backcolor emoticons",
    image_advtab: true,
  });

 $( ".tip" ).tooltip(
{ position: { my: "left+15 center", at: "right center" } }
);
 
$( ".datepicker" ).datepicker({
    changeMonth: true,
    changeYear: true
});
$(".datepicker").datepicker( "option",
    $.datepicker.regional[ "es" ] );
$(".gallery").imagepicker();
    var container = $(".gallery.image-picker.masonry").next("ul.thumbnails");
    container.imagesLoaded(function(){
      container.masonry({
        itemSelector:   "li",
      });
    });
}); 

