<?php

/**
 * TDProject_Core_Controller_Resource
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

require_once 'TDProject/Core/Controller/Abstract.php';
require_once 'TDProject/Core/Common/ValueObjects/ResourceViewData.php';
require_once 'TDProject/Core/Common/ValueObjects/ResourceLightValue.php';
require_once 'TDProject/Core/Block/Resource/Overview.php';
require_once 'TDProject/Core/Block/Resource/View.php';

/**
 * @category   	TDProject
 * @package    	TDProject_Core
 * @copyright  	Copyright (c) 2010 <info@techdivision.com> - TechDivision GmbH
 * @license    	http://opensource.org/licenses/osl-3.0.php
 * 				Open Software License (OSL 3.0)
 * @author      Tim Wagner <tw@techdivision.com>
 */
class TDProject_Core_Controller_Resource
    extends TDProject_Core_Controller_Abstract {

	/**
	 * The key for the ActionForward to the user overview template.
	 * @var string
	 */
	const RESOURCE_OVERVIEW = "ResourceOverview";

	/**
	 * The key for the ActionForward to the user view template.
	 * @var string
	 */
	const RESOURCE_VIEW = "ResourceView";

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
        // call the parent method
        parent::__construct($context);
		 // initialize the default page title
		 $this->_setPageTitle(
		     new TechDivision_Lang_String('TDProject, v2.0 - Resources')
		 );
	}

	/**
	 * This method is automatically invoked by the controller and implements
	 * the functionality to load a list with with the Application's resources.
	 *
	 * @return TechDivision_Controller_Action_Forward Returns a ActionForward
	 */
	function __defaultAction()
	{
		try {
			// replace the default ActionForm
			$this->getContext()->setActionForm(
				new TDProject_Core_Block_Resource_Overview($this->getContext())
			);
            // load and register the user overview data
            $this->_getRequest()->setAttribute(
            	TDProject_Core_Controller_Util_WebRequestKeys::OVERVIEW_DATA,
            	$this->_getDelegate()->getResourceOverviewData()
            );
		} catch(Exception $e) {
			// create and add and save the error
			$errors = new TechDivision_Controller_Action_Errors();
			$errors->addActionError(
			    new TechDivision_Controller_Action_Error(
                    TDProject_Core_Controller_Util_Errorkeys::SYSTEM_ERROR,
                    $e->__toString()
                )
            );
			// adding the errors container to the Request
			$this->_saveActionErrors($errors);
			// set the ActionForward in the Context
			return $this->_findForward(
			    TDProject_Core_Controller_Util_GlobalForwardKeys::SYSTEM_ERROR
			);
		}
		// go to the standard page
		return $this->_findForward(
		    TDProject_Core_Controller_Resource::RESOURCE_OVERVIEW
		);
	}


	/**
	 * This method is automatically invoked by the controller and implements
	 * the functionality to load the resource data with the id passed in the
	 * Request for editing it.
	 *
	 * @return TechDivision_Controller_Action_Forward Returns a ActionForward
	 */
	function editAction()
	{
        try {
            // try to load the resource ID from the Request
            $resourceId = $this->_getRequest()
                ->getAttribute(
                    TDProject_Core_Controller_Util_WebRequestKeys::RESOURCE_ID
                );
            // check if a resource ID can be found
            if ($resourceId == null) {
                $resourceId = $this->_getRequest()->getParameter(
                    TDProject_Core_Controller_Util_WebRequestKeys::RESOURCE_ID,
                    FILTER_VALIDATE_INT
                );
            }
            // initialize the ActionForm with the data from the DTO
            $this->_getActionForm()->populate(
                $dto = $this->_getDelegate()->getResourceViewData(
                    TechDivision_Lang_Integer::valueOf(
                        new TechDivision_Lang_String($resourceId)
                    )
                )
            );
            // register the DTO in the Request
            $this->_getRequest()->setAttribute(
                TDProject_Core_Controller_Util_WebRequestKeys::VIEW_DATA,
                $dto
            );
        } catch(Exception $e) {
			// create and add and save the error
			$errors = new TechDivision_Controller_Action_Errors();
			$errors->addActionError(
			    new TechDivision_Controller_Action_Error(
                    TDProject_Core_Controller_Util_Errorkeys::SYSTEM_ERROR,
                    $e->__toString()
                )
            );
			// adding the errors container to the Request
			$this->_saveActionErrors($errors);
			// set the ActionForward in the Context
			return $this->_findForward(
			    TDProject_Core_Controller_Util_GlobalForwardKeys::SYSTEM_ERROR
			);
		}
        // return to the user detail page
        return $this->_findForward(
            TDProject_Core_Controller_Resource::RESOURCE_VIEW
        );
	}

   /**
     * This method is automatically invoked by the controller and implements
     * the functionality to create a new resource message.
     *
	 * @return TechDivision_Controller_Action_Forward Returns a ActionForward
     */
    function createAction()
    {
        try {
            // set the available roles
            $this->_getActionForm()->setLocales(
                $this->_getDelegate()->getResourceViewData()->getLocales()
            );
        } catch(Exception $e) {
            // create and add and save the error
            $errors = new TechDivision_Controller_Action_Errors();
            $errors->addActionError(
                new TechDivision_Controller_Action_Error(
                    TDProject_Core_Controller_Util_ErrorKeys::SYSTEM_ERROR,
                    $e->__toString()
                )
            );
            // adding the errors container to the Request
			$this->_saveActionErrors($errors);
			// set the ActionForward in the Context
			return $this->_findForward(
			    TDProject_Core_Controller_Util_GlobalForwardKeys::SYSTEM_ERROR
			);
        }
        // return to the resource detail page
        return $this->_findForward(
            TDProject_Core_Controller_Resource::RESOURCE_VIEW
        );
    }

	/**
	 * This method is automatically invoked by the controller and implements
	 * the functionality to save the passed resource message data.
	 *
	 * @return TechDivision_Controller_Action_Forward Returns a ActionForward
	 */
	function saveAction()
	{
		try {
		    // load the ActionForm
		    $actionForm = $this->_getActionForm();
		    // validate the ActionForm with the login credentials
            $actionErrors = $actionForm->validate();
            if (($errorsFound = $actionErrors->size()) > 0) {
                $this->_saveActionErrors($actionErrors);
                return $this->createAction();
            }
			// initialize a new LVO
			$lvo = new TDProject_Core_Common_ValueObjects_ResourceLightValue();
			// filling it with the resource message data from the Request
			$lvo->setResourceId($actionForm->getResourceId());
			$lvo->setKey($actionForm->getKey());
			$lvo->setResourceLocale($actionForm->getResourceLocale());
			$lvo->setMessage($actionForm->getMessage());
			// save the resource message
			$resourceId = $this->_getDelegate()->saveResource($lvo);
			// store the id of the resource message in the Request
			$this->_getRequest()->setAttribute(
                TDProject_Core_Controller_Util_WebRequestKeys::RESOURCE_ID,
                $resourceId->intValue()
            );
			// create the affirmation message
	        $actionMessages = new TechDivision_Controller_Action_Messages();
            $actionMessages->addActionMessage(
                new TechDivision_Controller_Action_Message(
                    TDProject_Core_Controller_Util_MessageKeys::AFFIRMATION,
                    $this->translate('resourceUpdate.successfull')
                )
            );
            // save the ActionMessages in the request
            $this->_saveActionMessages($actionMessages);
		} catch(Exception $e) {
			// create and add and save the error
			$errors = new TechDivision_Controller_Action_Errors();
			$errors->addActionError(
                new TechDivision_Controller_Action_Error(
                    TDProject_Core_Controller_Util_ErrorKeys::SYSTEM_ERROR,
                    $e->__toString()
                )
            );
			// adding the errors container to the Request
			$this->_saveActionErrors($errors);
			// set the ActionForward in the Context
			return $this->_findForward(
			    TDProject_Core_Controller_Util_GlobalForwardKeys::SYSTEM_ERROR
			);
		}
		// return to the resource detail page
        return $this->editAction();
	}

	/**
     * This method is automatically invoked by the controller and implements
     * the functionality to delete the passed resource message.
     *
	 * @return TechDivision_Controller_Action_Forward Returns a ActionForward
     */
    function deleteAction()
    {
        try {
            // load the resource ID from the request
        	$resourceId = $this->_getRequest()->getParameter(
                TDProject_Core_Controller_Util_WebRequestKeys::RESOURCE_ID,
                FILTER_VALIDATE_INT
            );
            // delete the resource message
            $this->_getDelegate()->deleteResource(
                TechDivision_Lang_Integer::valueOf(
                    new TechDivision_Lang_String($resourceId)
                )
            );
        } catch(Exception $e) {
            // create and add and save the error
            $errors = new TechDivision_Controller_Action_Errors();
            $errors->addActionError(
                new TechDivision_Controller_Action_Error(
                    TDProject_Core_Controller_Util_ErrorKeys::SYSTEM_ERROR,
                    $e->__toString()
                )
            );
            // adding the errors container to the Request
			$this->_saveActionErrors($errors);
			// set the ActionForward in the Context
			return $this->_findForward(
			    TDProject_Core_Controller_Util_GlobalForwardKeys::SYSTEM_ERROR
			);
        }
        // return to the resource overview page
        return $this->__defaultAction();
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
	    // initialize the page and add the Block
	    $page = new TDProject_Core_Block_Page($this->getContext());
	    $page->setPageTitle($this->_getPageTitle());
	    $page->addBlock($this->getContext()->getActionForm());
	    // register the Block in the Request
	    $this->_getRequest()->setAttribute($path, $page);
	}
}