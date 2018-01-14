<?php
/**
 * Created by PhpStorm.
 * User: fabs
 * Date: 14.01.18
 * Time: 12:15
 */

namespace Brotzka\Affiliate\networks\Zanox;

use Brotzka\Affiliate\Models\AffiliateProfile;
use Brotzka\Affiliate\Networks\Zanox\ZanoxConnector;


class ZanoxProfile extends AffiliateProfile{

	public function getProfile()
	{
		$uri = '/profiles';
		$http_verb = 'GET';

		$connection = new ZanoxConnector($http_verb, $uri);
		$client = $connection->getClient();

		try {
			$response = $client->request($http_verb, $connection->getFullUrl());
			return json_decode($response->getBody(), true);
		} catch(\Exception $ex){
			dd($ex);
		}
	}
}