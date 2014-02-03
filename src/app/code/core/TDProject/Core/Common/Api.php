<?php

/**
 * TDProject_Core_Common_Api
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

require_once 'TDProject/Core/Common/XMLConfigParser.php';

/**
 * @category   	TDProject
 * @package    	TDProject_Core
 * @copyright  	Copyright (c) 2010 <info@techdivision.com> - TechDivision GmbH
 * @license    	http://opensource.org/licenses/osl-3.0.php
 * 				Open Software License (OSL 3.0)
 * @author      Tim Wagner <t.wagner@techdivision.com>
 */
class TDProject_Core_Common_Api
    extends TDProject_Core_Common_XMLConfigParser {

	/**
	 * Standardconstructor to initialize the necessary members.
	 *
	 * @return void
	 */
	public function __construct()
	{
	    parent::__construct();
	}


	/**
	 * Parses the api.xml files of all packages and
	 * merges them to one.
	 *
	 * @return TechDivision_Core_Common_Api
	 * 		The merged API structure
	 */
    public function parse()
    {
        // set filename and node information to parse
        $this->setFilename("api");
        $this->setRootNode("resources");
        $this->setNode("resource");
        // parse the subdirectories for api files
        return parent::parse();
    }
}