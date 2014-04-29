<?

include "../api.php";

$api = new SEMOR();

$data = array(
	"url"=>"www.domena.cz",
);

$api->SetProject($data);
?>