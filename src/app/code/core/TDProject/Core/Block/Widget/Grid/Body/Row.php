<?php

/**
 * TDProject_Core_Block_Widget_Grid_Header
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

require_once 'TechDivision/Lang/Object.php';
require_once 'TechDivision/Collections/Interfaces/Collection.php';
require_once 'TDProject/Core/Block/Widget/Abstract.php';
require_once 'TDProject/Core/Block/Widget/Grid/Column.php';
require_once 'TDProject/Core/Block/Widget/Grid/Body/Row/Column.php';
require_once 'TDProject/Core/Interfaces/Block/Widget/Grid/Body.php';
require_once 'TDProject/Core/Interfaces/Block/Widget/Grid/Body/Row.php';

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

class TDProject_Core_Block_Widget_Grid_Body_Row
    extends TDProject_Core_Block_Widget_Abstract
    implements TDProject_Core_Interfaces_Block_Widget_Grid_Body_Row {

	/**
	 * The block name for the grid's footer.
	 * @var string
	 */
    const BLOCK_NAME = 'row';

    protected $_body = null;

    protected $_data = null;

    protected $_rowId = 0;

    /**
     * Initialize the block with the
     * apropriate template and name.
     *
     * @return void
     */
    public function __construct(
    	TDProject_Core_Interfaces_Block_Widget_Grid_Body $body,
    	TechDivision_Lang_Object $data,
    	$rowId = 0) {
        // call the parent constructor
        parent::__construct($body->getContext());

        $this->_body = $body;

        $this->_data = $data;

        $this->_rowId = $rowId;

        // set block name and title
        $this->_setBlockName(
            TDProject_Core_Block_Widget_Grid_Body_Row::BLOCK_NAME . '_' . $rowId
        );

        $this->_setBlockTitle("row-$rowId");

        // set the template name
        $this->_setTemplate(
        	'www/design/core/templates/widget/grid/body/row.phtml'
        );
    }

    public function prepareLayout()
    {
        // load and add the columns
    	foreach ($this->getBody()->getColumns() as $column) {
    		$this->addColumn($column->create($this));
    	}

    	return parent::prepareLayout();
    }

    public function getRowId()
    {
        return $this->_rowId;
    }

    public function getBody()
    {
    	return $this->_body;
    }

    public function getData()
    {
    	return $this->_data;
    }

    /**
     * (non-PHPdoc)
     * @see TDProject_Core_Interfaces_Block_Widget_Grid_Body_Row::getColumns()
     */
    public function getColumns()
    {
    	return $this->_getChilds();
    }

    public function addColumn(
        TDProject_Core_Interfaces_Block_Widget_Grid_Body_Row_Column $column) {
    	$this->_childs[] = $column->setParent($this);
    }
}