<?php

/**
 * TDProject_Core_Block_Widget_Grid_Body_Row_Column
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

require_once 'TDProject/Core/Block/Widget/Abstract.php';
require_once 'TDProject/Core/Interfaces/Block/Widget/Grid/Column.php';
require_once 'TDProject/Core/Block/Widget/Grid/Body/Row/Column/Value.php';
require_once 'TDProject/Core/Interfaces/Block/Widget/Grid/Body/Row.php';
require_once 'TDProject/Core/Interfaces/Block/Widget/Grid/Body/Row/Column.php';

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
class TDProject_Core_Block_Widget_Grid_Body_Row_Column
    extends TDProject_Core_Block_Widget_Abstract
    implements TDProject_Core_Interfaces_Block_Widget_Grid_Body_Row_Column {
    
    /**
     * The row with the data to render the column for.
     * @var TDProject_Core_Interfaces_Block_Widget_Grid_Body_Row
     */
    protected $_row = null;
    
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
        parent::__construct($row->getContext());
        // set the grid the column is bound to
        $this->_row = $row;
        $this->_column = $column;
        // set the template name
        $this->_setTemplate(
        	'www/design/core/templates/widget/grid/body/row/column.phtml'
        ); 
    }
    
    public function getBlockName() {
    	return $this->_getColumn()->getBlockName();
    }
    
    public function getBlockTitle() {
    	return $this->_getColumn()->getBlockTitle();
    }
    
    protected function _getRow() {
    	return $this->_row;
    }
    
    protected function _getColumn() {
    	return $this->_column;
    }
      
    public function getData() {
    	return $this->_row->getData();
    }
    
    public function getActionUrl() {
    	return $this->_column->getActionUrl();
    }
    
    public function getWidth() {
    	return $this->_column->getWidth();
    }
       
    /**
     * (non-PHPdoc)
     * @see TDProject_Core_Block_Abstract::prepareLayout()
     */
    public function prepareLayout() {
    	
    	$this->addBlock(
    	    new TDProject_Core_Block_Widget_Grid_Body_Row_Column_Value($this)
    	);
    	
    	return parent::prepareLayout();
    }
    
    /**
     * (non-PHPdoc)
     * @see TDProject_Core_Interfaces_Block_Widget_Grid_Body_Row_Column::getValue()
     */
    public function getValue() {

    	$formatter = $this->_getColumn()->getFormatter();
    	
    	if (empty($formatter)) {
    		return $this->_getValue();
    	}
    	
    	return $formatter->format($this->_getValue());
    }
    
    protected function _getValue() {
	    // initialize the reflection object for the class itself
	    $reflectionObject = new ReflectionObject($data = $this->getData());
    	// concatenate the method name
	    $methodName = 'get' . ucfirst($blockName = $this->getBlockName());
	    // check if a method exists to load the value for the requested property
	    if ($reflectionObject->hasMethod($methodName)) {
		    $reflectionMethod = $reflectionObject->getMethod($methodName);
		    return $reflectionMethod->invoke($data);
		}
		// throw an exception if no getter for the requested property exists
		throw new Exception(
			'No getter method for requested property ' . $blockName . ' available'
		);    	
    }
}