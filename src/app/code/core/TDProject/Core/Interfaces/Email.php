<?php

/**
 * TDProject_Core_Interfaces_Email
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
 * @author      Tim Wagner <tw@techdivision.com>
 */
interface TDProject_Core_Interfaces_Email {
	
	/**
	 * Returns the mail's subject.
	 * 
	 * @return string
	 * 		The mail's subject
	 */
	public function getSubject();
	
	/**
	 * The mail's from addresses.
	 * 
	 * @return array
	 * 		The array with the mail's senders
	 */
	public function getFrom();
	
	/**
	 * The mail's to addresses.
	 * 
	 * @return array
	 * 		The array with the mail's receivers
	 */
	public function getTo();
	
	/**
	 * The body in HTML format.
	 * 
	 * @return string
	 * 		The mail body as HTML
	 */
	public function getBodyHtml();
	
	/**
	 * The body in simple text format.
	 * 
	 * @return string
	 * 		The mail body as simple text
	 */
	public function getBodyText();
	
	/**
	 * The template used for rendering
	 * the body in text format.
	 * 
	 * @return string
	 * 		The template for rendering the body as text
	 */
	public function getTemplateText();
	
	/**
	 * The template used for rendering
	 * the body in HTML format.
	 * 
	 * @return string
	 * 		The template for rendering the body as HTML
	 */
	public function getTemplateHtml();
}