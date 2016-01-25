
$("#formResetButton").click(function(){
     
  $('#formContact')[0].reset();
   
});

$("#formSendButton").click(function(){

  var isMail = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;

  if($("#firstName").val().length!=0 && $("#mail").val().length!=0 && $("#message").val().length!=0){

    if(isMail.test($("#mail").val())){

      formData = $("#formContact").serialize();

      $.ajax({
         url : 'contact/messageSend',
         type : 'POST',
         data : formData,
         dataType : 'html',
         beforeSend: function(){
            $("#ajaxResult").html('');
            $("#ajaxResult").append('<div class="progress" id="loadingBar"><div class="indeterminate"></div></div>');
         },
         success: function(resultat){
            $("#ajaxResult").hide();
            $("#formContact").remove();
            $(".row").append('<div class="alert alert-success z-depth-1" role="alert"><strong>Merci, </strong>votre message va être envoyé au créateur de ce site</div> <br> <a class="waves-effect waves-light btn" href="contact">Retour au menu</a>');
         }
      });

    }else{

      $("#ajaxResult").html('');
      $("#ajaxResult").append('<div class="alert alert-danger error_alert z-depth-1" role="alert"><b>Attention : </b> Le champ mail ne correspond pas à une adresse email</div>');

    }

  }else{

    $("#ajaxResult").html('');
    $("#ajaxResult").append('<div class="alert alert-danger error_alert z-depth-1" role="alert"><b>Attention : </b> Il est fort probable qu\'une donnée soit manquante dans le formulaire !</div>');

  }

});
