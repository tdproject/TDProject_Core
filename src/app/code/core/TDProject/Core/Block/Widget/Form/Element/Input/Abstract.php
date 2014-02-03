<?php

/**
 * TDProject_Core_Block_Widget_Element_Input_Abstract
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

require_once 'TDProject/Core/Block/Widget/Element/Abstract.php';
require_once 'TDProject/Core/Interfaces/Block/Widget/Element/Input.php';

/**
 * @category    TDProject
 * @package     TDProject_Core
 * @copyright   Copyright (c) 2010 <info@techdivision.com> - TechDivision GmbH
 * @license     http://opensource.org/licenses/osl-3.0.php
 *              Open Software License (OSL 3.0)
 * @author      Johann Zelger <jz@techdivision.com>
 */
abstract class TDProject_Core_Block_Widget_Element_Input_Abstract
    extends TDProject_Core_Block_Widget_Element_Abstract
    implements TDProject_Core_Interfaces_Block_Widget_Element_Input {
    	
    /**
     * The size of the input element to be rendered.
     * @var TechDivision_Lang_Integer
     */
    protected $_maxLength = 255;
    
    /**
     * The size of the input element to be rendered.
     * @var TechDivision_Lang_Integer
     */
    protected $_size = 10;
    
    /**
     * (non-PHPdoc)
     * @see TDProject_Core_Interfaces_Block_Widget_Element_Input::getMaxLength()
     */
    public function getMaxLength() {
    	return $this->_maxLength;	
    }
    
    /**
     * Sets the size of the input element to be rendered.
     * 
     * @param integer $size
     * 		The input element's size
     */
    public function setMaxLenth($maxLength) {
    	$this->_maxLength = new TechDivision_Lang_Integer($maxLength);
    }
    
    /**
     * (non-PHPdoc)
     * @see TDProject_Core_Interfaces_Block_Widget_Element_Input::getSize()
     */
    public function getSize() {
    	return $this->_size;
    }
    
    /**
     * Sets the size of the input element to be rendered.
     * 
     * @param integer $size
     * 		The input element's size
     */
    public function setSize($size) {
    	$this->_size = new TechDivision_Lang_Integer($size);
    }
}