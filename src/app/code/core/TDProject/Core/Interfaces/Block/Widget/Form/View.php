<?php

/**
 * TDProject_Core_Interfaces_Block_Widget_View
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

require_once 'TDProject/Core/Interfaces/Block/Widget/Form.php';

/**
 * @category    TDProject
 * @package     TDProject_Core
 * @copyright   Copyright (c) 2010 <info@techdivision.com> - TechDivision GmbH
 * @license     http://opensource.org/licenses/osl-3.0.php
 *              Open Software License (OSL 3.0)
 * @author      Tim Wagner <tw@techdivision.com>
 */
interface TDProject_Core_Interfaces_Block_Widget_Form_View 
	extends TDProject_Core_Interfaces_Block_Widget_Form {

	/**
	 * Returns the URL to for deleting the existing enity.
	 * 
	 * @return string
	 * 		The URL to delete an existing entity
	 */
	public function getDeleteUrl();

	/**
	 * Returns the URL to return to the overview
	 * dialog of the entities.
	 * 
	 * @return string
	 * 		The URL to return to the overview
	 */
	public function getBackUrl();
		    
	/**
	 * Return the method to be invoked when the
	 * form was submitted.
	 *
	 * @return TechDivision_Lang_String
	 *		The method name
	 */
	public function getMethod();
}