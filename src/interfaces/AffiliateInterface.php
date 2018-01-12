<?php

namespace Brotzka\Affiliate\Interfaces;

interface AffiliateInterface {
    public function getProfile();
    public function searchProducts($search, $options = array());
}