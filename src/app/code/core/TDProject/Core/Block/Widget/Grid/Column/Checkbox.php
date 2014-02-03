<?php

/**
 * TDProject_Core_Block_Widget_Grid_Column_Checkbox
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

require_once 'TechDivision/Lang/Object.php';
require_once 'TDProject/Core/Block/Widget/Grid/Column.php';
require_once 'TDProject/Core/Interfaces/Block/Widget/Grid/Column/Checkbox.php';
require_once 'TDProject/Core/Block/Widget/Grid/Body/Row/Column/Checkbox.php';

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

require_once 'TDProject/Core/Interfaces/Block/Widget/Grid/Column/Action.php';
require_once
	'TDProject/Core/Block/Widget/Grid/Column/Checkbox/Selector/Collection.php';
require_once
	'TDProject/Core/Block/Widget/Grid/Column/Checkbox/Selector/Object.php';

class TDProject_Core_Block_Widget_Grid_Column_Checkbox
    extends TDProject_Core_Block_Widget_Grid_Column
    implements TDProject_Core_Interfaces_Block_Widget_Grid_Column_Checkbox {

    protected $_selector = null;

    protected $_property = '';

    /**
     * The url to call when the checkbox was checked.
     *
     * @var string
     */
    protected $_checkedUrl = '';

    /**
     * The url to call when the checkbox was unchecked.
     *
     * @var string
     */
    protected $_uncheckedUrl = '';

    public function setOptions(
        TechDivision_Collections_Interfaces_Collection $options) {
    	$this->_options = $options;
    	return $this;
    }

    public function setProperty($property) {
    	$this->_property = $property;
    	return $this;
    }

    public function getProperty() {
    	return $this->_property;
    }

    public function setSourceObject(TechDivision_Lang_Object $object) {
    	$this->_selector =
    	    new TDProject_Core_Block_Widget_Grid_Column_Checkbox_Selector_Object(
    	        $this, $object
    	    );
    	return $this->_selector;
    }

    public function setSourceCollection(
        TechDivision_Collections_Interfaces_Collection $collection) {
    	$this->_selector =
    	    new TDProject_Core_Block_Widget_Grid_Column_Checkbox_Selector_Collection(
    	        $this, $collection
    	    );
    	return $this->_selector;
    }

    /**
     * (non-PHPdoc)
     * @see TDProject_Core_Interfaces_Block_Widget_Grid_Column_Checkbox::getSelector()
     */
    public function getSelector() {
    	return $this->_selector;
    }

    /**
     * (non-PHPdoc)
     * @see TDProject_Core_Block_Widget_Grid_Column::create()
     */
    public function create(
        TDProject_Core_Interfaces_Block_Widget_Grid_Body_Row $row) {
    	return new TDProject_Core_Block_Widget_Grid_Body_Row_Column_Checkbox(
    	    $row, $this
    	);
    }

    /**
     * Sets the url to be called when checkbox was checked
     *
     * @param string $url
     * @return TDProject_Core_Block_Widget_Grid_Column_Checkbox
     */
    public function setCheckedUrl($url) {
    	$this->_checkedUrl = $url;
    	return $this;
    }

	/**
     * Sets the url to be called when checkbox was unchecked
     *
     * @param string $url
     * @return TDProject_Core_Block_Widget_Grid_Column_Checkbox
     */
    public function setUncheckedUrl($url) {
    	$this->_uncheckedUrl = $url;
    	return $this;
    }

    /**
     * Gets the url to be called when checkbox was checked
     *
     * @return string
     */
    public function getCheckedUrl() {
    	return $this->_checkedUrl;
    }

    /**
     * Gets the url to be called when checkbox was unchecked
     *
     * @return string
     */
    public function getUncheckedUrl() {
    	return $this->_uncheckedUrl;
    }
}