<?php

/**
 * TDProject_Core_Block_Widget_Grid_Header
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

require_once 'TDProject/Core/Block/Widget/Abstract.php';
require_once 'TDProject/Core/Block/Widget/Grid/Header/Row.php';

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

class TDProject_Core_Block_Widget_Grid_Header
    extends TDProject_Core_Block_Widget_Abstract {

	/**
	 * The block name for the grid's header.
	 * @var string
	 */
    const BLOCK_NAME = 'header';

    /**
     *
     * Enter description here ...
     * @var unknown_type
     */
    protected $_grid = null;

    /**
     * Initialize the block with the
     * apropriate template and name.
     *
     * @return void
     */
    public function __construct(TDProject_Core_Block_Widget_Grid $grid) {
        // call the parent constructor
        parent::__construct($grid->getContext());
        // set the parent Grid instance
        $this->_grid = $grid;
        // set block name and title
        $this->_setBlockName(
            TDProject_Core_Block_Widget_Grid_Header::BLOCK_NAME
        );
        $this->_setBlockTitle('Header');
        // set the template name
        $this->_setTemplate(
        	'www/design/core/templates/widget/grid/header.phtml'
        );
    }

    /**
     * Returns the headers columns.
     *
     * @return array An array with the headers columns
     */
    public function getColumns()
    {
    	return $this->_grid->getColumns();
    }

    /**
     * Returns the Collection with the data.
     *
     * @return TechDivision_Collections_Interfaces_Collection
     * 		The Collection with data
     */
    public function getCollection() {
    	return $this->_grid->getCollection();
    }

    /**
     * (non-PHPdoc)
     * @see TDProject_Core_Block_Abstract::prepareLayout()
     */
    public function prepareLayout() {
        // add the header row
    	$this->addBlock(new TDProject_Core_Block_Widget_Grid_Header_Row($this));
        // call the parent method
    	parent::prepareLayout();
    }

    /**
     * Returns the header's rows.
     *
     * @return array An array with the header's rows
     */
    public function getRows()
    {
        // initialize the array for the rows
    	$rows = array();
        // iterate over all childs an check for the header row
    	foreach ($this->_getChilds() as $child) {
    		if ($child instanceof TDProject_Core_Block_Widget_Grid_Header_Row) {
    			$rows[$child->getBlockName()] = $child;
    		}
    	}
        // return the rows
    	return $rows;
    }
}