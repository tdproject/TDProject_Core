<?php

/**
 * TDProject_Core_Block_Widget_View
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

require_once 'TechDivision/Lang/String.php';
require_once 'TechDivision/Controller/Interfaces/Context.php';
require_once 'TDProject/Core/Block/Widget/Form/Abstract.php';
require_once 'TDProject/Core/Interfaces/Block/Widget/Form/View.php';
require_once 'TDProject/Core/Block/Widget/Button/Back.php';
require_once 'TDProject/Core/Block/Widget/Button/Save.php';
require_once 'TDProject/Core/Block/Widget/Button/Delete.php';

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

abstract class TDProject_Core_Block_Widget_Form_Abstract_View
    extends TDProject_Core_Block_Widget_Form_Abstract
    implements TDProject_Core_Interfaces_Block_Widget_Form_View {

    /**
     * Initialize the block with the
     * apropriate template and name.
     *
     * @return void
     */
    public function __construct(
        TechDivision_Controller_Interfaces_Context $context) {
        // call the parent constructor
        parent::__construct($context);
    	// set the block title
    	$this->_setBlockTitle(
    	    $this->translate('title' . $this->getPathPrepared() . '.view')
    	);
        // set the internal name
        $this->_setBlockName(
        	TDProject_Core_Block_Abstract::BLOCK_NAME
        );
        // set the template name
        $this->_setTemplate('www/design/core/templates/widget/view.phtml');
    }

    /**
     * (non-PHPdoc)
     * @see TDProject_Core_Block_AbstractForm::getBackUrl()
     */
    public function getBackUrl()
    {
    	return '?path=' . $this->getPath();
    }

    /**
     * (non-PHPdoc)
     * @see TDProject_Core_Block_Abstract::getCssId()
     */
    public function getCssId()
    {
    	return $this->getFormName();
    }

    /**
     *
     * Enter description here ...
     * @return string
     */
    public function getNewUrl()
    {
    	return '?path=' . $this->getPath() . '&method=create';
    }

	/**
     * (non-PHPdoc)
     * @see TDProject/Interfaces/Block#prepareLayout()
     */
    public function prepareLayout()
    {
    	// add the hidden fields
    	$this->addElement($this->getElement('hidden', 'path'));
    	$this->addElement($this->getElement('hidden', 'method'));
		// add the toolbar's default buttons
		$this->getToolbar()
			->addButton(
				new TDProject_Core_Block_Widget_Button_New(
					$this,
					$this->translate('widget.button' . $this->getPathPrepared() . '.new')
				)
			)
			->addButton(
			    new TDProject_Core_Block_Widget_Button_Back(
			        $this,
			        $this->translate(
			        	'widget.button.back',
			            TDProject_Core_Block_Widget_Abstract::MESSAGE_RESOURCES
			        )
			    )
			)
			->addButton(
			    new TDProject_Core_Block_Widget_Button_Save(
			        $this,
			        $this->translate(
			        	'widget.button.save',
			            TDProject_Core_Block_Widget_Abstract::MESSAGE_RESOURCES
			        )
			    )
			)
			->addButton(
			    new TDProject_Core_Block_Widget_Button_Delete(
			        $this,
			        $this->translate(
			        	'widget.button.delete',
			            TDProject_Core_Block_Widget_Abstract::MESSAGE_RESOURCES
			        )
			    )
			);
		// return the instance
    	return parent::prepareLayout();
    }

	/**
	 * (non-PHPdoc)
	 * @see TDProject_Core_Interfaces_Block_Widget_Form_View::getMethod()
	 */
	public function getMethod()
	{
		return new TechDivision_Lang_String('save');
	}
}