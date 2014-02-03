<?php

/**
 * TDProject_Core_Block_Page_Footer
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
class TDProject_Core_Block_Page_Footer
	extends TDProject_Core_Block_Abstract
{

    /**
     * Holds the unique name of the block.
     * @var string
     */
    const BLOCK_NAME = 'footer';

    /**
     * The page instance.
     * @var TDProject_Core_Block_Page
     */
    protected $_page = null;

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
        $this->_setBlockName(TDProject_Core_Block_Page_Footer::BLOCK_NAME);
        // set the template name
        $this->_setTemplate('www/design/core/templates/page/footer.phtml');
        // register the head in the Context instance
        $this->getContext()->setAttribute($this->getBlockName(), $this);
    }
}