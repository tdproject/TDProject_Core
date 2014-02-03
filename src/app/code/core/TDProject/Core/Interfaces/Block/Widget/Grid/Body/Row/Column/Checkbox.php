<?php

/**
 * TDProject_Core_Interfaces_Block_Widget_Grid_Body_Row_Column_Checkbox
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

require_once 'TDProject/Core/Interfaces/Block/Widget/Grid/Body/Row/Column.php';

/**
 * @category    TDProject
 * @package     TDProject_Core
 * @copyright   Copyright (c) 2010 <info@techdivision.com> - TechDivision GmbH
 * @license     http://opensource.org/licenses/osl-3.0.php
 *              Open Software License (OSL 3.0)
 * @author      Tim Wagner <tw@techdivision.com>
 */
interface TDProject_Core_Interfaces_Block_Widget_Grid_Body_Row_Column_Checkbox
	extends TDProject_Core_Interfaces_Block_Widget_Grid_Body_Row_Column {
    
	/**
	 * Returns TRUE if the checkbox has to be rendered
	 * as checked, else FALSE.
	 * 
	 * @return boolean 
	 * 		TRUE if the checkbox has to be rendered as checked, else FALSE
	 */
    public function isChecked();
}