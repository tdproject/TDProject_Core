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
require_once 'TDProject/Core/Block/Widget/Grid/Column/Select/Selector/Abstract.php';

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
class TDProject_Core_Block_Widget_Grid_Column_Select_Selector_Collection
	extends TDProject_Core_Block_Widget_Grid_Column_Select_Selector_Abstract {

	protected $_collection = null;

	public function __construct(
		TDProject_Core_Interfaces_Block_Widget_Grid_Column_Select $column,
		TechDivision_Collections_Interfaces_Collection $collection) {
		parent::__construct($column);
		$this->_collection = $collection;
	}

	public function getOptions() {
		return $this->getColumn()->getOptions();
	}

	public function getOptionProperty() {
		return $this->getColumn()->getOptionProperty();
	}

	public function getValue(TechDivision_Lang_Object $data) {
		return $this->_invoke($data, $this->getTargetProperty());
	}

	public function getSourceCollectionKeyType() {
		return $this->getColumn()->getSourceCollectionKeyType();
	}

	/**
	 * (non-PHPdoc)
	 * @see TDProject_Core_Interfaces_Block_Widget_Grid_Column_Select_Selector::isSelected()
	 */
    public function isSelected(TechDivision_Lang_Object $object, TechDivision_Lang_Object $data /* TDProject_EPR_Common_ValueObjects_AddressOverviewData */) {
		foreach ($this->_collection as $key => $value) { /* TDProject_EPR_Common_ValueObjects_CompanyAddressLightValue */
			$toCompare = $this->_invoke($data, $this->getTargetProperty());
			$keyType = $this->getSourceCollectionKeyType();
   			if ($toCompare->equals(new TechDivision_Lang_Integer($key))) {
   				if ($object->isSelected(new $keyType($value))) {
   					return true;
   				}
   			}
   		}

   		return false;
    }
}