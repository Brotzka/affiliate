<?php
/**
 * Created by PhpStorm.
 * User: fabs
 * Date: 14.01.18
 * Time: 17:30
 */

namespace Brotzka\Affiliate\Networks\Zanox;


use Brotzka\Affiliate\Interfaces\AffiliateProductSearchInterface;

class ZanoxSearch implements AffiliateProductSearchInterface {

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


	public function searchProducts($search, array $options)
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
}