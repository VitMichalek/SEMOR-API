<?
include "config.php";
class SEMOR{
	static $jsonOutput = false; //defaultne vraci vysledek jako JSON, false => vrací Array()
	static $method = "P"; // POST/GET
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
		
		$GET = "";
		$ch = curl_init(); 

		
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
		curl_setopt($ch,CURLOPT_HEADER, false);
		if($this->method == "P"){
			$postData = array();
			$postData["token"] = SEMOR_TOKEN;//Jedineèný token, je pøidìlován každému zájemci o API
			$postData["data"] = $pole;

			curl_setopt($ch,CURLOPT_POST, count($postData));
			curl_setopt($ch,CURLOPT_POSTFIELDS, $postData);   
		}else{
			$GET = "?";
			$GET.= "token="+SEMOR_TOKEN;
			$GET.= "&".$pole;
		}
		curl_setopt($ch,CURLOPT_URL,$url."/".$GET);
		$output=curl_exec($ch);

		curl_close($ch);
		return (!SEMOR::$jsonOutput) ? json_decode($output,true) : $output;//dle nastavení jsonOutput vrací hodnoty json/array
	}


	static function Data($data){
		if(is_array($data) && count($data)!=0){
			if($this->method == "P"){
				return json_encode($data);
			}else{
				$prop = array();
				foreach($data as $i => $o){
					$prop[] = $i."=".$o;
				}
				return join("&",$prop);
			}
		}else{
			echo "Data v požadavku nejsou vyplnìna!";
			return;
		}
	}

	static function PutProject($pole){
		//Založení 
		/*
		$pole["url"] - www projektu
		*/
		$this->method = "P";
		$url = SEMOR::$server."PutProject";
		return SEMOR::send($url,SEMOR::Data($pole));
	}

	static function SetProject($pole){
		// uprava projektu
		/*
		$pole["idp"] - IDP projektu
		$pole["stav"] - stav projektu A,C
		*/
		$this->method = "P";
		$url = SEMOR::$server."SetProject";
		return SEMOR::send($url,SEMOR::Data($pole));
	}

	static function GetProjectList(){
		//Výpis všech projektù pro daný token
		$this->method = "G";
		$url = SEMOR::$server."GetProjectList";
		return SEMOR::send($url,"{}");
	}

	static function GetKeywordStats($pole){
		//Výpis statistick pro klíèové slovo
		/*
		$pole["idp"] - ID projektu
		$pole["idk"] - ID fráze
		$pole["from"] - YYYY-MM-DD, datum od
		$pole["to"] - YYYY-MM-DD, datum do
		*/
		$this->method = "G";
		$url = SEMOR::$server."GetKeywordStats";
		return SEMOR::send($url,SEMOR::Data($pole));
	}

	static function GetKeywordList($pole){
		//Výpis seznamu klíèových slov s hodnotou o posledním mìøení
		/*
		$pole["idp"] - ID projektu
		$pole["active"] - 1/0 vypsání jen aktivích/uživatelem odstranìných odkazù
		*/
		$this->method = "G";
		$url = SEMOR::$server."GetKeywordList";
		return SEMOR::send($url,SEMOR::Data($pole));
	}

	static function PutKeyword($pole){
		//Založení
		/*
		$pole["idp"] - ID projektu
		$pole["keyword"][] - pole klíèových slov
		$pole["keyword"][0][0] = "slovo";
		$pole["keyword"][0][1] = "A";
		$pole["keyword"][0][2] = 0;
		$pole["keyword"][1][0] = "slovo 2";
		$pole["keyword"][1][1] = "A";
		$pole["keyword"][1][2] = 1;
		//frekvence mìøení (0 - 1x za 30 dní, 1 - 1x za 14 dní, 2 - každý den)
		Pokud uvedete idk, system bude dìlat upbdate na tomto IDK, dle nastaveni výše. V tom pøípadì ignoruje položku keyword
		$pole["idk"] - ID fráze
		
		*/
		$this->method = "P";
		$url = SEMOR::$server."PutKeyword";
		return SEMOR::send($url,SEMOR::Data($pole));
	}

	static function SetKeyword($pole){
		//mazání fráze v systému
		/*
		$pole["idp"] - ID projektu
		$pole["keyword"][] - pole klíèových slov
		$pole["keyword"][idk][0] = stav;
		$pole["keyword"][idk][1] = frekvence;
		idk - id klíèového slova
		
		Zatim neni pøipraveno
		
		*/
		$this->method = "P";
		$url = SEMOR::$server."SetKeyword";
		return SEMOR::send($url,SEMOR::Data($pole));
	}

	static function GetLinkList($pole){
		//Výpis evidovaných odkazù v systému pro daný projekt
		/*
		$pole["idp"] - ID projektu	
		*/
		$this->method = "G";
		$url = SEMOR::$server."GetLinkList";
		return SEMOR::send($url,SEMOR::Data($pole));
	}

	static function SetLink($pole){
		//Zápis nového odkazu do systému
		/*
		$pole["source"] - url umisteni odkazu
		$pole["target"] - url cíle odkazu
		$pole["anchor"] - anchor odkazu
		*/
		$this->method = "P";
		$url = SEMOR::$server."SetLink";
		return SEMOR::send($url,SEMOR::Data($pole));
	}

	static function GetSpeed($pole){
		//Výpis posledního mìøení GooglePageSpeed - nejdøíve 10 minut po vložení nového projektu
		/*
		$pole["idp"] - ID projektu	
		*/
		$this->method = "G";
		$url = SEMOR::$server."GetSpeed";
		return SEMOR::send($url,SEMOR::Data($pole));
	}

	static function GetSerp($pole){
		//Výpis 20 vysledku z kazdeho vyhledavaèe pro vsechna merena slova,pri poslednim mereni
		/*
		$pole["idp"] - ID projektu	
		*/
		$this->method = "G";
		$url = SEMOR::$server."GetSerp";
		return SEMOR::send($url,SEMOR::Data($pole));
	}
}
?>