<?php

/**
 * TDProject_Core_Block_Widget_Overview
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

require_once 'TDProject/Common/Util/WebRequestKeys.php';
require_once 'TDProject/Core/Block/Widget/Tabs.php';
require_once 'TDProject/Core/Block/Widget/Form/Abstract.php';
require_once 'TDProject/Core/Block/Widget/Button/New.php';
require_once 'TDProject/Core/Interfaces/Block/Widget/Form/Overview.php';

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

abstract class TDProject_Core_Block_Widget_Form_Abstract_Overview 
    extends TDProject_Core_Block_Widget_Form_Abstract
    implements TDProject_Core_Interfaces_Block_Widget_Form_Overview {
    	
    /**
     * Initialize the block with the
     * apropriate template and name.
     * 
     * @return void
     */
    public function __construct(TechDivision_Controller_Interfaces_Context $context) {
        // call the parent constructor
        parent::__construct($context);
    	// set the block title
    	$this->_setBlockTitle($this->translate('title' . $this->getPathPrepared() . '.overview'));
        // set the internal name
        $this->_setBlockName(
        	TDProject_Core_Block_Abstract::BLOCK_NAME
        );
        // set the template name
        $this->_setTemplate('www/design/core/templates/widget/overview.phtml'); 
    }

    /**
     * (non-PHPdoc)
     * @see TDProject_Core_Interfaces_Block_Widget_Form_Overview::getCollection()
     */
    public function getCollection() {
		return $this->getRequest()->getAttribute(
			TDProject_Common_Util_WebRequestKeys::OVERVIEW_DATA
		);
    }

	/**
     * (non-PHPdoc)
     * @see TDProject/Interfaces/Block#prepareLayout()
     */
    public function prepareLayout() {
		// add the toolbar's default buttons
		$this->getToolbar()
			->addButton(
				new TDProject_Core_Block_Widget_Button_New(
					$this, 
					$this->translate('button' . $this->getPathPrepared() . '.new')
				)
			);
    	// initialize the tabs add the tab for the users
    	$tabs = $this->addTabs(
    		TDProject_Core_Block_Widget_Tabs::BLOCK_NAME, 
    		$this->translate('tabs.label' . $this->getPathPrepared())
    	)->addTab(
        	$this->getPathPrepared('')->stringValue(), 
        	$this->translate('tab.label' . $this->getPathPrepared())
        )->addGrid(
        	$this->prepareGrid()
        );
	    // return the instance itself
	    return parent::prepareLayout();
    }
    
    /**
     * (non-PHPdoc)
     * @see TDProject_Core_Interfaces_Block_Widget_Form_Overview::getNewUrl()
     */
    public function getNewUrl() {
    	return '?path=' . $this->getPath() . '&method=create';
    }
    
    /**
     * (non-PHPdoc)
     * @see TDProject_Core_Interfaces_Block_Widget_Form_Overview::getTabs()
     */
    public function getTabs() {
    	return $this->_getBlock(TDProject_Core_Block_Widget_Tabs::BLOCK_NAME);
    }
    
    /**
     * (non-PHPdoc)
     * @see TDProject_Core_Interfaces_Block_Widget_Form_Overview::getDefaultTab()
     */
    public function getDefaultTab() {
    	return $this->getTabs()->getTab($this->getPathPrepared('')->stringValue());
    }
}