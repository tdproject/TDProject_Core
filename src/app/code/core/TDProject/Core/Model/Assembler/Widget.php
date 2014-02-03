<?php

/**
 * TDProject_Core_Model_Assembler_Widget
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

/**
 * @category   	TDProject
 * @package    	TDProject_Core
 * @copyright  	Copyright (c) 2010 <info@techdivision.com> - TechDivision GmbH
 * @license    	http://opensource.org/licenses/osl-3.0.php
 * 				Open Software License (OSL 3.0)
 * @author      Tim Wagner <tw@techdivision.com>
 */
class TDProject_Core_Model_Assembler_Widget 
    extends TDProject_Core_Model_Assembler_Abstract {

    /**
     * Factory method to create a new instance.
     *
     * @param TechDivision_Model_Interfaces_Container $container The container instance
     * @return TDProject_Channel_Model_Actions_Category
     * 		The requested instance
     */
    public static function create(TechDivision_Model_Interfaces_Container $container)
    {
        return new TDProject_Core_Model_Assembler_Widget($container);
    }

    /**
     * Returns an ArrayList with all widgets 
     * assembled as LVO's.
     * 
     * @return TechDivision_Collections_ArrayList
     * 		The requested widget LVO's
     */
    public function getWidgetLightValues() 
    {
        // initialize a new ArrayList
        $list = new TechDivision_Collections_ArrayList();
        // load the widgets
        $widgets = TDProject_Core_Model_Utils_WidgetUtil::getHome($this->getContainer())
            ->findAll();
        // assemble the widgets
        foreach ($widgets as $widget) {
            $list->add($widget->getLightValue());
        }
        // return the ArrayList with the WidgetLightValues
        return $list;
    }
}