<?php

/**
 * TDProject_Core_Controller_Setting
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

require_once 'TDProject/Core/Controller/Abstract.php';
require_once 'TDProject/Core/Block/Setting/View.php';
require_once 'TDProject/Core/Common/ValueObjects/SettingLightValue.php';

/**
 * @category   	TDProject
 * @package    	TDProject_Core
 * @copyright  	Copyright (c) 2010 <info@techdivision.com> - TechDivision GmbH
 * @license    	http://opensource.org/licenses/osl-3.0.php
 * 				Open Software License (OSL 3.0)
 * @author      Bastian Stangl <b.stangl@techdivision.com>
 */
class TDProject_Core_Controller_Setting
    extends TDProject_Core_Controller_Abstract {

	/**
	 * The key for the ActionForward to the setting view template.
	 * @var string
	 */
	const SETTING_VIEW = "SettingView";

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
		 $this->_setPageTitle(new TechDivision_Lang_String('TDProject, v2.0 - Settings'));
	}

	/**
	 * This method is automatically invoked by the controller and implements
	 * the functionality to load the settings for editing them.
	 *
	 * @return TechDivision_Controller_Action_Forward Returns a ActionForward
	 */
	function __defaultAction()
	{
        try {
            // initialize the ActionForm with the data from the DTO
            $this->_getActionForm()->populate(
                $dto = $this->_getDelegate()->getSettingViewData()
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
        // return to the setting detail page
        return $this->_findForward(
            TDProject_Core_Controller_Setting::SETTING_VIEW
        );
	}

	/**
	 * This method is automatically invoked by the controller and implements
	 * the functionality to save the passed settings.
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
                return $this->_findForward(
                    TDProject_Core_Controller_Setting::SETTING_VIEW
                );
            }
			// initialize a new LVO
			$lvo = new TDProject_Core_Common_ValueObjects_SettingLightValue();
			// filling it with the channel data from the Request
			$lvo->setSettingId($actionForm->getSettingId());
			$lvo->setEmailSupport($actionForm->getEmailSupport());
			$lvo->setMediaDirectory($actionForm->getMediaDirectory());
			$lvo->setUseLdap($actionForm->getUseLdap());
			$lvo->setLdapHost($actionForm->getLdapHost());
			$lvo->setLdapBindRequired($actionForm->getLdapBindRequired());
			$lvo->setLdapDomain($actionForm->getLdapDomain());
			$lvo->setLdapDn($actionForm->getLdapDn());
			$lvo->setUseSmtp($actionForm->getUseSmtp());
			$lvo->setSmtpHost($actionForm->getSmtpHost());
			$lvo->setSmtpPort($actionForm->getSmtpPort());
			$lvo->setSmtpUser($actionForm->getSmtpUser());
			$lvo->setSmtpPassword($actionForm->getSmtpPassword());
			$lvo->setWebserviceUri($actionForm->getWebserviceUri());
			$lvo->setWsdlUri($actionForm->getWsdlUri());
			// save the settings
			$this->_getDelegate()->saveSetting($lvo);
			// create the affirmation message
	        $actionMessages = new TechDivision_Controller_Action_Messages();
            $actionMessages->addActionMessage(
                new TechDivision_Controller_Action_Message(
                    TDProject_Core_Controller_Util_MessageKeys::AFFIRMATION,
                    $this->translate('settingUpdate.successfull')
                )
            );
            // save the ActionMessages in the request
            $this->_saveActionMessages($actionMessages);
		}
		catch(Exception $e) {
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
		// return to the setting detail page
        return $this->__defaultAction();
	}

	/**
	 * This method is automatically invoked by the controller and implements
	 * the functionality run the system update process.
	 *
	 * @return TechDivision_Controller_Action_Forward Returns a ActionForward
	 */
	public function systemUpdateAction()
	{
		try {
			// run the system update
			$this->_getDelegate()->runSystemUpdate();
		}
		catch(Exception $e) {			
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
		// return to the setting detail page
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