<?php

/**
 * TDProject_Core_Formatter_Date
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

require_once 'Zend/Date.php';
require_once 'TechDivision/Lang/String.php';
require_once 'TechDivision/Lang/Integer.php';
require_once 'TDProject/Core/Interfaces/Formatter.php';

/**
 * This class implements thefunctionality to
 * format a columns value as localized date.
 *
 * @category    TProject
 * @package     TDProject_Core
 * @copyright   Copyright (c) 2010 <info@techdivision.com> - TechDivision GmbH
 * @license     http://opensource.org/licenses/osl-3.0.php
 *              Open Software License (OSL 3.0)
 * @author      Bastian Stangl <b.stangl@techdivision.com>
 */
class TDProject_Core_Formatter_Date 
	implements TDProject_Core_Interfaces_Formatter {

	/**
	 * The singleton instance.
	 * @static TDProject_Core_Formatter_Date
	 */
	protected static $_singleton = null;
	
	/**
	 * Protected constructor to aviod direct
	 * instanciation.
	 * 
	 * @return void
	 */
	protected function __construct() {
		// only to protect
	}
		
	/**
	 * Initializes and returns the singleton
	 * instance.
	 * 
	 * @return TDProject_Core_Formatter_Date
	 * 		The instance as singleton
	 */
	public static function get() {
		// check if already an instance exists
		if (self::$_singleton == null) {
			self::$_singleton = new TDProject_Core_Formatter_Date();
		}
		// return the singleton
		return self::$_singleton;
	}
		
	/**
	 * (non-PHPdoc)
	 * @see TDProject_Core_Interfaces_Formatter::format()
	 */
	public function format(TechDivision_Lang_Integer $integer) {
        $date = new Zend_Date($integer->intValue(), Zend_Date::TIMESTAMP);
		return new TechDivision_Lang_String($date->toString());		
	}
}