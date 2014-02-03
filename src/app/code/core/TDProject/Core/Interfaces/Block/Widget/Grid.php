<?php

/**
 * TDProject_Core_Interfaces_Block_Widget_Grid
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

require_once 'TDProject/Core/Interfaces/Block/Widget/Grid/Column.php';
require_once 'TDProject/Core/Interfaces/Block/Widget.php';

/**
 * @category    TDProject
 * @package     TDProject_Core
 * @copyright   Copyright (c) 2010 <info@techdivision.com> - TechDivision GmbH
 * @license     http://opensource.org/licenses/osl-3.0.php
 *              Open Software License (OSL 3.0)
 * @author      Tim Wagner <tw@techdivision.com>
 */
interface TDProject_Core_Interfaces_Block_Widget_Grid
	extends TDProject_Core_Interfaces_Block_Widget {
		
	/**
	 * Adds a column to the grid.
	 * 
	 * @param TDProject_Core_Interfaces_Block_Widget_Grid_Column $column
	 * 		The column to render
	 * @return TDProject_Core_Interfaces_Block_Widget_Grid_Column
	 * 		The column added before
	 */
	public function addColumn(TDProject_Core_Interfaces_Block_Widget_Grid_Column $column);
    
	/**
	 * Adds row based actions to the grid, e. g. for editing or 
	 * deleting a row's data.
	 * 
	 * @param TDProject_Core_Interfaces_Block_Widget_Grid_Column_Actions $actions
	 * 		The column with the row based actions
	 * @see TDProject_Core_Interfaces_Block_Widget_Grid::addColumn(TDProject_Core_Interfaces_Block_Widget_Grid_Column $column)
	 */
	public function addActions(TDProject_Core_Interfaces_Block_Widget_Grid_Column_Actions $actions);
	
    /**
     * Returns the Collection with data that has to
     * be rendered.
	 *
     * @return TechDivision_Collections_Interfaces_Collection
     * 		The Collection with the data to render
     */
    public function getCollection();
    
    /**
     * Returns the flag to render the grid header 
     * or not.
	 *
     * @return boolean 
     * 		TRUE if the header has to be rendered, else FALSE
     */
    public function hasHeader();
    
    /**
     * Returns the flag to render the grid footer 
     * or not.
	 *
     * @return boolean 
     * 		TRUE if the footer has to be rendered, else FALSE
     */
    public function hasFooter();
    
    /**
     * Returns the Toolbar of the parent Form if available.
     * 
     * @return TDProject_Core_Interfaces_Block_Widget_Toolbar
     * 		The Toolbar of the parent Form instance
     */
    public function getToolbar();
    
    /**
     * Returns TRUE if the grid has columns that
     * uses sparklines.
     * 
     * @return boolean 
     * 		TRUE if the grid has columns using sparklines else FALSE
     */
    public function useSparklines();
    
    /**
     * Returns the flag to let the grid be sortable otherwhise FALSE.
     * 
     * @return boolean
     * 		TRUE when the grid is sortable, else FALSE
     */
    public function isSortable();
    
    /**
     * Returns the grid sorting as array with column number and sort order.
     * 
     * @return array The grid sorting
     */
    public function getSorting();
}