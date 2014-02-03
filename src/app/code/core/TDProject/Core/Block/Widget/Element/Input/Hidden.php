<?php

/**
 * TDProject_Core_Block_Widget_Element_Hidden
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

require_once 'TDProject/Core/Block/Widget/Element/Input/Abstract.php';
require_once 'TDProject/Core/Interfaces/Block/Widget/Element/Input.php';
require_once 'TDProject/Core/Interfaces/Block/Widget/Form.php';

/**
 * @category    TDProject
 * @package     TDProject_Core
 * @copyright   Copyright (c) 2010 <info@techdivision.com> - TechDivision GmbH
 * @license     http://opensource.org/licenses/osl-3.0.php
 *              Open Software License (OSL 3.0)
 * @author      Johann Zelger <jz@techdivision.com>
 */
class TDProject_Core_Block_Widget_Element_Input_Hidden
    extends TDProject_Core_Block_Widget_Element_Input_Abstract
    implements TDProject_Core_Interfaces_Block_Widget_Element_Input {

    /**
     * Constant that contains the block title.
     * @var string
     */
    const BLOCK_TITLE = 'hidden';

    /**
     * Initialize the toolbar with the apropriate template and name.
     *
     * @param TDProject_Core_Interfaces_Block_Widget_Form The ActionForm instance the element is bound to
     * @param string $blockName The block name of the element, alias the property
     * @return void
     */
    public function __construct(
        TDProject_Core_Interfaces_Block_Widget_Form $form, $blockName) {
        // call the parent constructor
        parent::__construct(
            $form,
            $blockName,
            TDProject_Core_Block_Widget_Element_Input_Hidden::BLOCK_TITLE
        );
        // set the template name
        $this->_setTemplate(
        	'www/design/core/templates/widget/element/input/hidden.phtml'
        );
    }

    /**
     * (non-PHPdoc)
     * @see TDProject_Core_Block_Widget_Abstract_Localized::trsl()
     */
    public function trsl()
    {
        // avoid translation
        return;
    }
}