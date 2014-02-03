<?php

/**
 * TDProject_Core_Block_Widget_Button_CleanCache
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

require_once 'TDProject/Core/Block/Widget/Button.php';
require_once 'TDProject/Core/Interfaces/Block/Widget/Button.php';
require_once 'TDProject/Core/Interfaces/Block/Widget/Form.php';

/**
 * @category    TDProject
 * @package     TDProject_Core
 * @copyright   Copyright (c) 2010 <info@techdivision.com> - TechDivision GmbH
 * @license     http://opensource.org/licenses/osl-3.0.php
 *              Open Software License (OSL 3.0)
 * @author      Johann Zelger <twtechdivision.com>
 */
class TDProject_Core_Block_Widget_Button_CleanCache
    extends TDProject_Core_Block_Widget_Button
    implements TDProject_Core_Interfaces_Block_Widget_Button {

    /**
     * The unique block name.
     * @var string
     */
    const BLOCK_NAME = 'cleanCache';

    /**
     * The URL to clean the application cache.
     * @var string
     */
    protected $_cleanCacheUrl = '';

    /**
     * Initialize the button with the context.
     *
     * @param string $blockTitle The button label
     * @return void
     */
    public function __construct(
        TDProject_Core_Interfaces_Block_Widget_Form $form,
        $blockTitle) {
        // call the parent constructor
        parent::__construct($form->getContext(), self::BLOCK_NAME, $blockTitle);
    	// set the icon to use
		$this->setIcon('ui-icon-disk');
		// initialize the params for the clean cache URL
		$params = array(
			'path' => '/setting',
			TDProject_Application::CLEAN_CACHE_MODE => Zend_Cache::CLEANING_MODE_ALL
		);
		// set the URL to clean the application cache
		$this->setCleanCacheUrl($this->getUrl($params));
		// set the onClick event
		$this->setOnClick(
			'window.location="' . $this->getCleanCacheUrl() . '"; return false;'
		);
    }

    /**
     * Sets the URL to clean the application cache.
     *
     * @param string $cleanCacheUrl The URL to clean the cache
     * @return TDProject_Core_Block_Widget_Button_CleanCache
     * 		The instance itself
     */
    public function setCleanCacheUrl($cleanCacheUrl)
    {
		$this->_cleanCacheUrl = $cleanCacheUrl;
		return $this;
    }

    /**
     * Returns the URL to clean the application cache.
     *
     * @return string The URL to clean the appclication cache
     */
    public function getCleanCacheUrl()
    {
		return $this->_cleanCacheUrl;
    }
}