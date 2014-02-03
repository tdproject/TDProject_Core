<?php

/**
 * TDProject_Core_Block_Widget_Grid_Column_Actions_Abstract
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

require_once 'TechDivision/Lang/Object.php';
require_once 'TDProject/Core/Interfaces/Block/Widget/Grid/Column/Action.php';

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
abstract class TDProject_Core_Block_Widget_Grid_Column_Actions_Abstract
    extends TechDivision_Lang_Object
    implements TDProject_Core_Interfaces_Block_Widget_Grid_Column_Action {

    /**
     * The Action's context.
     * @var TechDivision_Controller_Interfaces_Context
     */
    protected $_context = null;

    /**
     * The URL to invoke when the option is selected.
     * @var string
     */
    protected $_url = '';

    /**
     * The option label.
     * @var string
     */
    protected $_label = '';

    /**
     * The name of the property with the ID.
     * @var string
     */
    protected $_property = '';

    /**
     * Initialize the block with the
     * apropriate template and name.
     *
     * @return void
     */
    public function __construct(
        TechDivision_Controller_Interfaces_Context $context,
        $property,
        $url) {
        $this->_setContext($context);
    	$this->_setProperty($property);
    	$this->_setUrl($url);
    }

    /**
     * Sets the URL to invoke when the Action is selected.
     *
     * @param string $url
     * 		The URL to invoke
     */
    protected function _setUrl($url)
    {
    	$this->_url = $url;
    }

    /**
     * (non-PHPdoc)
     * @see TDProject_Core_Block_Abstract::getUrl()
     */
    public function getUrl()
    {
    	return $this->_url;
    }

    /**
     * Sets the Action's label.
     *
     * @param string $label The Action's label
     */
    protected function _setLabel($label)
    {
    	$this->_label = $label;
    }

    /**
     * (non-PHPdoc)
     * @see TDProject_Core_Interfaces_Block_Widget_Grid_Column::getLabel()
     */
    public function getLabel() {
    	return $this->_label;
    }

    /**
     * Sets the objects property for the ID
     * necessary for creating the URL.
     *
     * @param string $property The property with the ID
     */
    protected function _setProperty($property)
    {
    	$this->_property = $property;
    }

    /**
     * (non-PHPdoc)
     * @see TDProject_Core_Block_Widget_Grid_Column::getProperty()
     */
    public function getProperty() {
    	return $this->_property;
    }

    /**
     * Sets the Action's context.
     *
     * @param TechDivision_Controller_Interfaces_Context $context
     * 		The Action's context
     */
    protected function _setContext(
        TechDivision_Controller_Interfaces_Context $context) {
        $this->_context = $context;
    }

    /**
     * (non-PHPdoc)
     * @see TDProject_Core_Interfaces_Block_Widget_Grid_Column_Action::getContext()
     */
    public function getContext()
    {
        return $this->_context;
    }

    /**
     * Returns the application instance itself
     * from the controllers Context.
     *
     * @return TDProject_Application The application instance
     */
    public function getApp() {
    	return $this->getContext()
    	    ->getAttribute(TDProject_Application::CONTEXT);
    }

    /**
     * Returns the translation for the passed key.
     *
     * If no translation can be found, the key itself will be returned.
     *
     * @param string $key The key to return the translation for
     * @param string $module The module name to return the translation for
     * @return string The translation
     */
    public function translate($key)
    {
        // try to translate the passed key
        $translated = $this->getApp()->translate(
            new TechDivision_Lang_String($key),
            new TechDivision_Lang_String(
                TDProject_Core_Block_Widget_Abstract::MESSAGE_RESOURCES
            )
        );
        // if now translation for the key is available, return the key itself
        if (empty($translated)) {
            $translated = $key;
        }
        // return the translation
        return $translated;
    }
}