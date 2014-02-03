<?php

/**
 * TDProject_Core_Controller_Install
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

/**
 * @category    TProject
 * @package     TDProject_Core
 * @copyright   Copyright (c) 2010 <info@techdivision.com> - TechDivision GmbH
 * @license     http://opensource.org/licenses/osl-3.0.php
 *              Open Software License (OSL 3.0)
 * @author      Tim Wagner <tw@techdivision.com>
 */
class TDProject_Core_Controller_Install
    extends TDProject_Core_Controller_Abstract
{

    /**
     * (non-PHPdoc)
     * @see TechDivision_Controller_Interfaces_Action::preDispatch()
     */
	public function preDispatch()
	{
		// avoid running parent method, because Guest user is NOT available
	}

	/**
	 * This method is automatically invoked by the controller if
	 * a new installation is requested.
	 *
	 * @return void
	 */
	public function __default()
	{
	    try {
	    	$this->getLogger()->error("Setup method not defined");
	    } 
	    catch (Exception $e) {
	    	$this->getLogger()->error($e->__toString());
		}
	}

	/**
	 * This method is automatically invoked by the controller if
	 * a new installation is requested.
	 *
	 * @return void
	 */
	public function install()
	{
	    try {
	    	// log the installation start
	    	$this->getLogger()->error("Now starting installation process");
	    	// take the time
	    	$startTime = $this->getApp()->timeUsage();
	    	// load the installation options
	    	$options = $this->_getRequest()->getAttribute('options');
	    	// run the system installation process
			$this->_getDelegate()->runSystemInstall($options);
			// calculate runtime and end date
			$runTime = $this->getApp()->timeUsage($startTime);
			// log runtime
	    	$this->getLogger()->error(
	    		"Successfully finished installation process taking $runTime s"
	    	);
	    } 
	    catch (Exception $e) {
	    	$this->getLogger()->error($e->__toString());
		}
	    // forward to the output page
    	return $this->_findForward(parent::SUCCESS);
	}

	/**
	 * This method is automatically invoked by the controller if
	 * an update is requested.
	 *
	 * @return void
	 */
	public function update()
	{
	    try {
	    	// log the installation start
	    	$this->getLogger()->error("Now starting update process");
	    	// take the time
	    	$startTime = $this->getApp()->timeUsage();
	    	// load the installation options
	    	$options = $this->_getRequest()->getAttribute('options');
	    	// run the system installation process
			$this->_getDelegate()->runSystemUpdate($options);
			// calculate runtime
			$runTime = $this->getApp()->timeUsage($startTime);
			// log runtime
	    	$this->getLogger()->error(
	    		"Successfully finished update process taking $runTime s"
	    	);
	    } 
	    catch (Exception $e) {
	    	$this->getLogger()->error($e->__toString());
		}
	    // forward to the output page
    	return $this->_findForward(parent::SUCCESS);
	}

	/**
	 * This method is automatically invoked by the controller and invokes
	 * the functionality to generate the sources.
	 *
	 * @return void
	 */
	public function generate()
	{
	    try {
	    	// log the installation start
	    	$this->getLogger()->error("Now starting generation process");
	    	// take the time
	    	$startTime = $this->getApp()->timeUsage();
	    	// load the installation options
	    	$options = $this->_getRequest()->getAttribute('options');
	    	// run the system installation process
			$this->_getDelegate()->runGeneration($options);
			// calculate runtime
			$runTime = $this->getApp()->timeUsage($startTime);
			// log runtime
	    	$this->getLogger()->error(
	    		"Successfully finished update process taking $runTime s"
	    	);
	    } 
	    catch (Exception $e) {
	    	$this->getLogger()->error($e->__toString());
		}
	    // forward to the output page
    	return $this->_findForward(parent::SUCCESS);
	}

	/**
	 * This method prevents from adding the 'Action' suffix
	 * to the Controller methods before invoking them. This
	 * is necessary to exclude them from authorization.
	 *
	 * @param string $method The method to return the method name to invoke
	 * @return string The method name to invoke
	 */
    protected function _getMethodName($method)
    {
        return $method;
    }

	/**
	 * Tries to load the Block class specified as path parameter
	 * in the ActionForward. If a Block was found and the class
	 * can be instanciated, the Block was registered to the Request
	 * with the path as key.
	 *
	 * @param TechDivision_Controller_Action_Forward $actionForward
	 * 		The ActionForward to initialize the Block for
	 * @return void
	 */
	protected function _getBlock(
	    TechDivision_Controller_Action_Forward $actionForward) {
	    // check if the class required to initialize the Block is included
	    if (!class_exists($path = $actionForward->getPath())) {
	        return;
	    }
	    // initialize the messages and add the Block
	    $page = new $path($this->getContext());
	    // register the Block in the Request
	    $this->_getRequest()->setAttribute($path, $page);
	}
}