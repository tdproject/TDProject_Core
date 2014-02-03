<?php

/**
 * TDProject_Core_Interfaces_Block_Widget_Element
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
 * @author      Tim Wagner <tw@techdivision.com>
 */
interface TDProject_Core_Interfaces_Block_Widget_Element
	extends TDProject_Core_Interfaces_Block_Widget {
	
	/**
	 * Returns the current value of the element.
	 * 
	 * @return TechDivision_Lang_Object The current value
	 */
	public function getValue();
	
	/**
	 * Returns the html width of the element.
	 * 
	 * @return TechDivision_Lang_Object The current width
	 */
	public function getWidth();
	
	/**
	 * Returns TRUE if the element has to be rendered
	 * disabled, else FALSE.
	 * 
	 * @return boolean 
	 * 		TRUE if the element has to be disabled, else FALSE
	 */
	public function isDisabled();
	
	/**
	 * Returns TRUE if the element has to be marked as
	 * mandatory, else FALSE.
	 * 
	 * @return boolean 
	 * 		TRUE if the element has to be marked as mandatory, else FALSE
	 */
	public function isMandatory();
    
    /**
     * Returns the ActionForm the element is bound to.
     * 
     * @return TDProject_Core_Interfaces_Block_Form
     * 		The ActionForm instance the element is bound to
     */
    public function getForm();
}