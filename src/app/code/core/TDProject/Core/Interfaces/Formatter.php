<?php

/**
 * TDProject_Core_Interfaces_Formatter
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

/**
 * @category    TDProject
 * @package     TDProject_Core
 * @copyright   Copyright (c) 2010 <info@techdivision.com> - TechDivision GmbH
 * @license     http://opensource.org/licenses/osl-3.0.php
 *              Open Software License (OSL 3.0)
 * @author      Johann Zelger <jz@techdivision.com>
 */
interface TDProject_Core_Interfaces_Formatter  {
	
	/**
	 * Formats the passed integer as date and
	 * returns a String representation.
	 * 
	 * @param TechDivision_Lang_Integer $integer
	 * 		The date value as UNIX timestamp
	 * @return TechDivision_Lang_String
	 * 		The formatted date
	 */
	public function format(TechDivision_Lang_Integer $integer);
}