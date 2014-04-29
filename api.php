<?
include "config.php";
class SEMOR{
	public $jsonOutput = true; //defaultne vraci vysledek jako JSON, false => vrací Array()
	static $sever = "https://www.semor.cz/api/"; 

	static function send($url,$pole){
		//Odesle požadavek na server a zpracuje odpoved
		$postData = array();
		$postData["token"] = semor_token;//Jedineèný token, je pøidìlován každému zájemci o API
		$postData["data"] = $pole;

		$ch = curl_init(); 

		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
		curl_setopt($ch,CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_POST, count($postData));
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);   

		$output=curl_exec($ch);

		curl_close($ch);
		return () ? json_decode($output) : $output;//dle nastavení jsonOutput vrací hodnoty json/array
	}


	static function Data($data){
		if(is_array($data) && count($data)!=0){
			return json_encode($data);
		}else{
		
		}
	}

	static function SetProject($pole){
		//Založení nebo uprava projektu
		$url = $this->server."SetProject";
		return $this->send($url,$pole);
	}

	static function GetProjectList($pole){
		//Výpis všech projektù
		$url = $this->server."GetProjectList";
		return $this->send($url,$pole);
	}

	static function GetKeywordStats($pole){
		//Výpis statistick pro klíèové slovo
		$url = $this->server."GetKeywordStat";
		return $this->send($url,$pole);
	}

	static function GetKeywordList($pole){
		//Výpis seznamu klíèových slov s hodnotou o posledním mìøení
		$url = $this->server."GetKeywordList";
		return $this->send($url,$pole);
	}

	static function SetKeyword($pole){
		//Založení,mazání klíèových slov v systému
		$url = $this->server."SetKeyword";
		return $this->send($url,$pole);
	}

	static function GetLinkList($pole){
		//Výpis evidovaných odkazù v systému pro daný projekt
		$url = $this->server."GetLinkList";
		return $this->send($url,$pole);
	}

	static function GetLinkStats($pole){
		//Výpis statistik z evidovaných odkazù v systému pro daný projekt
		$url = $this->server."GetLinkStats";
		return $this->send($url,$pole);
	}

	static function SetLink($pole){
		//Zápis nového odkazu do systému
		$url = $this->server."SetLink";
		return $this->send($url,$pole);
	}
}
?>