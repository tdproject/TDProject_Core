<?php

/**
 * TDProject_Core_Block_Widget_Grid_Column_Checkbox_Selector_Collection
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */


require_once 'TDProject/Core/Interfaces/Block/Widget/Grid/Column/Checkbox.php';
require_once 'TDProject/Core/Block/Widget/Grid/Column/Checkbox/Selector/Abstract.php';

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
class TDProject_Core_Block_Widget_Grid_Column_Checkbox_Selector_Collection
	extends TDProject_Core_Block_Widget_Grid_Column_Checkbox_Selector_Abstract {

	protected $_collection = null;
		
	public function __construct(
		TDProject_Core_Interfaces_Block_Widget_Grid_Column_Checkbox $column,
		/* TechDivision_Collections_Interfaces_Collection */ $collection) {
		parent::__construct($column);
		$this->_collection = $collection;
	}
	
    public function isChecked(TechDivision_Lang_Object $object) {    	
    	
    	$logger = TechDivision_Logger_Logger::forObject($this, 'TDProject/META-INF/log4php.properties');
   		
		foreach ($this->_collection as $element => $id) {
			$toCompare = $this->_invoke($object, $this->getTargetProperty());
   			if ($toCompare->equals(new TechDivision_Lang_Integer($id))) {
   				return true;
   			}
   		}

   		return false;
    }
}