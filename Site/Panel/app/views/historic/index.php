
<link href=<?php use Helpers\Url; echo Url::templatePath() . 'css/sweetalert.css'; ?> rel="stylesheet" type="text/css">

<div class="row">
  
  <p><b>Afficher l'historique des données sur : </b></p>

  <div class="input-field col s10" id="divTypeSelectButton">
    
      <a class="waves-effect waves-light btn" id="dayButton">La Journée</a>
      <a class="waves-effect waves-light btn" id="monthButton">Le Mois</a>
      <a class="waves-effect waves-light btn" id="yearButton">L'Année</a>
  
  </div>
	
</div>

<div class="row">

	<div id="settings"></div>

</div>

<div class="row">

    <div class="progress" style="display: none;">
      <div class="indeterminate"></div>
    </div>

    <br/>

		<table class="responsive-table table">
        
      <thead>
          <tr>
            <th data-field="date">Date</th>
            <th data-field="hour">Heure</th>
            <th data-field="value">Valeur</th>
            <th data-field="type">Type</th>
         </tr>
      </thead>

      <tbody id="historicResult">
          		
      </tbody>
        	
    </table>

</div>