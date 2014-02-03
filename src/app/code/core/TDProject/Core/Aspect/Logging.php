<?php

/**
 * TDProject_Core_Aspect_Logging
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */
require_once 'TechDivision/Lang/Object.php';
require_once 'TechDivision/AOP/Interfaces/Aspect.php';
require_once 'TechDivision/AOP/Interfaces/JoinPoint.php';

/**
 * @category    TProject
 * @package     TDProject_Core
 * @copyright   Copyright (c) 2010 <info@techdivision.com> - TechDivision GmbH
 * @license     http://opensource.org/licenses/osl-3.0.php
 *              Open Software License (OSL 3.0)
 * @author      Tim Wagner <tw@techdivision.com>
 */
class TDProject_Core_Aspect_Logging
    extends TechDivision_Lang_Object
    implements TechDivision_AOP_Interfaces_Aspect 
{
    
    /**
     * Dummy constructor to avoid object factory
     * initialization problems.
     * 
     * @return void
     */
    public function __construct()
    {
    	// dummy constructor	
    }

    /**
     * Dummy implementation.
     * 
     * @param TechDivision_AOP_Interfaces_JoinPoint $joinPoint
     * 		The join point instance
     */
    public function log(TechDivision_AOP_Interfaces_JoinPoint $joinPoint)
    {
		$aspectable = $joinPoint
    		->getMethodInterceptor()
            ->getAspectContainer()
            ->getAspectable();
         $method = $joinPoint->getMethodInterceptor()->getMethod();
    }
}