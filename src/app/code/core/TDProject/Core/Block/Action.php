<?php

/**
 * TDProject_Core_Block_Navigation
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

require_once 'TDProject/Core/Block/Action/Errors.php';
require_once 'TDProject/Core/Block/Action/Messages.php';

/**
 * @category    TDProject
 * @package     TDProject_Core
 * @copyright   Copyright (c) 2010 <info@techdivision.com> - TechDivision GmbH
 * @license     http://opensource.org/licenses/osl-3.0.php
 *              Open Software License (OSL 3.0)
 * @author      Tim Wagner <tw@techdivision.com>
 */
class TDProject_Core_Block_Action 
    extends TDProject_Core_Block_Abstract {
    
    /**
     * Show block as jquery dialog if flag is true
     * @var boolean
     */
    protected $_dialog = true;
    	
    /**
     * Initialize the block with the
     * apropriate template and name.
     * 
     * @return void
     */
    public function __construct(
        TechDivision_Controller_Interfaces_Context $context, $dialog = true) {
        // set the internal name
        $this->_setBlockName('action');
        // set the template name
        $this->_setTemplate('www/design/core/templates/action.phtml');
        // set dialog mode
        $this->_setDialog($dialog);
        // call the parent constructor
        parent::__construct($context);
    }

	/**
     * (non-PHPdoc)
     * @see TDProject/Interfaces/Block#prepareLayout()
     */
    public function prepareLayout() {
        // add the messages and errors
        $this->addBlock(
        	new TDProject_Core_Block_Action_Errors($this->getContext(), $this->isDialog())
        );
        $this->addBlock(
        	new TDProject_Core_Block_Action_Messages($this->getContext())
        );
        // call the parent method
        return parent::prepareLayout();
    }
    
    /**
     * Set dialog flag if this block should be shown as a jQuery dialog
     * after the page rendering is finished.
     * 
     * @param boolean $flag
     * @return TDProject_Core_Block_Action
     */
    protected function _setDialog($flag) {
    	$this->_dialog = $flag;
    	return $this;
    }
    
    /**
     * Gets the flag if this block should be shown as a jQuery dialog
     * after the page rendering is finished.
     * 
     * @return boolean
     */
    public function isDialog() {
    	return $this->_dialog;
    }

}