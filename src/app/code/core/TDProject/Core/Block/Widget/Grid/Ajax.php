<?php

/**
 * TDProject_Core_Block_Widget_Grid_Ajax
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

require_once 'TDProject/Core/Block/Widget/Grid.php';
require_once 'TDProject/Core/Block/Widget/Button/Action/Edit.php';
require_once 'TDProject/Core/Block/Widget/Button/Action/Delete.php';
require_once 'TDProject/Core/Interfaces/Block/Widget/Grid/Ajax.php';

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

class TDProject_Core_Block_Widget_Grid_Ajax
    extends TDProject_Core_Block_Widget_Grid
    implements TDProject_Core_Interfaces_Block_Widget_Grid_Ajax {

    /**
     * The URL calling to load the data.
     * @var TechDivision_Lang_String
     */
    protected $_dataSource = true;

    /**
     * The row based actions of the grid, e. g. for editing or deleting a rows data.
     * @var TDProject_Core_Interfaces_Block_Widget_Grid_Column_Actions
     */
    protected $_actions = null;

    /**
     * The URL to open the dialog to edit the selected row.
     * @var string
     */
    protected $_editUrl = '';

    /**
     * The URL to to delete the selected row.
     * @var string
     */
    protected $_deleteUrl = '';

    /**
     * Initialize the block with the
     * apropriate template and name.
     *
     * @return void
     */
    public function __construct(TDProject_Core_Interfaces_Block_Widget $widget, $blockName, $blockTitle) {
        // call the parent constructor
        parent::__construct($widget, $blockName, $blockTitle);
        // set an empty Collection (necessary to render header/footer)
        $this->setCollection(new TechDivision_Collections_ArrayList());
        // set the template name
        $this->_setTemplate('www/design/core/templates/widget/grid/ajax.phtml');
        // add the Actions
        $this->addActions(
        	new TDProject_Core_Block_Widget_Grid_Column_Actions_Ajax(
        		$this->getContext(), 'actions', ''
        	)
        );
    }

    /**
     * Adds the passed Action as Button to the toolbar and
     * binds it to the passed tab.
     *
     * @param TDProject_Core_Interfaces_Block_Widget_Button_Action $action
     * 		The Action to add a button for
     * @param TDProject_Core_Interfaces_Block_Widget_Tab $tab
     * 		The Tab to bind the Button to
     * @return TDProject_Core_Block_Widget_Grid_Ajax
     * 		The Grid instance itself
     */
    public function addAction(
    	TDProject_Core_Interfaces_Block_Widget_Button_Action $action,
    	TDProject_Core_Interfaces_Block_Widget_Tab $tab) {
		// add the button to the Toolbar and bind it to the Tab
		$this->getToolbar()->addButton($action->bindToTab($tab));
		// return the instance itself
		return $this;
    }

    /**
     * Adds a delete Button to the Toolbar, that deletes
     * the selected row from the Grid.
     *
     * @param TDProject_Core_Interfaces_Block_Widget_Tab $tab
     * 		The Tab to bind the Button to
     * @param string The block name of the button to use
     * @param string The block title of the button to use
     * @return TDProject_Core_Block_Widget_Grid_Ajax
     * 		The Grid instance itself
     */
    public function addDeleteAction(
        TDProject_Core_Interfaces_Block_Widget_Tab $tab,
        $blockName,
        $blockTitle) {
    	// create the Action and add it to the Toolbar
    	$action = new TDProject_Core_Block_Widget_Button_Action_Delete(
    	    $this, $blockName, $blockTitle
    	);
		// add the button to create a new address
    	return $this->addAction($action, $tab);
    }

    /**
     * Adds an edit Button to the Toolbar, that opens the dialog
     * to edit the selected row from the Grid.
     *
     * @param TDProject_Core_Interfaces_Block_Widget_Tab $tab
     * 		The Tab to bind the Button to
     * @param string The block name of the button to use
     * @param string The block title of the button to use
     * @return TDProject_Core_Block_Widget_Grid_Ajax
     * 		The Grid instance itself
     */
    public function addEditAction(
        TDProject_Core_Interfaces_Block_Widget_Tab $tab,
        $blockName,
        $blockTitle) {
    	// create the Action and add it to the Toolbar
    	$action = new TDProject_Core_Block_Widget_Button_Action_Edit(
    	    $this, $blockName, $blockTitle
    	);
		// add the button to create a new address
    	return $this->addAction($action, $tab);
    }

    /**
     * Set the parameters for the URL to open the dialog,
     * to edit the row selected by the user.
     *
     * @param array The parameters for the URL
     * @return TDProject_Core_Block_Widget_Grid_Ajax
     * 		The Grid instance itself
     */
    public function setEditUrl(array $params) {
    	$this->_editUrl = $this->getUrl($params);
    	return $this;
    }

    /**
     * Set the parameters for the URL to delete the row,
     * selected by the user.
     *
     * @param array The parameters for the URL
     * @return TDProject_Core_Block_Widget_Grid_Ajax
     * 		The Grid instance itself
     */
    public function setDeleteUrl(array $params) {
    	$this->_deleteUrl = $this->getUrl($params);
    	return $this;
    }

    /**
     * Sets the data source to the URL for loading the
     * JSON encoded array with the data to render.
     *
     * @param TechDivision_Lang_String $dataSource
     * 		The URL calling to load the data.
     * @return TDProject_Core_Block_Widget_Grid_Ajax
     * 		The instance itself
     */
    public function setDataSource(TechDivision_Lang_String $dataSource) {
    	$this->_dataSource = $dataSource;
    	return $this;
    }

    /**
     * (non-PHPdoc)
     * @see TDProject_Core_Block_Widget_Grid::addActions()
     */
    public function addActions(
        TDProject_Core_Interfaces_Block_Widget_Grid_Column_Actions $actions) {
    	$this->_actions = $actions;
    }

    /**
     * (non-PHPdoc)
     * @see TDProject_Core_Interfaces_Block_Widget_Grid_Ajax::getActions()
     */
    public function getActions() {
    	return $this->_actions;
    }

    /**
     * (non-PHPdoc)
     * @see TDProject_Core_Interfaces_Block_Widget_Grid_Ajax::getDataSource()
     */
    public function getDataSource() {
    	return $this->_dataSource;
    }

    /**
     * (non-PHPdoc)
     * @see TDProject_Core_Interfaces_Block_Widget_Grid_Ajax::getEditUrl()
     */
    public function getEditUrl() {
    	return $this->_editUrl;
    }

    /**
     * (non-PHPdoc)
     * @see TDProject_Core_Interfaces_Block_Widget_Grid_Ajax::getDeleteUrl()
     */
    public function getDeleteUrl() {
    	return $this->_deleteUrl;
    }
}