<?php
/**
 * Created by PhpStorm.
 * User: fabs
 * Date: 14.01.18
 * Time: 12:15
 */

namespace Brotzka\Affiliate\Networks\Zanox;

use Brotzka\Affiliate\Interfaces\AffiliateProfileInterface;
use Brotzka\Affiliate\Models\AffiliateProfile;
use Brotzka\Affiliate\Networks\Zanox\ZanoxConnector;


class ZanoxProfile extends AffiliateProfile implements AffiliateProfileInterface {

	public function getProfile() : AffiliateProfile
	{
		$uri = '/profiles';
		$http_verb = 'GET';

		$connection = new ZanoxConnector($http_verb, $uri);
		$client = $connection->getClient();

		try {
			$response = $client->request($http_verb, $connection->getFullUrl());

			$profile = json_decode($response->getBody(), true);

			return $this->mapToModel($profile['profileItem'][0]);
			//return json_decode($response->getBody(), true);
		} catch(\Exception $ex){
			dd($ex);
		}
	}

	public function updateProfile(): AffiliateProfile {
		// TODO: Implement updateProfile() method.
	}

	private function mapToModel(array $data)
	{
		// TODO: Create migration for AffiliateProfile
		$profile = new ZanoxProfile();
		$profile->network = "Zanox";

		foreach($data as $key => $value){
			if($key == "@id"){
				$profile->affiliate_id = $value;
				continue;
			}
			$profile->$key = $value;
		}
		return $profile;
	}
}