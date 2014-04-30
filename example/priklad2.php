<?

include "../api.php";

$api = new SEMOR();
$api->jsonOutput = false;//Výpis výsledku bude v poli

$data = array(
	"idp"=>"15",//IDP = ID projektu v systému
);

$output = $api->GetKeywordList($data);//Vrátí seznam klíèových slov pro daný projekt

?>
<pre>
 <?
 print_r($output);
 ?>
</pre>