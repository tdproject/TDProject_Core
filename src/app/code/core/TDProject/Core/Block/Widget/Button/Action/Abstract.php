<?php

/**
 * TDProject_Core_Block_Widget_Button_Action_Abstract
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

require_once 'TDProject/Core/Block/Widget/Button.php';
require_once 'TDProject/Core/Interfaces/Block/Widget/Grid.php';
require_once 'TDProject/Core/Interfaces/Block/Widget/Button/Action.php';

/**
 * @category    TDProject
 * @package     TDProject_Core
 * @copyright   Copyright (c) 2010 <info@techdivision.com> - TechDivision GmbH
 * @license     http://opensource.org/licenses/osl-3.0.php
 *              Open Software License (OSL 3.0)
 * @author      Johann Zelger <twtechdivision.com>
 */
abstract class TDProject_Core_Block_Widget_Button_Action_Abstract
    extends TDProject_Core_Block_Widget_Button
    implements TDProject_Core_Interfaces_Block_Widget_Button_Action {

    /**
     * Initialize the button's URL when clicked.
     * @var string
     */
    protected $_url = '#';

    /**
     * Initialize the button with the context.
     *
     * @return void
     */
    public function __construct(TDProject_Core_Interfaces_Block_Widget_Grid $grid, $blockName, $blockTitle) {
        // call the parent constructor
        parent::__construct($grid->getContext(), $blockName, $blockTitle);
        // add the grid Actions
        $grid->getActions()->addAction($this);
        // set the fieldset template
        $this->_setTemplate('www/design/core/templates/widget/button/action.phtml');
    }

    /**
     * Sets the button's URL when clicked.
     *
     * @param string $url
     * 		The URL to invoke when clicked
     * @return void
     */
    public function setUrl($url) {
    	$this->_url = $url;
    }

    /**
     * (non-PHPdoc)
     * @see TDProject_Core_Interfaces_Block_Widget_Grid_Column_Action::getLabel()
     */
    public function getLabel() {
    	return $this->getBlockTitle();
    }

    /**
     * (non-PHPdoc)
     * @see TDProject_Core_Interfaces_Block_Widget_Grid_Column_Action::getProperty()
     */
    public function getProperty() {
    	return $this->getBlockName();
    }

    /**
     * (non-PHPdoc)
     * @see TDProject_Core_Block_Abstract::getUrl()
     */
    public function getUrl() {
    	return 'window.location="' .
    	    $this->_url . '" + anSelected[i]; return false;';
    }
}