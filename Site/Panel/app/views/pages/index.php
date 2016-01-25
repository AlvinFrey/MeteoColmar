
<div class="center-align">

	<h5><b>Bienvenue sur cette station météo située à Colmar !</b></h5>

	<p>Nous sommes le <b><?php echo date('d/m/Y'); ?> </b>, il est <b id="heure"></b></p>

	<?php 

		if(date('d/m')=="31/05"){

			echo '<p>Nous souhaitons un joyeux anniversaire à <b>Nicolas</b> ! </p>';

		}else if(date('d/m')=="24/08"){

			echo '<p>Nous souhaitons un joyeux anniversaire à <b>Gaël</b> ! </p>';

		}else if(date('d/m')=="24/08"){

			echo '<p>Nous souhaitons un joyeux anniversaire à <b>Christian</b> sans qui ce projet n\'aurait jamais aboutis ! </p>';

		}

	?>

</div>

<?php 

	use Helpers\Url;

	$vigilanceIndex = $data["vigilance"]->xpath('DV[@dep="68"]');
	$vigilanceCouleur = $vigilanceIndex[0]->attributes()->coul;
	
	if(isset($vigilanceIndex[0]->risque)){

		$vigilanceRisqueNum = $vigilanceIndex[0]->risque[0]->attributes()->val;

		switch($vigilanceRisqueNum){
			case '1':
				$vigilanceRisque = "(Vents Violents)";
				break;
			case '2':
				$vigilanceRisque = "(Pluie-Inondation)";
				break;
			case '3':
				$vigilanceRisque = "(Orages)";
				break;
			case '4':
				$vigilanceRisque = "(Inondation)";
				break;
			case '5':
				$vigilanceRisque = "(Neige-Verglas)";
				break;
			case '6':
				$vigilanceRisque = "(Canicule)";
				break;
			case '7':
				$vigilanceRisque = "(Grand-Froid)";
				break;
			case '8':
				$vigilanceRisque = "(Avalanches)";
				break;
			case '9':
				$vigilanceRisque = "(Vagues Hautes)";
				break;
			default:
				#On ne fais rien :D
				break;
		}

	}

	switch ($vigilanceCouleur) {
		case '2':
			echo '<div class="alert alert-warning z-depth-1" role="alert" id="toknow_alert"><strong>Vigilance Jaune '.$vigilanceRisque.' : </strong> Il est préférable de rester attentif si vous faites des activités en extérieur</div>';
			break;
		case '3':
			echo '<div class="alert alert-medium z-depth-1" role="alert" id="toknow_alert"><strong>Vigilance Orange '.$vigilanceRisque.' : </strong> Il faut être très vigilant, des phénomènes météo dangereux sont prévus</div>';
			break;
		case '4':
			echo '<div class="alert alert-danger z-depth-1" role="alert" id="toknow_alert"><strong>Vigilance Rouge '.$vigilanceRisque.' : </strong> Soyez sur le qui-vive ! Des phénomènes dangereux de très forte intensité sont prévues</div>';
			break;
		default:
			#On ne fais rien :D
			break;
	}

?>

<ul class="collection with-header" id="temperature">
	<li class="collection-header"><img class="vertical-align" src=<?php echo Url::templatePath() . '/img/dataImages/temperature.png' ?> alt="Icône Température"></img><h4 class="inline-block-padding vertical-align">Température</h4></li>
	<li class="collection-item">Température Actuelle : <?php if(isset($data["last_temp"][0]["value"])){echo $data["last_temp"][0]["value"];}else{echo "?";} ?> °</li>
	<li class="collection-item">Température Max sur la journée : <?php if(isset($data["max_temp"][0]["maximum"])){echo $data["max_temp"][0]["maximum"];}else{echo "?";} ?> ° </li>
	<li class="collection-item">Température Min sur la journée : <?php if(isset($data["min_temp"][0]["minimum"])){echo $data["min_temp"][0]["minimum"];}else{echo "?";} ?> ° </li>
	<li class="collection-item">Point de rosée : <?php if(isset($data["last_dewPoint"][0]["value"])){echo $data["last_dewPoint"][0]["value"];}else{echo "?";} ?> ° </li>
</ul>

<ul class="collection with-header" id="vent">
	<li class="collection-header"><img class="vertical-align" src=<?php echo Url::templatePath() . '/img/dataImages/vent.png' ?> alt="Icône Vent"></img><h4 class="inline-block-padding vertical-align">Vent</h4></li>
	<li class="collection-item">Vitesse Actuelle : <?php if(isset($data["last_windSpeed"][0]["value"])){echo $data["last_windSpeed"][0]["value"];}else{echo "?";} ?> km/h</li>
	<li class="collection-item">Direction Actuelle : <?php if(isset($data["last_windDir"][0]["value"])){echo $data["last_windDir"][0]["value"];}else{echo "?";} ?> </li>
	<li class="collection-item">Vitesse Maximum sur la journée : <?php if(isset($data["max_windSpeed"][0]["maximum"])){echo $data["max_windSpeed"][0]["maximum"];}else{echo "?";} ?> km/h</li>
	<li class="collection-item">Vitesse Minimum sur la journée : <?php if(isset($data["min_windSpeed"][0]["minimum"])){echo $data["min_windSpeed"][0]["minimum"];}else{echo "?";} ?> km/h</li>
