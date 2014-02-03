<?php

/**
 * TDProject_Core_Block_Setting_View
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
require_once 'TDProject/Core/Block/Abstract/Setting.php';

/**
 * This class implements the form functionality
 * for handling the application settings.
 *
 * @category    TProject
 * @package     TDProject_Core
 * @copyright   Copyright (c) 2010 <info@techdivision.com> - TechDivision GmbH
 * @license     http://opensource.org/licenses/osl-3.0.php
 *              Open Software License (OSL 3.0)
 * @author      Bastian Stangl <b.stangl@techdivision.com>
 */

class TDProject_Core_Block_Setting_View
    extends TDProject_Core_Block_Abstract_Setting {

	/**
     * (non-PHPdoc)
     * @see TDProject/Interfaces/Block#prepareLayout()
     */
    public function prepareLayout() {
		// call the parent method
    	parent::prepareLayout();
    	// remove the unnecessary toolbar buttons
    	$this->getToolbar()
    		->removeButton(
    		    TDProject_Core_Block_Widget_Button_Back::BLOCK_NAME
    		)
    		->removeButton(
    		    TDProject_Core_Block_Widget_Button_Delete::BLOCK_NAME
    		)
    		->addButton(
			    new TDProject_Core_Block_Widget_Button_CleanCache(
			        $this,
			        $this->translate(
			        	'widget.button.clean-cache',
			            TDProject_Core_Block_Widget_Abstract::MESSAGE_RESOURCES
			        )
			    )
    		)
    		->addButton(
			    new TDProject_Core_Block_Widget_Button_SystemUpdate(
			        $this,
			        $this->translate(
			        	'widget.button.system-update',
			            TDProject_Core_Block_Widget_Abstract::MESSAGE_RESOURCES
			        )
			    )
    		);
    	// initialize the tabs
    	$tabs = $this->addTabs('tabs', 'Tabs');
        // add the tab for the global settings
        $tabs->addTab(
        	'settings',
            $this->translate('setting.view.tab.label.settings')
        )
    	->addFieldset(
    		'settings',
    	    $this->translate('setting.view.fieldset.label.settings')
    	 )
		->addElement(
		    $this->getElement(
		    	'textfield',
		    	'emailSupport',
		        $this->translate('setting.view.label.email-support')
		    )
		 )
		->addElement(
		    $this->getElement(
		    	'textfield',
		    	'mediaDirectory',
		        $this->translate('setting.view.label.media-directory')
		    )
		);
        // add the tab for the LDAP settings
		$tabs->addTab(
			'ldap',
		    $this->translate('setting.view.tab.label.ldap')
		)
    	->addFieldset(
    		'ldap',
    	    $this->translate('setting.view.fieldset.label.ldap')
	    )
    	->addElement(
    	    $this->getElement(
    	    	'checkbox',
    	    	'useLdap',
    	        $this->translate('setting.view.label.use-ldap')
    	    )
    	)
    	->addElement(
    	    $this->getElement(
    	    	'textfield',
    	    	'ldapHost',
    	        $this->translate('setting.view.label.ldap-host')
    	    )
    	)
    	->addElement(
    	    $this->getElement(
    	    	'checkbox',
    	    	'ldapBindRequired',
    	        $this->translate('setting.view.label.ldap-bind-required')
    	    )
    	)
    	->addElement(
    	    $this->getElement(
    	    	'textfield',
    	    	'ldapDomain',
    	        $this->translate('setting.view.label.ldap-domain')
    	    )
    	)
    	->addElement(
    	    $this->getElement(
    	    	'textfield',
    	    	'ldapDn',
    	        $this->translate('setting.view.label.ldap-dn')
    	    )
    	);
        // add the tab for the SMTP settings
		$tabs->addTab(
			'smtp',
		    $this->translate('setting.view.tab.label.smtp')
		)
		->addFieldset(
			'smtp',
		    $this->translate('setting.view.fieldset.label.smtp')
		)
    	->addElement(
    	    $this->getElement(
    	    	'checkbox',
    	    	'useSmtp',
    	        $this->translate('setting.view.label.use-smtp')
    	    )
    	)
    	->addElement(
    	    $this->getElement(
    	    	'textfield',
    	    	'smtpHost',
    	        $this->translate('setting.view.label.smtp-host')
    	    )
    	)
    	->addElement(
    	    $this->getElement(
    	    	'textfield',
    	    	'smtpPort',
    	        $this->translate('setting.view.label.smtp-port')
    	    )
    	)
    	->addElement(
    	    $this->getElement(
    	    	'textfield',
    	    	'smtpUser',
    	        $this->translate('setting.view.label.smtp-user')
    	    )
    	)
    	->addElement(
    	    $this->getElement(
    	    	'password',
    	    	'smtpPassword',
    	        $this->translate('setting.view.label.smtp-password')
    	    )
    	);



		// add the tab for the global settings
		$tabs->addTab(
			'webservice',
		    $this->translate('setting.view.tab.label.webservice')
		)
		->addFieldset(
			'webservice',
		    $this->translate('setting.view.fieldset.label.webservice')
		)
    	->addElement(
    	    $this->getElement(
    	    	'textfield',
    	    	'webserviceUri',
    	        $this->translate('setting.view.label.webservice-uri')
    	    )
    	)
		->addElement(
    		$this->getElement(
    			'textfield',
    			'wsdlUri',
    		    $this->translate('setting.view.label.wsdl-uri')
    		)
		);


	    // return the instance itself
	    return $this;
    }

    /**
     * This method checks if the values in the member variables
     * holds valid data. If not, a ActionErrors container will
     * be initialized an for every incorrect value a ActionError
     * object with the apropriate error message will be added.
     *
     * @return ActionErrors
     * 		Returns a ActionErrors container with ActionError objects
     */
    function validate() {
        // initialize the ActionErrors
        $errors = new TechDivision_Controller_Action_Errors();
        // check if a valid support email was entered
        if (filter_var($this->_emailSupport, FILTER_VALIDATE_EMAIL) === false) {
            $errors->addActionError(
                new TechDivision_Controller_Action_Error(
                    TDProject_Core_Controller_Util_ErrorKeys::EMAIL_SUPPORT,
                    $this->translate('emailSupport.invalid')
                )
            );
        }
        // return the ActionErrors
        return $errors;
    }
}