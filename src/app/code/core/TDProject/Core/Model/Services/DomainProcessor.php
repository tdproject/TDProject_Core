<?php

/**
 * TDProject_Core_Model_Services_DomainProcessor
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

/**
 * @category   	TDProject
 * @package    	TDProject_Core
 * @copyright  	Copyright (c) 2010 <info@techdivision.com> - TechDivision GmbH
 * @license    	http://opensource.org/licenses/osl-3.0.php
 * 				Open Software License (OSL 3.0)
 * @author      Bastian Stangl <b.stangl@techdivision.com>
 */
class TDProject_Core_Model_Services_DomainProcessor
    extends TDProject_Core_Model_Services_AbstractDomainProcessor 
{

	/**
	 * This method returns the logger of the requested
	 * type for logging purposes.
	 *
     * @param string The log type to use
	 * @return TechDivision_Logger_Logger Holds the Logger object
	 * @throws Exception Is thrown if the requested logger type is not initialized or doesn't exist
	 * @deprecated 0.6.26 - 2011/12/19
	 */
    protected function _getLogger(
        $logType = TechDivision_Logger_System::LOG_TYPE_SYSTEM)
    {
    	return $this->getLogger();
    }   
    
    /**
     * This method returns the logger of the requested
     * type for logging purposes.
     *
     * @param string The log type to use
     * @return TechDivision_Logger_Logger Holds the Logger object
     * @since 0.6.27 - 2011/12/19
     */
    public function getLogger(
    	$logType = TechDivision_Logger_System::LOG_TYPE_SYSTEM)
    {
    	return $this->getContainer()->getLogger();
    } 

	/**
     * (non-PHPdoc)
     * @see TDProject/Core/Common/Delegates/Interfaces/DomainProcessorDelegate#getUserViewData(TechDivision_Lang_Integer $userId = null)
     */
	public function getUserViewData(
	    TechDivision_Lang_Integer $userId = null) 
	{
    	try {
            // load and return the user with the passed ID
            return TDProject_Core_Model_Assembler_User::create($this->getContainer())
                ->getUserViewData($userId);
	    } catch(TechDivision_Model_Interfaces_Exception $e) {
            // log the exception message
            $this->_getLogger()->error($e->__toString());
            // throw a new exception
            throw new TDProject_Core_Common_Exceptions_SystemException(
                $e->__toString()
            );
        }
	}

    /**
     * (non-PHPdoc)
     * @see TDProject/Core/Common/Delegates/Interfaces/DomainProcessorDelegate#getUserOverviewData()
     */
	public function getUserOverviewData()
	{
	    try {
            // load and return all users
            return TDProject_Core_Model_Assembler_User::create($this->getContainer())
                ->getUserOverviewData();
	    } catch(TechDivision_Model_Interfaces_Exception $e) {
            // log the exception message
            $this->_getLogger()->error($e->__toString());
            // throw a new exception
            throw new TDProject_Core_Common_Exceptions_SystemException(
                $e->__toString()
            );
        }
    }

	/**
     * (non-PHPdoc)
     * @see TDProject/Core/Common/Delegates/Interfaces/DomainProcessorDelegate#saveUser(TDProject_Core_Common_ValueObjects_UserLightValue $lvo)
     */
	public function saveUser(
        TDProject_Core_Common_ValueObjects_UserLightValue $lvo)
    {
		try {
			// begin the transaction
			$this->beginTransaction();
			// save the user
			$userId = TDProject_Core_Model_Actions_User::create($this->getContainer())
			    ->saveUser($lvo);
			// commit the transaction
			$this->commitTransaction();
			// return the user id
			return $userId;
		} catch(TechDivision_Model_Interfaces_Exception $e) {
            // log the exception message
            $this->_getLogger()->error($e->__toString());
            // throw a new exception
            throw new TDProject_Core_Common_Exceptions_SystemException(
                $e->__toString()
            );
        }
	}

    /**
     * (non-PHPdoc)
     * @see TDProject/Core/Common/Delegates/Interfaces/DomainProcessorDelegate#changeUserStatus(TechDivision_Lang_Integer $userId, TechDivision_Lang_Boolean $enabled)
     */
    public function changeUserStatus(
        TechDivision_Lang_Integer $userId,
        TechDivision_Lang_Boolean $enabled) {
        try {
            // begin the transaction
            $this->beginTransaction();
            // get the user
            $user = TDProject_Core_Model_Utils_UserUtil::getHome($this->getContainer())
                ->findByPrimaryKey($userId);
            // set the new status and update the user
            $user->setEnabled($enabled);
            $user->update();
            $mail = new TDProject_Core_Model_Services_Generator_Mail();
            $mail->generateActiveMail($user);
            // commit the transaction
            $this->commitTransaction();
        } catch(TechDivision_Model_Interfaces_Exception $e) {
            // log the exception message
            $this->_getLogger()->error($e->__toString());
            // throw a new exception
            throw new TDProject_Core_Common_Exceptions_SystemException(
                $e->__toString()
            );
        }
    }

    /**
     * (non-PHPdoc)
     * @see TDProject/Core/Common/Delegates/Interfaces/DomainProcessorDelegate#deleteUser(TechDivision_Lang_Integer $userId)
     */
    public function deleteUser(TechDivision_Lang_Integer $userId) {
        try {
            // start the transaction
            $this->beginTransaction();
            // load the user
            $user = TDProject_Core_Model_Utils_UserUtil::getHome($this->getContainer())
                ->findByPrimaryKey($userId);
            // delete the user
            $user->delete();
            // commit the transcation
            $this->commitTransaction();
        } catch(TechDivision_Model_Interfaces_Exception $e) {
            // log the exception message
            $this->_getLogger()->error($e->__toString());
            // throw a new exception
            throw new TDProject_Core_Common_Exceptions_SystemException(
                $e->__toString()
            );
        }
    }

	/**
     * (non-PHPdoc)
     * @see TDProject/Core/Common/Delegates/Interfaces/DomainProcessorDelegate#getOwnUserViewData(TechDivision_Lang_Integer $userId = null)
     */
	public function getOwnUserViewData(
	    TechDivision_Lang_Integer $userId = null)
	{
    	try {
            // load and return the system user with the passed ID
            return TDProject_Core_Model_Assembler_User::create($this->getContainer())
                ->getOwnUserViewData($userId);
	    } catch(TechDivision_Model_Interfaces_Exception $e) {
            // log the exception message
            $this->_getLogger()->error($e->__toString());
            // throw a new exception
            throw new TDProject_Core_Common_Exceptions_SystemException(
                $e->__toString()
            );
        }
	}

    /**
     * Updates the user's data if he/she changes his/her own options.
     * @param TDProject_Core_Common_ValueObjects_UserLightValue $inputLvo
     */
    public function updateOwnUser(
        TDProject_Core_Common_ValueObjects_UserLightValue $inputLvo)
    {
        try {
            // start a new transaction
            $this->beginTransaction();
            //get the id of the user that should be changed
            $userId = $inputLvo->getUserId();
            // reinitialize the system user and return it
            $systemUser = TDProject_Core_Model_Utils_System_UserUtil::getHome($this->getContainer())
                ->findByPrimaryKey($userId);
            //set the values that were changed
            $systemUser->setEmail($inputLvo->getEmail());
            $systemUser->setUserLocale($inputLvo->getUserLocale());
            // update the user in the database
            $systemUser->update();
            // commit the transcation
            $this->commitTransaction();
            // return the system user DTO
            return $systemUser->getValue();
        } catch(TechDivision_Model_Interfaces_Exception $e) {
            // rollback the transaction
            $this->rollbackTransaction();
            // log the exception message
            $this->_getLogger()->error($e->__toString());
            // throw a new exception
            throw new TDProject_Core_Common_Exceptions_SystemException(
                $e->__toString()
            );
        }
    }

	/**
	 * (non-PHPdoc)
	 * @see TDProject/Core/Common/Delegates/Interfaces/DomainProcessorDelegate#login(TechDivision_Lang_String $username, TechDivision_Lang_String $password)
	 */
    public function login(
        TechDivision_Lang_String $username,
        TechDivision_Lang_String $password) {
        try {
            // start transaction, because of creating a local user
            // if available in LDAP and not found in the database
            $this->beginTransaction();
            // initialize a new system user
            $systemUser = TDProject_Core_Model_Utils_System_UserUtil::getHome($this->getContainer())
                ->epbCreate();
            // set username and password
            $systemUser->setUsername($username);
            $systemUser->setPassword($password);
            // try to authenticate the user
            $systemUser->authenticate($this->getContainer());
            // check the users right
            if ($systemUser->getEnabled()->equals(new TechDivision_Lang_Boolean(false))) {
                throw new TDProject_Core_Common_Exceptions_InsufficientRightsException(
                    'Insufficient rights'
                );
            }
            // load the system user
            $dto = $systemUser->getValue();
            // commit the transcation
            $this->commitTransaction();
            // return the system user DTO
            return $dto;
        } catch(TechDivision_Model_Interfaces_Exception $e) {
            // rollback the transaction
            $this->rollbackTransaction();
            // log the exception message
            $this->_getLogger()->error($e->__toString());
            // throw a new exception
            throw new TDProject_Core_Common_Exceptions_SystemException(
                $e->__toString()
            );
        }
    }

	/**
     * (non-PHPdoc)
     * @see TDProject/Core/Common/Delegates/Interfaces/DomainProcessorDelegate#saveSetting(TDProject_Core_Common_ValueObjects_SettingLightValue $lvo)
     */
	public function saveSetting(
        TDProject_Core_Common_ValueObjects_SettingLightValue $lvo) {
		try {
			// begin the transaction
			$this->beginTransaction();
			// lookup setting ID
			$settingId = $lvo->getSettingId();
			// store the settings
			if ($settingId->equals(new TechDivision_Lang_Integer(0))) {
	            // create new settings
				$setting = TDProject_Core_Model_Utils_SettingUtil::getHome($this->getContainer())
				    ->epbCreate();
				// set the data
				$setting->setEmailSupport($lvo->getEmailSupport());
				$setting->setMediaDirectory($lvo->getMediaDirectory());
				$setting->setUseLdap($lvo->getUseLdap());
				$setting->setLdapHost($lvo->getLdapHost());
				$setting->setLdapBindRequired($lvo->getLdapBindRequired());
				$setting->setLdapDomain($lvo->getLdapDomain());
				$setting->setLdapDn($lvo->getLdapDn());
				$setting->setUseSmtp($lvo->getUseSmtp());
				$setting->setSmtpHost($lvo->getSmtpHost());
				$setting->setSmtpPort($lvo->getSmtpPort());
				$setting->setSmtpUser($lvo->getSmtpUser());
				$setting->setSmtpPassword($lvo->getSmtpPassword());
				$setting->setWebserviceUri($lvo->getWebserviceUri());
				$setting->setWsdlUri($lvo->getWsdlUri());
				$settingId = $setting->create();
			} else {
			    // update the settings
				$setting = TDProject_Core_Model_Utils_SettingUtil::getHome($this->getContainer())
				    ->findByPrimaryKey($settingId);
				$setting->setEmailSupport($lvo->getEmailSupport());
				$setting->setMediaDirectory($lvo->getMediaDirectory());
				$setting->setUseLdap($lvo->getUseLdap());
				$setting->setLdapHost($lvo->getLdapHost());
				$setting->setLdapBindRequired($lvo->getLdapBindRequired());
				$setting->setLdapDomain($lvo->getLdapDomain());
				$setting->setLdapDn($lvo->getLdapDn());
				$setting->setUseSmtp($lvo->getUseSmtp());
				$setting->setSmtpHost($lvo->getSmtpHost());
				$setting->setSmtpPort($lvo->getSmtpPort());
				$setting->setSmtpUser($lvo->getSmtpUser());
				$setting->setSmtpPassword($lvo->getSmtpPassword());
				$setting->setWebserviceUri($lvo->getWebserviceUri());
				$setting->setWsdlUri($lvo->getWsdlUri());
				$setting->update();
			}
			// commit the transaction
			$this->commitTransaction();
			// return the setting ID
			return $settingId;
		} catch(TechDivision_Model_Interfaces_Exception $e) {
            // log the exception message
            $this->_getLogger()->error($e->__toString());
            // throw a new exception
            throw new TDProject_Core_Common_Exceptions_SystemException(
                $e->__toString()
            );
        }
	}

	/**
     * (non-PHPdoc)
     * @see TDProject/Core/Common/Delegates/Interfaces/DomainProcessorDelegate#getSettingViewData()
     */
	public function getSettingViewData()
	{
        try {
            // initialize a new LocalHome
    	    $home = TDProject_Core_Model_Utils_SettingUtil::getHome($this->getContainer());
    	    // load the settings if available
    	    $settings = $home->findAll();
    	    // iterate over the settings and return the first one
    	    for($i = 0; $i < $settings->size(); $i++) {
    	        return $settings->get($i)->getValue();
    	    }
    	    // return an empty LVO
    	    return $home->epbCreate()->getValue();
	    } catch(TechDivision_Model_Interfaces_Exception $e) {
            // log the exception message
            $this->_getLogger()->error($e->__toString());
            // throw a new exception
            throw new TDProject_Core_Common_Exceptions_SystemException(
                $e->__toString()
            );
        }
	}

	/**
     * (non-PHPdoc)
     * @see TDProject/Core/Common/Delegates/Interfaces/DomainProcessorDelegate#getDashboardViewData()
     */
	public function getDashboardViewData()
	{
	    try {
    		// assemble and return the initialized DTO
    		return TDProject_Core_Model_Assembler_Dashboard::create($this->getContainer())
    		    ->getDashboardViewData();
	    } catch(TechDivision_Model_Interfaces_Exception $e) {
            // log the exception message
            $this->_getLogger()->error($e->__toString());
            // throw a new exception
            throw new TDProject_Core_Common_Exceptions_SystemException(
                $e->__toString()
            );
        }
	}

	/**
     * (non-PHPdoc)
     * @see TDProject/Core/Common/Delegates/Interfaces/DomainProcessorDelegate#getResourceViewData(TechDivision_Lang_Integer $resourceId = null)
     */
	public function getResourceViewData(
	    TechDivision_Lang_Integer $resourceId = null) {
    	    try {
            // load and return the resource with the passed ID
            return TDProject_Core_Model_Assembler_Resource::create($this->getContainer())
                ->getResourceViewData($resourceId);
	    } catch(TechDivision_Model_Interfaces_Exception $e) {
            // log the exception message
            $this->_getLogger()->error($e->__toString());
            // throw a new exception
            throw new TDProject_Core_Common_Exceptions_SystemException(
                $e->__toString()
            );
        }
	}

    /**
     * (non-PHPdoc)
     * @see TDProject/Core/Common/Delegates/Interfaces/DomainProcessorDelegate#getResourceOverviewData()
     */
	public function getResourceOverviewData() {
	    try {
            // load and return all users
            return TDProject_Core_Model_Assembler_Resource::create($this->getContainer())
                ->getResourceLightValues();
	    } catch(TechDivision_Model_Interfaces_Exception $e) {
            // log the exception message
            $this->_getLogger()->error($e->__toString());
            // throw a new exception
            throw new TDProject_Core_Common_Exceptions_SystemException(
                $e->__toString()
            );
        }
    }

    /**
     * (non-PHPdoc)
     * @see TDProject/Core/Common/Delegates/Interfaces/DomainProcessorDelegate#deleteResource(TechDivision_Lang_Integer $resourceId)
     */
    public function deleteResource(TechDivision_Lang_Integer $resourceId) {
        try {
            // start the transaction
            $this->beginTransaction();
            // load the resource message
            $resource = TDProject_Core_Model_Utils_ResourceUtil::getHome($this->getContainer())
                ->findByPrimaryKey($resourceId);
            // delete the resource message
            $resource->delete();
            // commit the transcation
            $this->commitTransaction();
        } catch(TechDivision_Model_Interfaces_Exception $e) {
            // log the exception message
            $this->_getLogger()->error($e->__toString());
            // throw a new exception
            throw new TDProject_Core_Common_Exceptions_SystemException(
                $e->__toString()
            );
        }
    }

	/**
     * (non-PHPdoc)
     * @see TDProject/Core/Common/Delegates/Interfaces/DomainProcessorDelegate#saveResource(TDProject_Core_Common_ValueObjects_ResourceLightValue $lvo)
     */
	public function saveResource(
        TDProject_Core_Common_ValueObjects_ResourceLightValue $lvo) {
		try {
			// begin the transaction
			$this->beginTransaction();
			// lookup resource ID
			$resourceId = $lvo->getResourceId();
			// store the resource message
			if ($resourceId->equals(new TechDivision_Lang_Integer(0))) {
	            // create a new resource message
				$resource = TDProject_Core_Model_Utils_ResourceUtil::getHome($this->getContainer())
				    ->epbCreate();
				// set the data
				$resource->setKey($lvo->getKey());
				$resource->setResourceLocale($lvo->getResourceLocale());
				$resource->setMessage($lvo->getMessage());
				$resourceId = $resource->create();
			} else {
			    // update the resource message
				$resource = TDProject_Core_Model_Utils_ResourceUtil::getHome($this->getContainer())
				    ->findByPrimaryKey($resourceId);
				$resource->setKey($lvo->getKey());
				$resource->setResourceLocale($lvo->getResourceLocale());
				$resource->setMessage($lvo->getMessage());
				$resource->update();
			}
			// commit the transaction
			$this->commitTransaction();
			// return the resource ID
			return $resourceId;
		} catch(TechDivision_Model_Interfaces_Exception $e) {
            // log the exception message
            $this->_getLogger()->error($e->__toString());
            // throw a new exception
            throw new TDProject_Core_Common_Exceptions_SystemException(
                $e->__toString()
            );
        }
	}

	/**
     * (non-PHPdoc)
     * @see TDProject/Core/Common/Delegates/Interfaces/DomainProcessorDelegate#getAcl()
     */
	public function getAcl()
	{
        try {
            // load and return the ACL
            return TDProject_Core_Model_Actions_Acl::create($this->getContainer())
                ->getAcl();
        } catch(TechDivision_Model_Interfaces_Exception $e) {
            // log the exception message
            $this->_getLogger()->error($e->__toString());
            // throw a new exception
            throw new TDProject_Core_Common_Exceptions_SystemException(
                $e->__toString()
            );
        }
	}

	/**
     * (non-PHPdoc)
     * @see TDProject/Core/Common/Delegates/Interfaces/DomainProcessorDelegate#getGuestUser()
     */
	public function getGuestUser()
	{
	    try {
            // load and return the guest user DTO
            return TDProject_Core_Model_Utils_System_UserUtil::getHome($this->getContainer())
                ->findByUsername(new TechDivision_Lang_String('guest'))
                ->getValue();
        } catch(TechDivision_Model_Interfaces_Exception $e) {
            // rollback the transaction
            $this->rollbackTransaction();
            // log the exception message
            $this->_getLogger()->error($e->__toString());
            // throw a new exception
            throw new TDProject_Core_Common_Exceptions_SystemException(
                $e->__toString()
            );
        }
	}

	/**
     * (non-PHPdoc)
     * @see TDProject/Core/Common/Delegates/Interfaces/DomainProcessorDelegate#rewrite(TechDivision_Lang_String $source)
     */
	public function rewrite(TechDivision_Lang_String $source)
	{
		try {
			// try to load the rewrite for the passed source URL
			$rewrite = TDProject_Core_Model_Utils_RewriteUtil::getHome($this->getContainer())
				->findBySource($source);

			if ($rewrite) {
				return $rewrite->getLightValue();
			}

		} catch(TechDivision_Model_Interfaces_Exception $e) {
            // rollback the transaction
            $this->rollbackTransaction();
            // log the exception message
            $this->_getLogger()->error($e->__toString());
            // throw a new exception
            throw new TDProject_Core_Common_Exceptions_SystemException(
                $e->__toString()
            );
		}
	}

	/**
     * (non-PHPdoc)
     * @see TDProject/Core/Common/Delegates/Interfaces/DomainProcessorDelegate#runSystemUpdate($options = array())
     */
	public function runSystemUpdate($options = array())
    {
    	// initialize a new instance and process the update functionality
    	TDProject_Core_Model_Actions_System::create($this->getContainer())
    		->runSystemUpdate($this->getContainer(), $options);
    	// return the instance itself
    	return $this;
    }

	/**
     * (non-PHPdoc)
     * @see TDProject/Core/Common/Delegates/Interfaces/DomainProcessorDelegate#runSystemInstall($options = array())
     */
	public function runSystemInstall($options = array())
    {
    	// initialize a new instance and process the update functionality
    	TDProject_Core_Model_Actions_System::create($this->getContainer())
    		->runSystemInstall($this->getContainer(), $options);
    	// return the instance itself
    	return $this;
    }

	/**
     * (non-PHPdoc)
     * @see TDProject/Core/Common/Delegates/Interfaces/DomainProcessorDelegate#runGeneration($options = array())
     */
	public function runGeneration($options = array())
    {
    	// initialize a new instance and process the update functionality
    	TDProject_Core_Model_Actions_System::create($this->getContainer())
    		->runGeneration($this->getContainer(), $options);
    	// return the instance itself
    	return $this;
    }
}