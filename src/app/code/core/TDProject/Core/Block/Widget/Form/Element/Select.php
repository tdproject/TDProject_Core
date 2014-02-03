<?php

/**
 * TDProject_Core_Block_Widget_Element_Select
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

require_once 'TechDivision/Collections/ArrayList.php';
require_once 'TechDivision/Collections/Interfaces/Collection.php';
require_once 'TDProject/Core/Block/Widget/Element/Abstract.php';
require_once 'TDProject/Core/Interfaces/Block/Widget/Element/Select.php';
require_once 'TDProject/Core/Interfaces/Block/Widget/Form.php';

/**
 * @category    TDProject
 * @package     TDProject_Core
 * @copyright   Copyright (c) 2010 <info@techdivision.com> - TechDivision GmbH
 * @license     http://opensource.org/licenses/osl-3.0.php
 *              Open Software License (OSL 3.0)
 * @author      Johann Zelger <jz@techdivision.com>
 */
class TDProject_Core_Block_Widget_Element_Select
    extends TDProject_Core_Block_Widget_Element_Abstract
    implements TDProject_Core_Interfaces_Block_Widget_Element_Select {
    
    /**
     * Collection with the options for the select field.
     * @var TechDivision_Collections_Interfaces_Collection
     */	
    protected $_options = null;
    
    /**
     * TRUE if a dummy option has to be rendered, else FALSE.
     * @var boolean
     */
    protected $_dummyOption = false;
    	
    /**
     * Initialize the dropdown with the apropriate template and name.
     * 
     * @param TDProject_Core_Interfaces_Block_Widget_Form The ActionForm instance the element is bound to
     * @param string $blockName The block name of the element, alias the property
     * @param string $blockTitle The block title of the element, alias the lable
     * @return void
     */
    public function __construct(TDProject_Core_Interfaces_Block_Widget_Form $form, $blockName, $blockTitle) {
        // call the parent constructor
        parent::__construct($form, $blockName, $blockTitle);
    	// set the CSS class
    	$this->_setCssClass('type-text');
        // set the template name
        $this->_setTemplate('www/design/core/templates/widget/element/select.phtml');
        // initialize the Collection for the options
        $this->_options = new TechDivision_Collections_ArrayList();
    }
    
    /**
     * (non-PHPdoc)
     * @see TDProject_Core_Interfaces_Block_Widget_Element_Select::setDummyOption($dummyOption)
     */
    public function setDummyOption($dummyOption = true) {
    	$this->_dummyOption = $dummyOption;
    	return $this;
    }
    
    /**
     * (non-PHPdoc)
     * @see TDProject_Core_Interfaces_Block_Widget_Element_Select::hasDummyOption()
     */
    public function hasDummyOption() {
    	return $this->_dummyOption;
    }
    
    /**
     * (non-PHPdoc)
     * @see TDProject_Core_Interfaces_Block_Widget_Element_Select::getOptionValue()
     */
    public function getOptionValue(TDProject_Core_Interfaces_Block_Widget_Element_Select_Option $option) {
    	return $option->getOptionValue();
    }
    
    /**
     * (non-PHPdoc)
     * @see TDProject_Core_Interfaces_Block_Widget_Element_Select::getOptionLabel()
     */
    public function getOptionLabel(TDProject_Core_Interfaces_Block_Widget_Element_Select_Option $option) {
    	return $option->getOptionLabel();
    }
    
    /**
     * (non-PHPdoc)
     * @see TDProject_Core_Interfaces_Block_Widget_Element_Select::isSelected()
     */
    public function isSelected(TDProject_Core_Interfaces_Block_Widget_Element_Select_Option $option) {
    	return $option->isSelected($this->getValue());
    }
    
    /**
     * (non-PHPdoc)
     * @see TDProject_Core_Interfaces_Block_Widget_Element_Select::setOptions()
     */
    public function setOptions(TechDivision_Collections_Interfaces_Collection $options) {
    	$this->_options = $options;
    	return $this;
    }
    
    /**
     * (non-PHPdoc)
     * @see TDProject_Core_Interfaces_Block_Widget_Element_Select::getOptions()
     */
    public function getOptions() {
    	return $this->_options;
    }
}