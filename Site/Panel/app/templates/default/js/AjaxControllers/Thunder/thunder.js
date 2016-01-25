
$( document ).ready(function(){

	if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {

		$("#thunderMap").css('width', '100%');
		$("#thunderMap").css('height', '50%');
		$("#thunderMap").css('margin-bottom', '20px');
		$("#tableThunder").css('width', '100%');

	}

	$.ajax({
	    url : 'thunder/getLightning',
	    type : 'POST',
	    dataType : 'json',
	    data : {},
	    beforeSend: function(){
	    },
	    success: function(resultat){

	    	if(resultat!=""){

		        for(var i in resultat){

		        	$("#thunderResult").append("<tr><td>"+ resultat[i]["date"] +"</td><td>"+ resultat[i]["time"] +"</td><td>"+ resultat[i]["value"] +" km</td></tr>");

		        }

	        }

	     }
	
	});

});