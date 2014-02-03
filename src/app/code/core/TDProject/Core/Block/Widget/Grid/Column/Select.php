<?php

/**
 * TDProject_Core_Block_Widget_Grid_Column_Select
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

require_once 'TechDivision/Lang/Object.php';
require_once 'TDProject/Core/Block/Widget/Grid/Column.php';
require_once 'TDProject/Core/Interfaces/Block/Widget/Grid/Column/Select.php';
require_once 'TDProject/Core/Block/Widget/Grid/Body/Row/Column/Select.php';
require_once 'TDProject/Core/Interfaces/Block/Widget/Grid/Column/Action.php';
require_once 'TDProject/Core/Block/Widget/Grid/Column/Select/Selector/Collection.php';
require_once 'TDProject/Core/Block/Widget/Grid/Column/Select/Selector/Collection/String.php';
require_once 'TDProject/Core/Block/Widget/Grid/Column/Select/Selector/Object.php';

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
class TDProject_Core_Block_Widget_Grid_Column_Select
    extends TDProject_Core_Block_Widget_Grid_Column
    implements TDProject_Core_Interfaces_Block_Widget_Grid_Column_Select {

    protected $_selector = null;

    protected $_options = null;

    protected $_optionProperty = '';
    
    protected $_sourceCollectionKeyType = 'TechDivision_Lang_Integer';

    /**
     * (non-PHPdoc)
     * @see TDProject_Core_Interfaces_Block_Widget_Grid_Column_Select::getOptions()
     */
    public function getOptions() {
    	return $this->_options;
    }

    /**
     * (non-PHPdoc)
     * @see TDProject_Core_Interfaces_Block_Widget_Grid_Column_Select::getSelector()
     */
    public function getSelector() {
    	return $this->_selector;
    }

    /**
     * (non-PHPdoc)
     * @see TDProject_Core_Interfaces_Block_Widget_Grid_Column_Select::getOptionProperty()
     */
    public function getOptionProperty() {
    	return $this->_optionProperty;
    }

    public function setOptions(
        TechDivision_Collections_Interfaces_Collection $options) {
    	$this->_options = $options;
    	return $this;
    }

    public function setOptionProperty($optionProperty) {
    	$this->_optionProperty = $optionProperty;
    	return $this;
    }

    public function setSourceObject(TechDivision_Lang_Object $object) {
    	$this->_selector =
    	    new TDProject_Core_Block_Widget_Grid_Column_Select_Selector_Object(
    	        $this, $object
    	    );
    	return $this->_selector;
    }

    public function setSourceCollection(
        TechDivision_Collections_Interfaces_Collection $collection) {
    	$this->_selector =
    	    new TDProject_Core_Block_Widget_Grid_Column_Select_Selector_Collection(
    	        $this, $collection
    	    );
    	return $this->_selector;
    }
    
    public function setSourceCollectionKeyType($sourceCollectionKeyType)
    {
    	$this->_sourceCollectionKeyType = $sourceCollectionKeyType;
    	return $this;
    }

    public function getSourceCollectionKeyType()
    {
    	return $this->_sourceCollectionKeyType;
    }
    
    public function setSourceCollectionString(
        TechDivision_Collections_Interfaces_Collection $collection) {
    	$this->_selector =
    	    new TDProject_Core_Block_Widget_Grid_Column_Select_Selector_Collection_String(
    	        $this, $collection
    	    );
    	return $this->_selector;
    }

    /**
     * (non-PHPdoc)
     * @see TDProject_Core_Block_Widget_Grid_Column::create()
     */
    public function create(
        TDProject_Core_Interfaces_Block_Widget_Grid_Body_Row $row) {
    	return new TDProject_Core_Block_Widget_Grid_Body_Row_Column_Select(
    	    $row, $this
    	);
    }
}