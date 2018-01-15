<?php

namespace Brotzka\Affiliate\Http\Controllers;

use Brotzka\Affiliate\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Brotzka\Affiliate\Models\AddiliateProfile;

use Illuminate\Support\Facades\Crypt;

class AffiliateAdminController extends BaseController
{
    public function dashboard()
    {
        $networks = require PACKAGEPATH . "/config/networks.php";

        $array = array(
            'value1'    => 'fünf',
            'name'      => 'Peter',
            'obst'      => ['Apfel', 'Banane', 'Orange']
        );

        $encrypted = Crypt::encrypt($array); 
        $decrypted = Crypt::decrypt($encrypted);

        return view('affiliate::pages.dashboard', [ 'values' => [
            'networks' => $networks,
            'encrypted' => $encrypted,
            'decrypted' => $decrypted
            ]
        ]);
    }
}
