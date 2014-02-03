<?php

/**
 * TDProject_Core_Block_Widget_Grid
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

require_once 'TechDivision/Collections/Interfaces/Collection.php';
require_once 'TDProject/Core/Block/Widget/Abstract.php';
require_once 'TDProject/Core/Interfaces/Block/Widget/Grid.php';
require_once 'TDProject/Core/Block/Widget/Grid/Header.php';
require_once 'TDProject/Core/Block/Widget/Grid/Body.php';
require_once 'TDProject/Core/Block/Widget/Grid/Footer.php';

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

class TDProject_Core_Block_Widget_Grid
    extends TDProject_Core_Block_Widget_Abstract
    implements TDProject_Core_Interfaces_Block_Widget_Grid {

    /**
     * Collection with the data the grid has to render.
     * @var TechDivision_Collections_Interfaces_Collection
     */
    protected $_collection = null;

    /**
     * Array with the columns to render.
     * @var array
     */
    protected $_columns = array();

    /**
     * Flag to render the grid header or not.
     * @var boolean
     */
    protected $_hasHeader = true;

    /**
     * Flag to render the grid footer or not.
     * @var boolean
     */
    protected $_hasFooter = true;

    /**
     * The parent widget.
     * @var TDProject_Core_Interfaces_Block_Widget
     */
    protected $_parent = null;
    
    /**
     * TRUE if the grid is sortable, else FALSE.
     * @var boolean
     */
    protected $_sortable = false;
    
    /**
     * The grid sorting with an array('columnNumber' => 'sortOrder').
     * @var array
     */
    protected $_sorting = array();

    /**
     * Initialize the block with the
     * apropriate template and name.
     *
     * @return void
     */
    public function __construct(
        TDProject_Core_Interfaces_Block_Widget $widget,
        $blockName,
        $blockTitle) {
        // call the parent constructor
        parent::__construct($widget->getContext());
        // set the parent Widget
        $this->_parent = $widget;
        // set block name and title
        $this->_setBlockName($blockName);
        $this->_setBlockTitle($blockTitle);
        // set the template name
        $this->_setTemplate('www/design/core/templates/widget/grid.phtml');
    }

    /**
     * (non-PHPdoc)
     * @see TDProject_Core_Interfaces_Block_Widget_Grid::getToolbar()
     */
    public function getToolbar()
    {
    	if ($this->_parent instanceof
    	    TDProject_Core_Interfaces_Block_Widget_Form) {
    		if ($this->_parent->hasToolbar()) {
    			return $this->_parent->getToolbar();
    		}
    	}
    }

    /**
     * (non-PHPdoc)
     * @see TDProject_Core_Block_AbstractForm::prepareLayout()
     */
    public function prepareLayout()
    {
        // add the Header, Body and Footer
    	$this->addBlock(new TDProject_Core_Block_Widget_Grid_Header($this));
    	$this->addBlock(new TDProject_Core_Block_Widget_Grid_Body($this));
    	$this->addBlock(new TDProject_Core_Block_Widget_Grid_Footer($this));
        // call the parent constructor
    	return parent::prepareLayout();
    }

    /**
     * Sets the Collection with the data
     * to be rendered.
     *
     * @param TechDivision_Collections_Interfaces_Collection $collection
     * 		The Collection with the data to render
     */
    public function setCollection(
        TechDivision_Collections_Interfaces_Collection $collection) {
    	$this->_collection = $collection;
    }

    /**
     * (non-PHPdoc)
     * @see TDProject_Core_Interfaces_Block_Widget_Grid::getCollection()
     */
    public function getCollection()
    {
    	return $this->_collection;
    }
    /**
     * (non-PHPdoc)
     * @see TDProject_Core_Interfaces_Block_Widget_Grid::addColumn()
     */
    public function addColumn(
        TDProject_Core_Interfaces_Block_Widget_Grid_Column $column) {
    	return $this->_columns[] = $column;
    }

    /**
     * (non-PHPdoc)
     * @see TDProject_Core_Interfaces_Block_Widget_Grid::addActions()
     */
    public function addActions(
        TDProject_Core_Interfaces_Block_Widget_Grid_Column_Actions $actions) {
    	$this->addColumn($actions);
    }

    /**
     * Returns the array with the grid's columns.
     *
     *
     * @return array The grid's columns
     */
    public function getColumns()
    {
    	return $this->_columns;
    }

    /**
     * Returns the grid's Body.
     *
     * @return TDProject_Core_Block_Widget_Grid_Body
     * 		The requested body
     * @throws Exception Is thrown if no body is available
     */
    public function getBody()
    {
        // check if a body exists, if not throw an exception
    	if (!$this->hasBody()) {
    		throw new Exception('Body does not exist');
    	}
        // return the body
    	return $this->_childs[
    	    TDProject_Core_Block_Widget_Grid_Body::BLOCK_NAME
    	];
    }
    
    /**
     * (non-PHPdoc)
     * @see TDProject_Core_Interfaces_Block_Widget_Grid::useSparklines()
     */
    public function useSparklines()
    {
        foreach ($this->getColumns() as $column) {
            if ($column instanceof 
                TDProject_Core_Block_Widget_Grid_Column_Sparklines) {
                return true;
            }
        }
    }

    /**
     * (non-PHPdoc)
     * @see TDProject_Core_Interfaces_Block_Widget_Grid::hasFooter()
     */
    public function hasBody()
    {
    	return array_key_exists(
    	    TDProject_Core_Block_Widget_Grid_Body::BLOCK_NAME, $this->_childs
    	);
    }

    /**
     * (non-PHPdoc)
     * @see TDProject_Core_Interfaces_Block_Widget_Grid::hasHeader()
     */
    public function hasHeader()
    {
    	return array_key_exists(
    	    TDProject_Core_Block_Widget_Grid_Header::BLOCK_NAME, $this->_childs
    	);
    }

    /**
     * (non-PHPdoc)
     * @see TDProject_Core_Interfaces_Block_Widget_Grid::hasFooter()
     */
    public function hasFooter()
    {
    	return array_key_exists(
    	    TDProject_Core_Block_Widget_Grid_Footer::BLOCK_NAME, $this->_childs
    	);
    }
    
    /**
	 * Marks the grid sortable if the passed flag is TRUE.
	 * 
	 * @param boolean TRUE if the grid has to be sortable
	 * @return TDProject_Core_Interfaces_Block_Widget_Grid
	 * 		The grid instance
     */
    public function setSortable($sortable = true)
    {
    	$this->_sortable = $sortable;
    	return $this;
    }

    /**
     * (non-PHPdoc)
     * @see TDProject_Core_Interfaces_Block_Widget_Grid::isSortable()
     */
    public function isSortable()
    {
    	return $this->_sortable;
    }
    
    /**
	 * Set the sorting for the grid by passing an array
	 * with columnNumber => sortOrder pairs.
	 *
	 * @param array $sorting Array with sorting information
	 * @return TDProject_Core_Interfaces_Block_Widget_Grid
	 * 		The grid instance
     */
    public function setSorting(array $sorting)
    {
    	$this->_sorting = $sorting;
    	return $this;
    }

    /**
     * (non-PHPdoc)
     * @see TDProject_Core_Interfaces_Block_Widget_Grid::getSorting()
     */
    public function getSorting()
    {
    	return $this->_sorting;
    }
}