<?php
/**
 * Created by PhpStorm.
 * User: fabs
 * Date: 09.01.18
 * Time: 05:29
 */

Route::group(['prefix' => 'affiliate', 'middleware' => ['web']], function(){
	Route::get('zanox', function(){
		$profile = new \Brotzka\Affiliate\networks\Zanox\ZanoxProfile();

		echo "<pre>", print_r($profile->getProfile()), "</pre>";
	});

	Route::get('amazon', function(){
		$amazon = new \Brotzka\Affiliate\Networks\Amazon();
		$amazon->getProfile();
	});
});
