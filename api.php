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
		curl_setopt($ch, CURLOPT_POST, count($postData));
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);   

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

	static function SetProject($pole){
		//Zalo�en� nebo uprava projektu
		/*
		$pole["url"] - www projektu
		$pole["stav"] - ID fr�ze
		*/
		$url = SEMOR::$server."SetProject";
		return SEMOR::send($url,SEMOR::Data($pole));
	}

	static function GetProjectList(){
		//V�pis v�ech projekt�

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

	static function SetKeyword($pole){
		//Zalo�en�,maz�n� kl��ov�ch slov v syst�mu
		/*
		$pole["idp"] - ID projektu
		$pole["keyword"][] - pole kl��ov�ch slov
		$pole["frekvence"] - frekvence m��en� (0 - 1x za 30 dn�, 1 - 1x za 14 dn�, 2 - ka�d� den)
		$pole["stav"] - A zapnuti, C vypnut� m��en�
		Pokud uvedete idk, system bude d�lat upbdate na tomto IDK, dle nastaveni v��e. V tom p��pad� ignoruje polo�ku keyword
		$pole["idk"] - ID fr�ze
		
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

	static function GetLinkStats($pole){
		//V�pis statistik z evidovan�ch odkaz� v syst�mu pro dan� projekt
		$url = SEMOR::$server."GetLinkStats";
		return SEMOR::send($url,SEMOR::Data($pole));
	}

	static function SetLink($pole){
		//Z�pis nov�ho odkazu do syst�mu
		$url = SEMOR::$server."SetLink";
		return SEMOR::send($url,SEMOR::Data($pole));
	}
}
?>