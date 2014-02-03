<?php

/**
 * TDProject_Core_Block_Resource_Overview
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

require_once 'TDProject/Core/Block/Widget/Form/Abstract/Overview.php';
require_once 'TDProject/Core/Block/Widget/Grid.php';
require_once 'TDProject/Core/Block/Widget/Grid/Column.php';
require_once 'TDProject/Core/Block/Widget/Grid/Column/Mapping.php';
require_once 'TDProject/Core/Block/Widget/Grid/Column/Actions.php';
require_once 'TDProject/Core/Block/Widget/Grid/Column/Actions/Edit.php';
require_once 'TDProject/Core/Block/Widget/Grid/Column/Actions/Delete.php';
require_once 'TDProject/Core/Block/Widget/Button/New.php';

/**
 * @category    TDProject
 * @package     TDProject_Core
 * @copyright   Copyright (c) 2010 <info@techdivision.com> - TechDivision GmbH
 * @license     http://opensource.org/licenses/osl-3.0.php
 *              Open Software License (OSL 3.0)
 * @author      Tim Wagner <tw@techdivision.com>
 */
class TDProject_Core_Block_Resource_Overview
	extends TDProject_Core_Block_Widget_Form_Abstract_Overview {

    /**
     * (non-PHPdoc)
     * @see TDProject_Core_Interfaces_Block_Widget_Form_Overview::prepareGrid()
     */
    public function prepareGrid() {
    	// instanciate the grid
    	$grid = new TDProject_Core_Block_Widget_Grid($this, 'grid', 'Resource');
    	// set the collection with the data to render
    	$grid->setCollection($this->getCollection());
    	// add the columns
    	$grid->addColumn(
    	    new TDProject_Core_Block_Widget_Grid_Column(
    	    	'resourceId', 'ID', 10
    	    )
    	);
    	$grid->addColumn(
    	    new TDProject_Core_Block_Widget_Grid_Column(
    	    	'key', 'Key', 20
    	    )
    	);
    	$grid->addColumn(
    	    new TDProject_Core_Block_Widget_Grid_Column(
    	    	'resourceLocale', 'Locale', 20
    	    )
    	);
    	$grid->addColumn(
    	    new TDProject_Core_Block_Widget_Grid_Column(
    	    	'message', 'Value', 35
    	    )
    	);
    	// add the actions
    	$action = new TDProject_Core_Block_Widget_Grid_Column_Actions(
    		'actions', 'Actions', 15
    	);
    	$action->addAction(
    	    new TDProject_Core_Block_Widget_Grid_Column_Actions_Edit(
    	        $this->getContext(),
    	        'resourceId',
    	        '?path=/resource&method=edit'
    	    )
    	);
    	$action->addAction(
    	    new TDProject_Core_Block_Widget_Grid_Column_Actions_Delete(
    	        $this->getContext(),
    	        'resourceId',
    	        '?path=/resource&method=delete'
    	    )
    	);
    	$grid->addColumn($action);
    	// return the initialized instance
    	return $grid;
    }
}