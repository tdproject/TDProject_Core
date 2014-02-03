<?php

/**
 * TDProject_Core_Block_Widget_Tab
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

require_once 'TDProject/Core/Block/Widget/Abstract/Localized.php';
require_once 'TDProject/Core/Interfaces/Block/Widget/Tab.php';
require_once 'TDProject/Core/Interfaces/Block/Widget/Fieldset.php';
require_once 'TDProject/Core/Block/Widget/Fieldset.php';

/**
 * @category    TDProject
 * @package     TDProject_Core
 * @copyright   Copyright (c) 2010 <info@techdivision.com> - TechDivision GmbH
 * @license     http://opensource.org/licenses/osl-3.0.php
 *              Open Software License (OSL 3.0)
 * @author      Johann Zelger <jz@techdivision.com>
 */
class TDProject_Core_Block_Widget_Tab
    extends TDProject_Core_Block_Widget_Abstract_Localized
    implements TDProject_Core_Interfaces_Block_Widget_Tab {

   	/**
     * The identifier of the fieldset
     * @var string
     */
    protected $_id = 'tabs';

    /**
     * The html class of the tab
     * @var string
     */
    protected $_class = 'ui-widget-header ui-corner-all';

    /**
     * Initialize the tab with the context instance, the name and the title.
     *
     * @param TechDivision_Controller_Interfaces_Context $context The context instance
     * @param string $blockName The tab name
     * @param string $blockTitle The tab title
     * @return void
     */
    public function __construct(
        TechDivision_Controller_Interfaces_Context $context,
        $blockName,
        $blockTitle) {
        // call the parent constructor
        parent::__construct($context);
    	// set the tab name and title
    	$this->_setBlockName($blockName);
    	$this->_setBlockTitle($blockTitle);
        // set the template name
        $this->_setTemplate('www/design/core/templates/widget/tab.phtml');
    }

    /**
     * (non-PHPdoc)
     * @see TDProject_Core_Block_Abstract::getCssId()
     */
    public function getCssId() {
    	return $this->_id . '-' . $this->getBlockName();
    }

    /**
     * Adds the passed fieldset to the tab.
     *
     * @param TDProject_Core_Interfaces_Block_Widget_Fieldset $fieldset
     * 		The fieldset to add
     * @return TDProject_Core_Block_Widget_Tab
     * 		The instance itself
     */
    protected function _addFieldset(
        TDProject_Core_Interfaces_Block_Widget_Fieldset $fieldset) {
    	$this->addBlock($fieldset);
    	return $fieldset;
    }

    /**
     * Creates a new fieldset with the passed title and
     * adds it to the tab.
     *
     * @param string $blockTitle
     * @return TDProject_Core_Interfaces_Block_Widget_Fieldset
     * 		The fieldset to add to the tab
     */
    public function addFieldset($blockName, $blockTitle) {
    	return $this->_addFieldset(
    		new TDProject_Core_Block_Widget_Fieldset(
    		    $this->getContext(),
    		    $blockName,
    		    $blockTitle
    		)
        );
    }

    /**
     * (non-PHPdoc)
     * @see TDProject_Core_Interfaces_Block_Widget_Tab::getFieldsets()
     */
    public function getFieldsets() {
    	// initialize the array for the fieldsets
    	$fieldsets = array();
    	// load the fieldset childs
    	foreach ($this->_childs as $blockName => $child) {
    		if ($child instanceof TDProject_Core_Interfaces_Block_Widget_Fieldset) {
    			$fieldsets[$blockName] = $child;
    		}
    	}
    	// return the fieldset childs
    	return $fieldsets;
    }
}