<?php

/**
 * TDProject_Core_Block_Widget_Grid_Body_Row_Column_Action
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

require_once 'TDProject/Core/Block/Widget/Abstract.php';
require_once 'TDProject/Core/Interfaces/Block/Widget/Grid/Column.php';
require_once 'TDProject/Core/Interfaces/Block/Widget/Grid/Body/Row.php';
require_once 'TDProject/Core/Interfaces/Block/Widget/Grid/Body/Row/Column.php';
require_once 'TDProject/Core/Interfaces/Block/Widget/Grid/Body/Row/Column/Actions.php';
require_once 'TDProject/Core/Interfaces/Block/Widget/Grid/Body/Row/Column/Actions/Action.php';

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

class TDProject_Core_Block_Widget_Grid_Body_Row_Column_Actions
    extends TDProject_Core_Block_Widget_Grid_Body_Row_Column
    implements TDProject_Core_Interfaces_Block_Widget_Grid_Body_Row_Column_Actions {

   	protected $_onChange = 'selectAction(this);';

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
        	'www/design/core/templates/widget/grid/body/row/column/actions.phtml'
        );
    }

    public function setOnChange($onChange) {
    	$this->_onChange = $onChange;
    	return $this;
    }

    public function getOnChange() {
    	return $this->_onChange;
    }

    public function addAction(
        TDProject_Core_Interfaces_Block_Widget_Grid_Body_Row_Column_Actions_Action $action) {
    	$this->_childs[$action->getBlockName()] = $action;
    }

    public function getActions() {
    	$actions = array();
    	foreach ($this->_getChilds() as $child) {
    		if ($child instanceof TDProject_Core_Interfaces_Block_Widget_Grid_Body_Row_Column_Actions_Action) {
    			$actions[$child->getBlockName()] = $child;
    		}
    	}
    	return $actions;
    }
}