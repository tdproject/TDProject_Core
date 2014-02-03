<?php

/**
 * TDProject_Core_Block_Widget_Grid_Column_Actions_Delete
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

require_once 'TDProject/Core/Block/Widget/Grid/Column/Actions/Abstract.php';
require_once
	'TDProject/Core/Block/Widget/Grid/Body/Row/Column/Actions/Delete.php';
require_once 'TDProject/Core/Interfaces/Block/Widget/Grid/Body/Row/Column.php';

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

class TDProject_Core_Block_Widget_Grid_Column_Actions_Delete
    extends TDProject_Core_Block_Widget_Grid_Column_Actions_Abstract {
	
	/**
	 * The resource key used to translate the button.
	 * @var string
	 */
	const RESOURCE_KEY = 'widget.action.delete';

    /**
     * The constructor to initialize the Action with.
     *
     * @param TechDivision_Controller_Interfaces_Context $context
     * 		The Action's context
     * @param string $property The property with the ID
     * @param string $url The URL to invoke when the Action is selected
     * @return void
     */
    public function __construct(
        TechDivision_Controller_Interfaces_Context $context,
        $property,
        $url) {
        // call the parent constructor
    	parent::__construct($context, $property, $url);
        // set the translated label
    	$this->_setLabel($this->translate(self::RESOURCE_KEY));
    }

    /**
     * (non-PHPdoc)
     * @see TDProject_Core_Interfaces_Block_Widget_Grid_Column_Action::create()
     */
    public function create(
        TDProject_Core_Interfaces_Block_Widget_Grid_Body_Row_Column $column) {
    	return new
    	    TDProject_Core_Block_Widget_Grid_Body_Row_Column_Actions_Delete(
    	        $column, $this
    	    );
    }
}