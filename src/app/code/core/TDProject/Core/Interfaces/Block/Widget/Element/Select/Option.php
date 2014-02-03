<?php

/**
 * TDProject_Core_Interfaces_Block_Widget_Element_Select_Option
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

require_once 'TechDivision/Lang/Object.php';

/**
 * @category    TDProject
 * @package     TDProject_Core
 * @copyright   Copyright (c) 2010 <info@techdivision.com> - TechDivision GmbH
 * @license     http://opensource.org/licenses/osl-3.0.php
 *              Open Software License (OSL 3.0)
 * @author      Tim Wagner <tw@techdivision.com>
 */
interface TDProject_Core_Interfaces_Block_Widget_Element_Select_Option {
	
	/**
	 * Returns the option's value to render.
	 * 
	 * @return TechDivision_Lang_String
	 * 		The option's value to render
	 */
	public function getOptionValue();
	
	/**
	 * Returns the option's label to render.
	 * 
	 * @return TechDivision_Lang_String
	 * 		The option's label to render
	 */
	public function getOptionLabel();
	
	/**
	 * Returns TRUE if the option has to be rendered as
	 * selected else FALSE.
	 * 
	 * @param TechDivision_Lang_Object $value
	 * 		The value to compare the options ID to
	 * @return boolean 
	 * 		TRUE if the option has to be rendered selected, else FALSE
	 */
	public function isSelected(TechDivision_Lang_Object $value = null);
}