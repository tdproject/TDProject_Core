<?php

/**
 * TDProject_Core_Block_Widget
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

require_once 'TechDivision/Util/SystemLocale.php';
require_once 'TechDivision/Resources/DBResourceBundle.php';
require_once 'TechDivision/Resources/Exceptions/ResourcesException.php';
require_once 'TDProject/Core/Block/Widget/Abstract.php';

/**
 * This class implements the widget functionality.
 *
 * @category    TProject
 * @package     TDProject_Core
 * @copyright   Copyright (c) 2010 <info@techdivision.com> - TechDivision GmbH
 * @license     http://opensource.org/licenses/osl-3.0.php
 *              Open Software License (OSL 3.0)
 * @author      Johann Zelger <zelgerj@techdivision.com>
 */
abstract class TDProject_Core_Block_Widget_Abstract_Localized
	extends TDProject_Core_Block_Widget_Abstract {

    /**
     * (non-PHPdoc)
     * @see TDProject_Core_Block_Abstract::trsl()
     */
    public function trsl()
    {
        // temporarly store the original block title
        $default = new TechDivision_Lang_String($this->getBlockTitle());
        // translate the block title
        $this->_setBlockTitle(
            $translated = $this->getTranslator()
                ->translate(
                    $key = $this->getResourceKey(),
                    $module = $this->getResourcePackage(),
                    null,
                    $default
                )
        );
        // call the parent method
        return parent::trsl();
    }
}