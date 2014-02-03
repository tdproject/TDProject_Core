<?php

/**
 * TDProject_Core_Block_Widget_Grid_Column_Action
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

require_once 'TechDivision/Lang/Object.php';
require_once 'TDProject/Core/Block/Widget/Grid/Column.php';
require_once 'TDProject/Core/Block/Widget/Grid/Body/Row/Column/Actions.php';
require_once 'TDProject/Core/Interfaces/Block/Widget/Grid/Column/Actions.php';

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

require_once 'TDProject/Core/Interfaces/Block/Widget/Grid/Column/Action.php';

class TDProject_Core_Block_Widget_Grid_Column_Actions
    extends TDProject_Core_Block_Widget_Grid_Column
    implements TDProject_Core_Interfaces_Block_Widget_Grid_Column_Actions {
    
   	protected $_actions = array();
   	
   	protected $_onChange = 'selectAction(this);';
    	
    public function addAction(TDProject_Core_Interfaces_Block_Widget_Grid_Column_Action $action) {
    	$this->_actions[] = $action;
    }
    
    public function getActions() {
    	return $this->_actions;
    }
    
    public function setOnChange($onChange) {
    	$this->_onChange = $onChange;
    }
    
    public function getOnChange() {
    	return $this->_onChange;
    }
    
    public function create(TDProject_Core_Interfaces_Block_Widget_Grid_Body_Row $row) {
    	
    	$column = new TDProject_Core_Block_Widget_Grid_Body_Row_Column_Actions($row, $this);
    	
    	$column->setOnChange($this->getOnChange());
    	
    	foreach ($this->getActions() as $action) {
    		$column->addAction($action->create($column));	
    	}
    	
    	return $column;
    }
}