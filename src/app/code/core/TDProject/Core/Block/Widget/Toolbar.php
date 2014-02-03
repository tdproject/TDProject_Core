<?php

/**
 * TDProject_Core_Block_Widget_Toolbar
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

require_once 'TechDivision/Lang/Boolean.php';
require_once 'TDProject/Core/Block/Widget/Abstract.php';
require_once 'TDProject/Core/Block/Widget/Button.php';
require_once 'TDProject/Core/Interfaces/Block/Widget/Toolbar.php';

/**
 * @category    TDProject
 * @package     TDProject_Core
 * @copyright   Copyright (c) 2010 <info@techdivision.com> - TechDivision GmbH
 * @license     http://opensource.org/licenses/osl-3.0.php
 *              Open Software License (OSL 3.0)
 * @author      Johann Zelger <jz@techdivision.com>
 */
class TDProject_Core_Block_Widget_Toolbar
    extends TDProject_Core_Block_Widget_Abstract
    implements TDProject_Core_Interfaces_Block_Widget_Toolbar {

    /**
     * The unique block name.
     * @var string
     */
    const BLOCK_NAME = 'toolbar';

    /**
     * The HTML class of the toolbar
     * @var string
     */
    protected $_class = 'ui-widget-header ui-corner-all';

    /**
     * Initialize the toolbar with the apropriate template and name.
     *
     * @return void
     */
    public function __construct(TechDivision_Controller_Interfaces_Context $context) {
        // call the parent constructor
        parent::__construct($context);
        // set auto render mode
        $this->_setAutoRender(false);
        // set css class
        $this->_setCssClass('ui-widget-header ui-corner-all');
        // set the block name
        $this->_setBlockName(TDProject_Core_Block_Widget_Toolbar::BLOCK_NAME);
    	// set the block title
    	$this->_setBlockTitle($this->translate('title.project.view.toolbar'));
        // set the template name
        $this->_setTemplate('www/design/core/templates/widget/toolbar.phtml');
    }

    /**
     * (non-PHPdoc)
     * @see TDProject_Core_Block_Abstract::getCssId()
     */
    public function getCssId() {
    	return $this->getBlockName();
    }

    /**
     * (non-PHPdoc)
     * @see TDProject/Interfaces/Block/Widget/Toolbar#addButton()
     */
    public function addButton(
        TDProject_Core_Interfaces_Block_Widget_Button $button) {
    	$this->addBlock($button);
    	return $this;
    }

    /**
     * (non-PHPdoc)
     * @see TDProject/Interfaces/Block/Widget/Toolbar#removeButton()
     */
    public function removeButton($blockName) {
    	if (!array_key_exists($blockName, $this->_childs)) {
    		throw new Exception(
    			"Can't remove toolbar button: $id does not exist"
    	    );
    	}
    	unset($this->_childs[$blockName]);
    	return $this;
    }

    /**
     * (non-PHPdoc)
     * @see TDProject/Interfaces/Block/Widget/Toolbar#getButtons()
     */
    public function getButtons() {
    	// initialize the array for the buttons
    	$buttons = array();
    	// load the buttons
    	foreach ($this->_childs as $blockName => $child) {
    		if ($child instanceof TDProject_Core_Interfaces_Block_Widget_Button) {
    			$buttons[$blockName] = $child;
    		}
    	}
    	// return the buttons
    	return $buttons;
    }

    /**
     * (non-PHPdoc)
     * @see TDProject_Core_Interfaces_Block_Widget_Toolbar::clear()
     */
    public function clear() {
    	// load the buttons
    	foreach ($this->_childs as $blockName => $child) {
    		if ($child instanceof TDProject_Core_Interfaces_Block_Widget_Button) {
    			unset($this->_childs[$blockName]);
    		}
    	}
    	// return the toolbar instance itself
    	return $this;
    }
}