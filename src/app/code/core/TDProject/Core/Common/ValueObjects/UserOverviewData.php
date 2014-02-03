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

require_once 'TechDivision/Lang/String.php';
require_once 'TechDivision/Model/Interfaces/LightValue.php';
require_once 'TDProject/Core/Common/ValueObjects/UserLightValue.php';
require_once 'TDProject/Core/Common/ValueObjects/RoleLightValue.php';
require_once 'TDProject/Core/Interfaces/Block/Widget/Element/Select/Option.php';

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
class TDProject_Core_Common_ValueObjects_UserOverviewData
    extends TDProject_Core_Common_ValueObjects_UserLightValue
    implements TDProject_Core_Interfaces_Block_Widget_Element_Select_Option,
        Zend_Acl_Role_Interface {

    /**
     * The the user's default role.
     * @var TDProject_Core_Common_ValueObjects_RoleLightValue
     */
    protected $_defaultRole = null;

    /**
     * The constructor intializes the DTO with the
     * values passed as parameter.
     *
     * @param TDProject_Core_Common_ValueObjects_UserLightValue $lvo
     * 		Holds the array with the virtual members to pass to the AbstractDTO's constructor
     * @param TDProject_Core_Common_ValueObjects_RoleLightValue $defaultRole
     * 		The user's default role
     * @return void
     */
    public function __construct(
    	TDProject_Core_Common_ValueObjects_UserLightValue $lvo,
    	TDProject_Core_Common_ValueObjects_RoleLightValue $defaultRole) {
        // call the parents constructor
        parent::__construct($lvo);
        // set the user's default role
        $this->setDefaultRole($defaultRole);
    }

    /**
     * Sets the role name of the user's default role.
     *
     * @param TDProject_Core_Common_ValueObjects_RoleLightValue $defaultRole
     * 		The user's default role
     * @return void
     */
    public function setDefaultRole(
        TDProject_Core_Common_ValueObjects_RoleLightValue $defaultRole) {
        $this->_defaultRole = $defaultRole;
    }

    /**
     * Returns the user's default role
     * Enter description here ...
     */
    public function getDefaultRole()
    {
        return $this->_defaultRole;
    }

    /**
     * Returns the role name of the user's role.
     *
     * @return TechDivision_Lang_String
     * 		The role name of the user's role
     */
    public function getRoleName() {
        return $this->getDefaultRole()->getName();
    }

	/**
	 * (non-PHPdoc)
	 * @see TDProject_Core_Interfaces_Block_Widget_Element_Select_Option::getOptionValue()
	 */
   	public function getOptionValue() {
   		return $this->getUserId();
   	}

   	/**
   	 * (non-PHPdoc)
   	 * @see TDProject_Core_Interfaces_Block_Widget_Element_Select_Option::getOptionLabel()
   	 */
   	public function getOptionLabel() {
   		return $this->getUsername();
   	}

   	/**
   	 * (non-PHPdoc)
   	 * @see TDProject_Core_Interfaces_Block_Widget_Element_Select_Option::isSelected()
   	 */
   	public function isSelected(TechDivision_Lang_Object $value = null) {
   		// check if the passed value is empty
   		if ($value == null) {
   			return false;
   		}
   		// check if the user ID's equals
   		return $this->getUserId()->equals($value);
   	}

   	/**
   	 * (non-PHPdoc)
   	 * @see Zend_Acl_Role_Interface::getRoleId()
   	 */
   	public function getRoleId()
   	{
   	    return $this->getDefaultRole()->getRoleId();
   	}
}