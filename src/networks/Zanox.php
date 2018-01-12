<?php
/**
 * Created by PhpStorm.
 * User: fabs
 * Date: 09.01.18
 * Time: 05:23
 */

// TODO: Dokumentation erstellen
// TODO: Query-Parameter richtig aufdröseln und an Request anhängen


namespace Brotzka\Affiliate\Networks;

use Brotzka\Affiliate\Interfaces\AffiliateInterface;

use Brotzka\Affiliate\AffiliateNetwork;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Client;

class Zanox extends AffiliateNetwork implements AffiliateInterface{
	protected $connect_id = "214E3A3429CBA6A9F7BD";
	protected $secret = "4cc56f85a6d141+ab86b4Cb67802ee/d4d440345";
	protected $base_url = "http://api.zanox.com/json/2011-03-01";
	protected $uri;
	protected $http_verb;
	protected $timestamp;
	protected $date;
	protected $nonce;

	protected $search_options = [
		"q" 				=> NULL,		// String e.g. "Samsung"|"iPhone"
		"searchtype"		=> "phrase", 	// String "phrase"|"contextual"
		"region"			=> "DE",		// String
		"minprice"			=> NULL,		// Integer
		"maxprice"			=> NULL,		// Integer
		"programs"			=> NULL, 		// Integer|String Example "1234", "1234,5678,9123"
		"hasimages"			=> true,		// Boolean
		"adspace"			=> NULL,		// Integer AdSpace-ID
		"partnership"		=> "confirmed",	// Enumeration "all"|"confirmed"
		"ean"				=> NULL,		// Integer
		"merchantcategory"	=> NULL,		// String e.g. Smartphones
		"items"				=> NULL,			// Integer
		"page"				=> NULL			// Integer
	];

	public function __construct($id, $secret) {
		//$this->id = env('ZANOX_CONNECT_ID');
		//$this->secret = env('ZANOX_SECRET_KEY');
		$this->connect_id = $id;
		$this->secret = $secret;
		$this->nonce = uniqid() . uniqid();
	}

	public function getProfile()
	{
		return $this->callApi('GET', '/profiles');
	}

	public function searchProducts($search, $options = array())
	{
		$this->search_options["q"] = urlencode($search);
		if(count($options) > 0){
			foreach($options as $key => $value){
				if(array_key_exists($key, $this->search_options)){
					$this->search_options[$key] = $value;
				}
			}
		}

		$query = array();
		foreach($this->search_options as $key => $value){
			if($value !== NULL){
				$query[$key] = $value;
			}
		}

		return $this->callApi('GET', '/products', $query);
	}

	private function callApi($http_verb, $uri, $options = array(), $date = false)
	{
		// TODO: Datum einbauen (bei Bedarf)
		// TODO: Getter und Setter erstellen
		$this->setHttpVerb($http_verb);
		$this->setUri($uri);
		$this->date = date('Y-m-d');
		$this->timestamp = gmdate('D, d M Y H:i:s T', time());
		$nonce = uniqid() . uniqid();

		//$requestURL = $this->getRequestUrl();
		$requestURL = $this->base_url . $this->uri;
		$request_options = $this->getRequestUrlOptions($options);

		try {
			$client = new Client();

			$response = $client->request( $this->http_verb, $requestURL, ["query" => $request_options]);
			return json_decode($response->getBody(), true);
		} catch(\Exception $ex){
			return $ex->getMessage();
		}
	}

	private function getRequestUrlOptions($additional_options = array())
	{
		$search = "";
		$string_to_sign = mb_convert_encoding($this->http_verb . $this->uri . $this->timestamp . $this->nonce, 'UTF-8');
		$signature = base64_encode(hash_hmac('sha1', $string_to_sign, $this->secret, true));
		//return $this->base_url . $this->uri . '?connectid=' . $this->connect_id . '&date=' . urlencode($this->timestamp) . '&nonce=' . $this->nonce . '&signature=' . urlencode($signature);
		$additional_options['connectid'] = $this->connect_id;
		$additional_options['date'] = urlencode($this->timestamp);
		$additional_options['nonce'] = $this->nonce;
		$additional_options['signature'] = urlencode($signature);
		return $additional_options;
	}

	private function setUri($uri)
	{
		if($uri[0] != "/"){
			$this->uri = "/" . $uri;
		}
		$this->uri = $uri;
	}

	private function setHttpVerb($http_verb){
		// TODO: um weitere relevante HTTP-Methoden erweitern
		switch($http_verb){
			case 'GET':
			case 'POST':
				$this->http_verb = $http_verb;
				break;
			default:
				throw new \Exception("Ungültige HTTP-Methode übergeben!");
		}
	}
}