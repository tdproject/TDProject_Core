<?php

/**
 * TDProject_Core_Common_ValueObjects_Collections_ArrayList
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

require_once 'TDProject/Core/Common/ValueObjects/Collections/Abstract.php';

/**
 * This class is the data transfer object between the
 * model and the controller for the task overview.
 *
 * @category   	TDProject
 * @package     TDProject_Project
 * @copyright  	Copyright (c) 2010 <info@techdivision.com> - TechDivision GmbH
 * @license    	http://opensource.org/licenses/osl-3.0.php
 * 				Open Software License (OSL 3.0)
 * @author      Tim Wagner <tw@techdivision.com>
 */
class TDProject_Core_Common_ValueObjects_Collections_ArrayList
    extends TDProject_Core_Common_ValueObjects_Collections_Abstract  {
    	
    /**
     * Number of total records available without filter.
     * @var integer
     */
    protected $_totalRecords = 0;
    
    /**
     * Numbe of total recdords filtered.
     * @var integer
     */
    protected $_totalDisplayRecords = 0;

    /**
     * Sets the number of total records filtered.
     * 
     * @param integer $totalDisplayRecords
     * 		The number of filtered records
     * @return TDProject_Core_Common_ValueObjects_Collections_Paged_Abstract
     * 		The Collection instance
     */
    public function setTotalDisplayRecords($totalDisplayRecords) {
    	$this->_totalDisplayRecords = $totalDisplayRecords;
    	return $this;
    }

    /**
     * Sets the number of total records available without filter.
     * 
     * @param integer $totalDisplayRecords
     * 		The number of filtered records
     * @return TDProject_Core_Common_ValueObjects_Collections_Paged_Abstract
     * 		The Collection instance
     */
    public function setTotalRecords($totalRecords) {
    	$this->_totalRecords = $totalRecords;
    	return $this;
    }
    
    /**
     * (non-PHPdoc)
     * @see TDProject_Core_Common_ValueObjects_Collections_Abstract::getTotalRecords()
     */
    public function getTotalRecords() {
    	return $this->_totalRecords;
    }
    
    /**
     * (non-PHPdoc)
     * @see TDProject_Core_Common_ValueObjects_Collections_Abstract::getTotalDisplayRecords()
     */
    public function getTotalDisplayRecords() {
    	return $this->_totalDisplayRecords;
    }

    /**
     * This method adds the passed object with the passed key
     * to the ArrayList.
     *
     * @param $object The object that should be added to the ArrayList
     * @return TechDivision_Collection_ArrayList The instance
     * @throws TechDivision_Lang_Exceptions_NullPointerException
     * 		Is thrown it the passed object is NULL
     */
    public function add($object)
    {
		if (is_null($object)) {
			throw new TechDivision_Lang_Exceptions_NullPointerException(
				'Passed object is null'
			);
		}
		// set the item in the array
        $this->_items[$this->_count++] = $object;
		// return the instance
		return $this;
    }
}