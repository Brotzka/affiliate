<?php
/**
 * Created by PhpStorm.
 * User: fabs
 * Date: 09.01.18
 * Time: 05:29
 */



Route::group(['prefix' => 'affiliate', 'middleware' => ['web']], function(){
	Route::get('zanox', function(){
		$zanox = new Brotzka\Affiliate\Networks\Zanox();
		//$zanox->connect();
		$zanox->buildRequestUrl('GET','profiles');
	});
});
