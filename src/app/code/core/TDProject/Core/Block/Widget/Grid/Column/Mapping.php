<?php

/**
 * TDProject_Core_Block_Widget_Grid_Column_Action
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

require_once 'TechDivision/Lang/Object.php';
require_once 'TDProject/Core/Block/Widget/Grid/Column.php';
require_once 'TDProject/Core/Block/Widget/Grid/Body/Row/Column/Mapping.php';
require_once 'TDProject/Core/Interfaces/Block/Widget/Grid/Column/Mapping.php';

/**
 * This class implements the form functionality
 * for handling the application settings.
 * 
 * Usage:
 * <code>
 * 		$grid->addColumn(
 * 			new TDProject_Core_Block_Widget_Grid_Column_Mapping(
 * 				$aCollection, 	// the Collection with the data to replace
 * 				'roleIdFk', 	// the ID of the field to be replaced
 * 				'roleId', 		// the ID of the field in the Collection
 * 				'name', 		// the property in the Collection of the value to replace
 * 				'Rolle', 		// the column label
 * 				20 				// the column width
 * 			)
 * 		);
 * </code>
 * 
 * @category    TProject
 * @package     TDProject_Core
 * @copyright   Copyright (c) 2010 <info@techdivision.com> - TechDivision GmbH
 * @license     http://opensource.org/licenses/osl-3.0.php
 *              Open Software License (OSL 3.0)
 * @author      Bastian Stangl <b.stangl@techdivision.com>
 */

require_once 'TDProject/Core/Interfaces/Block/Widget/Grid/Column/Action.php';

class TDProject_Core_Block_Widget_Grid_Column_Mapping
    extends TDProject_Core_Block_Widget_Grid_Column
    implements TDProject_Core_Interfaces_Block_Widget_Grid_Column_Mapping {
    
    /**
     * The Collection with the replacement data.
     * @var TechDivision_Collections_Interfaces_Collection
     */
   	protected $_collection = null;
    	
    /**
     * Initialize the block with the
     * apropriate template and name.
     * 
     * @return void
     */
    public function __construct(
    	TechDivision_Collections_Interfaces_Collection $collection, $sourceProperty, $targetProperty, $labelProperty, $label, $width) {
        // sets the members
        parent::__construct($sourceProperty, $label, $width);
        
        $this->_targetProperty = $targetProperty;
        $this->_labelProperty = $labelProperty;
        
        $this->_collection = $collection;
    }
    
    public function getTargetProperty() {
    	return $this->_targetProperty;
    }
    
    public function getLabelProperty() {
    	return $this->_labelProperty;
    }
    
    public function getCollection() {
    	return $this->_collection;
    }
    
    public function create(TDProject_Core_Interfaces_Block_Widget_Grid_Body_Row $row) {
    	return new TDProject_Core_Block_Widget_Grid_Body_Row_Column_Mapping($row, $this);
    }
}