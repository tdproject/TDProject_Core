<?php

/**
 * TDProject_Core_Block_Widget_Grid_Body_Row_Column_Select
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

require_once 'TDProject/Core/Block/Widget/Grid/Body/Row/Column.php';
require_once 'TDProject/Core/Interfaces/Block/Widget/Grid/Column.php';
require_once 'TDProject/Core/Interfaces/Block/Widget/Grid/Body/Row.php';
require_once 'TDProject/Core/Interfaces/Block/Widget/Grid/Body/Row/Column/Select.php';

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
class TDProject_Core_Block_Widget_Grid_Body_Row_Column_Select
    extends TDProject_Core_Block_Widget_Grid_Body_Row_Column
    implements TDProject_Core_Interfaces_Block_Widget_Grid_Body_Row_Column_Select {
    	
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
        	'www/design/core/templates/widget/grid/body/row/column/select.phtml'
        );
    }
    
    public function getOptionValue(
        TDProject_Core_Interfaces_Block_Widget_Element_Select_Option $option) {
    	return $option->getOptionValue();
    }
    
    public function getOptionLabel(
        TDProject_Core_Interfaces_Block_Widget_Element_Select_Option $option) {
    	return $option->getOptionLabel();
    }
    
    public function isSelected(
        TDProject_Core_Interfaces_Block_Widget_Element_Select_Option $option) {
    	return $this->_getColumn()
    	    ->getSelector()
    	    ->isSelected($option, $this->getData());
    }
    
    /**
     * (non-PHPdoc)
     * @see TDProject_Core_Interfaces_Block_Widget_Grid_Body_Row_Column::getValue()
     */
    public function getValue() {
		return $this->_getColumn()->getSelector()->getValue($this->getData());
    }
    
    public function getOptions() {
    	return $this->_getColumn()->getOptions();	
    }
}