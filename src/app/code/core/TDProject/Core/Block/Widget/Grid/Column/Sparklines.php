<?php

/**
 * TDProject_Core_Block_Widget_Grid_Column_Sparklines
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

require_once 'TechDivision/Lang/Object.php';
require_once 'TDProject/Core/Block/Widget/Grid/Column.php';
require_once 'TDProject/Core/Block/Widget/Grid/Body/Row/Column/Sparklines.php';

/**
 * @category    TProject
 * @package     TDProject_Core
 * @copyright   Copyright (c) 2010 <info@techdivision.com> - TechDivision GmbH
 * @license     http://opensource.org/licenses/osl-3.0.php
 *              Open Software License (OSL 3.0)
 * @author      Bastian Stangl <b.stangl@techdivision.com>
 */
class TDProject_Core_Block_Widget_Grid_Column_Sparklines
    extends TDProject_Core_Block_Widget_Grid_Column {

    /**
     * (non-PHPdoc)
     * @see TDProject_Core_Block_Widget_Grid_Column::create()
     */
    public function create(
        TDProject_Core_Interfaces_Block_Widget_Grid_Body_Row $row) {
    	return new TDProject_Core_Block_Widget_Grid_Body_Row_Column_Sparklines(
    	    $row, $this
    	);
    }
}