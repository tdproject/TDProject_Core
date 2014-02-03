<?php

/**
 * TDProject_Core_Controller_Util_WebRequestKeys
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

require_once 'TDProject/Common/Util/WebRequestKeys.php';

/**
 * @category   	TDProject
 * @package    	TDProject_Core
 * @copyright  	Copyright (c) 2010 <info@techdivision.com> - TechDivision GmbH
 * @license    	http://opensource.org/licenses/osl-3.0.php
 * 				Open Software License (OSL 3.0)
 * @author      Bastian Stangl <b.stangl@techdivision.com>
 */
class TDProject_Core_Controller_Util_WebRequestKeys
	extends TDProject_Common_Util_WebRequestKeys {

	/**
	 * The Request parameter key for a retyped password.
	 * @var string
	 */
	const PASSWORD_RETYPE = "passwordRetype";

	/**
	 * The Request parameter key with the user id.
	 * @var string
	 */
	const USER_ID = "userId";

	/**
	 * The Request parameter key with the username.
	 * @var string
	 */
	const USERNAME = "username";

	/**
	 * The Request parameter key for storing a DTO.
	 * @var string
	 */
	const VIEW_DATA = "viewData";

	/**
     * The Request parameter key with the user's state.
     * @var string
     */
    const ENABLED = "enabled";

	/**
	 * The Request parameter key with the email.
	 * @var string
	 */
	const EMAIL = "email";

	/**
	 * The Request parameter key with the setting ID.
	 * @var string
	 */
	const SETTING_ID = "settingId";

	/**
	 * The Request parameter key with the resource ID.
	 * @var string
	 */
	const RESOURCE_ID = "resourceId";

	/**
	 * The request parameter for the numbers of records to load.
	 * @var string
	 */
	const DISPLAY_LENGTH = 'iDisplayLength';

	/**
	 * The request parameter for the record number up from where to load the data.
	 * @var string
	 */
	const DISPLAY_START = 'iDisplayStart';

	/**
	 * The request parameter for the ID of the column to sort.
	 * @var string
	 */
	const SORT_COLUMN = 'iSortCol_0';

	/**
	 * The request parameter for the direction to sort.
	 * @var string
	 */
	const SORT_DIR = 'sSortDir_0';

	/**
	 * The request parameter for the search value entered by the user.
	 * @var string
	 */
	const SEARCH = 'sSearch';
}

