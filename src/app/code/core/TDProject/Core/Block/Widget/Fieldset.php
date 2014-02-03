<?php

/**
 * TDProject_Core_Block_Widget_Fieldset
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

require_once 'TDProject/Core/Block/Widget/Abstract/Localized.php';
require_once 'TDProject/Core/Interfaces/Block/Widget/Tab.php';

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

class TDProject_Core_Block_Widget_Fieldset
    extends TDProject_Core_Block_Widget_Abstract_Localized
    implements TDProject_Core_Interfaces_Block_Widget_Fieldset {

    /**
     * Initialize the fieldset with the context instance, the name and the
     * title.
     *
     * @param TechDivision_Controller_Interfaces_Context $context
     * 		The context instance
     * @param string $blockName The fieldset name
     * @param string $blockTitle The fieldset title
     * @return void
     */
    public function __construct(
        TechDivision_Controller_Interfaces_Context $context,
        $blockName,
        $blockTitle) {
        // call the parent constructor
        parent::__construct($context);
    	// set the fieldset name and title
    	$this->_setBlockName($blockName);
    	$this->_setBlockTitle($blockTitle);
        // set the fieldset template
        $this->_setTemplate('www/design/core/templates/widget/fieldset.phtml');
    }

    public function addGraph($blockName, $blockTitle) {
        $this->addBlock(
            new TDProject_Core_Block_Widget_Fieldset_Graph(
	            $this,
	        	'graph',
	        	'User Performance'
	        )
	    );
    }
}