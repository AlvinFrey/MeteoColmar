<?php

	use Helpers\Assets;
	use Helpers\Url;
	use Helpers\Hooks;

	$hooks = Hooks::get();

?>

</div>

<?php

	//Array contains JS files required by template, regardless of view.
	$jsFileArray = array(
	    Url::templatePath() . 'js/materialize.min.js', 
		Url::templatePath() . 'js/main.js'    
	);

	if (isset($data['javascript'])){
	    foreach ($data['javascript'] as &$jsFile) {
	        array_push($jsFileArray, URL::templatePath() . "js/" . $jsFile . ".js");
	    }
	}

	Assets::js($jsFileArray);

	$hooks->run('js');
	$hooks->run('footer');

?>

</body>
</html>
