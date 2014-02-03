<?php

/**
 * TDProject_Core_Block_Widget_Element_Abstract
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

require_once 'TDProject/Core/Block/Widget/Abstract/Localized.php';
require_once 'TDProject/Core/Interfaces/Block/Widget/Element.php';
require_once 'TDProject/Core/Interfaces/Block/Widget/Form.php';

/**
 * @category    TDProject
 * @package     TDProject_Core
 * @copyright   Copyright (c) 2010 <info@techdivision.com> - TechDivision GmbH
 * @license     http://opensource.org/licenses/osl-3.0.php
 *              Open Software License (OSL 3.0)
 * @author      Johann Zelger <jz@techdivision.com>
 */
abstract class TDProject_Core_Block_Widget_Element_Abstract
    extends TDProject_Core_Block_Widget_Abstract_Localized
    implements TDProject_Core_Interfaces_Block_Widget_Element {

    /**
     * The ActionForm instance the element is bound to.
     * @var TDProject_Core_Interfaces_Block_Form
     */
    protected $_form = null;

    /**
     *
     * Enter description here ...
     * @var unknown_type
     */
    protected $_disabled = null;

    /**
     * Initialize the toolbar with the apropriate template and name.
     *
     * @param TDProject_Core_Interfaces_Block_Widget_Form The ActionForm instance the element is bound to
     * @param string $blockName The block name of the element, alias the property
     * @param string $blockTitle The block title of the element, alias the lable
     * @return void
     */
    public function __construct(
        TDProject_Core_Interfaces_Block_Widget_Form $form,
        $blockName,
        $blockTitle) {
        // call the parent constructor
        parent::__construct($form->getContext());
        // set the
        $this->_form = $form;
    	// set the block title
    	$this->_setBlockName($blockName);
    	$this->_setBlockTitle($blockTitle);
    	// sets the elments default options
    	$this->setDisabled(false);
    	$this->setMandatory(false);
    }

    /**
     * Disables the element if TRUE.
	 *
     * @param boolean $disabled
     * 		TRUE if the element has to be diabled, else FALSE
     * @return TDProject_Core_Interfaces_Block_Widget_Element
     * 		The element instance
     */
    public function setDisabled($disabled = true) {
    	$this->_disabled = new TechDivision_Lang_Boolean($disabled);
    	return $this;
    }

    /**
     * Renders an element as mandatory if TRUE.
	 *
     * @param boolean $mandatory
     * 		TRUE if the element has to be rendered mandatory, else FALSE
     * @return TDProject_Core_Interfaces_Block_Widget_Element
     * 		The element instance
     */
    public function setMandatory($mandatory = true) {
    	$this->_mandatory = new TechDivision_Lang_Boolean($mandatory);
    	return $this;
    }

    /**
     * (non-PHPdoc)
     * @see TDProject_Core_Block_Abstract::getCssId()
     */
    public function getCssId() {
    	$this->getBlockName();
    }

    /**
     * (non-PHPdoc)
     * @see TDProject_Core_Interfaces_Block_Widget_Element::getValue()
     */
    public function getValue() {
    	return $this->_form->getValueByProperty($this->getBlockName());
    }

    /**
     * (non-PHPdoc)
     * @see TDProject_Core_Interfaces_Block_Widget_Element::isDisabled()
     */
    public function isDisabled() {
    	return $this->_disabled->booleanValue();
    }

    /**
     * (non-PHPdoc)
     * @see TDProject_Core_Interfaces_Block_Widget_Element::isMandatory()
     */
    public function isMandatory() {
    	return $this->_mandatory->booleanValue();
    }
}