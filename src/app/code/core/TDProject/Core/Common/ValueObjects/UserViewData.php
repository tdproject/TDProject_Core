<?php

/**
 * TDProject_Core_Common_ValueObjects_UserViewData
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

require_once 'TechDivision/Collections/Interfaces/Collection.php';
require_once 'TechDivision/Collections/ArrayList.php';
require_once 'TechDivision/Model/Interfaces/Value.php';
require_once 'TDProject/Core/Common/ValueObjects/UserValue.php';

/**
 * This class is the data transfer object between the
 * model and the controller for the table user.
 *
 * Each class member reflects a database field and
 * the values of the related dataset.
 *
 * @category   	TDProject
 * @package     TDProject_ERP
 * @copyright  	Copyright (c) 2010 <info@techdivision.com> - TechDivision GmbH
 * @license    	http://opensource.org/licenses/osl-3.0.php
 * 				Open Software License (OSL 3.0)
 * @author      Tim Wagner <tw@techdivision.com>
 */
class TDProject_Core_Common_ValueObjects_UserViewData
    extends TDProject_Core_Common_ValueObjects_UserValue
    implements TechDivision_Model_Interfaces_Value {

    /**
     * The the user's default role.
     * @var TDProject_Core_Common_ValueObjects_RoleLightValue
     */
    protected $_defaultRole = null;

    /**
     * The roles available in the system.
     * @var TechDivision_Collections_Interfaces_Collection
     */
    protected $_roles = null;

    /**
    * The locales available in the system.
    * @var TechDivision_Collections_Interfaces_Collection
    */
    protected $_locales = null;
    
    /**
     * The constructor intializes the DTO with the
     * values passed as parameter.
     *
     * @param TDProject_Core_Common_ValueObjects_UserLightValue $lvo
     * 		Holds the array with the virtual members to pass to the AbstractDTO's constructor
     * @param TDProject_Core_Common_ValueObjects_RoleLightValue
     * 		The user's primary role
     * @return void
     */
    public function __construct(
        TDProject_Core_Common_ValueObjects_UserLightValue $lvo,
    	TDProject_Core_Common_ValueObjects_RoleLightValue $defaultRole) {
        // call the parents constructor
        parent::__construct($lvo);
        // initialize the ValueObject with the passed data
        $this->setDefaultRole($defaultRole);
        $this->_roles = new TechDivision_Collections_ArrayList();
        $this->_locales = new TechDivision_Collections_ArrayList();
    }

    /**
     * Sets the role name of the user's default role.
     *
     * @param TDProject_Core_Common_ValueObjects_RoleLightValue $role
     * 		The user's default role
     * @return void
     */
    public function setDefaultRole(
        TDProject_Core_Common_ValueObjects_RoleLightValue $defaultRole) {
        $this->_defaultRole = $defaultRole;
    }

    /**
	 * Returns the user's default role.
	 *
	 * @return TDProject_Core_Common_ValueObjects_RoleLightValue
	 * 		The user's default role
     */
    public function getDefaultRole()
    {
        return $this->_defaultRole;
    }

    /**
     * Sets the available roles.
     *
     * @param TechDivision_Collections_Interfaces_Collection $roles
     * 		The roles available in the system
     * @return void
     */
    public function setRoles(
        TechDivision_Collections_Interfaces_Collection $roles) {
        $this->_roles = $roles;
    }

    /**
     * Returns the available roles.
     *
     * @return TechDivision_Collections_Interfaces_Collection
     * 		The roles available in the system
     */
    public function getRoles()
    {
        return $this->_roles;
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