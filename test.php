<?php

include('settings_t.php');
$canto="Purgatorio";
$text="basciò";

function decode_entities($texts) {
					$texts=htmlentities($texts, ENT_COMPAT,'ISO-8859-1', true);
					$texts= preg_replace('/&#(\d+);/me',"chr(\\1)",$texts); #decimal notation
					$texts= preg_replace('/&#x([a-f0-9]+);/mei',"chr(0x\\1)",$texts);  #hex notation
					$texts= html_entity_decode($texts,ENT_COMPAT,"UTF-8"); #NOTE: UTF-8 does not work!
return $texts;
}
$text=str_replace("?","",$text);
$text=str_replace("-","",$text);
//$text=str_replace("ò",chr(242),$text);

$location="Sto cercando argomenti con parola chiave: ".$text;
echo $location;
$text=str_replace(" ","%20",$text);
$text=strtolower($text);
//			$text=mb_strtoupper($text,'UTF-8');
			$text=str_replace("ò","%C3%B2",$text);
			$text=str_replace("à","%C3%A0",$text);
			$text=str_replace("è","%C3%A8",$text);
			$text=str_replace("é","%C3%A9",$text);
			$text=str_replace("ì","%C3%AC",$text);
			$text=str_replace("ù","%C3%B9",$text);


$urlgd  ="https://spreadsheets.google.com/tq?tqx=out:csv&tq=SELECT%20%2A%20WHERE%20lower(C)%20like%20%27%25";
$urlgd .=$text;
$urlgd .="%25%27&key=".GDRIVEKEY."&gid=".GDRIVEGID1;
$urlgd=trim($urlgd);
$urlgd=str_replace(array("\r", "\n"), '', $urlgd);
$inizio=0;
$homepage ="";

//echo "\n</br>".$urlgd; // debug
//$homepage1 = file_get_contents("https://spreadsheets.google.com/tq?tqx=out:csv&tq=SELECT%20%2A%20WHERE%20lower(C)%20like%20%27%25basci%C3%B2%25%27&key=1DwHpLyynUlauslxA3nup7xUWLcWQ4nKm5CURKijQvJg&gid=1070577019");
//echo $homepage1;
//$homepage1 = file_get_contents($urlgd);
//$file = 'log/fal.csv';

// scrivo il contenuto sul file locale.
//file_put_contents($file, $homepage1);

$csv = array_map('str_getcsv',file($urlgd));

$count = 0;
foreach($csv as $data=>$csv1){
	$count = $count+1;
}
if ($count ==0){
		$location="</br>Nessun risultato trovato";
		echo $location;
//		$content = array('chat_id' => $chat_id, 'text' => $location,'disable_web_page_preview'=>true);
//		$telegram->sendMessage($content);
	}
	if ($count >40){
			$location="Troppe risposte per il criterio scelto. Ti preghiamo di fare una ricerca più circoscritta";
			echo $location;
	//		$content = array('chat_id' => $chat_id, 'text' => $location,'disable_web_page_preview'=>true);
	//		$telegram->sendMessage($content);
			exit;
		}

for ($i=$inizio;$i<$count;$i++){

	$homepage .="\n";
	if (strpos($csv[$i][0],'O') !== false)$homepage .="\n";
	$homepage .=$csv[$i][0];
	if ($csv[$i][1] !=NULL) $homepage .=" Canto : ".$csv[$i][1];
	$homepage .="\n".$csv[$i][2];
	if ($csv[$i][3] !=NULL) 	$homepage .="\n".$csv[$i][3];
	if ($csv[$i][4] !=NULL) 	$homepage .="\n".$csv[$i][4];
	if ($csv[$i][5] !=NULL) 	$homepage .="\n".$csv[$i][5];
	if ($csv[$i][6] !=NULL) 	$homepage .="\n".$csv[$i][6];
//		$homepage .="\n____________\n";

}

   echo $homepage;

?>
