<?php

/**
 * TDProject_Core_Block_Widget_Button_Action_Delete
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

require_once 'TDProject/Core/Block/Widget/Button.php';
require_once 'TDProject/Core/Interfaces/Block/Widget/Form.php';
require_once 'TDProject/Core/Block/Widget/Button/Action/Abstract.php';

/**
 * @category    TDProject
 * @package     TDProject_Core
 * @copyright   Copyright (c) 2010 <info@techdivision.com> - TechDivision GmbH
 * @license     http://opensource.org/licenses/osl-3.0.php
 *              Open Software License (OSL 3.0)
 * @author      Johann Zelger <twtechdivision.com>
 */
class TDProject_Core_Block_Widget_Button_Action_Delete
    extends TDProject_Core_Block_Widget_Button_Action_Abstract {
    
    /**
     * Initialize the button with the context.
     * 
     * @return void
     */
    public function __construct(TDProject_Core_Interfaces_Block_Widget_Grid $grid, $blockName, $blockTitle) {
        // call the parent constructor
        parent::__construct($grid, $blockName, $blockTitle);
    	// set the icon to use
		$this->setIcon('ui-icon-trash');
		// set the URL to invoke, when clicked
		$this->setUrl($grid->getDeleteUrl());
    }
}