<?php

/**
 * TDProject_Interfaces_Block_Widget
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

require_once 'TDProject/Core/Interfaces/Block.php';

/**
 * @category    TDProject
 * @package     TDProject_Core
 * @copyright   Copyright (c) 2010 <info@techdivision.com> - TechDivision GmbH
 * @license     http://opensource.org/licenses/osl-3.0.php
 *              Open Software License (OSL 3.0)
 * @author      Johann Zelger <jz@techdivision.com>
 */
interface TDProject_Core_Interfaces_Block_Widget
	extends TDProject_Core_Interfaces_Block {
    
    /**
     * Adds the passed element to the form.
     * 
     * @param TDProject_Core_Interfaces_Block_Widget_Element $element
     * 		The element to add
     * @return void
     */
	public function addElement(TDProject_Core_Interfaces_Block_Widget_Element $element);

	/**
	 * Returns all elements within the form as array.
	 * 
	 * @return array 
	 * 		A array of TDProject_Core_Interfaces_Block_Widget_Element objects.
	 */
	public function getElements();
	
	/**
	 * Creates and returns an specific element defined by params. 
	 * 
	 * @param string $type 
	 * 		The element type eg. 'textfield' 
	 * @param string $blockName
	 * 		The name
	 * @param string $blockTitle
	 * 		The title
	 * @return TDProject_Core_Block_Widget_Element_Abstract
	 */
	public function getElement($type, $blockName, $blockTitle = null);
	
	/**
	 * Adds a grid to the form
	 * 
	 * @param TDProject_Core_Interfaces_Block_Widget_Grid $grid
	 * @return TDProject_Core_Block_Abstract
	 */
	public function addGrid(TDProject_Core_Interfaces_Block_Widget_Grid $grid);
}