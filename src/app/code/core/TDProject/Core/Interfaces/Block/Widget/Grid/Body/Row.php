<?php

/**
 * TDProject_Core_Interfaces_Block_Widget_Grid_Body_Row
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

require_once 'TechDivision/Lang/Object.php';
require_once 'TDProject/Core/Interfaces/Block/Widget.php';

/**
 * @category    TDProject
 * @package     TDProject_Core
 * @copyright   Copyright (c) 2010 <info@techdivision.com> - TechDivision GmbH
 * @license     http://opensource.org/licenses/osl-3.0.php
 *              Open Software License (OSL 3.0)
 * @author      Tim Wagner <tw@techdivision.com>
 */
interface TDProject_Core_Interfaces_Block_Widget_Grid_Body_Row
	extends TDProject_Core_Interfaces_Block_Widget {
    
    /**
     * Returns the an array with the columns that
     * has to be rendered in the grid.
     * 
     * @return array
     * 		The columns that has to be rendered
     */
    public function getColumns();
}