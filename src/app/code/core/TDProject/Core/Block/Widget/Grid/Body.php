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

require_once 'TechDivision/Collections/Interfaces/Collection.php';
require_once 'TDProject/Core/Block/Widget/Abstract.php';
require_once 'TDProject/Core/Block/Widget/Grid/Body/Row.php';
require_once 'TDProject/Core/Interfaces/Block/Widget/Grid/Body.php';

/**
 * This class implements the form functionality
 * for handling the application settings.
 *
 * @category    TProject
 * @package     TDProject_Core
 * @copyright   Copyright (c) 2010 <info@techdivision.com> - TechDivision GmbH
 * @license     http://opensource.org/licenses/osl-3.0.php
 *              Open Software License (OSL 3.0)
 * @author      Tim Wagner <tw@techdivision.com>
 */
class TDProject_Core_Block_Widget_Grid_Body
    extends TDProject_Core_Block_Widget_Abstract
    implements TDProject_Core_Interfaces_Block_Widget_Grid_Body {

	/**
	 * The block name for the grid's footer.
	 * @var string
	 */
    const BLOCK_NAME = 'body';

    /**
     * The grid instance.
     * @var TDProject_Core_Block_Widget_Grid
     */
    protected $_grid = null;

    /**
     * Initialize the block with the
     * apropriate template and name.
     *
     * @return void
     */
    public function __construct(
        TDProject_Core_Interfaces_Block_Widget_Grid $grid) {
        // call the parent constructor
        parent::__construct($grid->getContext());
        // set the grid instance
        $this->_grid = $grid;
        // set block name and title
        $this->_setBlockName(TDProject_Core_Block_Widget_Grid_Body::BLOCK_NAME);
        $this->_setBlockTitle('Body');
        // set the template name
        $this->_setTemplate('www/design/core/templates/widget/grid/body.phtml');
    }

    /**
     * Returns the grids columns.
     *
     * @return array Array with the grid's columns to render
     */
    public function getColumns()
    {
    	return $this->_grid->getColumns();
    }

    /**
     * Returns a Collection with the data to render.
     *
	 * @return TechDivision_Collections_Interfaces_Collection
	 * 		The Collection with the data to render
     */
    public function getCollection()
    {
    	return $this->_grid->getCollection();
    }

    /**
     * (non-PHPdoc)
     * @see TDProject_Core_Block_Abstract::prepareLayout()
     */
    public function prepareLayout()
    {
        // initialize the row counter
    	$id = 0;
        // iterate over the data and add the grid's rows
    	foreach ($this->_grid->getCollection() as $data) {
    		$this->addBlock(
    		    new TDProject_Core_Block_Widget_Grid_Body_Row(
    		        $this, $data, $id++
    		    )
    		);
    	}
        // call parent constructor
    	parent::prepareLayout();
    }

    /**
     * (non-PHPdoc)
     * @see TDProject_Core_Interfaces_Block_Widget_Grid_Body::getRows()
     */
    public function getRows()
    {
        // rerturn the initialized rows
    	$rows = array();
        // iterate over the childs and check for rows
    	foreach ($this->_getChilds() as $child) {
    		if ($child instanceof TDProject_Core_Block_Widget_Grid_Body_Row) {
    			$rows[$child->getBlockName()] = $child;
    		}
    	}
        // return the rows
    	return $rows;
    }
}