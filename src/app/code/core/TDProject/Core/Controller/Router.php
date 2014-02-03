<?php

/**
 * TDProject_Core_Controller_Router
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
 * @author      Bastian Stangl <b.stangl@techdivision.com>
 */
class TDProject_Core_Controller_Router
    extends TDProject_Core_Controller_Abstract {

	/**
	 * The default route.
	 * @var string
	 */
    const DEFAULT_ROUTE = 'DefaultRoute';
    
    /**
     * Array with the exploded URL parts.
     * @var array
     */
    protected $_source = array();

	/**
	 * This method is automatically invoked by the controller if no path
	 * parameter is available in the request. It first tries to find a
	 * rewrite in the database, after that a path to the next ActionForward
	 * is build up from the found redirect URL parameters.
	 *
	 * @return void
	 */
	public function __default()
	{
	    try {
	    	// load the request URI
			$requestURI = $this->getRequestURI();
			// log the found URL
			$this->_getLogger()
				->debug('Request URI: ' . $requestURI, __LINE__);
			// load the base URL
			$baseUrl = $this->getBaseUrl();
			// if the base URL is the root URL, strip the leading slash
			if ($baseUrl == '/') {
				$baseUrl = '';
			}
			// log the found base URL
			$this->_getLogger()
				->debug('Base URL: ' . $baseUrl, __LINE__);
			// prepare the URL
			$preparedUrl = str_replace($baseUrl, '', $requestURI);
			// log the prepared URL
			$this->_getLogger()
				->debug('Prepared URL: ' . $preparedUrl, __LINE__);
			// create an array with the URL elements
			$this->setSource(explode('/', $preparedUrl));
			// initialize the default ActionForward
			$actionForward = $this->_findForward(self::DEFAULT_ROUTE);
			// concatenate the rewrite URL
			$rewriteUrl =
			    TechDivision_Lang_String::valueOf(implode('/', $this->getSource()));
			// initialize the rewrite
			$rewrite = null;
			// if a rewrite URL is available
			if ($rewriteUrl != null) {
				// log it
			    $this->_getLogger()
			        ->debug('Found rewrite URL: ' . $rewriteUrl, __LINE__);
				// and try to load the rewrite from the database
			    $rewrite = $this->rewrite($rewriteUrl);
			}
			// if a rewrite has been found
			if ($rewrite) {
				// log the found rewrite
			    $this->_getLogger()
			        ->debug('Found rewrite: ' . $rewrite->getName(), __LINE__);
				// initialize the ActionForward
				$actionForward->setName($rewrite->getName());
				$actionForward->setPath($rewrite->getPath());
				if ($rewrite->getRedirect()->booleanValue()) {
					$actionForward->setRedirect('true');
				}
			}
			// if no rewrite has been found, try to create a route by rule
			else {
				// initialize URL
				$url = '';
				// load the extracted URL parts
				$source = $this->getSource();
				// iterate over all elements found in the exploded source URL
				for ($i = 1; $i < sizeof($source); $i++) {
					// concatenate the next element
					$url .= '/' . $source[$i];
					// log the concatenated URL
					$this->_getLogger()
						->debug('Search ActionMapping for URL: ' . $url, __LINE__);
					// try to find an ActionMapping for the concatenated URL
					$actionMapping = $this->_getActionMapping()
						->getMappings()->find($url);
					// if a ActionMapping is available
					if ($actionMapping) {
						// load the parameter passed by the configuration file
						$parameterName = $actionMapping->getParameter();
						// initialize the default ActionForward
						$actionForward->setName('Default');
						$actionForward->setPath($actionMapping->getPath());
						// iterate over the residual elements
						for ($z = $i + 1; $z < sizeof($source); $z++) {
							// load the class name of the ActionMapping found
							$type = $actionMapping->getType();
							// assume that the next element has to be the method name
							$method = $source[$z];
							// log the assumed method name
							$this->_getLogger()
								->debug("Found assumed method: $type::$method", __LINE__);
							// check if method is available
							if (method_exists($type, $method) ||
								method_exists($type, $method . 'Action')) {
								// set the method name
								$this->_getLogger()
									->debug("Now adding $parameterName = " . $source[$z], __LINE__);
								// add the method name as request parameter
								$this->_getRequest()
									->setAttribute($parameterName, $source[$z]);
							}
							// if not a method name, it has to be a parameter
							else {
								// load the parameter name
								$key = $source[$z];
								// if a value is available, set it
								if (array_key_exists($z + 1, $source)) {
									$value = $source[++$z];
								}
								// if not, set parameter name as value also
								else {
									$value = $key;
								}
								// log the found parameter
								$this->_getLogger()
									->debug("Now adding $key = $value", __LINE__);
								// add the additional parameters to the request
								$this->_getRequest()->setAttribute($key, $value);
							}
						}
						// reset parameters in $_REQUEST
						$this->_getRequest()->toRequest();
					}
					// stop process
					break;
				}
			}
			// set the ActionForward in the context
			$this->getContext()->setActionForward($actionForward);
	    } 
	    catch (Exception $e) {
			// create action errors container
			$errors = new TechDivision_Controller_Action_Errors();
			// add error to container
			$errors->addActionError(
			    new TechDivision_Controller_Action_Error(
			        TDProject_Core_Controller_Util_ErrorKeys::SYSTEM_ERROR,
			        $e->__toString()
			    )
			);
			// log the exception
			$this->getLogger()->error($e->__toString());
			// save container in request
			$this->_saveActionErrors($errors);
			// set the ActionForward in the Context
			return $this->_findForward(
			    TDProject_Core_Controller_Util_GlobalForwardKeys::SYSTEM_ERROR
			);
		}
	}
	
	/**
	 * Sets the extracted URL parts.
	 * @param array $source The extracted URL parts
	 * @return TDProject_Core_Controller_Router
	 * 		The controller instance
	 */
	public function setSource(array $source)
	{
		$this->_source = $source;
		return $this;
	}
	
	/**
	 * Returns the extracted URL parts.
	 * 
	 * @return array The extracted URL parts
	 */
	public function getSource()
	{
		return $this->_source;
	}
	
	/**
	 * Returns the base URL of the application.
	 * 
	 * @return string The base URL
	 */
	public function getBaseUrl()
	{
		return $this->getApp()->getBaseUrl();
	}
	
	/**
	 * Returns the actual request URI from the request.
	 * 
	 * @return string The request URI
	 */
	public function getRequestURI()
	{
		return $this->_getRequest()->getRequestURI();
	}
	
	/**
	 * Tries to find the a rewrite for the passed URL.
	 * 
	 * @param TechDivision_Lang_String $rewriteUrl The URL to return the rewrite for
	 * @return TechDivision_Lang_String The rewrite URL
	 */
	public function rewrite(TechDivision_Lang_String $rewriteUrl)
	{
		// try to load the rewrite from the database
	    return $this->_getDelegate()->rewrite($rewriteUrl);
	}

	/**
	 * (non-PHPdoc)
	 * @see TDProject_Core_Controller_DispatchAction::_getMethodName()
	 */
    protected function _getMethodName($method)
    {
        return $method;
    }

	/**
	 * (non-PHPdoc)
	 * @see TDProject_Core_Controller_Abstract::_getBlock()
	 */
	protected function _getBlock(
	    TechDivision_Controller_Action_Forward $actionForward)
	{
	    return;
	}
}