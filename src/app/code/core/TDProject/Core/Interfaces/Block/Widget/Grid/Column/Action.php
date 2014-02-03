<?php

/**
 * TDProject_Core_Interfaces_Block_Widget_Grid_Column_Action
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

/**
 * @category    TDProject
 * @package     TDProject_Core
 * @copyright   Copyright (c) 2010 <info@techdivision.com> - TechDivision GmbH
 * @license     http://opensource.org/licenses/osl-3.0.php
 *              Open Software License (OSL 3.0)
 * @author      Tim Wagner <tw@techdivision.com>
 */
interface TDProject_Core_Interfaces_Block_Widget_Grid_Column_Action {

    /**
     * Returns the URL to invoke when the Action is selected.
     *
     * @return string The URL to invoke
     */
    public function getUrl();

    /**
     * The Action's label.
     *
     * @return string The Action's label
     */
    public function getLabel();

    /**
     * Returns the name of the class property containing the ID
     * for creating the URL to invoke.
     *
     * @return string The class property
     */
    public function getProperty();

    /**
     * The Action's context.
     *
     * @return TechDivision_Controller_Interfaces_Context
     * 		The context
     */
    public function getContext();
}