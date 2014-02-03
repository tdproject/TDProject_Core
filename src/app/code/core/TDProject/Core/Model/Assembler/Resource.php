<?php

/**
 * TDProject_Core_Model_Assembler_Resource
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

/**
 * @category   	TDProject
 * @package    	TDProject_Core
 * @copyright  	Copyright (c) 2010 <info@techdivision.com> - TechDivision GmbH
 * @license    	http://opensource.org/licenses/osl-3.0.php
 * 				Open Software License (OSL 3.0)
 * @author      Tim Wagner <tw@techdivision.com>
 */
class TDProject_Core_Model_Assembler_Resource
    extends TDProject_Core_Model_Assembler_Abstract {

    /**
     * Factory method to create a new instance.
     *
     * @param TechDivision_Model_Interfaces_Container $container The container instance
     * @return TDProject_Channel_Model_Actions_Category
     * 		The requested instance
     */
    public static function create(TechDivision_Model_Interfaces_Container $container)
    {
        return new TDProject_Core_Model_Assembler_Resource($container);
    }

    /**
     * Returns a DTO initialized with the data of the resource
     * with the passed ID.
     *
     * @param TechDivision_Lang_Integer $resourceId
     * 		The ID of the resource the DTO has to be initialized for
     * @return TDProject_Core_Common_ValueObjects_ResourceViewData
     * 		The initialized DTO
     */
    public function getResourceViewData(
        TechDivision_Lang_Integer $resourceId = null) {
    	// check if a resource ID was passed
    	if(!empty($resourceId)) { // if yes, load the resource message
    		$resource = TDProject_Core_Model_Utils_ResourceUtil::getHome($this->getContainer())
    			->findByPrimaryKey($resourceId);
    	} else {
        	// if not, initialize a new channel
        	$resource = TDProject_Core_Model_Utils_ResourceUtil::getHome($this->getContainer())
        		->epbCreate();
    	}
   		// initialize the DTO and add the available locales
  		$dto = new TDProject_Core_Common_ValueObjects_ResourceViewData($resource);
    	$dto->setLocales($this->getLocaleOverviewData());
    	// return the initialized DTO
    	return $dto;
    }

    /**
     * Returns an ArrayList with all resource messages
     * assembled as LVO's.
     *
     * @return TechDivision_Collections_ArrayList
     * 		The requested resource message LVO's
     */
    public function getResourceLightValues()
    {
        // initialize a new ArrayList
        $list = new TechDivision_Collections_ArrayList();
        // load the resource messages
        $resources = TDProject_Core_Model_Utils_ResourceUtil::getHome($this->getContainer())
            ->findAll();
        // assemble the resource message
        foreach ($resources as $resource) {
            $list->add($resource->getLightValue());
        }
        // return the ArrayList with the ResourceLightValues
        return $list;
    }

    /**
     * Returns the available locales.
     *
     * @return TechDivision_Collections_Interfaces_Collection
     * 		The Collection with available system locales
     */
    public function getLocaleOverviewData()
    {
        // load the available locales
        $locales = TechDivision_Util_SystemLocale::getAvailableLocales();
        // initialize a new Collection
        $list = new TechDivision_Collections_ArrayList();
        // assemble the locales
        foreach ($locales as $locale) {
            $list->add(
                new TDProject_Core_Common_ValueObjects_LocaleOverviewData(
                    $locale
                )
            );
        }
        // return the Collection
        return $list;
    }
}