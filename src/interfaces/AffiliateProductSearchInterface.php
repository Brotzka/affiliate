<?php
/**
 * Created by PhpStorm.
 * User: fabs
 * Date: 15.01.18
 * Time: 05:19
 */

namespace Brotzka\Affiliate\Interfaces;


interface AffiliateProductSearchInterface {

	public function searchProducts($search, array $options);
}