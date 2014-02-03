<?php

/**
 * TDProject_Core_Block_Widget_Form_Ajax_Abstract
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

require_once 'TechDivision/Lang/String.php';
require_once 'TechDivision/Controller/Interfaces/Context.php';
require_once 'TDProject/Core/Block/Widget/Form/Abstract.php';
require_once 'TDProject/Core/Interfaces/Block/Widget/Form/Ajax.php';
require_once 'TDProject/Core/Block/Widget/Form/Ajax/Toolbar.php';

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

abstract class TDProject_Core_Block_Widget_Form_Ajax_Abstract 
    extends TDProject_Core_Block_Widget_Form_Abstract
    implements TDProject_Core_Interfaces_Block_Widget_Form_Ajax {
    
    /**
     * Initialize the block with the
     * apropriate template and name.
     * 
     * @return void
     */
    public function __construct(TechDivision_Controller_Interfaces_Context $context) {
        // call the parent constructor
        parent::__construct($context);
        // set the template name
        $this->_setTemplate('www/design/core/templates/widget/form/ajax.phtml'); 
    }
    
    /**
     * (non-PHPdoc)
     * @see TDProject_Core_Block_Widget_Form_Abstract::prepareLayout()
     */
    public function prepareLayout() {
    	// get Action Messages and Errors block without dialog functionality
    	$this->addBlock(new TDProject_Core_Block_Action($this->getContext(), false));
	    // call parent function
    	parent::prepareLayout();
    	// add the hidden fields
    	$this->addElement($this->getElement('hidden', 'path'));
    	$this->addElement($this->getElement('hidden', 'method'));
		// return the instance
    	return $this;
    }
    
    /**
     * (non-PHPdoc)
     * @see TDProject_Core_Block_Abstract::getCssId()
     */
    public function getCssId() {
    	return $this->getFormName();
    }
    
    /**
     * (non-PHPdoc)
     * @see TDProject_Core_Interfaces_Block_Widget_Form_Ajax::getMethod()
     */
	public function getMethod() {
		return new TechDivision_Lang_String('save');
	}
    
    /**
     * (non-PHPdoc)
     * @see TDProject_Core_Interfaces_Block_Widget_Form::getToolbar()
     */
    public function getToolbar() {
    	// check if a toolbar was already initialized
    	if (!$this->hasToolbar()) {
	        // if not, prepare the toolbar widget
			$this->addBlock(
				new TDProject_Core_Block_Widget_Form_Ajax_Toolbar(
					$this->getContext()
				)
			);
    	}
    	// return the toolbar
    	return $this->_getBlock(
    		TDProject_Core_Block_Widget_Form_Ajax_Toolbar::BLOCK_NAME);
    }
}