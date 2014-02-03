<?php

/**
 * TDProject_Corel_Model_Assembler_Abstract
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
 * @subpackage	Model
 * @copyright  	Copyright (c) 2010 <info@techdivision.com> - TechDivision GmbH
 * @license    	http://opensource.org/licenses/osl-3.0.php
 * 				Open Software License (OSL 3.0)
 * @author      Tim Wagner <tw@techdivision.com>
 */
abstract class TDProject_Core_Model_Assembler_Abstract
    extends TechDivision_Lang_Object {
    
    /**
     * Reference to the container instance.
     * @var TechDivision_Model_Interfaces_Container
     */
    protected $_container = null;
    
    /**
     * Initializes the action with the passed container instance.
     * 
     * @param TechDivision_Model_Interfaces_Container $container The container instance
     * @return void
     */
    public function __construct(TechDivision_Model_Interfaces_Container $container)
    {
        $this->_container = $container;
    }
    
    /**
     * Returns the container instance.
     * 
     * @return TechDivision_Model_Interfaces_Container
     *     The container instance
     */
    public function getContainer()
    {
        return $this->_container;
    }
}