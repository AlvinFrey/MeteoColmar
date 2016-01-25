

$(document).ready(function(){

	if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {

		$("#forecastFrame").remove();
		$("#moreForecast").remove();
		$("br").remove();

	}else{

		$(".forecast").hide();

	}
   
});


$("#moreForecast").click(function(){

	if($(".forecast").css("display")=="none"){

		$("#moreForecast").html("<b>Cacher les détails</b>");
		$(".forecast").show();

	}else{

		$("#moreForecast").html("<b>Afficher plus de détails</b>");
		$(".forecast").hide();
		
	}
   
});