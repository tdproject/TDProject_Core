<?php

/**
 * TDProject_Core_Aspect_Authorization_Acl
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

require_once 'TechDivision/Lang/Object.php';
require_once 'TechDivision/AOP/Interfaces/Aspect.php';
require_once 'TechDivision/AOP/Interfaces/JoinPoint.php';


/**
 * This class is the Aspect used to authorize the system user
 * by using the Aspect adviced around.
 *
 * @category    TDProject
 * @package     TDProject_Core
 * @copyright   Copyright (c) 2010 <info@techdivision.com> - TechDivision GmbH
 * @license     http://opensource.org/licenses/osl-3.0.php
 *              Open Software License (OSL 3.0)
 * @author      Tim Wagner <tw@techdivision.com>
 */
class TDProject_Core_Aspect_Authorization_Acl
    extends TechDivision_Lang_Object
    implements TechDivision_AOP_Interfaces_Aspect {

    /**
     * String for authorization process in progress.
     * @var string
     */
    const AUTHORIZATION_IN_PROGRESS = 'authorizationInProgress';

    /**
     * Dummy constructor to avoid initialization errors.
     *
     * @return void
     */
    public function __construct()
    {
        // dummy implementation
    }

    /**
     * Start authorization process.
     *
     * @param TechDivision_Collections_Interfaces_Map $context
     * 		The Proxy context
     */
    public function setAuthorizationInProgess(
        TechDivision_Collections_Interfaces_Map $context) {
        $context->add(self::AUTHORIZATION_IN_PROGRESS, true);
    }

    /**
     * Stop the authorization process.
     *
     * @param TechDivision_Collections_Interfaces_Map $context
     * 		The Proxy context
     */
    public function setAuthorizationNotInProgress(
        TechDivision_Collections_Interfaces_Map $context) {
        $context->add(self::AUTHORIZATION_IN_PROGRESS, false);
    }

    /**
     * Returns TRUE if authorization is in progress, else FALSE.
     *
     * @param TechDivision_AOP_Interfaces_JoinPoint $context
     * 		The Proxy context
     * @return The flag if authorization is in progress or not
     */
    public function inAuthorizationProcess($context)
    {
        // check if the authentication flag is set, if not initialize it
        if ($context->exists(self::AUTHORIZATION_IN_PROGRESS) === false) {
            $context->add(self::AUTHORIZATION_IN_PROGRESS, false);
        }
        // return the flag
        return $context->get(self::AUTHORIZATION_IN_PROGRESS);
    }

    /**
     * This method forces authorization.
     *
     * @param TechDivision_AOP_Interfaces_JoinPoint $joinPoint
     * 		The actual JoinPoint
     * @return void
     */
    public function forceAuthorization(
        TechDivision_AOP_Interfaces_JoinPoint $joinPoint)
    {
        // load the Proxy context and the object the Aspect
        $context = $joinPoint->getProxyContext();
        // load the Proxy instance
		$aspectable = $joinPoint
    		->getMethodInterceptor()
            ->getAspectContainer()
            ->getAspectable();
        // check if already an authorization process is running
        if (!$this->inAuthorizationProcess($context)) {
    	    // load the application instance
            $app = TDProject_Factory::get();
            // set one running
            $this->setAuthorizationInProgess($context);
            // initialize the resource name to authorize
            $privilege = $aspectable->getPrivilege();
            // if a system user was found and resource is allowed
            if ($app->isAllowed($aspectable, $privilege)) {
            	// finish authorization progress
                $this->setAuthorizationNotInProgress($context);
                // proceed with the JoinPoint and return
            	return $joinPoint->proceed();
            }
			// create and add a new ActionError
			$actionErrors = new TechDivision_Controller_Action_Errors();
			$actionErrors->addActionError(
			    new TechDivision_Controller_Action_Error(
                    TDProject_Common_Util_ErrorKeys::INSUFFICIENT_RIGHTS,
                    $app->translate(
                        new TechDivision_Lang_String('insufficient.rights'),
                        new TechDivision_Lang_String('Basic')
                    )
                )
            );
			// load the session
			$session = $app->getRequest()->getSession();
            // save the ActionError in the session
            $session->setAttribute(
                TechDivision_Controller_Action_Errors::ACTION_ERRORS,
                $actionErrors
            );
            // is thrown if user is not authorized to use resource
	        $aspectable->forward(
	            TDProject_Core_Controller_Util_GlobalForwardKeys::SYSTEM_LOGIN
	        );
            // finish authorization process
            $this->setAuthorizationNotInProgress($context);
            // return
            return;
        }
        // proceed with the JoinPoint and return
        return $joinPoint->proceed();
    }
}