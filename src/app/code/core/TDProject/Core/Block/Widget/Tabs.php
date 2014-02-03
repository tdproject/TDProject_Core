<?php

/**
 * TDProject_Core_Block_Widget_View_Tabs
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

require_once 'TDProject/Core/Block/Widget/Abstract.php';
require_once 'TDProject/Core/Interfaces/Block/Widget/Tabs.php';
require_once 'TDProject/Core/Interfaces/Block/Widget/Tab.php';
require_once 'TDProject/Core/Block/Widget/Tab.php';

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

class TDProject_Core_Block_Widget_Tabs 
    extends TDProject_Core_Block_Widget_Abstract
    implements TDProject_Core_Interfaces_Block_Widget_Tabs {
    	
    /**
     * The unique block name.
     * @var string
     */
    const BLOCK_NAME = 'tabs';
    	
    /**
     * Initialize the tabs container with the context instance, the name and the title.
     * 
     * @param TechDivision_Controller_Interfaces_Context $context The context instance
     * @param string $blockName The tabs container name
     * @param string $blockTitle The tabs container title
     * @return void
     * 
     * @return void
     */
    public function __construct(TechDivision_Controller_Interfaces_Context $context, $blockName, $blockTitle) {
        // call the parent constructor
        parent::__construct($context);
        // set the tabs name and title
        $this->_setBlockName($blockName);
        $this->_setBlockTitle($blockTitle);
        // set the template name
        $this->_setTemplate('www/design/core/templates/widget/view/tabs.phtml'); 
    }
    
    /**
     * Adds the passed tab to the view.
     * 
     * @param TDProject_Core_Interfaces_Block_Widget_Tab $tab
     * 		The tab to add
     * @return TDProject_Core_Interfaces_Block_Widget_Tabs
     * 		The tab instance itself
     */
    protected function _addTab(
        TDProject_Core_Interfaces_Block_Widget_Tab $tab) {
    	$this->addBlock($tab);
    	return $tab;
    }
    
    /**
     * Creates a new tab with the passed title and
     * adds it to the view.
     * 
     * @param string $blockName
     * @param string $blockTitle
     * @return TDProject_Core_Interfaces_Block_Widget_Tab
     * 		The tab to add to the view
     */
    public function addTab($blockName, $blockTitle) {
    	return $this->_addTab(
    		new TDProject_Core_Block_Widget_Tab(
    		    $this->getContext(), 
    		    $blockName, 
    		    $blockTitle
    		)
        );
    }
    
    /**
     * (non-PHPdoc)
     * @see TDProject_Core_Interfaces_Block_Widget_Tabs::getTab()
     */
    public function getTab($blockName) {
    	// check if the requested block exists 
    	if (array_key_exists($blockName, $this->_childs)) {
    		$tab = $this->_childs[$blockName];
    		// if yes, check if the requested block is a Tab
    		if ($tab instanceof TDProject_Core_Block_Widget_Tab) {
    			// return the block
    			return $tab;
    		}
			// throw an Exception if requested block is not of type Tab
    		throw new Exception('Requested Tab ' . $blockName . ' is not a Tab');
    	}
		// throw an Exception if requested Tab doesn't exist
    	throw new Exception('Requested Tab ' . $blockName . ' is not registered');
    }
    
    /**
     * (non-PHPdoc)
     * @see TDProject_Core_Interfaces_Block_Widget_View::getTabs()
     */
    public function getTabs() {
    	// initialize the array for the tabs
    	$tabs = array();
    	// load the tab childs
    	foreach ($this->_childs as $blockName => $child) {
    		if ($child instanceof TDProject_Core_Interfaces_Block_Widget_Tab) {
    			$tabs[$blockName] = $child;
    		}
    	}
    	// return the tab childs
    	return $tabs;
    }
}