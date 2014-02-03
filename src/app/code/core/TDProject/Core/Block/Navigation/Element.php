<?php

/**
 * TDProject_Core_Block_Navigation_Element
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

require_once 'TechDivision/Lang/Object.php';
require_once 'TechDivision/Lang/String.php';
require_once 'TechDivision/Lang/Integer.php';
require_once 'TechDivision/Lang/Boolean.php';
require_once 'TDProject/Core/Block/Navigation.php';
require_once 'TDProject/Core/Block/Navigation/SortByPositionComparator.php';

/**
 * @category    TDProject
 * @package     TDProject
 * @copyright   Copyright (c) 2010 <info@techdivision.com> - TechDivision GmbH
 * @license     http://opensource.org/licenses/osl-3.0.php
 *              Open Software License (OSL 3.0)
 * @author      Tim Wagner <tw@techdivision.com>
 */
class TDProject_Core_Block_Navigation_Element
    extends TechDivision_Lang_Object {

    /**
     * The block that requests rendering the navigation.
     * @var TDProject_Core_Block_Navigation
     */
    protected $_block = null;

    /**
     * The selected navigation path.
     * @var TechDivision_Lang_String
     */
    protected $_path = null;

    /**
     * Flag that the navigation element is the active one.
     * @var boolean
     */
    protected $_active = false;

    /**
     * The position of the navigation element.
     * @var TechDivision_Lang_Integer
     */
    protected $_position = null;

    /**
     * The flag to make the navigation element visible or not.
     * @var TechDivision_Lang_Boolean
     */
    protected $_visible = null;

    /**
     * Contains child elements of the current navigation element.
     * @var TechDivision_Collections_TreeMap
     */
    protected $_children = null;
    
    /**
     * The parent navigation element.
     * @var TDProject_Core_Block_Navigation_Element
     */
    protected $_parent = null;

    /**
	 * Initializes the navigation element with the
	 * necessary values.
	 *
	 * @param TDProject_Core_Block_Navigation $block
	 * 		The block that requests rendering the navigation
	 * @param TechDivision_Lang_String $path
	 * 		The selected navigation path
	 * @param TechDivision_Lang_Integer $position
	 * 		The position of the navigation element
	 * @param TechDivision_Lang_Boolean $visible
	 * 		The flag to make the navigation element visible or not
     */
    public function __construct(
        TDProject_Core_Block_Navigation $block,
        TechDivision_Lang_String $path,
        TechDivision_Lang_Integer $position,
        TechDivision_Lang_Boolean $visible) {
        $this->_block = $block;
        $this->_path = $path;
        $this->_position = $position;
        $this->_visible = $visible;
        $this->_children = new TechDivision_Collections_TreeMap(
            new TDProject_Core_Block_Navigation_SortByPositionComparator()
        );
    }

    /**
     * Translate the navigation element by using
     * the block's tranlation method.
     *
     * @return string The translated string
     */
    public function translate()
    {
        return $this->_block->getApp()->translate(
            new TechDivision_Lang_String($this->getBlockPath()),
            new TechDivision_Lang_String($this->_block->getModuleName())
        );
    }

    /**
     * Sets the navigation element active depending
     * on the value of the passed path.
     *
     * @param $path TechDivision_Lang_String
     * 		The path to compare the internal one with
     * @return void
     */
    public function setActive(TechDivision_Lang_String $path)
    {
        // compare the path and make the element active
        if ($this->getPath()->equals($path)) {
            $this->_active = true;
        }
    }

    /**
     * Adds an element block to the child collection of this element
     *
     * @todo implement removeChild method
     * @param $child TDProject_Core_Block_Navigation_Element
     * 		The child element block to add
     * @return void
     */
    public function addChild(TDProject_Core_Block_Navigation_Element $child) {
    	$this->_children->add($child->getPath(), $child->setParent($this));
    }

    /**
     * Returns true, if the navigation element has children, otherwise false
     *
     * @return bool
     */
    public function hasChildren() {
    	if($this->_children->size() > 0) {
    		return true;
    	}
    	return false;
    }

    /**
     * Returns the currently added navigation children
     * @return TechDivision_Collections_TreeMap
     */
    public function getChildren() {
    	return $this->_children;
    }

    /**
     * Returns the URL the navigation represents.
     *
	 * @return string The URL the navigation element represents
	 * @see TDProject/Application#getUrl(array $params = array())
     */
    public function getUrl()
    {
        // the URL params to append
        $params = array(
            'path' => "$this->_path"
        );
        // returns the URL
        return $this->_block->getUrl($params);
    }

    /**
     * Returns the active flag of the navigation element.
     *
     * @return boolean
     * 		TRUE if the navigation element is the active, else FALSE
     */
    public function isActive()
    {
        return $this->_active;
    }

    /**
     * The selected navigation path.
     *
     * @return TechDivision_Lang_String
     * 		The selected navigation path
     */
    public function getPath()
    {
        return $this->_path;
    }

    /**
     * Returns the position of the navigation element.
     *
     * @return TechDivision_Lang_Integer
     * 		The internal position
     */
    public function getPosition()
    {
        return $this->_position;
    }

    /**
     * Returns TRUE if the navigation element visble
     * has to be visible, else FALSE.
     *
     * @return TechDivision_Lang_Boolean
     * 		TRUE if the navigation element has to be visible, else FALSE
     */
    public function isVisible()
    {
        return $this->_visible->booleanValue();
    }
    
    /**
     * Sets the parent navigation node.
     * 
     * @param TDProject_Core_Block_Navigation_Element $parent
     * 		The parent navigation node
     * @return TDProject_Core_Block_Navigation_Element
     * 		The node itself
     */
    public function setParent(TDProject_Core_Block_Navigation_Element $parent)
    {
        $this->_parent = $parent;
        return $this;
    }
    
    /**
     * Returns the parent navigation node.
     * 
     * @return TDProject_Core_Block_Navigation_Element
     * 		The parent navigation node
     */
    public function getParent()
    {
        return $this->_parent;
    }
    
    /**
     * Returns the block path with the key for
     * the message resources.
     * 
     * @return TechDivision_Lang_String
     * 		The key for the message resource used for translation
     */
    public function getBlockPath()
    {
        // check if a parent node is available
        if ($parent = $this->getParent()) {
            // if yes, load, concatenate and return the block path
            return $parent->getBlockPath()
                ->concat($this->getPath()->replace('/', '.'));    
        }
        // if not, load the block path of the block
        $blockPath = new TechDivision_Lang_String(
            $this->_block->getBlockPath()
        );
        // and concatente it with the path of the acutal navigation element
        return $blockPath->concat($this->getPath()->replace('/', '.'));   
    }
}