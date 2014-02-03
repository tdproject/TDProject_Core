<?php

/**
 * TDProject_Core_Block_Navigation
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

require_once 'TechDivision/Collections/TreeMap.php';
require_once 'TDProject/Core/Block/Abstract.php';
require_once 'TDProject/Core/Block/Navigation/Element.php';
require_once 'TDProject/Core/Block/Navigation/SortByPositionComparator.php';

/**
 * @category    TDProject
 * @package     TDProject_Core
 * @copyright   Copyright (c) 2010 <info@techdivision.com> - TechDivision GmbH
 * @license     http://opensource.org/licenses/osl-3.0.php
 *              Open Software License (OSL 3.0)
 * @author      Tim Wagner <tw@techdivision.com>
 */
class TDProject_Core_Block_Navigation
    extends TDProject_Core_Block_Abstract {

    /**
     * Initialize the block with the
     * apropriate template and name.
     *
     * @return void
     */
    public function __construct(
        TechDivision_Controller_Interfaces_Context $context) {
        // set the internal name
        $this->_setBlockName('navigation');
        // set the template name
        $this->_setTemplate('www/design/core/templates/navigation.phtml');
        // call the parent constructor
        parent::__construct($context);
    }

    /**
     * Loads the navigation structure from the
     * system user and returns a TreeMap with
     * the navigation elements to render.
     *
     * @return TechDivision_Collections_TreeMap
     * 		The TreeMap with the navigation elements
     */
    public function getNavigation()
    {
        // initialize the TreeMap with the comparator for sorting the elements
        $root = new TDProject_Core_Block_Navigation_Element(
            $this,
            new TechDivision_Lang_String('/root'),
            new TechDivision_Lang_Integer(0),
            new TechDivision_Lang_Boolean(false)
        );        
        // check if a system user is registered
        if (($systemUser = $this->getSystemUser()) != null) {
            // load the request
            $request = $this->getRequest();
            // load the path of the selected element
            $path = $request->getAttribute(
                TechDivision_Controller_Action_Controller::ACTION_PATH
            );
            // if no path can be found as request attribute
    		if ($path == null) {
    		    // try to load it as request parameter
    			$path = $request->getParameter(
    			    TechDivision_Controller_Action_Controller::ACTION_PATH,
    			    FILTER_SANITIZE_STRING
    			);
    		}
    		// initialize a new DOMDocument with the API structure
    		$navigation = new DOMDocument();
    		$navigation->loadXML($systemUser->getNavigation());
            $xPath = new DOMXPath($navigation);
            // load the resource nodes
            foreach ($xPath->query("/navigation/element") as $key => $node) {
                // add the element to the TreeMap
                if ($childElement = $this->appendChilds($node, $path)) {
                    $root->addChild($childElement);
                }
            }
        }
        // return the root's children
        return $root->getChildren();
    }
    
    /**
     * Creates and returns a new navigation element and appends its 
     * child navigation elements.
     * 
     * @param DOMNode $node The DOMNode with the navigation elements to load
     * @param string $path The path of the selected navigation element
     * @return TDProject_Core_Block_Navigation_Element
     * 		The initialized navigation element
     */
    public function appendChilds(DOMNode $node, $path) {
        // initialize the element itself
        $element = $this->generateElement($node);
        // try to load the child elements
        if ($node->getElementsByTagName('children')->length > 0) {
            $childs = $node->getElementsByTagName('element');
        	foreach ($childs as $key => $child) {
        	    // if a child element was found, add it
        	    if ($childElement = $this->appendChilds($child, $path)) {
        	        $element->addChild($childElement);
        	    }
        	}
        }
       	// set the navigation element active if necessary
      	$element->setActive(
       		new TechDivision_Lang_String($path)
       	);
        // check if the system user has the rights to access the element
        $isAllowed = $this->isAllowed($element->getPath(), '__default');
        // if not, return
        if ($isAllowed === false) {
            return;
        }
        // else, return the initialized element with its childs
       	return $element;
    }

    /**
     * Creates a new navigation element from a given navigation node
     *
     * @param $node
     * 		The node to generate the new navigation element from
     *
     * @return TDProject_Core_Block_Navigation_Element
     * 		The generated element
     */
    public function generateElement($node) {
    	// initialize a navigation element for each
    	$element = new TDProject_Core_Block_Navigation_Element(
	    	$this,
	    	new TechDivision_Lang_String($node->getAttribute('name')),
	    	TechDivision_Lang_Integer::valueOf(
	    		new TechDivision_Lang_String($node->getAttribute('position'))
	    	),
	    	new TechDivision_Lang_Boolean($node->getAttribute('visible'))
       	);
        // return the initialized element
       	return $element;
    }
}