<?php
/**
* TDProject_Core_Block_Widget_Element_Input_Textfield_DatePicker
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
 * @copyright  	Copyright (c) 2011 <info@techdivision.com> - TechDivision GmbH
 * @license    	http://opensource.org/licenses/osl-3.0.php
 * 				Open Software License (OSL 3.0)
 * @author      Markus Berwanger <m.berwanger@techdivision.com>
 */

class TDProject_Core_Block_Widget_Element_Input_Textfield_DatePicker
    extends TDProject_Core_Block_Widget_Element_Input_Textfield
{
    
    /**
     * Initialize the toolbar with the apropriate template and name.
     * 
     * @param TDProject_Core_Interfaces_Block_Widget_Form The ActionForm instance the element is bound to
     * @param string $blockName The block name of the element, alias the property
     * @param string $blockTitle The block title of the element, alias the lable
     * @return void
     */
    public function __construct(TDProject_Core_Interfaces_Block_Widget_Form $form, $blockName, $blockTitle) {
        // call the parent constructor
        parent::__construct($form, $blockName, $blockTitle);
        // set the template name
        $this->_setTemplate('www/design/core/templates/widget/element/input/textfield/date_picker.phtml');
    }
}