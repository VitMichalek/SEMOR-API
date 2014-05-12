<?
include "config.php";
class SEMOR{
	static $jsonOutput = false; //defaultne vraci vysledek jako JSON, false => vrac� Array()
	static $server = "http://www.semor.cz/api/"; 

	public function __construct(){
		SEMOR::testToken();
	}

	static function testToken(){
		if(strlen(SEMOR_TOKEN) != 45) {
			echo "Chybn� zadan� token. Zkontrolujte sv� nastaven� v config.php";
			return;
		}
	}

	static function send($url,$pole){
		//Odesle po�adavek na server a zpracuje odpoved
		$postData = array();
		$postData["token"] = SEMOR_TOKEN;//Jedine�n� token, je p�id�lov�n ka�d�mu z�jemci o API
		$postData["data"] = $pole;

		$ch = curl_init(); 



		curl_setopt($ch,CURLOPT_URL,$url."/");
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
		curl_setopt($ch,CURLOPT_HEADER, false);
		curl_setopt($ch,CURLOPT_POST, count($postData));
		curl_setopt($ch,CURLOPT_POSTFIELDS, $postData);   

		$output=curl_exec($ch);

		curl_close($ch);
		return (!SEMOR::$jsonOutput) ? json_decode($output,true) : $output;//dle nastaven� jsonOutput vrac� hodnoty json/array
	}


	static function Data($data){
		if(is_array($data) && count($data)!=0){
			return json_encode($data);
		}else{
			echo "Data v po�adavku nejsou vypln�na!";
			return;
		}
	}

	static function PutProject($pole){
		//Zalo�en� 
		/*
		$pole["url"] - www projektu
		*/

		$url = SEMOR::$server."PutProject";
		return SEMOR::send($url,SEMOR::Data($pole));
	}

	static function SetProject($pole){
		// uprava projektu
		/*
		$pole["idp"] - IDP projektu
		$pole["stav"] - stav projektu A,C
		*/
		$url = SEMOR::$server."SetProject";
		return SEMOR::send($url,SEMOR::Data($pole));
	}

	static function GetProjectList(){
		//V�pis v�ech projekt� pro dan� token

		$url = SEMOR::$server."GetProjectList";
		return SEMOR::send($url,"{}");
	}

	static function GetKeywordStats($pole){
		//V�pis statistick pro kl��ov� slovo
		/*
		$pole["idp"] - ID projektu
		$pole["idk"] - ID fr�ze
		*/
		$url = SEMOR::$server."GetKeywordStat";
		return SEMOR::send($url,SEMOR::Data($pole));
	}

	static function GetKeywordList($pole){
		//V�pis seznamu kl��ov�ch slov s hodnotou o posledn�m m��en�
		/*
		$pole["idp"] - ID projektu
		*/
		$url = SEMOR::$server."GetKeywordList";
		return SEMOR::send($url,SEMOR::Data($pole));
	}

	static function PutKeyword($pole){
		//Zalo�en�
		/*
		$pole["idp"] - ID projektu
		$pole["keyword"][] - pole kl��ov�ch slov
		$pole["keyword"][0][0] = "slovo";
		$pole["keyword"][0][1] = "A";
		$pole["keyword"][0][2] = 0;
		$pole["keyword"][1][0] = "slovo 2";
		$pole["keyword"][1][1] = "A";
		$pole["keyword"][1][2] = 1;
		//frekvence m��en� (0 - 1x za 30 dn�, 1 - 1x za 14 dn�, 2 - ka�d� den)
		Pokud uvedete idk, system bude d�lat upbdate na tomto IDK, dle nastaveni v��e. V tom p��pad� ignoruje polo�ku keyword
		$pole["idk"] - ID fr�ze
		
		*/
		$url = SEMOR::$server."PutKeyword";
		return SEMOR::send($url,SEMOR::Data($pole));
	}

	static function SetKeyword($pole){
		//maz�n� fr�ze v syst�mu
		/*
		$pole["idp"] - ID projektu
		$pole["keyword"][] - pole kl��ov�ch slov
		$pole["keyword"][idk][0] = stav;
		$pole["keyword"][idk][1] = frekvence;
		idk - id kl��ov�ho slova
		
		Zatim neni p�ipraveno
		
		*/
		$url = SEMOR::$server."SetKeyword";
		return SEMOR::send($url,SEMOR::Data($pole));
	}

	static function GetLinkList($pole){
		//V�pis evidovan�ch odkaz� v syst�mu pro dan� projekt
		/*
		$pole["idp"] - ID projektu	
		*/
		$url = SEMOR::$server."GetLinkList";
		return SEMOR::send($url,SEMOR::Data($pole));
	}

	static function SetLink($pole){
		//Z�pis nov�ho odkazu do syst�mu
		/*
		$pole["source"] - url umisteni odkazu
		$pole["target"] - url c�le odkazu
		$pole["anchor"] - anchor odkazu
		*/
		$url = SEMOR::$server."SetLink";
		return SEMOR::send($url,SEMOR::Data($pole));
	}

	static function GetSpeed($pole){
		//V�pis posledn�ho m��en� GooglePageSpeed - nejd��ve 10 minut po vlo�en� nov�ho projektu
		/*
		$pole["idp"] - ID projektu	
		*/
		$url = SEMOR::$server."GetSpeed";
		return SEMOR::send($url,SEMOR::Data($pole));
	}
}
?>