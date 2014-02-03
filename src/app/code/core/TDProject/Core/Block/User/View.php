<?php

/**
 * TDProject_Core_Block_User_View
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

require_once 'TechDivision/Controller/Action/Error.php';
require_once 'TechDivision/Controller/Action/Errors.php';
require_once 'TechDivision/Collections/Interfaces/Collection.php';
require_once 'TechDivision/Collections/ArrayList.php';
require_once 'TDProject/Core/Controller/Util/ErrorKeys.php';
require_once 'TDProject/Core/Block/Widget/Element/Input/Hidden.php';
require_once 'TDProject/Core/Block/Abstract/User.php';
require_once 'TDProject/Core/Common/ValueObjects/RoleLightValue.php';
require_once 'TDProject/Core/Common/ValueObjects/UserViewData.php';

/**
 * @category    TDProject
 * @package     TDProject_Core
 * @copyright   Copyright (c) 2010 <info@techdivision.com> - TechDivision GmbH
 * @license     http://opensource.org/licenses/osl-3.0.php
 *              Open Software License (OSL 3.0)
 * @author      Tim Wagner <tw@techdivision.com>
 */
class TDProject_Core_Block_User_View
	extends TDProject_Core_Block_Abstract_User {

    /**
     * The available user roles.
     * @var TechDivision_Collections_ArrayList
     */
    protected $_roles = null;

    /**
     * The user's role ID.
     * @var TechDivision_Lang_Integer
     */
    protected $_roleIdFk = null;

    /**
     * 
     * The list of available locales
     * @var TechDivision_Collections_ArrayList
     */
    protected $_locales = null;
    
    /**
     * Getter method for the available roles.
     *
     * @return TechDivision_Lang_Integer The available roles
     */
    public function getRoles() {
        return $this->_roles;
    }

    /**
     * Setter method for the available roles.
     *
     * @param TechDivision_Collections_Interfaces_Collection $roles The available roles
     * @return void
     */
    public function setRoles(TechDivision_Collections_Interfaces_Collection $roles) {
        $this->_roles = $roles;
    }

    /**
     * Getter method for user's last LDAP sync date.
     *
     * @return TechDivision_Lang_String The user's last LDAP sync date
     */
    public function getSyncedAt() {
    	// check if the account was synced
    	if ($this->getLdapSynced()->booleanValue() === false) {
    		// if not, return an empty String
    		return new TechDivision_Lang_String();
    	}
    	return new TechDivision_Lang_String($this->toDate($this->_syncedAt));
    }

    /**
     * Setter for the users primary role ID.
     *
     * @param string $string The primary role ID
     * @return void
     */
    public function setRoleIdFk($string)
    {
	    $this->_roleIdFk = TechDivision_Lang_Integer::valueOf(
	        new TechDivision_Lang_String($string)
	    );
    }

    /**
     * Getter for the users primary role ID.
	 *
	 * @return TechDivision_Lang_Integer
	 * 		The users primare role ID
     */
    public function getRoleIdFk()
    {
        return $this->_roleIdFk;
    }

    /**
     * Getter method for the available locales.
     *
     * @return TechDivision_Collections_Interfaces_Collection
     * 		The available locales
     */
    public function getLocales()
    {
        return $this->_locales;
    }

    /**
     * Setter method for the available locales.
     *
     * @param TechDivision_Collections_Interfaces_Collection $locales
     * 		The available locales
     * @return void
     */
    public function setLocales(
        TechDivision_Collections_Interfaces_Collection $locales) {
        $this->_locales = $locales;
    }
    
	/**
     * (non-PHPdoc)
     * @see TDProject/Interfaces/Block#prepareLayout()
     */
    public function prepareLayout() {
    	// initialize the tabs
    	$tabs = $this->addTabs('tabs', 'Tabs');
        // add the tab for the user data
        $tabs->addTab(
        	'user', 'User Data'
        )
    	->addFieldset(
    		'user', 'User Data'
    	)
		->addElement(
		    $this->getElement(
		    	'textfield', 'username', 'Username'
    		)->setMandatory()
        )
    	->addElement(
    	    $this->getElement('textfield', 'email', 'E-Mail')
    	)
        ->addElement(
            $this->getElement(
            	'select', 'userLocale', 'Locale'
            )->setOptions($this->getLocales())
        )
        ->addElement(
            $this->getElement('textfield', 'rate', 'Internal Price')
        )
        ->addElement(
            $this->getElement('textfield', 'contractedHours', 'Contracted Hours')
        )
        ->addElement(
            $this->getElement('checkbox', 'enabled', 'Active')
        )
        ->addElement(
            $this->getElement(
            	'select', 'roleIdFk', 'Role'
            )->setOptions($this->getRoles())
        );
        // add the tab for the LDAP settings
		$tabs->addTab(
			'ldap', 'LDAP'
		)
		->addFieldset(
			'ldap', 'LDAP'
		)
    	->addElement(
    	    $this->getElement(
    	    	'checkbox', 'ldapSynced', 'Synchronized'
    	    )
        )
    	->addElement(
    	    $this->getElement(
    	    	'textfield', 'syncedAt', 'Last Synchronized'
    	    )->setDisabled()
    	);
	    // return the instance itself
	    return parent::prepareLayout();
    }

    /**
     * (non-PHPdoc)
     * @see TDProject_Core_Block_Abstract::reset()
     */
    function reset()
    {
    	parent::reset();
        $this->_roles = new TechDivision_Collections_ArrayList();
        $this->_roleIdFk = new TechDivision_Lang_Integer(0);
        $this->_locales = new TechDivision_Collections_ArrayList();
    }

    /**
     * (non-PHPdoc)
     * @see TDProject_Core_Block_Abstract::repopulate()
     */
    function repopulate()
    {
        // initialize the DTO with the data to save
		$lvo = new TDProject_Core_Common_ValueObjects_UserLightValue();
		$lvo->setUserId($this->getUserId());
		$lvo->setUserLocale($this->getUserLocale());
		$lvo->setEmail($this->getEmail());
		$lvo->setUsername($this->getUsername());
		$lvo->setPassword($this->getPassword());
		$lvo->setEnabled($this->getEnabled());
		$lvo->setRate($this->getRate());
		$lvo->setContractedHours($this->getContractedHours());
		$lvo->setLdapSynced($this->getLdapSynced());
        // append the seleted role
        $role = new TDProject_Core_Common_ValueObjects_RoleLightValue();
        $role->setRoleId($this->getRoleIdFk());
    	$dto = new TDProject_Core_Common_ValueObjects_UserOverviewData(
    	    $lvo,
            $role
    	);
        // return the initialized DTO
    	return $dto;
    }

    /**
     * Populates the ActionForm with the values
     * of the passed DTO.
     *
     * @param TDProject_Core_Common_ValueObjects_UserViewData $dto
     * 		The DTO with the data to initialize the ActionForm with
     * @return void
     */
    function populate(TDProject_Core_Common_ValueObjects_UserViewData $dto) {
    	parent::populate($dto);
        $this->_roles = $dto->getRoles();
        $this->_roleIdFk = $dto->getDefaultRole()->getRoleId();
        $this->_locales = $dto->getLocales();
    }

    /**
     * This method checks if the values in the member variables
     * holds valiid data. If not, a ActionErrors container will
     * be initialized an for every incorrect value a ActionError
     * object with the apropriate error message will be added.
     *
     * @return ActionErrors Returns a ActionErrors container with ActionError objects
     */
    function validate() {
        // initialize the ActionErrors
        $errors = new TechDivision_Controller_Action_Errors();
        // check if a username was entered
        if ($this->_username->length() == 0) {
            $errors->addActionError(
                new TechDivision_Controller_Action_Error(
                    TDProject_Core_Controller_Util_ErrorKeys::USERNAME,
                    $this->translate('username.none')
                )
            );
        }
        // check if a email was entered
        if ($this->_email->length() == 0) {
            $errors->addActionError(
                new TechDivision_Controller_Action_Error(
                    TDProject_Core_Controller_Util_ErrorKeys::EMAIL,
                    $this->translate('email.none')
                )
            );
        }
        // check if a valid email was entered
        if (filter_var($this->_email, FILTER_VALIDATE_EMAIL) === false) {
            $errors->addActionError(
                new TechDivision_Controller_Action_Error(
                    TDProject_Core_Controller_Util_ErrorKeys::EMAIL,
                    $this->translate('email.invalid')
                )
            );
        }
        // return the ActionErrors
        return $errors;
    }
}