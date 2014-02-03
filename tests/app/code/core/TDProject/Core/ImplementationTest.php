<?php

/**
 * License: GNU General Public License
 *
 * Copyright (c) 2009 TechDivision GmbH.  All rights reserved.
 * Note: Original work copyright to respective authors
 *
 * This file is part of TechDivision GmbH - Connect.
 *
 * TechDivision_Generator is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * TechDivision_Generator is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA 02111-1307,
 * USA.
 *
 * @package TechDivision_Generator
 */

require_once 'TDProject/Factory.php';
require_once 'Mock/Request.php';

/**
 * This is the test for the Integer class.
 *
 * @package TDProject_Core
 * @author Tim Wagner <tw@techdivision.com>
 * @copyright TechDivision GmbH
 * @link http://www.techdivision.com
 * @license GPL
 */
class TDProject_Core_ImplementationTest
    extends PHPUnit_Framework_TestCase 
{

    /**
     * The Application instance to test.
     * @var TDProject_Application
     */
    protected $_app = null;

    /**
     * Prepars the unit test.
     *
     * @return void
     */
    public function setUp()
    {
        // initialize the Application instance to test
        $this->_app = TDProject_Factory::get();
        $this->_app->cleanCache();
    }

    /**
     * Cleans up after running a test.
     *
     * @return void
     */
    public function tearDown()
    {
    	// $this->_app->cleanCache();
    }

    /**
     * Dummy test.
     *
	 * @return void
     */
    public function testCachedCollection()
    {
        // initialize the parameters
        $params = array(
            'namespace' => 'TDProject',
            'module' => 'Test',
        	'path' => '/test',
            'method' => 'test',
        	'SCRIPT_NAME' => 'test.php',
            'cleanCacheMode' => Zend_Cache::CLEANING_MODE_ALL
        );
        
        // initialize the Mock request instance and set it
		$this->_app->setRequest(new Mock_Request($params));
        
    	$collection = new TDProject_Core_Model_Collections_Test();
    	
    	$collection->connect($container = $this->_app->getContainer());
    	
    	$entity = $container->lookup('TDProject_Core_Model_Entities_User', new TechDivision_Lang_Integer(2));
    	
    	$collection->add($entity);
    	
    	$this->_app->getContainer()->getCache()->save($collection, 'test');
    	
    	$cachedCollection = $this->_app->getContainer()->getCache()->load('test');
    	$cachedCollection->connect($container = $this->_app->getContainer());
    	
    	$user = $cachedCollection->get(0);
    	
    	$this->assertTrue($user instanceof TDProject_Core_Model_Entities_User);
    }
}