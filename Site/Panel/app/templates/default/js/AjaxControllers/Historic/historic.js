
$( document ).ready(function(){

	$(".table").hide();

});

$("#dayButton").click(function(){

 	$("#settings").empty();

 	$("#settings").append('<div class="col s4"><label>Choisir le jour</label><select class="browser-default" id="daySettings"><option value="" selected>Jour</option><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option><option value="13">13</option><option value="14">14</option><option value="15">15</option><option value="16">16</option><option value="17">17</option><option value="18">18</option><option value="19">19</option><option value="20">20</option><option value="21">21</option><option value="22">22</option><option value="23">23</option><option value="24">24</option><option value="25">25</option><option value="26">26</option><option value="27">27</option><option value="28">28</option><option value="29">29</option><option value="30">30</option><option value="31">31</option></select></div>');
 	$("#settings").append('<div class="col s4"><label>Choisir le mois</label><select class="browser-default" id="monthSettings"><option value="" selected>Mois</option><option value="1">Janvier</option><option value="2">Février</option><option value="3">Mars</option><option value="4">Avril</option><option value="5">Mai</option><option value="6">Juin</option><option value="7">Juillet</option><option value="8">Août</option><option value="9">Septembre</option><option value="10">Octobre</option><option value="11">Novembre</option><option value="12">Décembre</option></select></div>');
 	$("#settings").append('<div class="col s4"><label>Choisir l\'année</label><select class="browser-default" id="yearSettings"><option value="" selected>Année</option><option value="2015">2015</option><option value="2016">2016</option></div>');
 	$("#settings").append('<div class="col s4"><label>Choisir le type</label><select class="browser-default" id="typeSettings"><option value="all">Tout</option><option value="temperature">Température</option><option value="humidity">Humidité</option><option value="uvIndex">Indice UV</option><option value="pressure">Pression</option><option value="windSpeed">Vitesse du vent</option><option value="rainFall">Pluie</option></select></div>');
 	$("#settings").append('<br><br><br><br><br><br><br><div class="col s4"><a class="waves-effect waves-light btn" id="sendSettings">Envoyer</a></div>');

 	$("#sendSettings").click(function(){
 		
 		$("#historicResult tr").remove();

 		var day = $('#daySettings :selected').val();
 		var month = $('#monthSettings :selected').val();
 		var year = $('#yearSettings :selected').val();
 		var type = $('#typeSettings :selected').val();
 		var isJson = $('#json').val();

 		if(day == "" || month == "" || year == ""){

 			swal({
	        	title: "Oups !",   
	        	text: "Un champ au moins est manquant",
	        	confirmButtonText: "OK", 
	        	confirmButtonColor: "#C0392B",
	        	type: "error"
	        });

 		}else{

 			$("#settings").empty();
 			$(".progress").css({display: "block"});

			$.ajax({
	        	url : 'historic/searchSend',
	        	type : 'POST',
	        	dataType : 'json',
	        	data : { day: day, month: month, year: year, type: type },
	        	beforeSend: function(){
	        	},
	        	success: function(resultat){

	        		$(".progress").css({display: "none"});

	        		if(resultat!=""){

		        		for(var i in resultat){

		        			$("#historicResult").append("<tr><td>"+ resultat[i]["date"] +"</td><td>"+ resultat[i]["time"] +"</td><td>"+ resultat[i]["value"] +"</td><td>"+ resultat[i]["type"] +"</td></tr>");


		        		}

		        		$(".table").show();

	        		}else{

	        			swal({
	        				title: "Données Introuvable !",   
	        				text: "Désolé, mais aucune données n'a été trouvé pour cette date",
	        				confirmButtonText: "Dommage", 
	        				confirmButtonColor: "#C0392B",
	        				imageUrl: "https://cdn3.iconfinder.com/data/icons/linecons-free-vector-icons-pack/32/data-64.png"
	        			});

	        		}

	     		}
	      	});

 		}

 	});

});

