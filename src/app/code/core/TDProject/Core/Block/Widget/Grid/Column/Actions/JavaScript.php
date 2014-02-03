<?php

/**
 * TDProject_Core_Block_Widget_Grid_Column_Actions_JavaScript
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

require_once 'TDProject/Core/Block/Widget/Grid/Column/Actions/Abstract.php';
require_once
	'TDProject/Core/Block/Widget/Grid/Body/Row/Column/Actions/JavaScript.php';
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
class TDProject_Core_Block_Widget_Grid_Column_Actions_JavaScript
    extends TDProject_Core_Block_Widget_Grid_Column_Actions_Abstract {

    /**
     * The JavaScript code.
     * @var string
     */
    protected $_javaScript =
    	'<script type="text/javascript"><!--//--></script>';

    public function __construct(
        TechDivision_Controller_Interfaces_Context $context,
        $property,
        $label,
        $javaScript) {
        // invoke the parent constructor
    	parent::__construct($context, $property, '');
        // set the translated label
    	$this->_setLabel($label);
        // set the JavaScript sources
    	$this->_setJavaScript($javaScript);
    }

    /**
     * Sets the JavaScript source to invoke.
     *
     * @param string $javaScript
     * 		The JavaScript source to invoke
     */
    protected function _setJavaScript($javaScript) {
    	$this->_javaScript = $javaScript;
    }

    /**
     * Returns the JavaScript source to invoke when selected.
     *
     * @return string The JavaScript source to invoke
     */
    public function getJavaScript() {
    	return $this->_javaScript;
    }

    /**
     * (non-PHPdoc)
     * @see TDProject_Core_Interfaces_Block_Widget_Grid_Column_Action::create()
     */
    public function create(
        TDProject_Core_Interfaces_Block_Widget_Grid_Body_Row_Column $column) {
    	return new
    	    TDProject_Core_Block_Widget_Grid_Body_Row_Column_Actions_JavaScript(
    	        $column, $this
    	    );
    }
}