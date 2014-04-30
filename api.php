<?
include "config.php";
class SEMOR{
	static $jsonOutput = false; //defaultne vraci vysledek jako JSON, false => vrací Array()
	static $server = "http://www.semor.cz/api/"; 

	public function __construct(){
		SEMOR::testToken();
	}

	static function testToken(){
		if(strlen(SEMOR_TOKEN) != 45) {
			echo "Chybnì zadaný token. Zkontrolujte své nastavení v config.php";
			return;
		}
	}

	static function send($url,$pole){
		//Odesle požadavek na server a zpracuje odpoved
		$postData = array();
		$postData["token"] = SEMOR_TOKEN;//Jedineèný token, je pøidìlován každému zájemci o API
		$postData["data"] = $pole;

		$ch = curl_init(); 



		curl_setopt($ch,CURLOPT_URL,$url."/");
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
		curl_setopt($ch,CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_POST, count($postData));
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);   

		$output=curl_exec($ch);

		curl_close($ch);
		return (!SEMOR::$jsonOutput) ? json_decode($output,true) : $output;//dle nastavení jsonOutput vrací hodnoty json/array
	}


	static function Data($data){
		if(is_array($data) && count($data)!=0){
			return json_encode($data);
		}else{
			echo "Data v požadavku nejsou vyplnìna!";
			return;
		}
	}

	static function SetProject($pole){
		//Založení nebo uprava projektu
		/*
		$pole["url"] - www projektu
		$pole["stav"] - ID fráze
		*/
		$url = SEMOR::$server."SetProject";
		return SEMOR::send($url,SEMOR::Data($pole));
	}

	static function GetProjectList(){
		//Výpis všech projektù

		$url = SEMOR::$server."GetProjectList";
		return SEMOR::send($url,"{}");
	}

	static function GetKeywordStats($pole){
		//Výpis statistick pro klíèové slovo
		/*
		$pole["idp"] - ID projektu
		$pole["idk"] - ID fráze
		*/
		$url = SEMOR::$server."GetKeywordStat";
		return SEMOR::send($url,SEMOR::Data($pole));
	}

	static function GetKeywordList($pole){
		//Výpis seznamu klíèových slov s hodnotou o posledním mìøení
		/*
		$pole["idp"] - ID projektu
		*/
		$url = SEMOR::$server."GetKeywordList";
		return SEMOR::send($url,SEMOR::Data($pole));
	}

	static function SetKeyword($pole){
		//Založení,mazání klíèových slov v systému
		/*
		$pole["idp"] - ID projektu
		$pole["keyword"][] - pole klíèových slov
		$pole["frekvence"] - frekvence mìøení (0 - 1x za 30 dní, 1 - 1x za 14 dní, 2 - každý den)
		$pole["stav"] - A zapnuti, C vypnutí mìøení
		Pokud uvedete idk, system bude dìlat upbdate na tomto IDK, dle nastaveni výše. V tom pøípadì ignoruje položku keyword
		$pole["idk"] - ID fráze
		
		*/
		$url = SEMOR::$server."SetKeyword";
		return SEMOR::send($url,SEMOR::Data($pole));
	}

	static function GetLinkList($pole){
		//Výpis evidovaných odkazù v systému pro daný projekt
		/*
		$pole["idp"] - ID projektu	
		*/
		$url = SEMOR::$server."GetLinkList";
		return SEMOR::send($url,SEMOR::Data($pole));
	}

	static function GetLinkStats($pole){
		//Výpis statistik z evidovaných odkazù v systému pro daný projekt
		$url = SEMOR::$server."GetLinkStats";
		return SEMOR::send($url,SEMOR::Data($pole));
	}

	static function SetLink($pole){
		//Zápis nového odkazu do systému
		$url = SEMOR::$server."SetLink";
		return SEMOR::send($url,SEMOR::Data($pole));
	}
}
?>