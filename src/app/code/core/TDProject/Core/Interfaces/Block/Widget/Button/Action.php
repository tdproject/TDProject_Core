<?php

/**
 * TDProject_Core_Interfaces_Block_Widget_Button_Action
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

require_once 'TDProject/Core/Interfaces/Block/Widget/Button.php';
require_once 'TDProject/Core/Interfaces/Block/Widget/Grid/Column/Action.php';

/**
 * @category    TDProject
 * @package     TDProject_Core
 * @copyright   Copyright (c) 2010 <info@techdivision.com> - TechDivision GmbH
 * @license     http://opensource.org/licenses/osl-3.0.php
 *              Open Software License (OSL 3.0)
 * @author      Tim Wagner <tw@techdivision.com>
 */
interface TDProject_Core_Interfaces_Block_Widget_Button_Action
	extends TDProject_Core_Interfaces_Block_Widget_Button,
	    TDProject_Core_Interfaces_Block_Widget_Grid_Column_Action {
}