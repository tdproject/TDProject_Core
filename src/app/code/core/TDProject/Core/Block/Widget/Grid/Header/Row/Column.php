<?php

/**
 * TDProject_Core_Block_Widget_Grid_Header_Row_Column
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

require_once 'TDProject/Core/Block/Widget/Abstract/Localized.php';
require_once 'TDProject/Core/Interfaces/Block/Widget/Grid/Column.php';
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

class TDProject_Core_Block_Widget_Grid_Header_Row_Column
    extends TDProject_Core_Block_Widget_Abstract_Localized
    implements TDProject_Core_Interfaces_Block_Widget_Grid_Header_Row_Column {

    /**
     * The row with the data to render the column for.
     * @var TDProject_Core_Interfaces_Block_Widget_Grid_Header_Row
     */
    protected $_row = null;

    /**
     * The column width in pixel.
     * @var integer
     */
    protected $_width = 0;

    /**
     * Initialize the block with the
     * apropriate template and name.
     *
     * @return void
     */
    public function __construct(
    	TDProject_Core_Interfaces_Block_Widget_Grid_Header_Row $row,
    	TDProject_Core_Interfaces_Block_Widget_Grid_Column $column) {
        // call the parent constructor
        parent::__construct($row->getContext());
        // set the grid the column is bound to
        $this->_row = $row;
        $this->_width = $column->getWidth();
        // sets the block name and title
        $this->_setBlockName($column->getBlockName());
        $this->_setBlockTitle($column->getBlockTitle());
        // set the template name
        $this->_setTemplate(
        	'www/design/core/templates/widget/grid/header/row/column.phtml'
        );
    }

    /**
     * Returns the columns Row instance.
     *
     * @return TDProject_Core_Interfaces_Block_Widget_Grid_Header_Row
     * 		The Row instance
     */
    protected function _getRow() {
    	return $this->_row;
    }

    /**
     * (non-PHPdoc)
     * @see TDProject_Core_Interfaces_Block_Widget_Grid_Header_Row_Column::getWidth()
     */
    public function getWidth() {
    	return $this->_width;
    }

    /**
     * (non-PHPdoc)
     * @see TDProject_Core_Interfaces_Block_Widget_Grid_Header_Row_Column::getValue()
     */
    public function getValue() {
	    return $this->getBlockTitle();
    }
}