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
require_once 'TDProject/Core/Block/Widget/Grid/Header/Row/Column.php';
require_once 'TDProject/Core/Interfaces/Block/Widget/Grid/Header/Row.php';
require_once 'TDProject/Core/Interfaces/Block/Widget/Grid/Header/Row/Column.php';

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

class TDProject_Core_Block_Widget_Grid_Header_Row
    extends TDProject_Core_Block_Widget_Abstract
    implements TDProject_Core_Interfaces_Block_Widget_Grid_Header_Row {

	/**
	 * The block name for the grid's footer.
	 * @var string
	 */
    const BLOCK_NAME = 'row';

    /**
     *
     * Enter description here ...
     * @var unknown_type
     */
    protected $_header = null;

    /**
     * Initialize the block with the
     * apropriate template and name.
     *
     * @return void
     */
    public function __construct(
        TDProject_Core_Block_Widget_Grid_Header $header) {
        // call the parent constructor
        parent::__construct($header->getContext());
        // set the header
        $this->_header = $header;
        // set block name and title
        $this->_setBlockName(
            TDProject_Core_Block_Widget_Grid_Header_Row::BLOCK_NAME
        );
        $this->_setBlockTitle('row');
        // set the template name
        $this->_setTemplate(
        	'www/design/core/templates/widget/grid/header/row.phtml'
        );
    }

    /**
     * (non-PHPdoc)
     * @see TDProject_Core_Block_Abstract::prepareLayout()
     */
    public function prepareLayout()
    {
        // iterate over the headers colum
    	foreach ($this->getHeader()->getColumns() as $column) {
            // add the column
    		$this->addColumn(
    		    new TDProject_Core_Block_Widget_Grid_Header_Row_Column(
    		        $this, $column
    		    )
    		);
    	}
        // call parent method
    	return parent::prepareLayout();
    }

    /**
     * Returns the Header instance.
     *
     * @return TDProject_Core_Block_Widget_Grid_Header
     * 		The Header instance
     */
    public function getHeader()
    {
    	return $this->_header;
    }

    /**
     * (non-PHPdoc)
     * @see TDProject_Core_Interfaces_Block_Widget_Grid_Header_Row::getColumns()
     */
    public function getColumns()
    {
    	return $this->_getChilds();
    }

    /**
     * Adds a column to the row.
     *
     * @param TDProject_Core_Interfaces_Block_Widget_Grid_Header_Row_Column $column
     * 		The Column instance to add
     */
    public function addColumn(
        TDProject_Core_Interfaces_Block_Widget_Grid_Header_Row_Column $column) {
    	$this->_childs[] = $column->setParent($this);
    }
}