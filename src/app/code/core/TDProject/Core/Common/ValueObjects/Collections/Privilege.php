<?php

/**
 * TDProject_Core_Common_ValueObjects_Collections_Privilege
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

require_once 'TechDivision/Lang/String.php';
require_once 'TechDivision/Collections/AbstractCollection.php';
require_once 'TDProject/Core/Common/ValueObjects/Collections/ArrayList.php';
require_once 'TDProject/Core/Common/ValueObjects/PrivilegeOverviewData.php';

/**
 * This class is the data transfer object between the
 * model and the controller for the task overview.
 *
 * @category   	TDProject
 * @package     TDProject_Core
 * @copyright  	Copyright (c) 2010 <info@techdivision.com> - TechDivision GmbH
 * @license    	http://opensource.org/licenses/osl-3.0.php
 * 				Open Software License (OSL 3.0)
 * @author      Tim Wagner <tw@techdivision.com>
 */
class TDProject_Core_Common_ValueObjects_Collections_Privilege
    extends TechDivision_Collections_AbstractCollection  {
        
    /**
     * Array with predicates to filter the Collection.
     * @var array
     */
    protected $_predicates = array();

    /**
     * This method adds the passed object with the passed key
     * to the ArrayList.
     *
     * @param TDProject_Core_Common_ValueObjects_PrivilegeOverviewData $dto
     * 		The DTO that should be added to the Collection
     * @return TDProject_Core_Common_ValueObjects_PrivilegeOverviewData
     * 		The instance
     */
    public function add(
        TDProject_Core_Common_ValueObjects_PrivilegeOverviewData $dto) {
		// set the item in the array
        $this->_items[$this->_count++] = $dto;
		// return the instance
		return $this;
    }

    /**
     * Helper method to simplify add new privileges.
     *
     * @param string $privilege To add
     * @return TDProject_Core_Common_ValueObjects_Collections_Privilege
     * 		The instance itself
     */
    public function addPrivilege($privilege)
    {
        // assemble the passed string and add it to the Collection
        $this->add(
            new TDProject_Core_Common_ValueObjects_PrivilegeOverviewData(
                new TechDivision_Lang_String($privilege)
            )
        );
		// return the instance
        return $this;
    }

    /**
     * Creates and returns a concatenated, comma separated String with the
     * values of the Collection.
     *
     * @return TechDivision_Lang_String
     * 		The concatenated comma separeted string
     */
    public function toString()
    {
        return new TechDivision_Lang_String(
            implode(',', $this->_items)
        );
    }

    /**
     * Factory method to create a new, empty Collection.
     *
     * @return TDProject_Core_Common_ValueObjects_Collections_Privilege
     * 		The empty Collection
     */
    public static function create()
    {
        return TDProject_Core_Common_ValueObjects_Collections_Privilege();
    }
    
    /**
     * Adds a Predicate.
     * 
     * @param TechDivision_Collections_Interfaces_Predicate $predicate
     * 		The predicate to add to the Collection.
     * @return TDProject_Core_Common_ValueObjects_Collections_Privilege
     * 		The Collection itself
     * @see TDProject/Core/Common/ValueObjects/Collections/Privilege::filter()
     * @see TDProject/Core/Common/ValueObjects/Collections/Privilege::getPredicates()
     */
    public function addPredicate(
        TechDivision_Collections_Interfaces_Predicate $predicate) {
        $this->_predicates[] = $predicate;
        return $this;
    }
    
    /**
     * Returns the previously added predicates.
     * 
     * @return array Array with the predicates to apply
     * @see TDProject/Core/Common/ValueObjects/Collections/Privilege::filter()
     * @see TDProject/Core/Common/ValueObjects/Collections/Privilege::addPredicate()
     */
    public function getPredicates()
    {
        return $this->_predicates;
    }
    
    /**
     * Filters the Collection by applying the filters.
     * 
     * @return TDProject_Core_Common_ValueObjects_Collections_Privilege
     * 		The Collection with the predicates applied
     * @see TDProject/Core/Common/ValueObjects/Collections/Privilege::addPredicate()
     */
    public function filter() 
    {
        // apply all predicates
        foreach ($this->getPedicates() as $predicate) {
            TechDivision_Collections_CollectionUtils::filter(
                $this, $predicate
            );    
        }
        // return the Collection itself
        return $this;
    }
}