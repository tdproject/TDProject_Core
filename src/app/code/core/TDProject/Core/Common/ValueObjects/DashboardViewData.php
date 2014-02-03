<?php

/**
 * TDProject_Core_Common_ValueObjects_DashboardViewData
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

require_once 'TechDivision/Lang/Object.php';
require_once 'TechDivision/Collections/Interfaces/Collection.php';
require_once 'TechDivision/Model/Interfaces/Value.php';

/**
 * This class is the data transfer object between the
 * model and the controller for the dashboard view.
 * 
 * @category   	TDProject
 * @package     TDProject_ERP
 * @copyright  	Copyright (c) 2010 <info@techdivision.com> - TechDivision GmbH
 * @license    	http://opensource.org/licenses/osl-3.0.php
 * 				Open Software License (OSL 3.0)
 * @author      Tim Wagner <tw@techdivision.com>
 */
class TDProject_Core_Common_ValueObjects_DashboardViewData
    extends TechDivision_Lang_Object
    implements TechDivision_Model_Interfaces_Value {
    
    /**
     * The roles available in the system.
     * @var TechDivision_Collections_Interfaces_Collection
     */
    protected $_widgets = null;
        
    /**
     * Sets the available widgets.
     * 
     * @param TechDivision_Collections_Interfaces_Collection $widgets
     * 		The widgets available in the system
     * @return void
     */
    public function setWidgets(
        TechDivision_Collections_Interfaces_Collection $widgets) {
        $this->_widgets = $widgets;
    }
        
    /**
     * Returns the available widgets.
     * 
     * @return TechDivision_Collections_Interfaces_Collection
     * 		The widgets available in the system
     */
    public function getWidgets()
    {
        return $this->_widgets;
    }
}