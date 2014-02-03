<?php

/**
 * TDProject_Core_Aspect_Model_Services_DomainProcessor
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
 * @category   	TDProject
 * @package    	TDProject_Core
 * @copyright  	Copyright (c) 2010 <info@techdivision.com> - TechDivision GmbH
 * @license    	http://opensource.org/licenses/osl-3.0.php
 * 				Open Software License (OSL 3.0)
 * @author      Tim Wagner <tw@techdivision.com>
 */
class TDProject_Core_Aspect_Model_Services_DomainProcessor
    extends TechDivision_Lang_Object
    implements TechDivision_AOP_Interfaces_Aspect {
	
	/**
	 * Constructor to initialize Aspect.
	 * 
	 * @return void
	 */
	public function __construct()
	{
		// dummy constructor
	}

    /**
     * Cache the ACL's.
     * 
     * @param TechDivision_AOP_Interfaces_JoinPoint $joinPoint
     * @throws Exception Is thrown if data can't be cached
     * @return Zend_Acl The ACL's
     */
    public function cacheGetAcl(TechDivision_AOP_Interfaces_JoinPoint $joinPoint)
    {
        // load the processor
        $processor = $joinPoint
    		->getMethodInterceptor()
            ->getAspectContainer()
            ->getAspectable();
		// load the cache key
        $cacheKey = $this->getCacheKey();
        // check if the tasks has already been cached
        if ($acls = $processor->getContainer()->getCache()->load($cacheKey)) {
            return $acls;
        }
        // let the Service add the load the ACL's
        $acls = $joinPoint->proceed();
        // store the ACL's in the cache
        if (!$processor->getContainer()->getCache()->save($acls, $cacheKey)) {
        	throw new Exception("Can't save data for $cacheKey in cache");
        }
        // return ACL's
        return $acls;
    }

    /**
     * Return the cache key used to store the ACL's in the
     * cache instance.
     * 
     * @return string The cache key
     */
    public function getCacheKey()
    {
        return TDProject_Core_Model_Actions_Acl::CACHE_KEY;
    }
}