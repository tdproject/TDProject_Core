<?php

/**
 * TDProject_Core_Common_XMLConfigParser
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
 * @author      Markus Stockbauer <m.stockbauer@techdivision.com>
 */
class TDProject_Core_Common_XMLConfigParser extends DOMDocument
{

	/**
	 * The name of the files to find and parse
	 * @var string
	 */
	protected $_filename = "api";

	/**
	 * The name of the files' root node
	 * @var string
	 */
	protected $_rootNode = "resources";

	/**
	 * The name of the files' nodes
	 * @var string
	 */
	protected $_node = "resource";

	/**
	 * Standardconstructor to initialize the necessary members.
	 *
	 * @return void
	 */
	public function __construct()
	{
	    // initialize the DOMDocument
	    parent::__construct('1.0', 'UTF-8');
	}

	/**
	 * Set the filename of the files to parse
	 * @param string $filename
	 */
	public function setFilename($filename)
	{
		$this->_filename = $filename;
	}

	/**
	 * Get the filename of the files to parse
	 * @return string The filename to parse
	 */
	public function getFilename()
	{
		return $this->_filename;
	}

	/**
	 * Set the root node name
	 * @param string $rootNode
	 */
	public function setRootNode($rootNode)
	{
		$this->_rootNode = $rootNode;
	}

	/**
	 * Get the root node name
	 * @return string The root node name
	 */
	public function getRootNode()
	{
		return $this->_rootNode;
	}

	/**
	 * Set the default node name
	 * @param string $node
	 */
	public function setNode($node)
	{
		$this->_node = $node;
	}

	/**
	 * Get the default node name
	 * @return string The default node name
	 */
	public function getNode()
	{
		return $this->_node;
	}

    /**
     * Returns the logger instance.
     *
     * @return TechDivision_Logger_Interfaces_Logger The instance
     */
    public static function _getLogger()
    {
        return TechDivision_Logger_Logger::forClass(
            __CLASS__,
            'TDProject/META-INF/log4php.properties'
        );
    }

	/**
	 * Parses the XML files of all packages and
	 * merges them to one.
	 *
	 * @return TechDivision_Core_Common_Navigation
	 * 		The merged Navigation structure
	 */
    public function parse()
    {
    	// initialize the array for the found XML files
    	$docs = array();
        // load the initial data necessary to start parsing
    	$filename = $this->getFilename();
    	$rootNode = $this->getRootNode();
    	$nodeName = $this->getNode();
        // initialize the directory iterator
        $directory = new RecursiveDirectoryIterator('.');
        $iterator = new RecursiveIteratorIterator($directory);
        $regex = new RegexIterator(
            $iterator, '/^\.\/app\/code\/.*\/TDProject.*\/' . $filename . '\.xml$/i',
            RecursiveRegexIterator::GET_MATCH
        );
        // load the XML files of all packages
        foreach ($regex as $key => $document) {
            for ($i = 0; $i < sizeof($document); $i++) {
                $docs[] = $document[$i];
            }
        }
        // create the new root node
        $document = $this->createElement($rootNode);
        // iterate over all found XML files
        for ($z = 0; $z < sizeof($docs); $z++) {
            // load the XML file
            $toMerge = new DOMDocument();
            $toMerge->load($docs[$z]);
            // initialize a new XPath expression
            $xPath = new DOMXPath($toMerge);
            // load and merge the resources of the found XML file
            foreach ($xPath->query("/$rootNode/$nodeName") as $node) {
                $toImport = $this->importNode($node, true);
                $document->appendChild($toImport);
            }
        }
        // append the root node
        $this->appendChild($document);
        // return the instance
        return $this;
    }
}