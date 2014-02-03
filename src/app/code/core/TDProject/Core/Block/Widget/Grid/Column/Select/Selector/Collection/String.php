<?php

/**
 * TDProject_Core_Block_Widget_Grid_Column_Select_Selector_Collection
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

require_once 'TDProject/Core/Interfaces/Block/Widget/Grid/Column/Checkbox.php';
require_once 'TDProject/Core/Block/Widget/Grid/Column/Select/Selector/Collection.php';

/**
 * This class implements the form functionality
 * for handling the application settings.
 *
 * @category    TProject
 * @package     TDProject_Core
 * @copyright   Copyright (c) 2010 <info@techdivision.com> - TechDivision GmbH
 * @license     http://opensource.org/licenses/osl-3.0.php
 *              Open Software License (OSL 3.0)
 * @author      Bastian Stangl <b.stangl@techdivision.com>
 */
class TDProject_Core_Block_Widget_Grid_Column_Select_Selector_Collection_String
	extends TDProject_Core_Block_Widget_Grid_Column_Select_Selector_Collection {

	/**
	 * (non-PHPdoc)
	 * @see TDProject_Core_Interfaces_Block_Widget_Grid_Column_Select_Selector::isSelected()
	 */
    public function isSelected(
        TechDivision_Lang_Object $object, TechDivision_Lang_Object $data) {
        // iterate over the options to check which one has to be selected
		foreach ($this->_collection as $key => $value) {
			$toCompare = $this->_invoke($data, $this->getTargetProperty());
   			if ($toCompare->equals(new TechDivision_Lang_Integer($key))) {
   				if ($object->isSelected(new TechDivision_Lang_String($value))) {
   					return true;
   				}
   			}
   		}

   		return false;
    }
}