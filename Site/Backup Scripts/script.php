<?php 

	backup_tables('***','***','***','***');

	function backup_tables($host,$user,$pass,$name,$tables = '*'){
		
		$link = mysql_connect($host,$user,$pass);
		mysql_select_db($name,$link);

		if($tables == '*'){

			$tables = array();
			$result = mysql_query('SHOW TABLES');

			while($row = mysql_fetch_row($result)){
				$tables[] = $row[0];
			}

		}else{

			$tables = is_array($tables) ? $tables : explode(',',$tables);

		}
		
		foreach($tables as $table){

			$result = mysql_query('SELECT * FROM '.$table);
			$num_fields = mysql_num_fields($result);
			
			$return.= 'DROP TABLE '.$table.';';
			$row2 = mysql_fetch_row(mysql_query('SHOW CREATE TABLE '.$table));
			$return.= "\n\n".$row2[1].";\n\n";
			
			for ($i = 0; $i < $num_fields; $i++){

				while($row = mysql_fetch_row($result)){

					$return.= 'INSERT INTO '.$table.' VALUES(';
					
					for($j=0; $j<$num_fields; $j++) {

						$row[$j] = addslashes($row[$j]);
						$row[$j] = ereg_replace("\n","\\n",$row[$j]);
						if (isset($row[$j])) { $return.= '"'.$row[$j].'"' ; } else { $return.= '""'; }
						if ($j<($num_fields-1)) { $return.= ','; }

					}
					
					$return.= ");\n";

				}
			
			}
			
			$return.="\n\n\n";
		
		}
		
		$handle = fopen('backupFiles/backup_'.date('d-m-Y').'_'.date('G:i:s').'.sql','w+');
		fwrite($handle,$return);
		fclose($handle);

		$headers ='From: "Backup SQL Météo Colmar"<srv@meteo-colmar.fr>'."\n"; 
	    $headers .='Reply-To: noreply@meteo-colmar.fr'."\n"; 
	    $headers .='Content-Type: text/html; charset="UTF-8"'."\n"; 

	    mail('***', 'Backup SQL du '. date('d/m/Y') .'', 'Une Backup SQL à eu lieu le '. date('d/m/Y') .' à '. date('G:i:s') .' <br/> <br/> Voici l\'emplacement du fichier : ***/Backup/backup_files/backup_'.date('d-m-Y').'_'.date('G:i:s').'.sql', $headers);

	}

?>