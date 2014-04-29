<?
include "config.php";
class SEMOR{
	public $jsonOutput = true; //defaultne vraci vysledek jako JSON, false => vrac� Array()
	static $sever = "https://www.semor.cz/api/"; 

	static function send($url,$pole){
		//Odesle po�adavek na server a zpracuje odpoved
		$postData = array();
		$postData["token"] = semor_token;//Jedine�n� token, je p�id�lov�n ka�d�mu z�jemci o API
		$postData["data"] = $pole;

		$ch = curl_init(); 

		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
		curl_setopt($ch,CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_POST, count($postData));
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);   

		$output=curl_exec($ch);

		curl_close($ch);
		return () ? json_decode($output) : $output;//dle nastaven� jsonOutput vrac� hodnoty json/array
	}


	static function Data($data){
		if(is_array($data) && count($data)!=0){
			return json_encode($data);
		}else{
		
		}
	}

	static function SetProject($pole){
		//Zalo�en� nebo uprava projektu
		$url = $this->server."SetProject";
		return $this->send($url,$pole);
	}

	static function GetProjectList($pole){
		//V�pis v�ech projekt�
		$url = $this->server."GetProjectList";
		return $this->send($url,$pole);
	}

	static function GetKeywordStats($pole){
		//V�pis statistick pro kl��ov� slovo
		$url = $this->server."GetKeywordStat";
		return $this->send($url,$pole);
	}

	static function GetKeywordList($pole){
		//V�pis seznamu kl��ov�ch slov s hodnotou o posledn�m m��en�
		$url = $this->server."GetKeywordList";
		return $this->send($url,$pole);
	}

	static function SetKeyword($pole){
		//Zalo�en�,maz�n� kl��ov�ch slov v syst�mu
		$url = $this->server."SetKeyword";
		return $this->send($url,$pole);
	}

	static function GetLinkList($pole){
		//V�pis evidovan�ch odkaz� v syst�mu pro dan� projekt
		$url = $this->server."GetLinkList";
		return $this->send($url,$pole);
	}

	static function GetLinkStats($pole){
		//V�pis statistik z evidovan�ch odkaz� v syst�mu pro dan� projekt
		$url = $this->server."GetLinkStats";
		return $this->send($url,$pole);
	}

	static function SetLink($pole){
		//Z�pis nov�ho odkazu do syst�mu
		$url = $this->server."SetLink";
		return $this->send($url,$pole);
	}
}
?>