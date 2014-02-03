<?php

/**
 * TDProject_Core_Common_Interfaces_Assertion
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

require_once 'Zend/Acl/Assert/Interface.php';

/**
 * @category    TDProject
 * @package     TDProject_Core
 * @copyright   Copyright (c) 2010 <info@techdivision.com> - TechDivision GmbH
 * @license     http://opensource.org/licenses/osl-3.0.php
 *              Open Software License (OSL 3.0)
 * @author      Tim Wagner <tw@techdivision.com>
 */
interface TDProject_Core_Common_Interfaces_Assertion
    extends Zend_Acl_Assert_Interface {

    /**
     * The unique Assertion ID of the assertion defined
     * in the database.
     *
     * @return TechDivision_Lang_Integer
     * 		The unique Assertion ID
     */
    public function getAssertionId();
}