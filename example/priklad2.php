<?

include "../api.php";

$api = new SEMOR();
$api->jsonOutput = false;//V�pis v�sledku bude v poli

$data = array(
	"idp"=>"15",//IDP = ID projektu v syst�mu
);

$output = $api->GetKeywordList($data);//Vr�t� seznam kl��ov�ch slov pro dan� projekt
print_r($output);
?>