<?php

/**
 * TDProject_Core_Block_Resource_View
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
require_once 'TDProject/Core/Block/Abstract/Resource.php';
require_once 'TDProject/Core/Common/ValueObjects/ResourceViewData.php';

/**
 * @category    TDProject
 * @package     TDProject_Core
 * @copyright   Copyright (c) 2010 <info@techdivision.com> - TechDivision GmbH
 * @license     http://opensource.org/licenses/osl-3.0.php
 *              Open Software License (OSL 3.0)
 * @author      Tim Wagner <tw@techdivision.com>
 */
class TDProject_Core_Block_Resource_View
	extends TDProject_Core_Block_Abstract_Resource {

    /**
     * The available system locales.
     * @var TechDivision_Collections_ArrayList
     */
    protected $_locales = null;

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
    public function prepareLayout()
    {
    	// initialize the tabs
    	$tabs = $this->addTabs('tabs', 'Resourcese');
        // add the tab for the user data
        $tabs->addTab('resources', 'Resources')
        	->addFieldset('resources', 'Resources')
        		->addElement(
        		    $this->getElement('textfield', 'key', 'Key')
        		        ->setMandatory()
        		)
	        	->addElement(
	        	    $this->getElement('select', 'resourceLocale', 'Locale')
	        	        ->setOptions($this->getLocales())
	        	)
        		->addElement(
        		    $this->getElement('textfield', 'message', 'Message')
        		        ->setMandatory()
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
        $this->_locales = new TechDivision_Collections_ArrayList();
        $this->_resourceLocale = 
            TechDivision_Util_SystemLocale::getDefault()->toString();
    }

    /**
     * Populates the ActionForm with the values
     * of the passed DTO.
     *
     * @param TDProject_Core_Common_ValueObjects_ResourceViewData $dto
     * 		The DTO with the data to initialize the ActionForm with
     * @return void
     */
    function populate(
        TDProject_Core_Common_ValueObjects_ResourceViewData $dto) {
    	parent::populate($dto);
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
    function validate()
    {
        // initialize the ActionErrors
        $errors = new TechDivision_Controller_Action_Errors();
        // check if a message key was entered
        if ($this->_key->length() == 0) {
            $errors->addActionError(
                new TechDivision_Controller_Action_Error(
                    TDProject_Core_Controller_Util_ErrorKeys::KEY,
                    $this->translate('key.none')
                )
            );
        }
        // check if a message value was entered
        if ($this->_message->length() == 0) {
            $errors->addActionError(
                new TechDivision_Controller_Action_Error(
                    TDProject_Core_Controller_Util_ErrorKeys::MESSAGE,
                    $this->translate('message.none')
                )
            );
        }
        // return the ActionErrors
        return $errors;
    }
}