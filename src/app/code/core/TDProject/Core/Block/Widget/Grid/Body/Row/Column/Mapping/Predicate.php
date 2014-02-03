<?php

require_once 'TechDivision/Collections/Interfaces/Predicate.php';

class TDProject_Core_Block_Widget_Grid_Body_Row_Column_Mapping_Predicate
	implements TechDivision_Collections_Interfaces_Predicate {

    /**
	 * Holds the name the found pattern has to equal
	 * @var String
	 */
    private $_targetP = null;

    /**
     * Constructor that initializes the internal member
     * with the value passed as parameter.
     *
     * @param string $name Holds the name the found pattern has to equal
     * @return void
     */
    public function __construct($name)
    {
		// set the member
        $this->_name = $name;
    }
	
	public function evaluate($object) {
		
	}
}