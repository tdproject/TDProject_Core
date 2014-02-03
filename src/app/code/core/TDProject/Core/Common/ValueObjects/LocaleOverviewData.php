<?php

/**
 * TDProject_Core_Common_ValueObjects_LocaleOverviewData
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

require_once 'TechDivision/Lang/Object.php';
require_once 'TechDivision/Lang/String.php';
require_once 'TechDivision/Util/SystemLocale.php';
require_once 'TechDivision/Model/Interfaces/LightValue.php';
require_once 'TDProject/Core/Interfaces/Block/Widget/Element/Select/Option.php';

/**
 * This class is the data transfer object between the
 * model and the controller for the table user.
 *
 * Each class member reflects a database field and
 * the values of the related dataset.
 *
 * @category   	TDProject
 * @package     TDProject_ERP
 * @copyright  	Copyright (c) 2010 <info@techdivision.com> - TechDivision GmbH
 * @license    	http://opensource.org/licenses/osl-3.0.php
 * 				Open Software License (OSL 3.0)
 * @author      Tim Wagner <tw@techdivision.com>
 */
class TDProject_Core_Common_ValueObjects_LocaleOverviewData
    extends TechDivision_Util_SystemLocale
    implements TechDivision_Model_Interfaces_LightValue,
        TDProject_Core_Interfaces_Block_Widget_Element_Select_Option {

    /**
     * The locale's label used for rendering the option.
     * @var TechDivision_Lang_String
     */
    protected $_optionLabel = null;

    /**
     * Initializes the LVO with the data from
     * the passed locale.
     *
     * @param TechDivision_Util_SystemLocale $systemLocale
     * @return void
     */
    public function __construct(TechDivision_Util_SystemLocale $systemLocale)
    {
        // initialize the LVO with the data of the passed locale
        parent::__construct(
            $systemLocale->getLanguage(),
            $systemLocale->getCountry(),
            $systemLocale->getVariant()
        );
        // initialize the label with the locale itself
        $this->_optionLabel = new TechDivision_Lang_String($this->toString());
    }

    /**
     *
     * Enter description here ...
     * @param unknown_type $optionLable
     */
    public function setOptionLabel(TechDivision_Lang_String $optionLable)
    {
        $this->_optionLabel = $optionLabel;
    }

   	/**
   	 * (non-PHPdoc)
   	 * @see TDProject_Core_Interfaces_Block_Widget_Element_Select_Option::getOptionLabel()
   	 */
   	public function getOptionLabel()
   	{
   		return $this->_optionLabel;
   	}

	/**
	 * (non-PHPdoc)
	 * @see TDProject_Core_Interfaces_Block_Widget_Element_Select_Option::getOptionValue()
	 */
   	public function getOptionValue()
   	{
   		return $this->toString();
   	}

   	/**
   	 * (non-PHPdoc)
   	 * @see TDProject_Core_Interfaces_Block_Widget_Element_Select_Option::isSelected()
   	 */
   	public function isSelected(TechDivision_Lang_Object $value = null)
   	{
   		return $this->getOptionValue()->equals($value);
   	}
}