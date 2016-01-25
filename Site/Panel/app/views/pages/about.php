
<?php use Helpers\Url; ?>

<h5><b>La station : </b></h5>

<br>

<p>Cette station <b>diffère des autres</b> car la plupart des stations météo <b>sont basées sur des stations pré-faites et souvent très chères !</b> (ex: Vanguard)</p>
<p>De plus, la plupart de sites affichant la météo de manière amateur <b>utilise un logiciel qui fait une grande partie du travail de traitement</b> (affichage des graphes etc...) hors sur cette station, toutes les données sont traités par un <b>système fait main de A à Z</b>.</p>
<p>La station est située au Sud-Est de Colmar, en revanche la station est <b>installée sur un balcon</b>, c'est pourquoi les données <b>peuvent varier car le bâtiment bloque en partie le passage du vent.</b></p>

<br>

<h5><b>Composition de la station : </b></h5>

<br>

<p>La station utilise une <b>Arduino Mega</b> pour interfacer les différents capteurs et utilise un <b>Module ESP8266</b> pour envoyer les données facilement et rapidement dans la base de données MySQL du site.</p>
<br>

<ul class="collection with-header">
	<li class="collection-header"><h5>Capteurs : </h5></li>
    <li class="collection-item">Capteur de température / humidité (DHT22)</li>
    <li class="collection-item">Capteur de préssion (MPL115A2)</li>
    <li class="collection-item">Capteur d'impact de foudre (AS3935)</li>
    <li class="collection-item">Capteur d'indice UV Grove (GUVA-S12D)</li>
    <li class="collection-item">Kit Météo (Anémomètre / Girouette / Pluviomètre) (SEN-08942)</li>
</ul>

<br>

<h5><b>Fonctionnement de la station : </b></h5>

<br>

<p>Le fonctionnement est plutôt simple, l'Arduino Mega <b>récupère la valeur des capteurs toutes les X minutes</b> et les <b>envoie via le module ESP8266 à une API</b> qui <b>envoie elle-même les données à la base de données</b></p>

<p>En revanche, <b>lorsqu'un orage est détecté</b>, <b>le système arrête de chercher les valeurs</b> des capteurs pour <b>envoyer les informations sur l'orage (distance / intensité etc...)</b></p>

<br>

<h5><b>Autres services proposés : </b></h5>

<br>

<p>J'ai également créé un <a href="http://blog.meteo-colmar.fr/" target="_blank">blog</a> qui vous permet de <b>suivre l'avancée de la station</b>, <b>la manière dont je l'ai construite</b> etc...</p>

<p><b>En plus de ce blog</b> j'ai fait un petit <a href="http://photo.meteo-colmar.fr/" target="_blank">album photo</a> qui me permet de conjuguer mes <b>2 autres passions</b> : <b>la photographie et l'astronomie</b></p>

<br>

<h5><b>Services Utilisés : </b></h5>

<br>

<p><a href="http://www.calendrier-lunaire.net/" target="_blank">Calendrier-lunaire</a> m'a permis d'afficher l'image <b>apportant les informations sur la lune</b></b></p>
<p><a href="http://fetedujour.fr/" target="_blank">Fête du jour</a> m'a permis grâce à leur API de <b>récupérer la fête du jour</b></p>
<p><a href="http://www.prevision-meteo.ch/" target="_blank">Prévision-meteo.ch</a> me permet de <b>récupérer les prévisions météos sur 4 jours</b></p>
<p>J'ai aussi eu l'occasion d'utiliser un framework CSS qui se nomme <a href="http://materializecss.com/" target="_blank">MaterializeCSS</a> que j'ai avant tout utilisé pour <b>faire une base de design</b></p>
<p>En plus du framework CSS j'ai utilisé un framework PHP se nommant <a href="http://simplemvcframework.com/" target="_blank">SimpleMVCFramework</a> qui m'a aussi permis de <b>faire le coeur du site facilement</b></p>

<br>

<h5><b>Me contacter : </b></h5>

<br>

<ul class="share-buttons">
  <li><a href="https://twitter.com/Frey_Alvin" target="_blank" alt="Twitter" title="Twitter"><img src=<?php echo Url::templatePath(). "img/logo/Twitter.png" ?>></a></li>
  <li><a href="https://plus.google.com/117708629348124646552/posts" target="_blank" alt="Google+" title="Google+"><img src=<?php echo Url::templatePath(). "img/logo/Google+.png" ?>></a></li>
  <li><a href="contact" target="_blank" alt="Email" title="Email"><img src=<?php echo Url::templatePath(). "img/logo/Email.png" ?>></a></li>
</ul>