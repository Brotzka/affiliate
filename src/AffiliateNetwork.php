<?php
/**
 * Created by PhpStorm.
 * User: fabs
 * Date: 09.01.18
 * Time: 05:22
 */

namespace Brotzka\Affiliate;


class AffiliateNetwork {
	protected $key;
	protected $secret;

	public function __construct($key, $secret) {
		$this->key = $key;
		$this->secret = $secret;
	}
}