<?php

/**
 * TDProject_Core_Common_ValueObjects_Collections_Abstract
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

require_once 'TechDivision/Collections/AbstractCollection.php';

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
abstract class TDProject_Core_Common_ValueObjects_Collections_Abstract
    extends TechDivision_Collections_AbstractCollection  {
    
    /**
     * Returns the number of total records available 
     * without filter.
     * 
     * @return int The total number of records
     */
    public function getTotalRecords() {
    	return $this->size();
    }
    
    /**
     * The total number of total recdords filtered.
     * 
     * @return int The total number of filtered records
     */
    public function getTotalDisplayRecords() {
    	return $this->getTotalRecords();
    }
    
    /**
     * Returns a JSON encoded representation of the
     * ArrayList and its items.
  	 *
  	 * @return string The JSON representation
     */
    public function toJson()
    {
    	// initialize an empty StdClass instance
        $toEncode = new StdClass();
        // initialize a new array
        $list = array();
        // iterate over the items
        foreach ($this->_items as $dto) {
            $list[] = $dto->toArray();
        }
        // set the objects data
        $toEncode->iTotalRecords = $this->getTotalRecords();
        $toEncode->iTotalDisplayRecords = $this->getTotalDisplayRecords();
        $toEncode->sEcho = 'Some echo here!';
        $toEncode->aaData = $list;
        // return the JSON representation
        return json_encode($toEncode);
    }
}