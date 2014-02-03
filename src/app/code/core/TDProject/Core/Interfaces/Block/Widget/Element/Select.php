<?php

/**
 * TDProject_Core_Interfaces_Block_Widget_Element_Select
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

require_once 'TechDivision/Collections/Interfaces/Collection.php';
require_once 'TDProject/Core/Interfaces/Block/Widget/Element.php';
require_once 'TDProject/Core/Interfaces/Block/Widget/Element/Select/Option.php';

/**
 * @category    TDProject
 * @package     TDProject_Core
 * @copyright   Copyright (c) 2010 <info@techdivision.com> - TechDivision GmbH
 * @license     http://opensource.org/licenses/osl-3.0.php
 *              Open Software License (OSL 3.0)
 * @author      Tim Wagner <tw@techdivision.com>
 */
interface TDProject_Core_Interfaces_Block_Widget_Element_Select
	extends TDProject_Core_Interfaces_Block_Widget_Element {

	/**
	 * Sets the Collection with the option elements
	 * to render.
	 *
	 * @param TechDivision_Collections_Interfaces_Collection $options
	 * 		Collection with the options to render
     * @return TDProject_Core_Interfaces_Block_Widget_Element_Select
     * 		The instance itself
	 */
	public function setOptions(
	    TechDivision_Collections_Interfaces_Collection $options);

	/**
	 * Returns the Collection to render the option elements
	 * of the select field.
	 *
	 * @return TechDivision_Collections_Interfaces_Collection
	 * 		The Collection to render the option elements for
	 */
	public function getOptions();

	/**
	 * Returns the option's label to render.
	 *
	 * @param TDProject_Core_Interfaces_Block_Widget_Element_Select_Option $option
	 * 		The option to render the label for
	 * @return TechDivision_Lang_String
	 * 		The option label to render
	 */
	public function getOptionLabel(
		TDProject_Core_Interfaces_Block_Widget_Element_Select_Option $option);

	/**
	 * Returns the option's value to render.
	 *
	 * @param TDProject_Core_Interfaces_Block_Widget_Element_Select_Option $option
	 * 		The option to render the value for
	 * @return TechDivision_Lang_String
	 * 		The option value to render
	 */
	public function getOptionValue(
		TDProject_Core_Interfaces_Block_Widget_Element_Select_Option $option);

	/**
	 * Returns TRUE if the option is selected,
	 * else FALSE.
	 *
	 * @param TDProject_Core_Interfaces_Block_Widget_Element_Select_Option $option
	 * 		The option to check be selected
	 * @return boolean
	 * 		TRUE if the option has to be rendered selected, else FALSE
	 */
	public function isSelected(
		TDProject_Core_Interfaces_Block_Widget_Element_Select_Option $option);

    /**
     * Flag to render the dummy option or not.
     *
     * @param boolean $dummyOption
     * 		TRUE if a dummy option has to be rendered, else FALSE
     * @return TDProject_Core_Interfaces_Block_Widget_Element_Select
     * 		The instance itself
     */
    public function setDummyOption($dummyOption = true);

	/**
	 * Returns TRUE if a dummy option has to be rendered,
	 * else FALSE.
	 *
	 * @return boolean
	 * 		TRUE if a dummy option has to be rendered, else FALSE
	 */
	public function hasDummyOption();
}