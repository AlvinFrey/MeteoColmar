
<div id="forecastFrame" style="width:100%;color:#000;">

	<iframe height="95" frameborder="0" width="510" scrolling="no" src="http://www.prevision-meteo.ch/services/html/colmar/horizontal" allowtransparency="true"></iframe>

</div>

<br>

<p id="moreForecast"><b>Afficher plus de détails</b></p>

<br>

<div class="forecast">

	<ul class="collection with-header">
	    <li class="collection-header"><img class="vertical-align" src=<?php echo $data["icon+1"];?>></img><h4 class="inline-block-padding vertical-align"><?php echo date('d/m/Y', strtotime("+1 days")); ?></h4></li>
	    <li class="collection-item">Température Minimale : <?php echo $data["tempMin+1"]; ?>°</li>
	    <li class="collection-item">Température Maximale : <?php echo $data["tempMax+1"]; ?>°</li>
	    <li class="collection-item">Résumé de la journée : <?php echo $data["resume+1"]; ?></li>
		<li class="collection-item"><a href="http://www.prevision-meteo.ch/meteo/localite/colmar"><img class="adaptive-forecast" src="http://www.prevision-meteo.ch/uploads/widget/colmar_1.png" width="650" height="250" /></a></li>

	</ul>

	<ul class="collection with-header">
	   <li class="collection-header"><img class="vertical-align" src=<?php echo $data["icon+2"];?>></img><h4 class="inline-block-padding vertical-align"><?php echo date('d/m/Y', strtotime("+2 days")); ?></h4></li>
	    <li class="collection-item">Température Minimale : <?php echo $data["tempMin+2"]; ?>°</li>
	    <li class="collection-item">Température Maximale : <?php echo $data["tempMax+2"]; ?>°</li>
	    <li class="collection-item">Résumé de la journée : <?php echo $data["resume+2"]; ?></li>
		<li class="collection-item"><a href="http://www.prevision-meteo.ch/meteo/localite/colmar"><img class="adaptive-forecast" src="http://www.prevision-meteo.ch/uploads/widget/colmar_2.png" width="650" height="250" /></a></li>

	</ul>


	<ul class="collection with-header">
	    <li class="collection-header"><img class="vertical-align" src=<?php echo $data["icon+3"];?>></img><h4 class="inline-block-padding vertical-align"><?php echo date('d/m/Y', strtotime("+3 days")); ?></h4></li>
	    <li class="collection-item">Température Minimale : <?php echo $data["tempMin+3"]; ?>°</li>
	    <li class="collection-item">Température Maximale : <?php echo $data["tempMax+3"]; ?>°</li>
	    <li class="collection-item">Résumé de la journée : <?php echo $data["resume+3"]; ?></li>
		<li class="collection-item"><a href="http://www.prevision-meteo.ch/meteo/localite/colmar"><img class="adaptive-forecast" src="http://www.prevision-meteo.ch/uploads/widget/colmar_3.png" width="650" height="250" /></a></li>

	</ul>


	<ul class="collection with-header">
	    <li class="collection-header"><img class="vertical-align" src=<?php echo $data["icon+4"];?>></img><h4 class="inline-block-padding vertical-align"><?php echo date('d/m/Y', strtotime("+4 days")); ?></h4></li>
	    <li class="collection-item">Température Minimale : <?php echo $data["tempMin+4"]; ?>°</li>
	    <li class="collection-item">Température Maximale : <?php echo $data["tempMax+4"]; ?>°</li>
	    <li class="collection-item">Résumé de la journée : <?php echo $data["resume+4"]; ?></li>
		<li class="collection-item"><a href="http://www.prevision-meteo.ch/meteo/localite/colmar"><img class="adaptive-forecast" src="http://www.prevision-meteo.ch/uploads/widget/colmar_4.png" width="650" height="250" /></a></li>

	</ul>

</div>

<div class="alert alert-warning z-depth-1" role="alert">
    <strong>Attention : </strong> Les données affichées sur cette page proviennent du site : prevision-meteo.ch et non du site Météo Colmar
</div>
