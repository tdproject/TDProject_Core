<?php

/**
 * TDProject_Core_Block_Abstract
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

require_once 'Zend/Date.php';
require_once 'TechDivision/Lang/Boolean.php';
require_once 'TechDivision/Logger/Logger.php';
require_once 'TechDivision/Logger/System.php';
require_once 'TechDivision/Logger/Mail.php';
require_once 'TDProject/Interfaces/Translator.php';
require_once 'TDProject/Interfaces/Translateable.php';
require_once 'TDProject/Core/Interfaces/Block.php';
require_once 'TechDivision/Controller/Interfaces/Context.php';
require_once 'TechDivision/Controller/Action/AbstractActionForm.php';
require_once 'TechDivision/Controller/Action/Errors.php';
require_once 'TDProject/Core/Interfaces/Block/Widget/Script.php';
require_once 'TDProject/Core/Interfaces/Block/Widget/Link.php';

/**
 * @category    TDProject
 * @package     TDProject
 * @copyright   Copyright (c) 2010 <info@techdivision.com> - TechDivision GmbH
 * @license     http://opensource.org/licenses/osl-3.0.php
 *              Open Software License (OSL 3.0)
 * @author      Tim Wagner <tw@techdivision.com>
 */
abstract class TDProject_Core_Block_Abstract
    extends TechDivision_Controller_Action_AbstractActionForm
    implements TDProject_Core_Interfaces_Block,
        TDProject_Interfaces_Translateable {

	/**
	 * The default block name for the content element.
	 * @var string
	 */
	const BLOCK_NAME = 'content';

	/**
	 * The Translator instance.
	 * @var TDProject_Core_Interfaces_Translator
	 */
	protected $_translator = null;

	/**
	 * The parent block.
	 * @var TDProject_Core_Interfaces_Block
	 */
	protected $_parent = null;

    /**
     * The internal block name used by the _getChildHtml() method.
     * @var string
     */
    protected $_blockName = 'content';

    /**
     * The block title used for e. g. rendering a page or navigation title.
     * @var string
     */
    protected $_blockTitle = '';

    /**
     * The blocks child blocks.
     * @var array
     */
    protected $_childs = array();

    /**
     * Reference to the application instance.
     * @var TDProject_Application
     */
    protected $_app = null;

	/**
	 * Flag for allow auto rendering as child block
	 * @var TechDivision_Lang_Boolean
	 */
	protected $_isAutoRender = null;

	/**
	 * TRUE if the block is already rendered, else FALSE
	 * @var boolean
	 */
	protected $_rendered = false;

	/**
	 * CSS ID for the block rendering
	 * @var string
	 */
	protected $_cssId = '';

	/**
	 * CSS class for the block rendering
	 * @var string
	 */
	protected $_cssClass = '';

	/**
	 * Standardconstructor to initialize the
	 * necessary members and the logger.
	 *
     * @param TechDivision_Controller_Interfaces_Context $context
     * 		The Context for the actual Request
	 * @return void
	 */
	public function __construct(
        TechDivision_Controller_Interfaces_Context $context) {
        // call the constructor of the superclass
        parent::__construct($context);
        // set the Application instance
    	$this->setApp(
    	    $this->getContext()
    	        ->getAttribute(TDProject_Application::CONTEXT)
    	);
    	// set the Translator instance
    	$this->setTranslator($this->getApp());
        // initialize the auto rendering
        $this->_isAutoRender = new TechDivision_Lang_Boolean(true);
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
	protected final function _getLogger(
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
	protected final function getLogger(
        $logType = TechDivision_Logger_System::LOG_TYPE_SYSTEM)
    {
        return $this->getLogger($logType);
	}

	/**
	 * The internal block name used by the
	 * _getChildHtml() method.
	 *
	 * @param string $blockName The internal name
	 * @return void
	 */
	protected function _setBlockName($blockName)
	{
	    $this->_blockName = $blockName;
	}

	/**
	 * The block title used for e. g. rendering a page
	 * or navigation title..
	 *
	 * @param string $blockTitle The block's title
	 * @return void
	 */
	protected function _setBlockTitle($blockTitle)
	{
	    $this->_blockTitle = $blockTitle;
	}

	/**
	 * Sets the template name used when rendering the
	 * block.
	 *
	 * @param string $template Template name
	 * @return void
	 * @see TDProject_Block_Abstract::toHtml()
	 */
    protected function _setTemplate($template)
    {
        $this->_template = $template;
    }

    /**
	 * Sets the auto render flag
	 *
	 * @param boolead $allowed
	 * @return void
	 */
    protected function _setAutoRender($allowed)
    {
        $this->_isAutoRender = new TechDivision_Lang_Boolean($allowed);
    }

    /**
	 * Sets the css id for block rendering
	 *
	 * @param string $css_id
	 * @return void
	 */
    protected function _setCssId($cssId)
    {
        $this->_cssId = $cssId;
    }

    /**
	 * Sets the css class for block rendering
	 *
	 * @param string $css_class
	 * @return void
	 */
    protected function _setCssClass($cssClass)
    {
        $this->_cssClass = $cssClass;
    }

    /**
	 * Sets the template name used when rendering the
	 * block.
	 *
	 * @return string The template name
     */
    protected  function _getTemplate()
    {
        return $this->_template;
    }

    /**
	 * Returns the child block instance with the
	 * passed name.
	 *
	 * @param string $blockName
	 * 		The name of the requested block instance
	 * @return TDProject_Block_Interface
	 * 		The requested block instance
     */
    protected function _getBlock($blockName)
    {
        // check if the requested block exists, if not throw an exception
        if (!array_key_exists($blockName, $this->_childs)) {
            throw new Exception(
            	'Block with name ' . $blockName . ' is not registered'
            );
        }
        // return the block instance
        return $this->_childs[$blockName];
    }

    /**
     * Loads the child block with the passed name
     * and calls the toHtml() method.

     * @param string $blockName The block name to render
     * @see TDProject/Interfaces/Block#toHtml()
     */
    protected function _getChildHtml($blockName)
    {
        // load and render the requested block
        $this->_getBlock($blockName)->toHtml();
    }

    /**
     * Returns the block's child elements.
     *
     * @return array The child elements
     */
    protected function _getChilds()
    {
    	return $this->_childs;
    }

	/**
     * (non-PHPdoc)
     * @see TDProject/Interfaces/Block#prepareLayout()
     */
    public function prepareLayout()
    {
        // iterate over the childs and prepare their layout
        foreach ($this->_childs as $child) {
            $child->prepareLayout();
        }
        // return a reference to the block itself
        return $this;
    }

	/**
     * (non-PHPdoc)
     * @see TDProject/Interfaces/Block#addBlock(TDProject_Core_Interfaces_Block $block)
     */
    public function addBlock(TDProject_Core_Interfaces_Block $block)
    {
        // add the block and return a reference to the block itself
        $this->_childs[$block->getBlockName()] = $block->setParent($this);
        return $this;
    }

	/**
     * (non-PHPdoc)
     * @see TDProject/Interfaces/Block#getBlockName()
     */
    public function getBlockName()
    {
        return $this->_blockName;
    }

	/**
     * (non-PHPdoc)
     * @see TDProject/Interfaces/Block#getBlockTitle()
     */
    public function getBlockTitle()
    {
        return $this->_blockTitle;
    }

    /**
     * (non-PHPdoc)
     * @see TDProject_Core_Interfaces_Block::getBlockPath()
     */
    public function getBlockPath()
    {
        // initialize the block path
        $blockPath = $this->getBlockName();
        // check if the block has a parent one
        if ($this->getParent()) {
            // if yes, prepend the parent block path
            $blockPath = $this->getParent()->getBlockPath() . '.' .
                $this->getBlockName();
        }
        // return the block path
        return $blockPath;
    }

	/**
     * (non-PHPdoc)
     * @see TDProject/Interfaces/Block#isRendered()
     */
    public function isRendered()
    {
    	return $this->_rendered;
    }

    /**
     * Marks the block as already rendered.
     *
     * @return void
     */
    public function setRendered()
    {
    	$this->_rendered = true;
    }

	/**
     * (non-PHPdoc)
     * @see TDProject/Interfaces/Block#getHtml()
     */
    public function toHtml()
    {
    	// check if the block was already rendered
    	if ($this->isRendered()) {
    		return;
    	}
        // translate and render the block
    	require $this->_getTemplate();
    	// mark the block as already rendered
    	$this->setRendered();
    }

	/**
     * (non-PHPdoc)
     * @see TDProject/Interfaces/Block#getSystemUser()
     */
    public function getSystemUser()
    {
        return $this->getRequest()
            ->getSession()
            ->getAttribute(
                TDProject_Core_Controller_Util_WebSessionKeys::SYSTEM_USER
            );
    }

    /**
     * (non-PHPdoc)
     * @see TDProject_Core_Interfaces_Block::translate()
     */
    public function translate($key, $module = null)
    {
        // check if a module name has been passed
        if (empty($module)) {
            // if not, use the module name of the extending class
            $module = $this->getModuleName();
        } else {
            $module = new TechDivision_Lang_String($module);
        }
        // return the translation
        return $this->getTranslator()
            ->translate(new TechDivision_Lang_String($key), $module);
    }

    /**
     * Sets the Application instance.
     *
     * @param TDProject_Application $app The Application instance
     * @return TDProject_Core_Interfaces_Block
     * 		The instance itself
     */
    public function setApp(TDProject_Application $app)
    {
        $this->_app = $app;
        return $this;
    }

    /**
     * Returns the application instance itself
     * from the controllers Context.
     *
     * @return TDProject_Application The application instance
     */
    public function getApp()
    {
        return $this->_app;
    }

	/**
	 * @see TDProject_Application::getUrl(array $params = array()
	 */
    public function getUrl(array $params = array())
    {
        return $this->getApp()->getUrl($params);
    }

    /**
     * @see TDProject_Application::getBaseUrl()
     */
    public function getBaseUrl()
    {
        return $this->getApp()->getBaseUrl();
    }

    /**
     * @see TDProject_Application::getDesignUrl($imageName)
     */
    public function getDesignUrl($imageName)
    {
        return $this->getApp()->getDesignUrl($imageName);
    }

    /**
     * Return the ActionForm related with the actual
     * request from the Controller's Context.
	 *
	 * @return TechDivision_Controller_Interfaces_Form
	 * 		The requested ActionForm
     */
    public function getActionForm()
    {
        return $this->getContext()->getActionForm();
    }

    /**
     * Converts the passed timestamp to a date.
     *
     * @param TechDivision_Lang_Integer $integer
     * 		The timestamp to convert
     * @return TechDivision_Lang_String
     * 		The human readable date
     */
    public function toDate(TechDivision_Lang_Integer $integer)
    {
        $date = new Zend_Date($integer->intValue(), Zend_Date::TIMESTAMP);
        return new TechDivision_Lang_String(
            $date->toString('YYYY-MM-dd H:m:s')
        );
    }

    /**
     * Returns the ActionErrors container initialized
     * in the Controller or the ActionForm.
     *
     * @return TechDivision_Controller_Action_Errors
     * 		The container with the error messages
     */
    public function getActionErrors()
    {
        return $this->getRequest()
            ->getAttribute(
                TechDivision_Controller_Action_Errors::ACTION_ERRORS
            );
    }

    /**
     * (non-PHPdoc)
     * @see TDProject/Core/Block/Interfaces/TDProject_Core_Interfaces_Block::isAutoRender()
     */
    public function isAutoRender()
    {
    	return $this->_isAutoRender;
    }

    /**
     * (non-PHPdoc)
     * @see TDProject/Core/Block/Interfaces/TDProject_Core_Interfaces_Block::getCssId()
     */
    public function getCssId()
    {
    	return $this->_cssId;
    }

    /**
     * (non-PHPdoc)
     * @see TDProject/Core/Block/Interfaces/TDProject_Core_Interfaces_Block::getCssClass()
     */
    public function getCssClass()
    {
    	return $this->_cssClass;
    }

	/**
     * (non-PHPdoc)
     * @see TDProject/Core/Interfaces/Block#getTemplate()
     */
    public function getTemplate()
    {
    	return $this->_getTemplate();
    }

	/**
     * (non-PHPdoc)
     * @see TDProject/Core/Interfaces/Block#setTemplate($template)
     */
    public function setTemplate($template)
    {
    	$this->_setTemplate($template);
    }

    /**
     * (non-PHPdoc)
     * @see TechDivision/Controller/Interfaces/TechDivision_Controller_Interfaces_Form::reset()
     */
    public function reset()
    {
    }

    /**
     * (non-PHPdoc)
     * @see TechDivision/Controller/Interfaces/TechDivision_Controller_Interfaces_Form::validate()
     */
    public function validate()
    {
    }

    /**
     * (non-PHPdoc)
     * @see TDProject_Core_Interfaces_Block::addScript()
     */
    public function addScript(
        TDProject_Core_Interfaces_Block_Widget_Script $script) {
    	return $this->getContext()->getAttribute('head')->addBlock($script);
    }

    /**
     * (non-PHPdoc)
     * @see TDProject_Core_Interfaces_Block::addLink()
     */
    public function addLink(
        TDProject_Core_Interfaces_Block_Widget_Link $link) {
    	return $this->getContext()->getAttribute('head')->addBlock($link);
    }

    /**
     * Returns the system locale used.
     *
     * @return TechDivision_Util_SystemLocale
     * 		The used system locale
     */
    public function getSystemLocale()
    {
        return TechDivision_Util_SystemLocale::getDefault();
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
     * Sets the parent block.
     *
     * @param TDProject_Core_Interfaces_Block $parent
     * 		The parent block
     * @return TDProject_Core_Interfaces_Block
     * 		The block itself
     */
    public function setParent(TDProject_Core_Interfaces_Block $parent)
    {
        $this->_parent = $parent;
        return $this;
    }

    /**
     * (non-PHPdoc)
     * @see TDProject_Core_Interfaces_Block::getParent()
     */
    public function getParent()
    {
        return $this->_parent;
    }

    /**
     * Sets the Translator instance used of translation.
     *
     * @param TDProject_Interfaces_Translator $translator
     * 		The Translator instance
     * @return TDProject_Core_Interfaces_Block
     * 		The instance itself
     */
    public function setTranslator(
        TDProject_Interfaces_Translator $translator) {
        $this->_translator = $translator;
        return $this;
    }

    /**
     * (non-PHPdoc)
     * @see TDProject_Interfaces_Translateable::getTranslator()
     */
    public function getTranslator()
    {
        return $this->_translator;
    }

    /**
     * (non-PHPdoc)
     * @see TDProject_Interfaces_Translateable::trsl()
     */
    public function trsl()
    {
        // iterate over all child blocks and translate them
        foreach ($this->_getChilds() as $child) {
            if ($child instanceof TDProject_Interfaces_Translateable) {
                $child->trsl();
            }
        }
        // return the instance itself
        return $this;
    }

    /**
     * (non-PHPdoc)
     * @see TDProject_Interfaces_Translateable::getResourceKey()
     */
    public function getResourceKey()
    {
        return new TechDivision_Lang_String($this->getBlockPath());
    }

    /**
     * (non-PHPdoc)
     * @see TDProject_Interfaces_Translateable::getResourcePackage()
     */
    public function getResourcePackage()
    {
        return $this->getModuleName();
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
        return $this->getApp()->isAllowed($resource, $privilege);
    }

    /**
     * Converts the passed seconds into minutes.
     *
     * @param TechDivision_Lang_Integer $integer
     * 		The seconds to convert
     * @return TechDivision_Lang_String
     * 		The minutes
     */
    public function fromSecondsToMinutes(TechDivision_Lang_Integer $integer)
    {
    	return $integer->divide(new TechDivision_Lang_Integer(60));
    }

    /**
     * Converts the passed minutes into seconds.
     *
     * @param TechDivision_Lang_Integer $integer
     * 		The minutes to convert
     * @return TechDivision_Lang_String
     * 		The seconds
     */
    public function fromMinutesToSeconds(TechDivision_Lang_Integer $integer)
    {
    	return $integer->multiply(new TechDivision_Lang_Integer(60));
    }

    /**
     * Factory method for a new instance of the
     * class with the passed name.
     *
     * @param string Name of the class to create and return the oject for
     * @param array The arguments passed to the classes constructor
     * @return TechDivision_AOP_Interfaces_AspectContainer
     * 		The AspectContainer instance
     * @see TDProject_Application::newInstance()
     */
    public function newInstance($className, array $arguments = array())
    {
    	return $this->getApp()->newInstance($className, $arguments);
    }
}