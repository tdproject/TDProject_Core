<?php

/**
 * TDProject_Core_Block_Widget_Grid_Body_Row_Column_Checkbox
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

require_once 'TDProject/Core/Block/Widget/Abstract.php';
require_once 'TDProject/Core/Block/Widget/Grid/Body/Row/Column.php';
require_once 'TDProject/Core/Interfaces/Block/Widget/Grid/Column.php';
require_once 'TDProject/Core/Interfaces/Block/Widget/Grid/Body/Row.php';
require_once
	'TDProject/Core/Interfaces/Block/Widget/Grid/Body/Row/Column/Checkbox.php';

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
class TDProject_Core_Block_Widget_Grid_Body_Row_Column_Checkbox
    extends TDProject_Core_Block_Widget_Grid_Body_Row_Column
    implements TDProject_Core_Interfaces_Block_Widget_Grid_Body_Row_Column_Checkbox {

    /**
     * Initialize the block with the
     * apropriate template and name.
     *
     * @return void
     */
    public function __construct(
    	TDProject_Core_Interfaces_Block_Widget_Grid_Body_Row $row,
    	TDProject_Core_Interfaces_Block_Widget_Grid_Column $column) {
        // call the parent constructor
        parent::__construct($row, $column);
        // set the template name
        $this->_setTemplate(
        	'www/design/core/templates/widget/grid/body/row/column/checkbox.phtml'
        );
    }

    /**
     * (non-PHPdoc)
     * @see TDProject_Core_Block_Widget_Grid_Body_Row_Column::getValue()
     */
    public function getValue() {
    	return $this->_getColumn()->getSelector()->getValue($this->getData());
    }

    /**
     * (non-PHPdoc)
     * @see TDProject_Core_Interfaces_Block_Widget_Grid_Body_Row_Column_Checkbox::isChecked()
     */
    public function isChecked() {
   		return $this->_getColumn()->getSelector()->isChecked($this->getData());
    }

    /**
     * Gets the url to be called when checkbox was checked
     *
     * @return string
     */
    public function getCheckedUrl() {
    	return $this->_column->getCheckedUrl();
    }

    /**
     * Gets the url to be called when checkbox was unchecked
     *
     * @return string
     */
    public function getUncheckedUrl() {
    	return $this->_column->getUncheckedUrl();
    }
}