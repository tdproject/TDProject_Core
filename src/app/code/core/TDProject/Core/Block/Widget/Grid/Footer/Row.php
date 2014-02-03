<?php

/**
 * TDProject_Core_Block_Widget_Grid_Footer_Row
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

require_once 'TechDivision/Collections/Interfaces/Collection.php';
require_once 'TDProject/Core/Block/Widget/Abstract.php';
require_once 'TDProject/Core/Block/Widget/Grid/Footer/Row/Column.php';
require_once 'TDProject/Core/Interfaces/Block/Widget/Grid/Footer/Row.php';
require_once 'TDProject/Core/Interfaces/Block/Widget/Grid/Footer/Row/Column.php';

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

class TDProject_Core_Block_Widget_Grid_Footer_Row
    extends TDProject_Core_Block_Widget_Abstract
    implements TDProject_Core_Interfaces_Block_Widget_Grid_Footer_Row {

	/**
	 * The block name for the grid's footer.
	 * @var string
	 */
    const BLOCK_NAME = 'row';

    protected $_footer = null;

    /**
     * Initialize the block with the
     * apropriate template and name.
     *
     * @return void
     */
    public function __construct(
        TDProject_Core_Block_Widget_Grid_Footer $footer) {
        // call the parent constructor
        parent::__construct($footer->getContext());

        $this->_footer = $footer;
        // set block name and title
        $this->_setBlockName(
            TDProject_Core_Block_Widget_Grid_Header_Row::BLOCK_NAME
        );
        $this->_setBlockTitle('row');
        // set the template name
        $this->_setTemplate(
        	'www/design/core/templates/widget/grid/footer/row.phtml'
        );
    }

    public function prepareLayout() {

    	foreach ($this->getFooter()->getColumns() as $column) {
    		$this->addColumn(
    		    new TDProject_Core_Block_Widget_Grid_Footer_Row_Column(
    		        $this, $column
    		    )
    		);
    	}

    	return parent::prepareLayout();
    }

    public function getFooter() {
    	return $this->_footer;
    }

    public function getData() {
    	return $this->_data;
    }

    /**
     * (non-PHPdoc)
     * @see TDProject_Core_Interfaces_Block_Widget_Grid_Header_Row::getColumns()
     */
    public function getColumns() {
    	return $this->_getChilds();
    }

    public function addColumn(
        TDProject_Core_Interfaces_Block_Widget_Grid_Footer_Row_Column $column) {
    	$this->_childs[] = $column->setParent($this);
    }
}