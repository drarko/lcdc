
  function repo(form)
  {
      $.ajax({
        type: "POST",
        url: "/noticias/comentar/reportar",
        async: false,
        //Serializamos los datos del Form. Los parámetros son los NAME del formulario, no los id
        data: form.serialize(),
        success: function(data){
	  var x = $(".comentarios");
          x.append(data);
          $(".redondo").corner();
        },
        error: function(xml,msg){
          $(".n-nuevo-comentario").prepend("Error");
        }
      }); //$.ajax
      return false;  
  
  };

  function vpos(){
      $.ajax({
        type: "POST",
        url: "/noticias/votar/positivo",
        async: false,
        //Serializamos los datos del Form. Los parámetros son los NAME del formulario, no los id
        data: { art: $("#not-id").val()},
        success: function(data){
	  var x = $(".comentarios");
          x.append(data);
          $(".redondo").corner();
        },
        error: function(xml,msg){
          $(".n-nuevo-comentario").prepend("Error");
        }
      }); //$.ajax      
      return false;
    };
    function vneg(){
      $.ajax({
        type: "POST",
        url: "/noticias/votar/negativo",
        async: false,
        //Serializamos los datos del Form. Los parámetros son los NAME del formulario, no los id
        data: { art: $("#not-id").val()},
        success: function(data){
	  var x = $(".comentarios");
          x.append(data);
          $(".redondo").corner();
        },
        error: function(xml,msg){
          $(".n-nuevo-comentario").prepend("Error");
        }
      }); //$.ajax 
      return false;
    };
    
  $(document).ready(function(){
    $("#nct").click(function(evento){ 
      $.ajax({
        type: "POST",
        url: "/noticias/comentar/cargar",
        async: false,
        //Serializamos los datos del Form. Los parámetros son los NAME del formulario, no los id
        data: { art: $("#not-id").val()},
        success: function(data){
	  var x = $(".comentarios");
          x.html(data);
          $(".redondo").corner();
        },
        error: function(xml,msg){
          $(".n-nuevo-comentario").prepend("Error");
        }
      }); //$.ajax      
    
    });
    $("#nuevo").submit(function(){
      $.ajax({
        type: "POST",
        url: "/noticias/comentar/cargar",
        async: false,
        //Serializamos los datos del Form. Los parámetros son los NAME del formulario, no los id
        data: { art: $("#not-id").val()},
        success: function(data){
	  var x = $(".comentarios");
          x.html(data);
          $(".redondo").corner();
        },
        error: function(xml,msg){
          $(".n-nuevo-comentario").prepend("Error");
        }
      }); //$.ajax      
      $.ajax({
        type: "POST",
        url: "/noticias/comentar/nuevo",
        async: false,
        //Serializamos los datos del Form. Los parámetros son los NAME del formulario, no los id
        data: $(this).serialize(),
        success: function(data){
	  var x = $(".comentarios");
          x.append(data);
          $(".redondo").corner();
          $("#nct").val("");
        },
        error: function(xml,msg){
          $(".n-nuevo-comentario").prepend("Error");
        }
      }); //$.ajax
      return false;
    }); //submit
    }); //ready
   
