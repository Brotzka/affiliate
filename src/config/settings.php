<?php
/**
 * Created by PhpStorm.
 * User: Fabian Hagen
 * Date: 08.01.18
 * Time: 05:34
 */

return [
	'zanox'     => [
		'id'        => env('ZANOX_CONNECT_ID', ''),
		'secret'    => env('ZANOX_SECRET_KEY', '')
	],
	'amazon'    => [
		'id'            => env('AMAZON_TRACKING_ID', ''),
		'access_key'    => env('AMAZON_ACCESS_KEY', ''),
		'secret_key'    => env('AMAZON_SECRET_KEY', '')
	]
];