$("#monthButton").click(function(){

	$("#settings").empty();

 	$("#settings").append('<div class="col s4"><label>Choisir le mois</label><select class="browser-default" id="monthSettings"><option value="" selected>Mois</option><option value="1">Janvier</option><option value="2">Février</option><option value="3">Mars</option><option value="4">Avril</option><option value="5">Mai</option><option value="6">Juin</option><option value="7">Juillet</option><option value="8">Août</option><option value="9">Septembre</option><option value="10">Octobre</option><option value="11">Novembre</option><option value="12">Décembre</option></select></div>');
 	$("#settings").append('<div class="col s4"><label>Choisir l\'année</label><select class="browser-default" id="yearSettings"><option value="" selected>Année</option><option value="2015">2015</option><option value="2016">2016</option></select></div>');
 	$("#settings").append('<div class="col s4"><label>Choisir le type</label><select class="browser-default" id="typeSettings"><option value="all">Tout</option><option value="temperature">Température</option><option value="humidity">Humidité</option><option value="uvIndex">Indice UV</option><option value="pressure">Pression</option><option value="windSpeed">Vitesse du vent</option><option value="rainFall">Pluie</option></select></div>');
 	$("#settings").append('<br><br><br><br><div class="col s4"><a class="waves-effect waves-light btn" id="sendSettings">Envoyer</a></div>');

 	$("#sendSettings").click(function(){
 		
 		$("#historicResult tr").remove();

 		var month = $('#monthSettings :selected').val();
 		var year = $('#yearSettings :selected').val();
 		var type = $('#typeSettings :selected').val();
 		var isJson = $('#json').val();

 		if(month == "" || year == ""){

 			swal({
	        	title: "Oups !",   
	        	text: "Un champ au moins est manquant",
	        	confirmButtonText: "OK", 
	        	confirmButtonColor: "#C0392B",
	        	type: "error"
	        });

 		}else{

 			$("#settings").empty();
 			$(".progress").css({display: "block"});

			$.ajax({
	        	url : 'historic/searchSend',
	        	type : 'POST',
	        	dataType : 'json',
	        	data : { month: month, year: year, type: type },
	        	beforeSend: function(){
	        	},
	        	success: function(resultat){

	        		$(".progress").css({display: "none"});

	        		if(resultat!=""){

	        			for(var i in resultat){

	        				$("#historicResult").append("<tr><td>"+ resultat[i]["date"] +"</td><td>"+ resultat[i]["time"] +"</td><td>"+ resultat[i]["value"] +"</td><td>"+ resultat[i]["type"] +"</td></tr>");

			        	}

			        	$(".table").show();

	        		}else{

	        			swal({
	        				title: "Données Introuvable !",   
	        				text: "Désolé, mais aucune données n'a été trouvé pour ce mois",
	        				confirmButtonText: "Dommage", 
	        				confirmButtonColor: "#C0392B",
	        				imageUrl: "https://cdn3.iconfinder.com/data/icons/linecons-free-vector-icons-pack/32/data-64.png"
	        			});

	        		}

	     		}
	      	});

 		}

 	});
   
});

$("#yearButton").click(function(){

	$("#settings").empty();

 	$("#settings").append('<div class="col s4"><label>Choisir l\'année</label><select class="browser-default" id="yearSettings"><option value="" selected>Année</option><option value="2015">2015</option><option value="2016">2016</option></select></div>');
 	$("#settings").append('<div class="col s4"><label>Choisir le type</label><select class="browser-default" id="typeSettings"><option value="all">Tout</option><option value="temperature">Température</option><option value="humidity">Humidité</option><option value="uvIndex">Indice UV</option><option value="pressure">Pression</option><option value="windSpeed">Vitesse du vent</option><option value="rainFall">Pluie</option></select></div>');
 	$("#settings").append('<br><br><br><br><div class="col s4"><a class="waves-effect waves-light btn" id="sendSettings">Envoyer</a></div>');

 	$("#sendSettings").click(function(){
 		
		$("#historicResult tr").remove();

 		var year = $('#yearSettings :selected').val();
 		var type = $('#typeSettings :selected').val();
 		var isJson = $('#json').val();

 		if(year == ""){

 			swal({
	        	title: "Oups !",   
	        	text: "Un champ au moins est manquant",
	        	confirmButtonText: "OK", 
	        	confirmButtonColor: "#C0392B",
	        	type: "error"
	        });

 		}else{

 			$("#settings").empty();
 			$(".progress").css({display: "block"});

			$.ajax({
	        	url : 'historic/searchSend',
	        	type : 'POST',
	        	dataType : 'json',
	        	data : { year: year, type: type },
	        	beforeSend: function(){
	        	},
	        	success: function(resultat){

	        		$(".progress").css({display: "none"});

	        		if(resultat!=""){

		        		for(var i in resultat){

		        			$("#historicResult").append("<tr><td>"+ resultat[i]["date"] +"</td><td>"+ resultat[i]["time"] +"</td><td>"+ resultat[i]["value"] +"</td><td>"+ resultat[i]["type"] +"</td></tr>");

		        		}

		        		$(".table").show();

	        		}else{

	        			swal({
	        				title: "Données Introuvable !",   
	        				text: "Désolé, mais aucune données n'a été trouvé pour cette année",
	        				confirmButtonText: "Dommage", 
	        				confirmButtonColor: "#C0392B",
	        				imageUrl: "https://cdn3.iconfinder.com/data/icons/linecons-free-vector-icons-pack/32/data-64.png"
	        			});

	        		}

	     		}
	      	});

 		}

 	});
   
});