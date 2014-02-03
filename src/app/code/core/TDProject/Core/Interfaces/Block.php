<?php

/**
 * TDProject_Interfaces_Block
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

/**
 * @category    TDProject
 * @package     TDProject
 * @copyright   Copyright (c) 2010 <info@techdivision.com> - TechDivision GmbH
 * @license     http://opensource.org/licenses/osl-3.0.php
 *              Open Software License (OSL 3.0)
 * @author      Tim Wagner <tw@techdivision.com>
 */
interface TDProject_Core_Interfaces_Block {

	/**
	 * Returns the CSS ID used for rendering
	 * the element.
	 *
	 * @return The CSS ID to use
	 */
	public function getCssId();

	/**
	 * Returns the CSS class used for rendering
	 * the element.
	 *
	 * @return string The CSS class to use
	 */
	public function getCssClass();

    /**
     * The internal block name used by the _getChildHtml() method.
     *
     * @return string The unique block name
     */
    public function getBlockName();

    /**
     * The block title used for e. g. rendering a page
     * or navigation title.
     *
     * @return string The block's title
     */
    public function getBlockTitle();

    /**
     * Returns the path, recursively build from the block names.
     *
     * @return string
     * 		The requested block path
     */
    public function getBlockPath();

    /**
     * Prepares the layout of the block and the
     * child blocks.
     *
     * @return TDProject_Interfaces_Block
     * 		Reference to the block itself
     */
    public function prepareLayout();

    /**
     * Loads the templates and renders the output of the
     * actual block and it's childs.
     *
     * @return void
     */
    public function toHtml();

    /**
     * Adds the passed block instance to the internal
     * childs.
     *
     * @param TDProject_Core_Interfaces_Block $block
     * 		The internal block to add
     * @return TDProject_Interfaces_Block
     * 		Reference to the block itself
     */
    public function addBlock(TDProject_Core_Interfaces_Block $block);

    /**
     * Registers a block in the page head, registered as
     * a Context attribute.
     *
     * @param TDProject_Core_Interfaces_Block_Widget_Script $script
     * 		The block with the JavaScript content to add
     * @return TDProject_Interfaces_Block
     * 		Reference to the block itself
     * @see TDProject_Core_Interfaces_Block::addBlock(TDProject_Core_Interfaces_Block $block)
     */
    public function addScript(TDProject_Core_Interfaces_Block_Widget_Script $script);

    /**
     * Registers a block in the page head, registered as
     * a Context attribute.
     *
     * @param TDProject_Core_Interfaces_Block_Widget_Link $link
     * 		The block with the CSS link to add
     * @return TDProject_Interfaces_Block
     * 		Reference to the block itself
     * @see TDProject_Core_Interfaces_Block::addBlock(TDProject_Core_Interfaces_Block $block)
     */
    public function addLink(TDProject_Core_Interfaces_Block_Widget_Link $link);

    /**
     * Returns the acutal request instance.
     *
     * @return TechDivision_HttpUtils_Interfaces_Request The request instance
     */
    public function getRequest();

    /**
     * Returns the actual system user instance.
     *
     * @return TDProject_Core_Common_ValueObjects_System_UserValue
     * 		The request system user instance
     */
    public function getSystemUser();

    /**
     * Returns the TRUE if auto rendering is allowed or not.
     *
     * @return TechDivision_Lang_Boolean
     */
    public function isAutoRender();

    /**
     * Returns TRUE if the block was already rendered,
     * else FALSE.
     *
     * @return boolean
     * 		TRUE if the block was already rendered, else FALSE
     */
    public function isRendered();

    /**
     * Sets the path to the block template to
     * use.
     *
     * @param string $template Path and filename of the template to use
     * @return void
     */
    public function setTemplate($template);

    /**
     * Returns the path to the block template
     * to use.
     *
     * @return string Path and filename of the template to use
     */
    public function getTemplate();

    /**
     * Returns the parent block if available.
     *
     * @return TDProject_Core_Interfaces_Block
     * 		The parent block
     */
    public function getParent();
}