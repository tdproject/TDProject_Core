<?php

/**
 * TDProject_Core_Block_Widget_Form_Abstract_Ajax_Toolbar
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

require_once 'TechDivision/Lang/Boolean.php';
require_once 'TDProject/Core/Block/Widget/Toolbar.php';

/**
 * @category    TDProject
 * @package     TDProject_Core
 * @copyright   Copyright (c) 2010 <info@techdivision.com> - TechDivision GmbH
 * @license     http://opensource.org/licenses/osl-3.0.php
 *              Open Software License (OSL 3.0)
 * @author      Johann Zelger <jz@techdivision.com>
 */
class TDProject_Core_Block_Widget_Form_Ajax_Toolbar
    extends TDProject_Core_Block_Widget_Toolbar
    implements TDProject_Core_Interfaces_Block_Widget_Toolbar {
    
    /**
     * Initialize the toolbar with the apropriate template and name.
     * 
     * @return void
     */
    public function __construct(TechDivision_Controller_Interfaces_Context $context) {
        // call the parent constructor
        parent::__construct($context);
        // set the template name
        $this->_setTemplate('www/design/core/templates/widget/form/ajax/toolbar.phtml');
    }
}