<?php


/**
 * TDProject_Project_Common_Enums_UserRole
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

require_once 'TechDivision/Lang/Object.php';
require_once 'TechDivision/Lang/String.php';
require_once 'TDProject/Core/Common/ValueObjects/RoleLightValue.php';
require_once 'TDProject/Project/Common/Exceptions/InvalidEnumException.php';

/**
 * This class is the enum type for all user roles.
 *
 * @category   	TDProject
 * @package     TDProject_Core
 * @copyright  	Copyright (c) 2011 <info@techdivision.com> - TechDivision GmbH
 * @license    	http://opensource.org/licenses/osl-3.0.php
 * 				Open Software License (OSL 3.0)
 * @author      Markus Berwanger <m.berwanger@techdivision.com>
 */
class TDProject_Core_Common_Enums_UserRole 
    extends TechDivision_Lang_Object {
    
    /**
     * Role admin.
     * @var string
     */
    const ADMINISTRATOR = 'Administrator';
    
    /**
    * Role user.
    * @var string
    */
    const USER = 'User';
    
    /**
     * Role guest.
     * @var string
     */
    const GUEST = 'Guest';
    
    /**
    * Role developer.
    * @var string
    */
    const DEVELOPER = 'Develeoper';
    
    /**
    * Role projectmanager.
    * @var string
    */
    const PROJECTMANAGER = 'Projectmanager';
    
    /**
     * The available user roles.
     * @var array
     */
    protected static $_userRoles = array(
        1 => self::ADMINISTRATOR,
        2 => self::USER,
        3 => self::GUEST,
        4 => self::DEVELOPER,
        5 => self::PROJECTMANAGER
    );
    
    /**
     * The instance user role value.
     * @var string
     */
    protected $_userRole = '';
    
    /**
     * Protected constructor to avoid direct initialization.
     * 
     * @param string $userRole
     * 		The requested user role
     */
    protected function __construct($userRole) {
    	$this->_userRole = $userRole;
    }
    
    /**
     * Factory method to create a new user role
     * instance for the requested value.
     * 
     * @param string $userRole
     * 		The requested user role
     * @return TDProject_Project_Common_Enums_UserRole
     * 		The requested user role instance
     * @throws TDProject_Project_Common_Exceptions_InvalidEnumException
     * 		Is thrown if the user role with the requested value is not available
     */
    public static function create($userRole)
    {
    	// check if the requested value is valid
    	if (in_array($userRole, self::$_userRoles)) {
    		return new TDProject_Core_Common_Enums_UserRole($userRole);
    	}
    	// throw an exception if not
    	throw new TDProject_Core_Common_Exceptions_InvalidEnumException(
    		'Invalid enum ' . $userRole . ' requested'
    	);
    }
    
    /**
 	 * Returns TRUE if the passed project user
 	 * has user role admin, else FALSE.
 	 * 
 	 * @param TDProject_Core_Common_ValueObjects_RoleLightValue $lvo
 	 * 		The LVO with the project user to compare
 	 * @return boolean TRUE if the passed project user has role admin, else FALSE
     */
    public static function isAdministrator(
    	TDProject_Core_Common_ValueObjects_RoleLightValue $lvo) {
    	// load the admin role
    	$userRole = self::create(
    	    self::ADMINISTRATOR
    	);
    	// check the passed role to be administrator
    	return $lvo->getName()->equals($userRole->toString());
    }
    
    /**
    * Returns TRUE if the passed project user
    * has user role projectmanager, else FALSE.
    *
    * @param TDProject_Core_Common_ValueObjects_RoleLightValue $lvo
    * 		The LVO with the project user to compare
    * @return boolean TRUE if the passed project user has role projectmanager, 
    * 		else FALSE
    */
    public static function isProjectmanager(
    TDProject_Core_Common_ValueObjects_RoleLightValue $lvo) {
        // load the admin role
        $userRole = self::create(
            self::PROJECTMANAGER
        );
        // check the passed role to be administrator
        return $lvo->getName()->equals($userRole->toString());
    }
    
    /**
    * Returns TRUE if the passed project user
    * has user role developer, else FALSE.
    *
    * @param TDProject_Core_Common_ValueObjects_RoleLightValue $lvo
    * 		The LVO with the project user to compare
    * @return boolean TRUE if the passed project user has role developer, 
    * 		else FALSE
    */
    public static function isDeveloper(
    TDProject_Core_Common_ValueObjects_RoleLightValue $lvo) {
        // load the admin role
        $userRole = self::create(
        self::DEVELOPER
        );
        // check the passed role to be administrator
        return $lvo->getName()->equals($userRole->toString());
    }
    
    /**
    * Returns TRUE if the passed project user
    * has user role user, else FALSE.
    *
    * @param TDProject_Core_Common_ValueObjects_RoleLightValue $lvo
    * 		The LVO with the project user to compare
    * @return boolean TRUE if the passed project user has role user,
    * 		else FALSE
    */
    public static function isUser(
    TDProject_Core_Common_ValueObjects_RoleLightValue $lvo) {
        // load the admin role
        $userRole = self::create(
        self::USER
        );
        // check the passed role to be administrator
        return $lvo->getName()->equals($userRole->toString());
    }
    
    /**
    * Returns TRUE if the passed project user
    * has user role guest, else FALSE.
    *
    * @param TDProject_Core_Common_ValueObjects_RoleLightValue $lvo
    * 		The LVO with the project user to compare
    * @return boolean TRUE if the passed project user has role guest,
    * 		else FALSE
    */
    public static function isGuest(
    TDProject_Core_Common_ValueObjects_RoleLightValue $lvo) {
        // load the admin role
        $userRole = self::create(
        self::GUEST
        );
        // check the passed role to be administrator
        return $lvo->getName()->equals($userRole->toString());
    }
    
    /**
     * Returns an ArrayList with all available user roles.
     * 
     * 
     * @return TechDivision_Collections_ArrayList
     * 		The ArrayList with all user roles
     */
    public static function load()
    {
    	// initialize the ArrayList
    	$list = new TechDivision_Collections_ArrayList();
    	// load all user roles
    	for ($i = 1; $i < sizeof(self::$_userRoles); $i++) {
    		$list->add(self::create(self::$_userRoles[$i]));	
    	}
    	// return the ArrayList
    	return $list;
    }
    
    /**
     * Returns the user role's string value.
  	 *
     * @return string The user role's value
     */
    public function getUserRole()
    {
    	return $this->_userRole;
    }
    
    /**
     * Returns the user role's string value.
  	 *
     * @return string The user role's value
     * @see TechDivision_Lang_Object::__toString()
     */
    public function __toString()
    {
    	return $this->getUserRole();
    }
    
    /**
     * Returns the user role's String value.
  	 *
     * @return TechDivision_Lang_String 
     * 		The user role's value as String instance
     */
    public function toString()
    {
    	return new TechDivision_Lang_String($this->getUserRole());
    }
}