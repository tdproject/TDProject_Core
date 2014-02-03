<?php

/**
 * TDProject_Core_Model_Assembler_Dashboard
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
class TDProject_Core_Model_Assembler_Dashboard 
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
        return new TDProject_Core_Model_Assembler_Dashboard($container);
    }
        
    /**
     * Returns a DTO with the data for the dashboard.
     * 
     * @return TDProject_Core_Common_ValueObjects_DashboardViewData
     * 		The requested DTO
     */
    public function getDashboardViewData() 
    {
		// initialize the DTO
		$dto = new TDProject_Core_Common_ValueObjects_DashboardViewData();
		// set the available widgets
		$dto->setWidgets(
		    TDProject_Core_Model_Assembler_Widget::create($this->getContainer())
		        ->getWidgetLightValues()
		);
        // return the assembled DTO
		return $dto;
    }
}