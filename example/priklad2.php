<?

include "../api.php";

$api = new SEMOR();

$data = array(
	"idp"=>"15",
);

$api->GetKeywordList($data);
?>