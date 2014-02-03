<?php

/**
 * TDProject_Interfaces_Block_Widget_Toolbar_Button
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
 * @package     TDProject_Core
 * @copyright   Copyright (c) 2010 <info@techdivision.com> - TechDivision GmbH
 * @license     http://opensource.org/licenses/osl-3.0.php
 *              Open Software License (OSL 3.0)
 * @author      Johann Zelger <jz@techdivision.com>
 */
interface TDProject_Core_Interfaces_Block_Widget_Button
	extends TDProject_Core_Interfaces_Block_Widget {
	
	/**
	 * Returns the on_click event action of the button.
	 * 
	 * @return string
	 */
	public function getOnClick();

	/**
	 * Returns the icon of the button.
	 * 
	 * @return string
	 */
	public function getIcon();
	
	/**
	 * Returns TRUE if the button is binded to a tab 
	 * element, else FALSE.
	 *  
	 * @return boolean 
	 * 		TRUE if the button is binded to a tab element, else FALSE
	 */
	public function isBindedToTab();
	
	/**
	 * Returns the tab element the button
	 * is binded to.
	 * 
	 * @return TDProject_Core_Interfaces_Block_Widget_Tab
	 * 		The tab the button is binded to
	 */
	public function getBindedTab();
}