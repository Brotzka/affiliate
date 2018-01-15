<?php
/**
 * Created by PhpStorm.
 * User: fabs
 * Date: 09.01.18
 * Time: 05:29
 */

use Brotzka\Affiliate\Networks\Zanox\ZanoxProfile;
use Brotzka\Affiliate\Networks\Zanox\ZanoxAdMedia;


Route::group([
	'prefix' => 'affiliate', 
	'middleware' => ['web'],
	'namespace' => '\Brotzka\Affiliate\Http\Controllers'
], function(){

	Route::group(['prefix' => 'admin', 'middleware' => ['auth']], function(){
		Route::get('/', 'AffiliateAdminController@dashboard');

	});

	Route::get('zanox', function(){
		$profile = new ZanoxProfile();
		//dd($profile->getProfile());
		//echo "<pre>", print_r($profile->getProfile()), "</pre>";

		$media = new ZanoxAdMedia();

		return view('affiliate::test');
		//dd($media->getAdMedia());
	});

	Route::get('amazon', function(){
		$amazon = new \Brotzka\Affiliate\Networks\Amazon();
		$amazon->getProfile();
	});
});
