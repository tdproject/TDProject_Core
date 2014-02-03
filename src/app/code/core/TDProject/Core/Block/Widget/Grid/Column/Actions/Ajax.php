<?php

/**
 * TDProject_Core_Block_Widget_Grid_Column_Actions
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

require_once 'TechDivision/Lang/Object.php';
require_once 'TDProject/Core/Block/Widget/Grid/Column.php';
require_once 'TDProject/Core/Interfaces/Block/Widget/Grid/Column/Action.php';
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

class TDProject_Core_Block_Widget_Grid_Column_Actions_Ajax
    extends TDProject_Core_Block_Widget_Grid_Column
    implements TDProject_Core_Interfaces_Block_Widget_Grid_Column_Actions {

    /**
     * Container for the actions.
     * @var array
     */
   	protected $_actions = array();

   	/**
   	 * Adds an Action.
   	 *
   	 * @param TDProject_Core_Interfaces_Block_Widget_Grid_Column_Action $action
   	 * 		The Action to add
   	 */
    public function addAction(
        TDProject_Core_Interfaces_Block_Widget_Grid_Column_Action $action) {
    	$this->_actions[] = $action;
    }

    /**
     * (non-PHPdoc)
     * @see TDProject_Core_Interfaces_Block_Widget_Grid_Column_Actions::getActions()
     */
    public function getActions() {
    	return $this->_actions;
    }
}