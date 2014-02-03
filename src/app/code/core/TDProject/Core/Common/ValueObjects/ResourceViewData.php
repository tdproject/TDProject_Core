<?php

/**
 * TDProject_Core_Common_ValueObjects_ResourceViewData
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

/**
 * This class is the data transfer object between the
 * model and the controller for the table resource.
 *
 * Each class member reflects a database field and
 * the values of the related dataset.
 *
 * @category   	TDProject
 * @package     TDProject_Core
 * @copyright  	Copyright (c) 2010 <info@techdivision.com> - TechDivision GmbH
 * @license    	http://opensource.org/licenses/osl-3.0.php
 * 				Open Software License (OSL 3.0)
 * @author      Tim Wagner <tw@techdivision.com>
 */
class TDProject_Core_Common_ValueObjects_ResourceViewData
    extends TDProject_Core_Common_ValueObjects_ResourceValue
    implements TechDivision_Model_Interfaces_Value
{

    /**
     * The locales available in the system.
     * @var TechDivision_Collections_Interfaces_Collection
     */
    protected $_locales = null;

    /**
     * The constructor intializes the DTO with the
     * values passed as parameter.
     *
     * @param TDProject_Core_Common_ValueObjects_ResourceValue $vo
     * 		Holds the array with the virtual members to pass to the
     * 		AbstractDTO's constructor
     * @return void
     */
    public function __construct(
        TDProject_Core_Common_ValueObjects_ResourceValue $vo) 
    {
        // call the parents constructor
        parent::__construct($vo);
        // initialize the ValueObject with the passed data
        $this->_locales = new TechDivision_Collections_ArrayList();
    }

    /**
     * Sets the available locales.
     *
     * @param TechDivision_Collections_Interfaces_Collection $locales
     * 		The locales available in the system
     * @return void
     */
    public function setLocales(
        TechDivision_Collections_Interfaces_Collection $locales) {
        $this->_locales = $locales;
    }

    /**
     * Returns the available locales.
     *
     * @return TechDivision_Collections_Interfaces_Collection
     * 		The locales available in the system
     */
    public function getLocales()
    {
        return $this->_locales;
    }
}