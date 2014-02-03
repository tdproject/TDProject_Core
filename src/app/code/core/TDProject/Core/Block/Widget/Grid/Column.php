<?php

/**
 * TDProject_Core_Block_Widget_Grid_Column
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

require_once 'TechDivision/Lang/Object.php';
require_once 'TDProject/Core/Interfaces/Formatter.php';
require_once 'TDProject/Core/Interfaces/Block/Widget/Grid/Column.php';

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

class TDProject_Core_Block_Widget_Grid_Column
    extends TechDivision_Lang_Object
    implements TDProject_Core_Interfaces_Block_Widget_Grid_Column {

    /**
     * The column's property to load the data from.
     * @var string
     */
    protected $_blockName = 'undefined';

    /**
     * The column's label.
     * @var string
     */
    protected $_blockTitle = 'undefined';

    /**
     * The column's width to render.
     * @var integer
     */
    protected $_width = 0;

    /**
     * Array with the actions to render per row.
     * @var array
     */
    protected $_actions = array();

    /**
     * The action url to save the row data instantly
     * @var string
     */
    protected $_actionUrl = null;

    /**
     * Formatter used for formatting the value.
     * @var TDProject_Core_Interfaces_Formatter
     */
    protected $_formatter = null;
    
    /**
     * Flag to set the column visible or not.
     * @var boolean
     */
    protected $_visible = true;

    /**
     * Initialize the block with the
     * apropriate template and name.
     *
     * @return void
     */
    public function __construct($blockName, $blockTitle, $width)
    {
        // sets the members
        $this->_setBlockName($blockName);
        $this->_setBlockTitle($blockTitle);
        $this->_setWidth($width);
    }
    
    /**
     * Hides the column.
     * 
     * @return TDProject_Core_Block_Widget_Grid_Column
     * 		The column instance
     */
    public function setInvisible()
    {
    	$this->_visible = false;
    }
    
    /**
     * TRUE if the column has to be visible, else FALSE.
     * 
     * @return boolean The flag to render the column visible or not
     */
    public function isVisible()
    {
    	return $this->_visible;
    }

    /**
     * Sets the column's block name to load the data from.
     *
     * @param string $property The column's block name
     * @return void
     */
    public function _setBlockName($blockName)
    {
    	$this->_blockName = $blockName;
    }

    /**
     * Sets the column's block title.
     *
     * @param string $label The column's block title
     * @return void
     */
    public function _setBlockTitle($blockTitle)
    {
    	$this->_blockTitle = $blockTitle;
    }

    /**
     * Sets the column's width.
     *
     * @param integer $width The column's width
     * @return void
     */
    public function _setWidth($width)
    {
    	$this->_width = $width;
    }

    /**
     * Sets the action url use to save data instantly event driven
     *
     * @param string $url
     * @return TDProject_Core_Block_Widget_Grid_Column
     */
    public function setActionUrl($url)
    {
    	$this->_actionUrl = $url;
    	return $this;
    }

    /**
     * Gets the action url
     *
     * @return string
     */
    public function getActionUrl()
    {
    	return $this->_actionUrl;
    }

    /**
     * (non-PHPdoc)
     * @see TDProject_Core_Interfaces_Block_Widget_Grid_Column::getWidth()
     */
    public function getWidth()
    {
    	return $this->_width;
    }

    /**
     * (non-PHPdoc)
     * @see TDProject_Core_Interfaces_Block_Widget_Grid_Column::getBlockName()
     */
    public function getBlockName()
    {
    	return $this->_blockName;
    }

    /**
     * (non-PHPdoc)
     * @see TDProject_Core_Interfaces_Block_Widget_Grid_Column::getBlockTitle()
     */
    public function getBlockTitle()
    {
    	return $this->_blockTitle;
    }

    /**
     * (non-PHPdoc)
     * @see TDProject_Core_Interfaces_Block_Widget_Grid_Column::getFormatter()
     */
    public function getFormatter()
    {
    	return $this->_formatter;
    }

    /**
     * Sets the formatter used to format
     * the columns value.
     *
     * @param TDProject_Core_Interfaces_Formatter $formatter
     * 		The formatter used to format the value
     */
    public function setFormatter(
        TDProject_Core_Interfaces_Formatter $formatter) {
    	$this->_formatter = $formatter;
    }

    /**
     * (non-PHPdoc)
     * @see TDProject_Core_Interfaces_Block_Widget_Grid_Column::create()
     */
    public function create(
        TDProject_Core_Interfaces_Block_Widget_Grid_Body_Row $row) {
    	return new TDProject_Core_Block_Widget_Grid_Body_Row_Column(
    	    $row, $this
    	);
    }
}