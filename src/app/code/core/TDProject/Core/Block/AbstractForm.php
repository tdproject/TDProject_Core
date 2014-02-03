<?php

/**
 * TDProject_Core_Controller_Form_UserForm
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

require_once 'TechDivision/Logger/Logger.php';
require_once 'TechDivision/Logger/System.php';
require_once 'TechDivision/Logger/Interfaces/Logger.php';
require_once 'TechDivision/Controller/Interfaces/Context.php';
require_once 'TechDivision/Controller/Action/Controller.php';
require_once 'TDProject/Core/Block/Abstract.php';

/**
 * This class implements the form functionality
 * for handling the registration for a user.
 *
 * @category    TProject
 * @package     TDProject_Core
 * @copyright   Copyright (c) 2010 <info@techdivision.com> - TechDivision GmbH
 * @license     http://opensource.org/licenses/osl-3.0.php
 *              Open Software License (OSL 3.0)
 * @author      Bastian Stangl <b.stangl@techdivision.com>
 */

abstract class TDProject_Core_Block_AbstractForm
	extends TDProject_Core_Block_Abstract {

	/**
	 * (non-PHPdoc)
	 * @see TDProject_Core_Interfaces_Block_Form::getFormName()
	 */
	public function getFormName() {
		return $this->getContext()->getActionMapping()->getName();
	}

	/**
	 * (non-PHPdoc)
	 * @see TDProject_Core_Interfaces_Block_Form::getEditUrl()
	 */
	public function getEditUrl() {
		throw new Exception(__METHOD__ . ' has to be implemented');
	}

	/**
	 * (non-PHPdoc)
	 * @see TDProject_Core_Interfaces_Block_Form::getDeleteUrl()
	 */
	public function getDeleteUrl() {
		throw new Exception(__METHOD__ . ' has to be implemented');
	}

	/**
	 * (non-PHPdoc)
	 * @see TDProject_Core_Interfaces_Block_Form::getBackUrl()
	 */
	public function getBackUrl() {
		throw new Exception(__METHOD__ . ' has to be implemented');
	}

	/**
	 * (non-PHPdoc)
	 * @see TDProject_Core_Interfaces_Block_Form::getSaveUrl()
	 */
	public function getSaveUrl() {
		throw new Exception(__METHOD__ . ' has to be implemented');
	}

	/**
	 * (non-PHPdoc)
	 * @see TDProject_Core_Interfaces_Block_Form::getNewUrl()
	 */
	public function getNewUrl() {
		throw new Exception(__METHOD__ . ' has to be implemented');
	}

    /**
     * (non-PHPdoc)
     * @see TDProject_Core_Interfaces_Block_Form::getValueByProperty()
     */
    public function getValueByProperty($property)
    {
    	// concatenate the method name
	    $methodName = 'get' . ucfirst($property);

        if (!method_exists($this, $methodName)) {
		    // throw an exception if no getter for the requested property exists
            throw Exception(
            	'No getter method for requested property ' . $property . ' available'
            );
        }

        return $this->$methodName();

        /*
	    // initialize the reflection object for the class itself
	    $reflectionObject = new ReflectionObject($this);
    	// concatenate the method name
	    $methodName = 'get' . ucfirst($property);
	    // check if a method exists to load the value for the requested property
	    if ($reflectionObject->hasMethod($methodName)) {
		    $reflectionMethod = $reflectionObject->getMethod($methodName);
		    return $reflectionMethod->invoke($this);
		}
		// throw an exception if no getter for the requested property exists
		throw new Exception('No getter method for requested property ' . $property . ' available');
		*/
    }

	/**
	 * Validates the passed date.
	 *
	 * @param string $value Date to validate
	 * @return boolean TRUE if the date is valid, else FALSE
	 * @throws Exception
	 */
    protected function _validateDatetime($value) {
		// initialize the regex
        $regex = array(
                "options" => array(
                        "regexp" => "/^([0-9]{2,4})-([0-1][0-9])-([0-3][0-9]) (?:([0-2][0-9]):([0-5][0-9]):([0-5][0-9]))?$/"
                )
        );
		// validate the date
        return filter_var($value, FILTER_VALIDATE_REGEXP, $regex);
    }
}