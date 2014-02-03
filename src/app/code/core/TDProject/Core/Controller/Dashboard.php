<?php

/**
 * TDProject_Core_Controller_Index
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

require_once "TDProject/Core/Common/ValueObjects/UserValue.php";
include_once "TechDivision/Controller/Action/Mapping.php";
include_once "TechDivision/HttpUtils/Interfaces/Request.php";
include_once "TechDivision/Controller/Interfaces/Action.php";
include_once "TDProject/Core/Controller/Abstract.php";
require_once "TDProject/Core/Common/ValueObjects/System/UserValue.php";

/**
 * @category    TProject
 * @package     TDProject_Core
 * @copyright   Copyright (c) 2010 <info@techdivision.com> - TechDivision GmbH
 * @license     http://opensource.org/licenses/osl-3.0.php
 *              Open Software License (OSL 3.0)
 * @author      Bastian Stangl <b.stangl@techdivision.com>
 */
class TDProject_Core_Controller_Dashboard
    extends TDProject_Core_Controller_Abstract {

	/**
	 * The ActionForward key to the dashboard.
	 * @var string
	 */
	const DASHBOARD = 'Dashboard';

	/**
	 * This method is automatically invoked by the controller renders the
	 * the home page.
	 *
	 * @return void
	 */
	public function __defaultAction()
	{
	    try {
    	    // load the widgets
    	    $this->getContext()->setAttribute(
    	    	'widgets',
    	        $this->_getDelegate()->getDashboardViewData()
    	    );
	    } catch (Exception $e) {
			// create action errors container
			$errors = new TechDivision_Controller_Action_Errors();
			// add error to container
			$errors->addActionError(
			    new TechDivision_Controller_Action_Error(
			        TDProject_Core_Controller_Util_ErrorKeys::SYSTEM_ERROR,
			        $e->__toString()
			    )
			);
			// save container in request
			$this->_saveActionErrors($errors);
			// set the ActionForward in the Context
			return $this->_findForward(
			    TDProject_Core_Controller_Util_GlobalForwardKeys::SYSTEM_ERROR
			);
		}
		// return the ActionForward to the dashboard
		return $this->_findForward(
		    TDProject_Core_Controller_Dashboard::DASHBOARD
		);
	}
}