<?php

/**
 * TDProject_Core_Block_Widget_Button_SystemUpdate
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

/**
 * @category    TDProject
 * @package     TDProject_Core
 * @copyright   Copyright (c) 2010 <info@techdivision.com> - TechDivision GmbH
 * @license     http://opensource.org/licenses/osl-3.0.php
 *              Open Software License (OSL 3.0)
 * @author      Johann Zelger <twtechdivision.com>
 */
class TDProject_Core_Block_Widget_Button_SystemUpdate
    extends TDProject_Core_Block_Widget_Button
    implements TDProject_Core_Interfaces_Block_Widget_Button {

    /**
     * The unique block name.
     * @var string
     */
    const BLOCK_NAME = 'systemUpdate';

    /**
     * The URL to update the system.
     * @var string
     */
    protected $_systemUpdateUrl = '';

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
			'method' => 'systemUpdate'
		);
		// set the URL to update the system
		$this->setSystemUpdateUrl($this->getUrl($params));
		// set the onClick event
		$this->setOnClick(
			'window.location="' . $this->getSystemUpdateUrl() . '"; return false;'
		);
    }

    /**
     * Sets the URL to update the system.
     *
     * @param string $updateUrl The URL to update the system
     * @return TDProject_Core_Block_Widget_Button_Update
     * 		The instance itself
     */
    public function setSystemUpdateUrl($systemUpdateUrl)
    {
		$this->_systemUpdateUrl = $systemUpdateUrl;
		return $this;
    }

    /**
     * Returns the URL to update the system.
     *
     * @return string The URL to update the system
     */
    public function getSystemUpdateUrl()
    {
		return $this->_systemUpdateUrl;
    }
}