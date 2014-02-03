<?php

/**
 * TDProject_Core_Block_Dashboard_Widget
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

require_once 'TDProject/Core/Block/Abstract.php';

/**
 * @category    TDProject
 * @package     TDProject_Core
 * @copyright   Copyright (c) 2010 <info@techdivision.com> - TechDivision GmbH
 * @license     http://opensource.org/licenses/osl-3.0.php
 *              Open Software License (OSL 3.0)
 * @author      Tim Wagner <tw@techdivision.com>
 */
class TDProject_Core_Block_Dashboard_Widget extends TDProject_Core_Block_Abstract {

    /**
     * Initialize the block with the
     * apropriate template and name.
     *
     * @return void
     */
    public function __construct(TechDivision_Controller_Interfaces_Context $context)
    {
        // set the internal name
        $this->_setBlockName('widgets');
        // set the template name
        $this->_setTemplate('www/design/core/templates/dashboard/widget.phtml');
        // call the parent constructor
        parent::__construct($context);
    }

    /**
     * Loads the widgets, initializes and returns a list with
     * the initialized block instances.
     *
     * @return TechDivision_Collections_Interfaces_Collection
     * 		The Collection with the initialized blocks
     */
    public function getWidgets()
    {
        // initialize the ArrayList with the blocks
        $widgets = new TechDivision_Collections_ArrayList();
        // load the widgets from the Context
        $dto = $this->getContext()->getAttribute('widgets');
        // iterate over the widgets and load the blocks
        foreach ($dto->getWidgets() as $widget) {
            // include the class file
            require_once $widget->getIncludeFile();
            // instanciate the block
            $reflectionClass = new ReflectionClass(
                $widget->getBlock()->stringValue()
            );
            // initialize the block instance
            $instance = $reflectionClass->newInstance($this->getContext());
            $instance->prepareLayout($this->getApp());
            // and add it to the ArrayList
            $widgets->add($instance);
        }
        // return the ArrayList
        return $widgets;
    }
}