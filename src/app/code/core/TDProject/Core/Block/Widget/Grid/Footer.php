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

require_once 'TDProject/Core/Block/Widget/Abstract.php';
require_once 'TDProject/Core/Block/Widget/Grid/Footer/Row.php';

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

class TDProject_Core_Block_Widget_Grid_Footer
    extends TDProject_Core_Block_Widget_Abstract {
    
	/**
	 * The block name for the grid's footer.
	 * @var string
	 */
    const BLOCK_NAME = 'footer';
    
    protected $_grid = null;
    	
    /**
     * Initialize the block with the
     * apropriate template and name.
     * 
     * @return void
     */
    public function __construct(TDProject_Core_Block_Widget_Grid $grid) {
        // call the parent constructor
        parent::__construct($grid->getContext());
        
        $this->_grid = $grid;
        
        // set block name and title
        $this->_setBlockName(TDProject_Core_Block_Widget_Grid_Footer::BLOCK_NAME);
        $this->_setBlockTitle('Footer');
        // set the template name
        $this->_setTemplate('www/design/core/templates/widget/grid/footer.phtml'); 
    }
    
    public function getColumns() {
    	return $this->_grid->getColumns();
    }
    
    public function prepareLayout() {	
    	
    	$this->addBlock(new TDProject_Core_Block_Widget_Grid_Footer_Row($this));
    	
    	parent::prepareLayout();
    }
    
    public function getRows() {
    	
    	$rows = array();
    	
    	foreach ($this->_getChilds() as $child) {
    		if ($child instanceof TDProject_Core_Block_Widget_Grid_Footer_Row) {
    			$rows[] = $child;
    		}
    	}
    	
    	return $rows;
    }
}