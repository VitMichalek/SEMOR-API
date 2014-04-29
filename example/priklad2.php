<?

include "../api.php";

$api = new SEMOR();
$api->jsonOutput = false;//Vэpis vэsledku bude v poli

$data = array(
	"idp"=>"15",//IDP = ID projektu v systйmu
);

$output = $api->GetKeywordList($data);//Vrбtн seznam klниovэch slov pro danэ projekt
print_r($output);
?>