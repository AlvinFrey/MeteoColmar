
<h5><b><?php echo $data["main_title"]; ?></b></h5>

<br>
<br>

 <div class="row">

    <form autocomplete="off" action="contact/messageSend" method="post" class="col s12" id="formContact">
      <div class="row">
        <div class="input-field col s6">
          <input placeholder="Gérard" name="firstName" id="firstName" type="text" class="validate"/>
          <label for="firstName">Prénom</label>
        </div>
        <div class="input-field col s6">
          <input placeholder="contact@meteo-colmar.fr" name="mail" id="mail" type="email" class="validate"/>
          <label for="mail">Votre Adresse Mail</label>
        </div>
      </div>
      <div class="row">
       <div class="input-field col s12">
          <textarea placeholder="Mon magnifique message" name="message" id="message" class="materialize-textarea validate"></textarea>
          <label for="message">Votre Message</label>
        </div>
      </div>
      
      <div id="ajaxResult"></div>
      
      <input type="hidden" name="csrf_token" value="<?php echo $data['csrf_token']; ?>" />

      <div class="row">
        <div class="input-field col s12" id="divFormContactButton">
          <a class="waves-effect waves-light btn" id="formResetButton">Réinitialiser</a>
          <a class="waves-effect waves-light btn" id="formSendButton">Envoyer</a>
        </div>
      </div>
    </form>
  </div>
