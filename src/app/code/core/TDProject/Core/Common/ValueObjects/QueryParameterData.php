<?php

/**
 * TDProject_Core_Common_ValueObjects_QueryParameterData
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

require_once 'TechDivision/Lang/Object.php';
require_once 'TechDivision/Lang/String.php';
require_once 'TechDivision/Lang/Integer.php';
require_once 'TechDivision/Model/Interfaces/LightValue.php';
require_once 'TDProject/Core/Common/ValueObjects/System/UserValue.php';

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
class TDProject_Core_Common_ValueObjects_QueryParameterData 
    extends TechDivision_Lang_Object
    implements TechDivision_Model_Interfaces_LightValue {
    
    /**
     * Default value for the record number up from where to load the data.
     * @var integer
     */
    const DEFAULT_START = 0;
    
    /**
     * Default value for the number or records to load.
     * @var integer
     */
    const DEFAULT_LENGTH = 10;
    
    /**
     * Default value for the ID of the column to sort.
     * @var integer
     */
    const DEFAULT_SORT_COLUMN = 1;
    
    /**
     * Default value for the direction to sort.
     * @var string
     */
    const DEFAULT_SORT_DIR = 'asc';
    
    /**
     * Default value for the search value.
     * @var string
     */
    const DEFAULT_SEARCH = '%';
    
    /**
     * The record number up from where to load the data.
     * @var TechDivision_Lang_Integer
     */
    protected $_start = null;
    
    /**
     * The number or records to load.
     * @var TechDivision_Lang_Integer
     */
    protected $_length = null;
    
    /**
     * The ID of the column to sort.
     * @var TechDivision_Lang_Integer
     */
    protected $_sortColumn = null;
    
    /**
     * The direction to sort.
     * @var TechDivision_Lang_String
     */
    protected $_sortDir = null;
    
    /**
     * The search value.
     * @var TechDivision_Lang_String
     */
    protected $_search = null;
    
    /**
     * Container for custom parameters.
     * @var array
     */
    protected $_customParams = array();
        
    /**
     * Initializes the query parameters with the
     * default values:
     * 
     * - start: 0 // start with the first row
     * - length: 10 // load ten rows
     * - sortColumn: 0 // sort by first column
     * - sortDir: ASC // sort ascending
     * - search: % // search value %, to find all
     * 
     * @param TechDivision_Lang_Integer $userId
     * 		The ID of the user that requests the data
     * @return void
     */
    public function __construct(TechDivision_Lang_Integer $userId) {
    	// set the system user
    	$this->_userId = $userId;
    	// initialize the members with default values 
    	$this->_start = new TechDivision_Lang_Integer(self::DEFAULT_START);
    	$this->_length = new TechDivision_Lang_Integer(self::DEFAULT_LENGTH);
    	$this->_sortColumn = new TechDivision_Lang_Integer(self::DEFAULT_SORT_COLUMN);
    	$this->_sortDir = new TechDivision_Lang_String(self::DEFAULT_SORT_DIR);
    	$this->_search = new TechDivision_Lang_String(self::DEFAULT_SEARCH);
    }
    
    /**
     * Returns the ID of the user that requests
     * the data.
     * 
     * @return TechDivision_Lang_Integer
     * 		The system user data
     */
    public function getUserId() {
    	return $this->_userId;
    }
    
    /**
     * Sets the record number up from where to load the data.
     * 
     * @param TechDivision_Lang_Integer $start
     * 		The record number up from where to load the data
     * @return void
     */
    public function setStart(TechDivision_Lang_Integer $start) {
        $this->_start = $start;
    }
        
    /**
     * Returns the record number up from where to load the data.
     * 
     * @return TechDivision_Lang_Integer
     * 		The record number up from where to load the data
     */
    public function getStart() {
        return $this->_start;
    }
    
    /**
     * Sets the number or records to load.
     * 
     * @param TechDivision_Lang_Integer $start
     * 		The number or records to load
     * @return void
     */
    public function setLength(TechDivision_Lang_Integer $length) {
        $this->_length = $length;
    }
        
    /**
     * Returns the number or records to load.
     * 
     * @return TechDivision_Lang_Integer
     * 		The number or records to load
     */
    public function getLength() {
        return $this->_length;
    }
    
    /**
     * Sets the ID of the column to sort.
     * 
     * @param TechDivision_Lang_Integer $sortColumn
     * 		The ID of the column to sort
     * @return void
     */
    public function setSortColumn(TechDivision_Lang_Integer $sortColumn) {
        $this->_sortColumn= $sortColumn;
    }
        
    /**
     * Returns the ID of the column to sort.
     * 
     * @return TechDivision_Lang_Integer
     * 		The ID of the column to sort
     */
    public function getSortColumn() {
        return $this->_sortColumn;
    }
    
    /**
     * Sets the direction to sort.
     * 
     * @param TechDivision_Lang_String $sortDir
     * 		The direction to sort
     * @return void
     */
    public function setSortDir(TechDivision_Lang_String $sortDir) {
        $this->_sortDir= $sortDir;
    }
        
    /**
     * Returns the direction to sort.
     * 
     * @return TechDivision_Lang_String
     * 		The direction to sort
     */
    public function getSortDir() {
        return $this->_sortDir;
    }
    
    /**
     * Sets the search value.
     * 
     * @param TechDivision_Lang_String $search
     * 		The search value
     * @return void
     */
    public function setSearch(TechDivision_Lang_String $search) {
        $this->_search= $search;
    }
        
    /**
     * Returns the search value.
     * 
     * @return TechDivision_Lang_String
     * 		The search value
     */
    public function getSearch() {
        return $this->_search;
    }
    
    /**
     * Adds a custom parameter.
     * 
     * @param mixed $key The key of the parameter to store under
     * @param mixed $value The parameter value
     * @return TDProject_Core_Common_ValueObjects_QueryParameterData
     * 		The instance itself
     */
    public function addCustomParam($key, $value)
    {
    	$this->_customParams[$key] = $value;
    	return $this;
    }
    
    /**
     * Returns the value of the parameter with the passed key.
     * 
     * @param mixde $key The key of the paramter to return
     * @return mixed The parameter value
     */
    public function getCustomParam($key)
    {
    	if (array_key_exists($key, $this->_customParams)) {
    		return $this->_customParams[$key];
    	}
    }
}