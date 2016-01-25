
<link href=<?php use Helpers\Url; echo Url::templatePath() . 'css/sweetalert.css'; ?> rel="stylesheet" type="text/css">

<div class="row">

	<p><b>Afficher les graphiques sur : </b></p>

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

	<div id="graphResult" class="z-depth-1"></div>

</div>