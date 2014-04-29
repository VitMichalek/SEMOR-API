<?
include "config.php";
class SEMOR{
	static $sever = "https://www.semor.cz/api/";
	static function send($url,$pole){
		$postData = array();
		$postData["token"] = semor_token;
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

	static function SetProject($pole){
		$url = $this->server."SetProject";
		return $this->send($url,$pole);
	}

	static function GetProjectList($pole){
		$url = $this->server."GetProjectList";
		return $this->send($url,$pole);
	}

	static function GetKeywordStats($pole){
		$url = $this->server."GetKeywordStat";
		return $this->send($url,$pole);
	}

	static function GetKeywordList($pole){
		$url = $this->server."GetKeywordList";
		return $this->send($url,$pole);
	}

	static function SetKeyword($pole){
		$url = $this->server."SetKeyword";
		return $this->send($url,$pole);
	}

	static function GetLinkList($pole){
		$url = $this->server."GetLinkList";
		return $this->send($url,$pole);
	}

	static function GetLinkStats($pole){
		$url = $this->server."GetLinkStats";
		return $this->send($url,$pole);
	}

	static function SetLink($pole){
		$url = $this->server."SetLink";
		return $this->send($url,$pole);
	}
}
?>