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
interface TDProject_Core_Interfaces_Block_Widget_Element_Input_Checkbox {
	
	/**
	 * Returns TRUE if the checkbox has to be rendered as
	 * checked else FALSE.
	 * 
	 * @param string $property
	 * @param string $sourceCollection
	 * @param string $sourceProperty
	 * @return boolean 
	 * 		TRUE if the checkbox has to be rendered checked, else FALSE
	 */
	public function isChecked($property, $sourceCollection, $sourceProperty);
}