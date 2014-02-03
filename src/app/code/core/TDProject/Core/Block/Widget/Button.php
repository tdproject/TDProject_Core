<?php

/**
 * TDProject_Core_Block_Widget_Button
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

require_once 'TDProject/Core/Block/Widget/Abstract/Localized.php';
require_once 'TDProject/Core/Interfaces/Block/Widget/Button.php';
require_once 'TDProject/Core/Interfaces/Block/Widget/Tab.php';

/**
 * @category    TDProject
 * @package     TDProject_Core
 * @copyright   Copyright (c) 2010 <info@techdivision.com> - TechDivision GmbH
 * @license     http://opensource.org/licenses/osl-3.0.php
 *              Open Software License (OSL 3.0)
 * @author      Johann Zelger <jz@techdivision.com>
 */
class TDProject_Core_Block_Widget_Button
    extends TDProject_Core_Block_Widget_Abstract_Localized
    implements TDProject_Core_Interfaces_Block_Widget_Button {

    /**
     * The buttons icon
     * @var string
     */
    protected $_icon = 'ui-icon-plusthick';

    /**
     * The onclick javascript action
     * @var string
     */
    protected $_onClick = 'alert(\'button clicked\');';

    /**
     * The tab element the button is binded to.
     * @var TDProject_Core_Interfaces_Block_Widget_Tab
     */
    protected $_tabToBind = null;

    /**
     * Initialize the block with the
     * apropriate template and name.
     *
     * @return void
     */
    public function __construct(
        TechDivision_Controller_Interfaces_Context $context,
        $blockName,
        $blockTitle) {
        // call the parent constructor
        parent::__construct($context);
    	// set the fieldset name and title
    	$this->_setBlockName($blockName);
    	$this->_setBlockTitle($blockTitle);
    	// set the icon to use
		$this->setIcon('ui-icon-document');
        // set the fieldset template
        $this->_setTemplate('www/design/core/templates/widget/button.phtml');
    }

    /**
     * Sets the onClick Javascript event for the button.
     *
     * @param $onClick string
     * 		JavaScript code for the buttons onClick event
     * @return TDProject_Core_Interfaces_Block_Widget_Button
     * 		The button instance
     */
    public function setOnClick($onClick) {
    	$this->_onClick = $onClick;
    	return $this;
	}

	/**
	 * Sets the tab element the button is binded to. The tab will
	 * be opened when the button was clicked.
	 *
	 * @param TDProject_Core_Interfaces_Block_Widget_Tab $tabToBind
     * @return TDProject_Core_Interfaces_Block_Widget_Button
     * 		The button instance
	 */
	public function bindToTab(
	    TDProject_Core_Interfaces_Block_Widget_Tab $tabToBind) {
		$this->_tabToBind = $tabToBind;
		return $this;
	}

	/**
	 * Sets the icon for the button.
	 *
	 * @param string $icon Name of the buttons icon
	 */
	public function setIcon($icon) {
		$this->_icon = $icon;
	}

    /**
     * (non-PHPdoc)
     * @see TDProject_Core_Interfaces_Block_Widget_Button::getOnClick()
     */
    public function getOnClick() {
    	return $this->_onClick;
	}

    /**
     * (non-PHPdoc)
     * @see TDProject_Core_Interfaces_Block_Widget_Button::getIcon()
     */
	public function getIcon() {
		return $this->_icon;
	}

	/**
	 * (non-PHPdoc)
	 * @see TDProject_Core_Interfaces_Block_Widget_Button::isBindedToTab()
	 */
	public function isBindedToTab() {
		if ($this->_tabToBind == null) {
			return false;
		}
		return true;
	}

	/**
	 * (non-PHPdoc)
	 * @see TDProject_Core_Interfaces_Block_Widget_Button::getBindedTab()
	 */
	public function getBindedTab() {
		return $this->_tabToBind;
	}
}