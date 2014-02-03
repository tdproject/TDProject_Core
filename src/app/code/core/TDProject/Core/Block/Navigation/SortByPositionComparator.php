<?php

/**
 * TDProject_Core_Block_Navigation_SortByPositionComparator
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

require_once 'TechDivision/Lang/Object.php';
require_once 'TechDivision/Collections/Interfaces/Comparator.php';

/**
 * @category    TDProject
 * @package     TDProject
 * @copyright   Copyright (c) 2010 <info@techdivision.com> - TechDivision GmbH
 * @license     http://opensource.org/licenses/osl-3.0.php
 *              Open Software License (OSL 3.0)
 * @author      Tim Wagner <tw@techdivision.com>
 */
class TDProject_Core_Block_Navigation_SortByPositionComparator
    extends TechDivision_Lang_Object
    implements TechDivision_Collections_Interfaces_Comparator {

    /**
     * This method compares the begin date of the objects passed as
     * parameter .
     *
     * @param Event $object Holds the event for the evalualtion
     * @return integer Returns 0 if the begin date is equal
     * 				   Returns 1 if the begin date of the first value is smaller
     * 				   Returns -1 if the begin date of the first value is greater
     */
    public function compare($o1, $o2)
    {
		// get the values from the objects
		$value1 = $o1->getPosition()->intValue();
		$value2 = $o2->getPosition()->intValue();
		// if value 1 is smaller than value 2
		if ($value1 < $value2) {
			return -1;
		}
		// if value 1 and 2 are equal
		if ($value1 == $value2) {
			return 0;
		}
		// if value 1 is greater than value 2
		if ($value1 > $value2) {
			return 1;
		}
    }       
}