<?php

/**
 * TDProject_Core_Common_Navigation
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
 * @author      Markus Stockbauer <m.stockbauer@techdivision.com>
 */
class TDProject_Core_Common_Navigation
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
	 * Parses the navigation.xml files of all packages and
	 * merges them to one.
	 *
	 * @return TechDivision_Core_Common_Navigation
	 * 		The merged Navigation structure
	 */
    public function parse()
    {
        // set filename and node information to parse
        $this->setFilename("navigation");
        $this->setRootNode("navigation");
        $this->setNode("element");
        // parse the subdirectories for navigation files
        return parent::parse();
    }
}