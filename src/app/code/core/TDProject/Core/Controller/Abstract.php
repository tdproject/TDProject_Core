<?php

/**
 * TDProject_Core_Controller_Abstract
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

require_once 'Zend/Acl.php';
require_once 'Zend/Acl/Resource/Interface.php';
require_once 'TechDivision/Lang/String.php';
require_once 'TechDivision/Lang/Integer.php';
require_once 'TechDivision/Logger/Logger.php';
require_once 'TechDivision/Logger/System.php';
require_once 'TechDivision/Logger/Mail.php';
require_once 'TechDivision/Controller/Action/Errors.php';
require_once 'TechDivision/Controller/Action/DispatchAction.php';
require_once 'TechDivision/Controller/Action/Messages.php';
require_once 'TechDivision/Controller/Action/Controller.php';
require_once 'TechDivision/Controller/Interfaces/Context.php';
require_once 'TechDivision/HttpUtils/Interfaces/Request.php';
require_once 'TechDivision/Controller/Action/Controller.php';
require_once 'TDProject/Core/Controller/Util/GlobalForwardKeys.php';
require_once 'TDProject/Core/Controller/Util/WebRequestKeys.php';
require_once 'TDProject/Core/Controller/Util/WebSessionKeys.php';
require_once 'TDProject/Core/Controller/Util/ErrorKeys.php';
require_once 'TDProject/Core/Controller/Util/MessageKeys.php';
require_once 'TDProject/Core/Common/Delegates/DomainProcessorDelegateUtil.php';
require_once 'TDProject/Core/Common/Exceptions/InsufficientRightsException.php';
require_once 'TDProject/Core/Common/ValueObjects/System/UserValue.php';
require_once 'TDProject/Core/Common/ValueObjects/QueryParameterData.php';
require_once 'TDProject/Core/Block/Page.php';
require_once 'TDProject/Core/Block/Dashboard.php';
require_once 'TDProject/Core/Block/Action.php';

/**
 * @category   	TDProject
 * @package    	TDProject_Core
 * @copyright  	Copyright (c) 2010 <info@techdivision.com> - TechDivision GmbH
 * @license    	http://opensource.org/licenses/osl-3.0.php
 * 				Open Software License (OSL 3.0)
 * @author      Tim Wagner <tw@techdivision.com>
 */
