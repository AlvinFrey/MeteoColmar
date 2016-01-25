window.onload=function() {
	getHours('heure');
};
 
function getHours(id) {

	if(typeof id=="string"){ 

		id = document.getElementById(id); 

	}

	function refresh() {

		var date = new Date();
		var str = date.getHours();
		str += 'h'+(date.getMinutes()<10?'0':'')+date.getMinutes();
		str += 'm'+(date.getSeconds()<10?'0':'')+date.getSeconds() + 's';
		id.innerHTML = str;
		
  	}
  
  	refresh();
  	setInterval(refresh,1000);

}