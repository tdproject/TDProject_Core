<?php

/**
 * TDProject_Core_Block_Widget_Grid_Body_Row_Column_Value
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
require_once 'TDProject/Core/Interfaces/Block/Widget/Grid/Body/Row/Column/Value.php';

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

class TDProject_Core_Block_Widget_Grid_Body_Row_Column_Value
    extends TDProject_Core_Block_Widget_Abstract
    implements TDProject_Core_Interfaces_Block_Widget_Grid_Body_Row_Column_Value {

    protected $_parentElement = null;

    /**
     * Initialize the block with the
     * apropriate template and name.
     *
     * @return void
     */
    public function __construct(
    	TDProject_Core_Interfaces_Block_Widget_Grid_Body_Row_Column $parentElement) {
        // call the parent constructor
        parent::__construct($parentElement->getContext());

        $this->_parentElement = $parentElement;

        // set the template name
        $this->_setTemplate(
        	'www/design/core/templates/widget/grid/body/row/column/value.phtml'
        );
    }

    public function getBlockName()
    {
    	return $this->_getParentElement()->getBlockName();
    }

    public function getBlockTitle()
    {
    	return $this->_getParentElement()->getBlockTitle();
    }

    protected function _getProperty()
    {
    	return $this->getBlockName();
    }

    protected function _getParentElement()
    {
    	return $this->_parentElement;
    }

    public function getValue()
    {
    	return $this->_getParentElement()->getValue();
    }
}