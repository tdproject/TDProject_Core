<?php

/**
 * TDProject_Interfaces_Block_Widget_Toolbar
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

require_once 'TDProject/Core/Interfaces/Block/Widget.php';

/**
 * @category    TDProject
 * @package     TDProject_Core
 * @copyright   Copyright (c) 2010 <info@techdivision.com> - TechDivision GmbH
 * @license     http://opensource.org/licenses/osl-3.0.php
 *              Open Software License (OSL 3.0)
 * @author      Johann Zelger <jz@techdivision.com>
 */
interface TDProject_Core_Interfaces_Block_Widget_Toolbar
	extends TDProject_Core_Interfaces_Block_Widget {
	
	/**
     * Adds a button to the toolbar.
     * 
     * @param TDProject_Core_Interfaces_Block_Widget_Button $button 
     * 		The button to add
     * @return TDProject_Core_Interfaces_Block_Widget_Toolbar
     */
    public function addButton(TDProject_Core_Interfaces_Block_Widget_Button $block);
    
    /**
     * Removes a button by it's block name.
     * 
     * @param string $blockName
     * @return TDProject_Core_Interfaces_Block_Widget_Toolbar
     */
    public function removeButton($blockName);
    
    /**
     * Returns the buttons
     * 
	 * @return array
     */
    public function getButtons();	
    
    /**
     * Removes all buttons from the toolbar.
     * 
     * @return TDProject_Core_Interfaces_Block_Widget_Toolbar
     * 		The instance itself
     */
    public function clear();
}