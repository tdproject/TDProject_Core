<?php

/**
 * TDProject_Core_Block_Dashboard
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

require_once 'TDProject/Core/Block/Abstract.php';
require_once 'TDProject/Core/Block/Dashboard/Widget.php';

/**
 * @category    TDProject
 * @package     TDProject_Core
 * @copyright   Copyright (c) 2010 <info@techdivision.com> - TechDivision GmbH
 * @license     http://opensource.org/licenses/osl-3.0.php
 *              Open Software License (OSL 3.0)
 * @author      Tim Wagner <tw@techdivision.com>
 */
class TDProject_Core_Block_Dashboard extends TDProject_Core_Block_Abstract {
    
    /**
     * Initialize the block with the
     * apropriate template and name.
     * 
     * @return void
     */
    public function __construct(
        TechDivision_Controller_Interfaces_Context $context) {
        // set the template name
        $this->_setTemplate('www/design/core/templates/dashboard.phtml');
        // call the parent constructor
        parent::__construct($context);
    }

	/**
     * (non-PHPdoc)
     * @see TDProject/Interfaces/Block#prepareLayout()
     */
    public function prepareLayout() 
    {   
        // add the widgets
        $this->addBlock(new TDProject_Core_Block_Dashboard_Widget($this->getContext()));
        // call the parent method
        return parent::prepareLayout();
    }
}