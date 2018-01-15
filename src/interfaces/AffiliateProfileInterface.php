<?php
/**
 * Created by PhpStorm.
 * User: fabs
 * Date: 15.01.18
 * Time: 05:11
 */

namespace Brotzka\Affiliate\Interfaces;

use Brotzka\Affiliate\Models\AffiliateProfile;


interface AffiliateProfileInterface {

	/**
	 * Should return an instance of the users profile.
	 * @return AffiliateProfile
	 */
	public function getProfile() : AffiliateProfile;

	/**
	 * Updates a profile and returns it after updating.
	 * @return AffiliateProfile
	 */
	public function updateProfile() : AffiliateProfile;
}