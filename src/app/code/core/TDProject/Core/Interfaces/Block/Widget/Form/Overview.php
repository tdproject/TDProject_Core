<?php

/**
 * TDProject_Core_Interfaces_Block_Widget_Form_Overview
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
 * @author      Tim Wagner <tw@techdivision.com>
 */
interface TDProject_Core_Interfaces_Block_Widget_Form_Overview 
	extends TDProject_Core_Interfaces_Block_Widget_Form {

	/**
	 * Returns the URL to open the view for creating 
	 * a new enity.
	 * 
	 * @return string
	 * 		The URL to create a new entity
	 */
	public function getNewUrl();
    
    /**
     * Returns the Collection with the
     * data to render.
     * 
     * @return TechDivision_Collections_Interfaces_Collection
     * 		The Collection with the data to render
     */
    public function getCollection();
    
    /**
     * Initializes the grid and returns the instance.
     * 
     * @return TDProject_Core_Block_Widget_Grid
     * 		The initialized grid instance.
     */
    public function prepareGrid();
    
    /**
     * Returns the default Tab of the Grid.
     * 
     * @return TDProject_Core_Interfaces_Block_Widget_Tab
     * 		The default Tab
     */
    public function getDefaultTab();
    
    /**
     * Returns the Tabs of the overview dialog.
     * 
     * @return TDProject_Core_Block_Widget_Tabs
     * 		The Tabs instance
     */
    public function getTabs();
}