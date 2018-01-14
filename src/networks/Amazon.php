<?php
/**
 * Created by PhpStorm.
 * User: fabs
 * Date: 13.01.18
 * Time: 07:00
 */

namespace Brotzka\Affiliate\Networks;

use Brotzka\Affiliate\AffiliateNetwork;
use Brotzka\Affiliate\Interfaces\AffiliateInterface;


class Amazon extends AffiliateNetwork implements AffiliateInterface {
	protected $id;
	protected $key;
	protected $secret;
	protected $region;
	protected $config;

	public function __construct( $key = false, $secret = false, $id = false ) {
		$this->key = ($key === false) ? env('AMAZON_ACCESS_KEY') : $key;
		$this->secret = ($secret === false) ? env('AMAZON_ACCESS_SECRET') : $secret;
		$this->id = ($key === false) ? env('AMAZON_TRACKING_ID') : $id;

		$this->config = require_once __DIR__ . "/../config/amazon.php";
	}

	public function getProfile() {
		echo "<pre>", print_r($this), "</pre>";
		// TODO: Implement getProfile() method.
	}

	public function searchProducts( $search, $options = array() ) {
		// TODO: Implement searchProducts() method.
	}

	public function callApi()
	{
		// Your Access Key ID, as taken from the Your Account page
		$access_key_id = "AKIAIOGL5BJ6SOS6DVZQ";

		// Your Secret Key corresponding to the above ID, as taken from the Your Account page
		$secret_key = "0XDXHN33mNrMM54igxlwPUUdV1xzu5VXJtLmZXWt";

		// The region you are interested in
		$endpoint = "webservices.amazon.de";

		$uri = "/onca/xml";

		$params = array(
			"Service" => "AWSECommerceService",
			"Operation" => "ItemSearch",
			"AWSAccessKeyId" => "AKIAIOGL5BJ6SOS6DVZQ",
			"AssociateTag" => "fhagen02-21",
			"SearchIndex" => "Baby",
			"ResponseGroup" => "Images,ItemAttributes,Offers",
			"Keywords" => "Jacke"
		);

		// Set current timestamp if not set
		if (!isset($params["Timestamp"])) {
			$params["Timestamp"] = gmdate('Y-m-d\TH:i:s\Z');
		}

		// Sort the parameters by key
		ksort($params);

		$pairs = array();

		foreach ($params as $key => $value) {
			array_push($pairs, rawurlencode($key)."=".rawurlencode($value));
		}

		// Generate the canonical query
		$canonical_query_string = join("&", $pairs);

		// Generate the string to be signed
		$string_to_sign = "GET\n".$endpoint."\n".$uri."\n".$canonical_query_string;

		// Generate the signature required by the Product Advertising API
		$signature = base64_encode(hash_hmac("sha256", $string_to_sign, $secret_key, true));

		// Generate the signed URL
		$request_url = 'http://'.$endpoint.$uri.'?'.$canonical_query_string.'&Signature='.rawurlencode($signature);

		echo "Signed URL: \"".$request_url."\"";
	}
}