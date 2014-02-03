<?php

/**
 * TDProject_Core_Block_Widget
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

require_once 'TDProject/Core/Block/Abstract.php';
require_once 'TDProject/Core/Interfaces/Block/Widget/Grid.php';
require_once 'TDProject/Core/Interfaces/Block/Widget.php';

/**
 * This class implements the widget functionality.
 *
 * @category    TProject
 * @package     TDProject_Core
 * @copyright   Copyright (c) 2010 <info@techdivision.com> - TechDivision GmbH
 * @license     http://opensource.org/licenses/osl-3.0.php
 *              Open Software License (OSL 3.0)
 * @author      Johann Zelger <zelgerj@techdivision.com>
 */

abstract class TDProject_Core_Block_Widget_Abstract
	extends TDProject_Core_Block_Abstract
	implements TDProject_Core_Interfaces_Block_Widget {

	/**
	 * The key for the resource bundle to use for widget translation..
	 * @var string
	 */
	const MESSAGE_RESOURCES = 'Widgets';

    /**
     * (non-PHPdoc)
     * @see TDProject_Core_Interfaces_Block_Widget::addElement()
     */
    public function addElement(
        TDProject_Core_Interfaces_Block_Widget_Element $element) {
    	return $this->addBlock($element);
    }

    /**
     * (non-PHPdoc)
     * @see TDProject_Core_Interfaces_Block_Widget::getElements()
     */
    public function getElements() {
    	// initialize the array for the elements
    	$elements = array();
    	// load the element childs
    	foreach ($this->_childs as $blockName => $child) {
    		if ($child instanceof TDProject_Core_Interfaces_Block_Widget_Element) {
    			$elements[$blockName] = $child;
    		}
    	}
    	// return the element childs
    	return $elements;
    }

    /**
     * (non-PHPdoc)
     * @see TDProject_Core_Interfaces_Block_Widget::getElement()
     */
    public function getElement($type, $blockName, $blockTitle = null) {
    	switch ($type) {
    		case 'textfield':
    			return new TDProject_Core_Block_Widget_Element_Input_Textfield(
    				$this, $blockName, $blockTitle);
    			break;
    		case 'password':
    			return new TDProject_Core_Block_Widget_Element_Input_Password(
    				$this, $blockName, $blockTitle);
    			break;
    		case 'checkbox':
    			return new TDProject_Core_Block_Widget_Element_Input_Checkbox(
    				$this, $blockName, $blockTitle);
    			break;
    		case 'hidden':
    			return new TDProject_Core_Block_Widget_Element_Input_Hidden(
    				$this, $blockName);
    			break;
    		case 'select':
    			return new TDProject_Core_Block_Widget_Element_Select(
    				$this, $blockName, $blockTitle);
    			break;
    		case 'textarea':
    			return new TDProject_Core_Block_Widget_Element_Textarea(
    				$this, $blockName, $blockTitle);
    			break;
    		case 'graph':
    			return new TDProject_Core_Block_Widget_Element_Graph(
    				$this, $blockName, $blockTitle);
    			break;
    		case 'file':
    			return new TDProject_Core_Block_Widget_Element_Input_File(
    				$this, $blockName, $blockTitle);
    			break;
    		case 'datePicker':
    			return new TDProject_Core_Block_Widget_Element_Input_Textfield_DatePicker(
    				$this, $blockName, $blockTitle);
    			break;
    		case 'dateTimePicker':
    			return new TDProject_Core_Block_Widget_Element_Input_Textfield_DateTimePicker(
    				$this, $blockName, $blockTitle);
    			break;
    		default:
    			throw new Exception('Invalid element type ' . $type . ' requested');
    	}
    }

	/**
	 * (non-PHPdoc)
	 * @see TDProject_Core_Interfaces_Block_Widget::addGrid()
	 */
    public function addGrid(TDProject_Core_Interfaces_Block_Widget_Grid $grid) {
    	return $this->addBlock($grid);
    }
}