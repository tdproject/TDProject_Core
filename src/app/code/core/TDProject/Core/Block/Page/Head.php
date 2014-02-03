<?php

/**
 * TDProject_Core_Block_Page_Head
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

require_once 'TDProject/Core/Block/Abstract.php';
require_once 'TDProject/Core/Block/Widget/Script.php';
require_once 'TDProject/Core/Block/Widget/Link.php';

/**
 * @category    TDProject
 * @package     TDProject_Core
 * @copyright   Copyright (c) 2010 <info@techdivision.com> - TechDivision GmbH
 * @license     http://opensource.org/licenses/osl-3.0.php
 *              Open Software License (OSL 3.0)
 * @author      Johann Zelger <jz@techdivision.com>
 */
class TDProject_Core_Block_Page_Head
	extends TDProject_Core_Block_Abstract 
{

    /**
     * Holds the unique name of the block.
     * @var string
     */
    const BLOCK_NAME = 'head';

    /**
     * The page instance.
     * @var TDProject_Core_Block_Page
     */
    protected $_page = null;

    /**
     * Flag for minifying the JS and CSS files
     * @var boolean
     */
    protected $_minify = false;

    /**
     * Initialize the block with the
     * apropriate template and name.
     *
     * @param TDProject_Core_Block_Page $page The page instance
     *
     * @return void
     */
    public function __construct(
        TDProject_Core_Block_Page $page)
    {
        // call the parent constructor
        parent::__construct($page->getContext());
        // set the page instance
        $this->_page = $page;
        // set block name
        $this->_setBlockName(TDProject_Core_Block_Page_Head::BLOCK_NAME);
        // set the template name
        $this->_setTemplate('www/design/core/templates/page/head.phtml');
        // register the head in the Context instance
        $this->getContext()->setAttribute($this->getBlockName(), $this);
    }

    /**
     * Returns the page title.
     *
     * @return TechDivision_Lang_String The page title
     */
    public function getPageTitle()
    {
    	return $this->_page->getBlockTitle();
    }

    /**
     * (non-PHPdoc)
     * @see TDProject_Core_Block_Abstract::prepareLayout()
     */
    public function prepareLayout()
    {
    	// include the necessary CSS libraries
    	$this->addLink(new TDProject_Core_Block_Widget_Link($this->getContext(), 'demoTabelUICss' , $this->getDesignUrl('core/templates/global/css/dataTables/demo_table_jui.css')));
    	$this->addLink(new TDProject_Core_Block_Widget_Link($this->getContext(), 'treeViewCss' , $this->getDesignUrl('core/templates/global/css/treeview/treeview.css')));
    	$this->addLink(new TDProject_Core_Block_Widget_Link($this->getContext(), 'menuCss' , $this->getDesignUrl('core/templates/global/css/fgMenu/fg.menu.css')));
    	$this->addLink(new TDProject_Core_Block_Widget_Link($this->getContext(), 'reset960Css' , $this->getDesignUrl('core/templates/global/css/960/reset.css')));
    	$this->addLink(new TDProject_Core_Block_Widget_Link($this->getContext(), '960Css' , $this->getDesignUrl('core/templates/global/css/960/960.css')));
    	$this->addLink(new TDProject_Core_Block_Widget_Link($this->getContext(), 'text960Css' , $this->getDesignUrl('core/templates/global/css/960/text.css')));
    	$this->addLink(new TDProject_Core_Block_Widget_Link($this->getContext(), 'jQueryUICss' , $this->getDesignUrl('core/templates/global/css/smoothness/jquery-ui-1.8.16.custom.css')));
    	$this->addLink(new TDProject_Core_Block_Widget_Link($this->getContext(), 'jgrowl' , $this->getDesignUrl('core/templates/global/css/jgrowl/jquery.jgrowl.css')));
    	$this->addLink(new TDProject_Core_Block_Widget_Link($this->getContext(), 'jqplot' , $this->getDesignUrl('core/templates/global/css/jqplot/jquery.jqplot.min.css')));
    	$this->addLink(new TDProject_Core_Block_Widget_Link($this->getContext(), 'pageCss' , $this->getDesignUrl('core/templates/global/css/style.css')));
    	$this->addLink(new TDProject_Core_Block_Widget_Link($this->getContext(), 'fileuploaderCss' , $this->getDesignUrl('core/templates/global/css/fileuploader/fileuploader.css')));
    	// include the necessary JavaScript libraries
    	$this->addScript(new TDProject_Core_Block_Widget_Script($this, 'jquery' , $this->getDesignUrl('core/templates/global/js/jquery-1.6.4.min.js')));
    	$this->addScript(new TDProject_Core_Block_Widget_Script($this, 'jquery.ui' , $this->getDesignUrl('core/templates/global/js/jquery-ui-1.8.16.custom.min.js')));
    	$this->addScript(new TDProject_Core_Block_Widget_Script($this, 'jquery.fogLoader' , $this->getDesignUrl('core/templates/global/js/jquery.fogLoader.0.9.1.js')));
    	$this->addScript(new TDProject_Core_Block_Widget_Script($this, 'jquery.jgrowl' , $this->getDesignUrl('core/templates/global/js/jquery.jgrowl.js')));
    	$this->addScript(new TDProject_Core_Block_Widget_Script($this, 'jquery.dataTables' , $this->getDesignUrl('core/templates/global/js/jquery.dataTables.js')));
    	$this->addScript(new TDProject_Core_Block_Widget_Script($this, 'jquery.jstree' , $this->getDesignUrl('core/templates/global/js/jquery.jstree.js')));
    	$this->addScript(new TDProject_Core_Block_Widget_Script($this, 'jquery.sparklines' , $this->getDesignUrl('core/templates/global/js/jquery.sparkline.js')));
    	$this->addScript(new TDProject_Core_Block_Widget_Script($this, 'jquery.fgmenu' , $this->getDesignUrl('core/templates/global/js/fg.menu.js')));
    	$this->addScript(new TDProject_Core_Block_Widget_Script($this, 'config' , $this->getDesignUrl('core/templates/global/js/config.js')));
    	$this->addScript(new TDProject_Core_Block_Widget_Script($this, 'jquery.jqplot' , $this->getDesignUrl('core/templates/global/js/jquery.jqplot.min.js')));
    	$this->addScript(new TDProject_Core_Block_Widget_Script($this, 'jquery.jqplot.highlighter' , $this->getDesignUrl('core/templates/global/js/plugins/jqplot.highlighter.min.js')));
    	$this->addScript(new TDProject_Core_Block_Widget_Script($this, 'jquery.jqplot.cursor' , $this->getDesignUrl('core/templates/global/js/plugins/jqplot.cursor.min.js')));
    	$this->addScript(new TDProject_Core_Block_Widget_Script($this, 'jquery.jqplot.dateAxisRenderer' , $this->getDesignUrl('core/templates/global/js/plugins/jqplot.dateAxisRenderer.min.js')));
    	$this->addScript(new TDProject_Core_Block_Widget_Script($this, 'filuploader' , $this->getDesignUrl('core/templates/global/js/fileuploader.js')));
    	$this->addScript(new TDProject_Core_Block_Widget_Script($this, 'jquery.validate' , $this->getDesignUrl('core/templates/global/js/jquery.validate.min.js')));
    	$this->addScript(new TDProject_Core_Block_Widget_Script($this, 'jquery.timepicker' , $this->getDesignUrl('core/templates/global/js/jquery-ui-timepicker-addon.js')));
    	// prepare the parent layout and return
    	return parent::prepareLayout();
    }

    /**
     * Concatenates the URL's of all CSS in a minify compatible
     * URL and replaces the CSS tags with minify one.
     *
     * @return void
     */
    protected function _minifyCSS()
    {
    	// load the application base URL
    	$baseUrl = $this->getBaseUrl();
    	if ($baseUrl != '/') {
    		$baseUrl .= '/';
    	}
    	// load CSS base URL
    	$cssUrl = $this->getDesignUrl('core/templates/global/css/');
    	// prepare the base path
    	$path = $baseUrl . 'min/?b=' .  substr($cssUrl, 1, strlen($cssUrl) - 2) . '&f=';
        // inizialize the array with the CSS files to include
        $scripts = array();
        // iterate over all CSS files
        foreach ($this->_getChilds() as $child) {
            if ($child instanceof TDProject_Core_Block_Widget_Link) {
                // prepare the path of the CSS file
                $scripts[] = str_replace($cssUrl, '', $child->getBlockTitle());
                // mark the block as already rendered
                $child->setRendered();
            }
        }
        // concatenate the paths
        $path .= implode(',', $scripts);
    	// add a new CSS block linked to the cached CSS file
    	$this->addLink(new TDProject_Core_Block_Widget_Link($this->getContext(), 'css' , $path));
    }

    /**
     * Concatenates the URL's of all JavaScript in a minify compatible
     * URL and replaces the JavaScript tags with minify one.
     *
     * @return void
     */
    protected function _minifyJS()
    {
    	// load the application base URL
    	$baseUrl = $this->getBaseUrl();
    	if ($baseUrl != '/') {
    		$baseUrl .= '/';
    	}
        // load JavaScript base URL
    	$jsUrl = $this->getDesignUrl('core/templates/global/js/');
        // prepare the base path
        $path = $baseUrl . 'min/?b=' .  substr($jsUrl, 1, strlen($jsUrl) - 2) . '&f=';
        // inizialize the array with the JS files to include
        $scripts = array();
        // iterate over all JS files
        foreach ($this->_getChilds() as $child) {
            if ($child instanceof TDProject_Core_Interfaces_Block_Widget_Script) {
                // prepare the path of the JS file
                $scripts[] = str_replace($jsUrl, '', $child->getBlockTitle());
                // mark the block as already rendered
                $child->setRendered();
            }
        }
        // concatenate the paths
        $path .= implode(',', $scripts);
    	// add a new JS block linked to the cached JS file
    	$this->addScript(new TDProject_Core_Block_Widget_Script($this, 'js' , $path));
    }

    /**
     * (non-PHPdoc)
     * @see TDProject_Core_Block_Abstract::toHtml()
     */
    public function toHtml()
    {
    	// minitfy the CS files
    	if ($this->_minify) {
	    	$this->_minifyCSS();
	    	$this->_minifyJS();
    	}
    	// render the template
    	parent::toHtml();
    }
}