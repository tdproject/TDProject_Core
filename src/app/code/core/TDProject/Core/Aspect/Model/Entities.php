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
class TDProject_Core_Aspect_Model_Entities
    extends TechDivision_Lang_Object
    implements TechDivision_AOP_Interfaces_Aspect
{

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
     * Clean the cache.
     *
     * @param TechDivision_AOP_Interfaces_JoinPoint $joinPoint
     * 		The JoinPoint instance
     * @return void
     */
    public function cleanCache(
    	TechDivision_AOP_Interfaces_JoinPoint $joinPoint)
    {
        // load the entity
        $entity = $joinPoint
    		->getMethodInterceptor()
            ->getAspectContainer()
            ->getAspectable();
        // clean the cache
        $entity->getContainer()->getCache()->clean(
        	Zend_Cache::CLEANING_MODE_MATCHING_ANY_TAG,
        	$entity->getCacheTags()
       	);
    }

    /**
     * Checks if the requested collection has already been cached,
     * if yes the cached Collection will be returned.
     *
     * Otherwise the collection will be loaded, cached and returned.
     *
     * @param TechDivision_AOP_Interfaces_JoinPoint $joinPoint
     * 		The JoinPoint instance
     * @return TechDivision_Model_Interfaces_Collections_Cachable
     * 		The requested Collection
     */
    public function checkCache(
    	TechDivision_AOP_Interfaces_JoinPoint $joinPoint)
    {
    	// load the method interceptor
    	$methodInterceptor = $joinPoint->getMethodInterceptor();
        // load the home
        $home = $methodInterceptor->getAspectContainer()->getAspectable();
        // prepare the unique cache key for the method
        $cacheKey = $home->getContainer()->createCacheKey(
        	get_class($home) . '::' . $methodInterceptor->getMethod(),
        	$joinPoint->getArguments()
        );
    	// check if the collection has already been cached
    	if ($list = $home->getContainer()->getCache()->load($cacheKey)) {
    		// is so, reconnect and return the cached Collection
    		return $list->setContainer($home->getContainer())->load();
    	}
    	// proceed with the next aspect, if available
    	$list = $joinPoint->proceed();
    	// if a cachable Collection has been return
    	if ($list instanceof TechDivision_Model_Interfaces_Collections_Cachable) {
	    	// store the collection in the container's cache
	    	$home->getContainer()->getCache()->save($list, $cacheKey, $home->getCacheTags());
    	}
    	// return the resultset
    	return $list;
    }
}