</ul>

<ul class="collection with-header" id="pluie">
	<li class="collection-header"><img class="vertical-align" src=<?php echo Url::templatePath() . '/img/dataImages/pluie.png' ?> alt="Icône Pluie"><h4 class="inline-block-padding vertical-align">Pluie</h4></li>
	<li class="collection-item">Niveau de pluie Actuel : <?php if(isset($data["last_rainFall"][0]["value"])){echo $data["last_rainFall"][0]["value"];}else{echo "?";} ?> mm</li>
	<li class="collection-item">Niveau de pluie sur la semaine :  <?php if(isset($data["sumWeek_rainFall"][0]["somme"])){echo $data["sumWeek_rainFall"][0]["somme"];}else{echo "?";} ?> mm</li>
	<li class="collection-item">Niveau de pluie sur le mois : <?php if(isset($data["sumMonth_rainFall"][0]["somme"])){echo $data["sumMonth_rainFall"][0]["somme"];}else{echo "?";} ?> mm</li>
</ul>

<ul class="collection with-header" id="humidite-pression">
	<li class="collection-header"><img class="vertical-align" src=<?php echo Url::templatePath() . '/img/dataImages/humidite.png' ?> alt="Icône Humidité"><h4 class="inline-block-padding vertical-align">Humidité</h4></li>
	<li class="collection-item">Humidité Actuelle : <?php if(isset($data["last_humidity"][0]["value"])){echo $data["last_humidity"][0]["value"];}else{echo "?";} ?> %</li>
	<li class="collection-item">Baromètre Actuel : <?php if(isset($data["last_pressure"][0]["value"])){echo $data["last_pressure"][0]["value"];}else{echo "?";} ?> hPa</li>
</ul>

<ul class="collection with-header" id="ensoleillement">
	<li class="collection-header"><a target="_blank" href="https://www.iconfinder.com/denir"><img class="vertical-align" src=<?php echo Url::templatePath() . '/img/dataImages/soleil.png' ?> alt="Icône Soleil"></a><h4 class="inline-block-padding vertical-align">Soleil</h4></li>
	<li class="collection-item">Indice UV : <?php if(isset($data["last_uvIndex"][0]["value"])){echo $data["last_uvIndex"][0]["value"];}else{echo "?";} ?></li>
	<li class="collection-item">Lever du soleil : <?php echo $data["sunrise_hour"]; ?></li>
	<li class="collection-item">Coucher du soleil : <?php echo $data["sunset_hour"]; ?></li>
	<li class="collection-item">Durée du jour : <?php echo $data["day_length"]; ?></li>
</ul>

<ul class="collection with-header" id="astronomie">

	<li class="collection-header"><img class="vertical-align" src=<?php echo Url::templatePath() . '/img/dataImages/astro.png' ?> alt="Icône Astronomie"><h4 class="inline-block-padding vertical-align">Astronomie</h4></li>

	<li class="collection-item">

		<a target="blank" style="text-decoration:none;" href="http://www.calendrier-lunaire.net/"><img class="adaptive" src="http://www.calendrier-lunaire.net/module/LYWR2YW5jZWQtMjY0LWgxLTE0NDI5MzE0NzkuOTk1Ni0jMTUwOTFmLTQyMC0jZGVlYWI0LTE0NDI5MzE0NzktNS0y.png" alt="La Lune" title="La Lune" /></a>

		<br>

		<?php 

			$conditions = $data["forecast_api"]["fcst_day_0"]["hourly_data"]["21H00"]["CONDITION"];

			if($conditions=="Stratus" || $conditions=="Nuit légèrement voilée" || $conditions=="Ciel voilé" || $conditions=="Nuit nuageuse" || $conditions=="Faiblement Nuageux" || $conditions=="Fortement nuageux" || $conditions=="Nuit avec averses" || $conditions=="Couvert avec averses" || $conditions=="Couvert avec averses"){

				echo "<p>Les conditions météo <b>ne sont visiblement pas au rendez-vous</b> pour observer le ciel ce soir !</p>";

			}else{

				echo "<p>Les conditions météo <b>ont l'air d'être au beau fixe</b> vous pouvez sortir pour observer le ciel ce soir !</p>";

			}

		?>

		<b><a target="blank" href="http://www.stelvision.com/carte-ciel/">Afficher la carte du ciel pour ce soir</a></b>

	</li>

</ul>

<ul class="collection with-header" id="meteogramme">
	<li class="collection-header"><img class="vertical-align" src=<?php echo Url::templatePath() . '/img/dataImages/tableau.png' ?> alt="Icône Météogramme"><h4 class="inline-block-padding vertical-align">Tableau</h4></li>
	<li class="collection-item"><a target="_blank" href="http://www.prevision-meteo.ch/meteo/localite/colmar"><img class="adaptive-forecast" src="http://www.prevision-meteo.ch/uploads/widget/colmar_0.png" width="700" height="250" alt="Meteogramme"/></a></li>
</ul>

<br>

<div class="alert alert-warning z-depth-1" id="toknow_alert" role="alert">
    <strong>Attention : </strong> Météo Colmar est un site purement amateur et ne peut donc pas remplacer ou substituer des données météos professionnel
</div>
