<?php

namespace Brotzka\Affiliate\Networks\Zanox;

use Brotzka\Affiliate\Networks\Zanox\ZanoxConnector;

class ZanoxAdMedia {

    private $connection;

    public function __construct()
    {
        $this->connection = new ZanoxConnector('GET', 'admedia');
    }

    public function getAdMedia()
    {
        $uri = '/admedia';
		$http_verb = 'GET';

		$connection = new ZanoxConnector($http_verb, $uri);
		$client = $connection->getClient();

		try {
			$response = $client->request($http_verb, $connection->getFullUrl());

			$media = json_decode($response->getBody(), true);

			return $media;
			//return json_decode($response->getBody(), true);
		} catch(\Exception $ex){
			dd($ex);
		}
    }

}