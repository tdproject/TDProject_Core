<?php

/**
 * TDProject_Core_Interfaces_Block_Widget_Form
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

require_once 'TDProject/Core/Interfaces/Block/Widget.php';

/**
 * @category    TDProject
 * @package     TDProject
 * @copyright   Copyright (c) 2010 <info@techdivision.com> - TechDivision GmbH
 * @license     http://opensource.org/licenses/osl-3.0.php
 *              Open Software License (OSL 3.0)
 * @author      Johann Zelger <jz@techdivision.com>
 */
interface TDProject_Core_Interfaces_Block_Widget_Form
	extends TDProject_Core_Interfaces_Block_Widget {	
	
	/**
	 * Adds a new tabs container and returns the instance of the
	 * created container.
	 * 
	 * @param string $blockName The block name of the tab
	 * @param string $blockTitle The block title of the tab
	 * @return TDProject_Core_Interfaces_Block_Widget_Tabs
	 * 		The instance of the created tabs container
	 */
	public function addTabs($blockName, $blockTitle);
	
	/**
	 * Returns TRUE if the form has a toolbar, else FALSE.
	 * 
	 * @return boolean 
	 * 		TRUE if the form has a toolbar, else FALSE
	 */
	public function hasToolbar();
	
	/**
	 * Returns the actual toolbar instance, if already one exists
	 * or creates and returns a new one.
	 * 
	 * @return TDProject_Core_Interfaces_Block_Widget_Toolbar
	 * 		The actual toolbar instance.
	 */
	public function getToolbar();

	/**
	 * Returns the name of the actual form.
	 * 
	 * @return string The actual form name
	 */
	public function getFormName();
    
    /**
     * Checks if a getter method for the passed property exists, and 
     * returns the value if available, if not an exception is thrown.
     * 
     * @param string $property Name of the property to return the value for
     * @return TechDivision_Lang_Object The requested value
     * @throws Exception 
     * 		Is thrown if no getter method for the requested property exists
     */
    public function getValueByProperty($property);
    
	/**
	* Returns the action path to be invoked when
	* form was submitted.
	*
	* @return TechDivision_Lang_String
	* 		The action to be invoked
	*/
	public function getPath();
	
	/**
	 * Returns the path name of the actual request, prepared 
	 * by replace the slashes with the character passed as 
	 * parameter.
	 * 
	 * @param string $prepareWith
	 * 		The character to replace the slashes with
	 * @return TechDivision_Lang_String
	 * 		The prepared path name
	 * @see TDProject_Core_Interfaces_Block_Widget_Form::getPath()
	 */
    public function getPathPrepared($prepareWith = '.');
}