abstract class TDProject_Core_Controller_Abstract
    extends TDProject_Core_Controller_DispatchAction
    implements Zend_Acl_Resource_Interface, TDProject_Interfaces_Event_Observable {

	/**
	 * Holds the forward key for a successfull forward
	 * @const string
	 */
	const SUCCESS = "Success";

	/**
	 * Holds the forward key for a forward if a failure occurs
	 * @const string
	 */
	const FAILURE = "Failure";

	/**
	 * The page title to render
	 * @var TechDivision_Lang_String
	 */
	protected $_pageTitle = null;

	/**
     * Initializes the Action with the Context for the
     * actual request.
	 *
     * @param TechDivision_Controller_Interfaces_Context $context
     * 		The Context for the actual Request
     * @return void
	 */
    public function __construct(
        TechDivision_Controller_Interfaces_Context $context) {
    	// call the parent constructor
    	parent::__construct($context);
		 // initialize the default page title
		 $this->_setPageTitle(new TechDivision_Lang_String('TDProject, v2.0'));
	}

    /**
     * (non-PHPdoc)
     * @see TDProject_Interfaces_Event_Observable::dispatch()
     */
	public function dispatch(
		TDProject_Interfaces_Event_Observer $observer)
	{
		$observer->setAction($this)->dispatch();
	}

	/**
	 * Returns the unique event name.
	 *
	 * @param string $prefix The prefix for the event name
	 * @return The unique event name
	 */
	public function getEventName($prefix)
	{
		return $prefix . $this->getResourceId() . '/' .  $this->getPrivilege();
	}

    /**
     * (non-PHPdoc)
     * @see TechDivision_Controller_Interfaces_Action::preDispatch()
     */
	public function preDispatch()
	{
	    // check if a system user has already been loaded
	    if ($this->_getSystemUser() == null) {
	    // if not, load the Guest user store him in the session
	        $this->_setSystemUser(self::_getDelegate()->getGuestUser());
	    }
	    // dispatch the event
		$this->getApp()->dispatchEvent($this, $this->getEventName('/pre/dispatch'));
		// call the parent method
		return parent::preDispatch();
	}

    /**
     * (non-PHPdoc)
     * @see TechDivision_Controller_Interfaces_Action::postDispatch()
     */
	public function postDispatch()
	{
	    // dispatch the event
		$this->getApp()->dispatchEvent($this, $this->getEventName('/post/dispatch'));
		// call the parent method
		return parent::postDispatch();
	}

	/**
	 * This method is the default method for DispatchAction instances called
	 * with a missing method parameter.
	 *
	 * The method returns the framework to the default error page.
	 *
	 * @return TechDivision_Controller_Action_Forward
	 * 		Returns a ActionForward
	 */
	public function __defaultAction()
	{
		try {
		    // load the Request instance
		    $request = $this->_getRequest();
			// concatenate the the message to send
			$message = "";
			$message .= "Missing method parameter for " . get_class($this);
			if (($referer = $request->getReferer()) != null) {
			    // if a referer was found, add it
				$message .= " and referer " . $referer;
			}
			$message .= ".\n\nDump of Request parameters:\n\n" .
                var_export(
                    $request->getParameterMap()->toIndexedArray(), true
                ) . "\n\n";
			// throw an exception with the message
			throw new Exception($message);
		} catch(Exception $e) {
			// create, add and save the error
			$errors = new TechDivision_Controller_Action_Errors();
			$errors->addActionError(new TechDivision_Controller_Action_Error(
                TDProject_Core_Controller_Util_ErrorKeys::SYSTEM_ERROR,
                $e->__toString())
            );
			$this->_saveActionErrors($errors);
			// return the ActionForward to the system error page
			return $this->_findForward(
                TDProject_Core_Controller_Util_GlobalForwardKeys::SYSTEM_ERROR
            );
		}
	}

	/**
	 * Forward the framwork by using the information of the ActionForward
	 * with the passed name.
	 *
	 * @param string $name Name of the ActionForward to use
	 */
	public function forward($name)
	{
        return $this->_findForward($name);
	}

	/**
	 * Forward the framwork by using the information of the ActionForward
	 * with the passed name.
	 *
	 * @param string $name Name of the ActionForward to use
	 * @param boolean $redirect TRUE if a redirect has to be taken, else FALSE
	 * @return TechDivision_Controller_Interfaces_Action
	 * 		The instance itself
	 */
	public function forwardByUrl($url, $redirect = false)
	{
		// initialize the ActionForward instance
        $actionForward = new TechDivision_Controller_Action_Forward();
        $actionForward->setName(TDProject_Core_Controller_Abstract::SUCCESS);
        $actionForward->setPath($url);
        // check if a redirect has to be taken
        if ($redirect) {
        	$actionForward->setRedirect('true');
        }
		// set the ActionForward in the context
		$this->getContext()->setActionForward($actionForward);
		// the instance itself
		return $this;
	}

    /**
     * Sets the system user logged into the system.
 	 *
     * @param TDProject_Core_Common_ValueObjects_System_UserValue $systemUser The system user
     * @return void
     */
    protected function _setSystemUser(
        TDProject_Core_Common_ValueObjects_System_UserValue $systemUser)
    {
        // store the system user in the session
        $this->_getRequest()->getSession()->setAttribute(
            TDProject_Core_Controller_Util_WebSessionKeys::SYSTEM_USER,
            $systemUser
        );
    }

    /**
     * Returns the system user logged into the system.
     *
     * @return TDProject_Core_Common_ValueObjects_System_UserValue
     * 		The system user
     */
    protected function _getSystemUser()
    {
        return $this->_getRequest()->getSession()->getAttribute(
            TDProject_Core_Controller_Util_WebSessionKeys::SYSTEM_USER
        );
    }

    /**
     * Returns the system user logged into the system.
     *
     * @return TDProject_Core_Common_ValueObjects_System_UserValue
     * 		The system user
     */
    protected function _getAcl()
    {
        return $this->_getRequest()->getSession()->getAttribute(
            TDProject_Core_Controller_Util_WebSessionKeys::ACL
        );
    }

	/**
	 * This method saves the ActionErrors container passed as parameter
	 * in the request also passed as parameter.
	 *
	 * @param TechDivision_Controller_Action_Errors $actionErrors
	 * 		Holds the ActionErrors container that should be added to the Request
	 * @return void
	 */
	protected final function _saveActionErrors(
	    TechDivision_Controller_Action_Errors $actionErrors) {
		// adding the errors container to the request
		$this->_getRequest()->setAttribute(
            TechDivision_Controller_Action_Errors::ACTION_ERRORS,
            $actionErrors
        );
	}

	/**
	 * This method saves the ActionMessages container passed as parameter
	 * in the request also passed as parameter.
	 *
	 * @param TechDivision_Controller_Action_Messages $actionMessages
	 * 		Holds the ActionMessages container that should be added to the Request
	 * @return void
	 */
	protected final function _saveActionMessages(
	    TechDivision_Controller_Action_Messages $actionMessages) {
		// adding the messages container to the request
		$this->_getRequest()->setAttribute(
            TechDivision_Controller_Action_Messages::ACTION_MESSAGES,
            $actionMessages
        );
	}

	/**
	 * Overrides the method of the DispatchAction that is throwing an exception
	 * by default and returns the default name for the method that should be
	 * invoked when the Request parameter with the method name is missing.
	 *
	 * @return string The default method name to invoke
	 */
	protected function _getDefaultMethod()
	{
		return TDProject_Core_Controller_DispatchAction::DEFAULT_METHOD;
	}

	/**
	 * This method returns the logger of the requested
	 * type for logging purposes.
	 *
     * @param string The log type to use
	 * @return TechDivision_Logger_Logger Holds the Logger object
	 * @throws Exception Is thrown if the requested logger type is not initialized or doesn't exist
	 * @deprecated 0.6.24 - 2011/12/16
	 */
	protected function _getLogger(
        $logType = TechDivision_Logger_System::LOG_TYPE_SYSTEM)
    {
		return $this->getApp()->getLogger($logType);
    }

    /**
     * This method returns the logger of the requested
     * type for logging purposes.
     *
     * @param string The log type to use
     * @return TechDivision_Logger_Logger Holds the Logger object
     * @since 0.6.25 - 2011/12/16
     */
	public function getLogger(
        $logType = TechDivision_Logger_System::LOG_TYPE_SYSTEM)
	{
	    return $this->_getLogger($logType);
	}

	/**
	 * This method returns the delegate for calling
	 * the backend functions.
	 *
	 * @return TDProject_Core_Model_Services_DomainProcessor
	 * 		The requested processor
	 */
	protected function _getDelegate()
	{
        return TDProject_Core_Common_Delegates_DomainProcessorDelegateUtil::getDelegate($this->getApp());
	}

	/**
	 * Initializes the ActionForward and the Block with the
	 * passed name from the actual ActionMapping, registers
	 * the ActionForward in the Context and the Block in the
	 * Request.
	 *
	 * @param string $name The ActionForward to initialize
	 * @return void
	 * @see TDProject/Core/Controller/Abstract#_getBlock(TechDivision_Controller_Action_Forward $actionForward)
	 */
	protected function _findForward($name) {
        // load the ActionForward from the ActionMapping
	    $actionForward = $this->_getActionMapping()->findForward($name);
	    // check if a redirect has to be done
	    if (!$actionForward->isRedirect()) {
	        // if not initialize the Block
            $this->_getBlock($actionForward);
	    }
	    // set the ActionForward in the Context
	    $this->getContext()->setActionForward(
	        $actionForward
	    );
	    // return the ActionForward
	    return $actionForward;
	}

	/**
	 * Tries to load the Block class specified as path parameter
	 * in the ActionForward. If a Block was found and the class
	 * can be instanciated, the Block was registered to the Request
	 * with the path as key.
	 *
	 * @param TechDivision_Controller_Action_Forward $actionForward
	 * 		The ActionForward to initialize the Block for
	 * @return void
	 */
	protected function _getBlock(
	    TechDivision_Controller_Action_Forward $actionForward) {
	    // check if the class required to initialize the Block is included
	    if (!class_exists($path = $actionForward->getPath())) {
	        return;
	    }
        // initialize the array with the context as constructor argument
	    $context = array($this->getContext());
	    // initialize the page and add the Block
	    $page = $this->getApp()
	        ->newInstance('TDProject_Core_Block_Page', $context);
	    // if yes, create a new instance
	    $content = $this->getApp()
	        ->newInstance($path, $context);
        // set page title and content block
	    $page->setPageTitle($this->_getPageTitle());
	    $page->addBlock($content);
	    // register the block in the request
	    $this->_getRequest()->setAttribute($path, $page);
	}

	/**
	 * Setter method for the page title to be rendered.
	 *
	 * @param TechDivision_Lang_String $pageTitle
	 * 		The page title that has to be rendered
	 */
	protected function _setPageTitle(TechDivision_Lang_String $pageTitle) {
		$this->_pageTitle = $pageTitle;
	}

	/**
	 * Getter method for the page title to be rendered.
	 *
	 * @return TechDivision_Lang_String
	 * 		The page title to be rendered
	 */
	protected function _getPageTitle() {
		return $this->_pageTitle;
	}

	/**
	 * Returns the request parameter sanitized with the passed
	 * key as Integer or the default value if passed.
	 *
	 * @param string $key
	 * 		The key of the Request parameter to return
	 * @param integer $default
	 * 		Default value if the Request parameter is not available
	 */
	protected function _integerParam($key, $default, $add = 0) {
	    // load the value
	    $value = $this->_getRequest()->getParameter($key, FILTER_VALIDATE_INT);
	    // if a value was found
		if ($value != null) {
			if ($add > 0) {
				$value += $add;
			}
			return TechDivision_Lang_Integer::valueOf(
				new TechDivision_Lang_String($value)
			);
		}
		return new TechDivision_Lang_Integer($default);
	}

	/**
	 * Creates and sends a header to redirect to a given url.
	 * @param String $url
	 * @return void
	 */
	protected function _forward($url)
	{
	    header("location: $url");
	}

	/**
	 * Returns the request parameter sanitized with the passed
	 * key as String or the default value if passed.
	 *
	 * @param string $key
	 * 		The key of the Request parameter to return
	 * @param string $default
	 * 		Default value if the Request parameter is not available
	 */
	public function _stringParam($key, $default) {
	    // load the value
	    $value = $this->_getRequest()
	        ->getParameter($key, FILTER_SANITIZE_STRING);
		if ($value != null) {
			return new TechDivision_Lang_String($value);
		}
		return new TechDivision_Lang_String($default);
	}

	/**
	 * Returns the DTO with the query params to load the
	 * paged data based on the passed Request parameters.
	 *
	 * @return TDProject_Core_Common_ValueObjects_QueryParameterData
	 * 		The query parameter for loading paged records
	 */
	public function getQueryParams() {
		// initialize the query data
		$dto = new TDProject_Core_Common_ValueObjects_QueryParameterData(
			$this->_getSystemUser()->getUserId()
		);
		// initialize the start
		$dto->setStart(
			$this->_integerParam(
				TDProject_Core_Controller_Util_WebRequestKeys::DISPLAY_START,
				TDProject_Core_Common_ValueObjects_QueryParameterData
				    ::DEFAULT_START
			)
		);
		// initialize the length
		$dto->setLength(
			$this->_integerParam(
				TDProject_Core_Controller_Util_WebRequestKeys::DISPLAY_LENGTH,
				TDProject_Core_Common_ValueObjects_QueryParameterData
				    ::DEFAULT_LENGTH
			)
		);
		// initialize the sort column
		$dto->setSortColumn(
			$this->_integerParam(
				TDProject_Core_Controller_Util_WebRequestKeys::SORT_COLUMN,
				TDProject_Core_Common_ValueObjects_QueryParameterData
				    ::DEFAULT_SORT_COLUMN,
				1
			)
		);
		// initialize the sort direction
		$dto->setSortDir(
			$this->_stringParam(
				TDProject_Core_Controller_Util_WebRequestKeys::SORT_DIR,
				TDProject_Core_Common_ValueObjects_QueryParameterData
				    ::DEFAULT_SORT_DIR
			)
		);
		// initialize the search value
		$dto->setSearch(
			$this->_stringParam(
				TDProject_Core_Controller_Util_WebRequestKeys::SEARCH,
				TDProject_Core_Common_ValueObjects_QueryParameterData
				    ::DEFAULT_SEARCH
			)
		);
		// return the initialized DTO
		return $dto;
	}

    /**
     * Returns the application instance itself
     * from the controllers Context.
     *
     * @return TDProject_Application The application instance
     */
    public function getApp()
    {
    	return $this->getContext()
    	    ->getAttribute(TDProject_Application::CONTEXT);
    }

    /**
    * @see TDProject_Application::getUrl(array $params = array()
    */
    public function getUrl(array $params = array())
    {
        return $this->getApp()->getUrl($params);
    }

    /**
     * Returns the translation for the passed key.
     *
     * If no translation can be found, the key itself will be returned.
     *
     * @param string $key The key to return the translation for
     * @param string $module The module name to return the translation for
     * @param TechDivision_Collections_ArrayList $parameter The parameters
     * @param TechDivision_Lang_String $default The default translation
     * @return string The translation
     */
    public function translate(
    	$key, 
    	$module = null,
        TechDivision_Collections_ArrayList $parameter = null,
	    TechDivision_Lang_String $default = null)
    {
        // check if a module name has been passed
        if (empty($module)) {
            // if not, use the module name of the extending class
            $module = $this->getModuleName();
        } else {
            $module = new TechDivision_Lang_String($module);
        }
        // try to translate the passed key
        $translated = $this->getApp()->translate(
            new TechDivision_Lang_String($key),
            $module,
            $parameter,
            $default
        );
        // if now translation for the key is available, return the key itself
        if (empty($translated)) {
            $translated = $key;
        }
        // return the translation
        return $translated;
    }

    /**
     * Returns the module name to use for e. g. translation.
     *
     * @param TechDivision_Lang_String
     * 		The requested module name
     */
    public function getModuleName()
    {
        // load namespace and modules name of the actual class
        list($namespace, $module)  = explode('_', get_class($this));
        // return the module name
        return new TechDivision_Lang_String($module);
    }

    /**
     * Returns the privilege that usually is the method
     * name, to check the ACL if the user is allowed to
     * request the resource.
     *
     * @return string The privilege
     */
    public function getPrivilege()
    {
        // check if a method (ACL privilege) was passed
        $privilege = $this->_getRequest()->getAttribute(
        	$this->_getActionMapping()->getParameter()
        );
        // if not found try to load it as Request attribute
        if ($privilege == null) {
            $privilege = $this->_getRequest()->getParameter(
            	$this->_getActionMapping()->getParameter(),
                FILTER_SANITIZE_STRING
            );
            // if not found set the default method name
            if ($privilege == null) {
                $privilege = TechDivision_Controller_Action_DispatchAction
                    ::DEFAULT_METHOD;
            }
        }
        // return the requested privilege
        return $privilege;
    }

    /**
     * (non-PHPdoc)
     * @see Zend/Acl/Resource/Interface::getResourceId()
     */
    public function getResourceId()
    {
        // return the resource ID alias the ActionMapping::getPath()
    	return $this->_getActionMapping()->getPath();
    }
}