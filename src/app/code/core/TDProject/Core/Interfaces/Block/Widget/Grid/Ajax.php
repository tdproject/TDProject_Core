<?php

/**
 * TDProject_Core_Interfaces_Block_Widget_Grid_Ajax
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

require_once 'TDProject/Core/Interfaces/Block/Widget/Grid.php';

/**
 * @category    TDProject
 * @package     TDProject_Core
 * @copyright   Copyright (c) 2010 <info@techdivision.com> - TechDivision GmbH
 * @license     http://opensource.org/licenses/osl-3.0.php
 *              Open Software License (OSL 3.0)
 * @author      Tim Wagner <tw@techdivision.com>
 */
interface TDProject_Core_Interfaces_Block_Widget_Grid_Ajax
	extends TDProject_Core_Interfaces_Block_Widget_Grid {
    
    /**
     * Returns the data source to the URL for loading the 
     * JSON encoded array with the data to render.
	 *
     * @return TechDivision_Lang_String
     * 		The URL calling to load the data
     */
    public function getDataSource();
    
    /**
     * Returns the row based actions, e. g.
     * for editing or deleting a row's data.
     * 
     * @return TDProject_Core_Interfaces_Block_Widget_Grid_Column_Actions
     * 		The row based actions
     */
    public function getActions();
    
    /**
     * Returns the URL to open the dialog to edit the row
     * selected by the user.
     * 
     * @return string The URL to open the editing dialog
     */
    public function getEditUrl();
    
    /**
     * Returns the URL to delete the row
     * selected by the user.
     * 
     * @return string The URL to delete the selected row
     */
    public function getDeleteUrl();
}