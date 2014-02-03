<?php

require_once 'Zend/Acl.php';
require_once 'Zend/Acl/Role/Interface.php';
require_once 'TechDivision/Model/Interfaces/Value.php';
require_once 'TDProject/Core/Common/ValueObjects/UserValue.php';
require_once 'TDProject/Core/Model/Entities/Role.php';
require_once 'TDProject/Core/Common/Api.php';
require_once 'TDProject/Core/Common/Navigation.php';

/**
 * This class is the data transfer object between the
 * model and the controller for the table user.
 *
 * Each class member reflects a database field and
 * the values of the related dataset.
 *
 * @package Common
 * @author generator <core@techdivision.com>
 * @version $Revision: 1.1 $ $Date: 2007-10-25 16:09:14 $
 * @copyright TechDivision GmbH
 * @link http://www.techdivision.com
 */
class TDProject_Core_Common_ValueObjects_System_UserValue
    extends TDProject_Core_Common_ValueObjects_UserValue
    implements TechDivision_Model_Interfaces_Value,
        Zend_Acl_Role_Interface
{

    /**
     * The Navigation structure in XML format.
     * @var string
     */
    protected $_navigation = null;

    /**
     * The system user's default role.
     * @var TDProject_Core_Common_ValueObjects_RoleLightValue
     */
    protected $_defaultRole = null;

    /**
    * The locales available in the system.
    * @var TechDivision_Collections_Interfaces_Collection
    */
    protected $_locales = null;

    /**
     * The constructor intializes the DTO with the
     * values passed as parameter.
     *
     * @param array $array
     * 		The array with the virtual members to pass to the AbstractDTO's constructor
     * @return void
     */
    public function __construct(
        TDProject_Core_Common_ValueObjects_UserValue $systemUser = null) {
        // call the parents constructor
        parent::__construct($systemUser);
        // initialize the ValueObject with the passed data
        if (!empty($systemUser)) {
            $this->setNavigation($systemUser->getNavigation());
            $this->setDefaultRole($systemUser->getDefaultRole()->getLightValue());
        }
        // initialize the Collection with the locales
        $this->_locales = new TechDivision_Collections_ArrayList();
    }

    /**
     * The Navigation structure for the actual user in XML format.
     *
     * @param TDProject_Core_Common_Navigation $navigation
     * 	The Navigation structure
     * @return void
     */
    public function setNavigation(TDProject_Core_Common_Navigation $navigation)
    {
        $this->_navigation = $navigation->saveXML();
    }

    /**
     * Returns the Navigation structure for the actual
     * user in XML format.
     *
     * @return TDProject_Core_Common_Navigation The Navigation structure
     */
    public function getNavigation()
    {
        return $this->_navigation;
    }

    /**
     * Checks if the user is allowed to user the passed
     * resource and returns TRUE if yes, else FALSE.
	 *
     * @param string $resource The resource to check
     * @param string $privilege The privilege to check
     * @return boolean
     * 		TRUE if the users is allowed to use the resource, else FALSE
     */
    public function isAllowed($resource = null, $privilege = null)
    {
        // check if the user is allowed to access the passed resource
        foreach ($this->getUserRoles() as $role) {
            $aclRole = new Zend_Acl_Role($role->getName()->__toString());
            if ($this->getAcl()->isAllowed($aclRole, $resource, $privilege)) {
                return true;
            }
        }
        // return FALSE if not
        return false;
    }

    public function setDefaultRole(
        TDProject_Core_Common_ValueObjects_RoleLightValue $defaultRole) {
        $this->_defaultRole = $defaultRole;
    }

    public function getDefaultRole()
    {
       return $this->_defaultRole;
    }

    /**
     * Returns the users default role ID.
     * 
     * @return TechDivision_Lang_Integer The role ID
     */
    public function getRoleId()
    {
        // return the first parent role
        foreach ($this->getUserRoles() as $role) {
            return $role->getRoleId();
        }
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