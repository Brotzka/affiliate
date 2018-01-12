<?php
/**
 * Created by PhpStorm.
 * User: fabs
 * Date: 09.01.18
 * Time: 05:23
 */

namespace Brotzka\Affiliate\Networks;

use Brotzka\Affiliate\AffiliateNetwork;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Client;

class Zanox extends AffiliateNetwork{
	protected $key = "214E3A3429CBA6A9F7BD";
	protected $secret = "4cc56f85a6d141+ab86b4Cb67802ee/d4d440345";
	protected $base_url = "http://api.zanox.com/json/2011-03-01/";

	protected $blubber;

	public function __construct() {
		$this->blubber = str_random(5);
	}

	public function buildRequestUrl($http_verb, $uri)
	{

		$timestamp = gmdate('D, d M Y H:i:s T', time());
		$date = date('Y-m-d');
		$nonce = uniqid() . uniqid();

		$string = mb_convert_encoding($http_verb . $uri . $timestamp . $nonce, 'UTF-8');
		$signature = base64_encode(hash_hmac('sha1', $string, $this->secret, true));

		$url = $this->base_url . $uri;

		$headers = [
			'Authorization' => 'ZXWS ' . env('ZANOX_CONNECT_ID') . ":" . $signature,
			'Date'          => $timestamp,
			'nonce'         => $nonce
		];

		$client = new Client();
		try {
			//$response = $client->request( $http_verb, $url, $headers );
			$response = $client->request($http_verb, $url, $headers);
			echo "<pre>", print_r($response->getHeaders()), "</pre>";
			echo $response->getStatusCode();
		} catch(\Exception $ex){
			echo $ex->getMessage();
		}


	}

	public function connect()
	{
		$http_verb = 'GET';
		$date = date('Y-m-d');
		$uri = '/profiles/' . $date;
		$time_stamp = gmdate('D, d M Y H:i:s T', time());
		$nonce = uniqid() . uniqid();
		$string_to_sign = mb_convert_encoding($http_verb . $uri . $time_stamp . $nonce, 'UTF-8');
		$signature = base64_encode(hash_hmac('sha1', $string_to_sign, $this->secret, true));
		$requestURL = 'http://api.zanox.com/json/2011-03-01' . $uri . '?connectid=' . $this->key . '&date=' . urlencode($time_stamp) . '&nonce=' . $nonce . '&signature=' . urlencode($signature);

		$this->showUrl($requestURL);
	}

	public function getProfile()
	{
		$test = "https://api.zanox.com/json/2011-03-01/profiles?connectid=802B8BF4AE99";
		$uri = "/profiles";
		$requestURL = 'http://api.zanox.com/json/2011-03-01' . $uri . '?connectid=' . $this->key;
		$this->showUrl($requestURL);
	}

	private function showUrl($url)
	{
		echo "Request: " . $url . "<br>";
		echo "<a href=\"" . $url . "\">Link</a><br>";
	}
}