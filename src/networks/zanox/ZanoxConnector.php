<?php
/**
 * Created by PhpStorm.
 * User: fabs
 * Date: 14.01.18
 * Time: 08:25
 */

namespace Brotzka\Affiliate\Networks\Zanox;

use GuzzleHttp\Client;

class ZanoxConnector {
	protected $base_url = "http://api.zanox.com/json/2011-03-01";
	protected $connect_id = NULL;
	protected $secret = NULL;
	protected $uri = NULL;
	protected $http_verb = NULL;
	protected $timestamp = NULL;
	protected $date = NULL;
	protected $nonce = NULL;


	public function __construct($http_verb, $uri) {
		$this->setHttpVerb($http_verb);
		$this->setUri($uri);
		$this->connect_id = env('ZANOX_CONNECT_ID');
		$this->secret = env('ZANOX_SECRET_KEY');
		$this->nonce = str_random(20);
		$this->timestamp = gmdate('D, d M Y H:i:s T', time());
	}

	/**
	 * Returns a Guzzle-Client with all Authorization-Headers set
	 * @return Client
	 */
	public function getClient()
	{
		return new Client([
			'headers' => [
				'Authorization' => 'ZXWS ' . $this->connect_id . ':' . $this->getSignature(),
				'Date'          => $this->timestamp,
				'nonce'         => $this->nonce
			]
		]);
	}

	/**
	 * Sets the Uri.
	 * @param $uri
	 */
	public function setUri($uri)
	{
		if($uri[0] != "/"){
			$this->uri = "/" . $uri;
		}
		$this->uri = $uri;
	}

	/**
	 * Returns a signature string.
	 * @return string
	 */
	private function getSignature()
	{
		$string_to_sign = mb_convert_encoding(
			$this->http_verb . $this->uri . $this->timestamp . $this->nonce,
			'UTF-8'
		);
		return base64_encode(
			hash_hmac(
				'sha1',
				$string_to_sign,
				$this->secret,
				true
			)
		);
	}


	/**
	 * Set the currently relevant http-verb
	 * @param $http_verb
	 *
	 * @throws \Exception
	 */
	public function setHttpVerb($http_verb){
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

	public function getFullUrl()
	{
		return $this->base_url . $this->uri;
	}
}