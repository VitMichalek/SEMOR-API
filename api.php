<?
include "config.php";
class SEMOR{
	static $sever = "https://www.semor.cz/api/";
	static function send($url,$pole){
		$postData = array();
		$postData["data"] = $pole;

		$ch = curl_init(); 

		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
		curl_setopt($ch,CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_POST, count($postData));
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);   

		$output=curl_exec($ch);

		curl_close($ch);
		return $output;
	}

	static function Data($data){
		if(is_array($data) && count($data)!=0){
			return json_encode($data);
		}else{
		
		}
	}

	static function GetProject($pole){
		$url = $this->server."GetProject";
		return $this->send($url,$pole);
	}

	static function SetProject($pole){
		$url = $this->server."SetProject";
		return $this->send($url,$pole);
	}
}

$data = array();
$data["idp"] = 4;

$api = new SEMOR();
$data = Data($data);
$api->GetProject($data);
?>