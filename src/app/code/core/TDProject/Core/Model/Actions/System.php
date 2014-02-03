<?php

/**
 * TDProject_Core_Model_Actions_System
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

/**
 * This class contains the functionality to create an XMS structure,
 * compatible with the MDB2_Schema to handle database updates.
 * 
 * @category    TDProject
 * @package     TDProject_Core
 * @copyright   Copyright (c) 2010 <info@techdivision.com> - TechDivision GmbH
 * @license     http://opensource.org/licenses/osl-3.0.php
 *              Open Software License (OSL 3.0)
 * @author      Tim Wagner <tw@techdivision.com>
 */
class TDProject_Core_Model_Actions_System
    extends TDProject_Core_Model_Actions_Abstract {

	/**
	 * List with extensions.
	 * @var array
	 * @todo This has to be replace with a dynamic list
	 */
	protected $_extensions = array(
		'TDProject_Channel',
		'TDProject_Core',
		'TDProject_ERP',
		'TDProject_Project',
		'TDProject_Report',
		'TDProject_Shop',
		'TDProject_Statistic',
		'TDProject_Webservice'
	);
	
	/**
	 * Default database options.
	 * @var array
	 */
	protected $_options = array(
		'db_host' => 'localhost',
		'db_name' => 'tdproject',
		'db_user' => 'tdproject',
		'db_pass' => 'somesecret',
		'db_charset' => 'utf8'
	);

	/**
	 * The available mysql field types with the MDB2_Schema mappings.
	 * @var array
	 */
	protected static $_datatypeMapping = array(
		'int' => 'integer',
		'varchar' => 'text',
		'enum' => 'text',
		'text' => 'clob',
		'tinyint' => 'integer'
	);

    /**
     * Factory method to create a new instance.
     *
     * @param TechDivision_Model_Interfaces_Container $container The container instance
     * @return TDProject_Channel_Model_Actions_Category
     * 		The requested instance
     */
    public static function create(TechDivision_Model_Interfaces_Container $container)
    {
        return new TDProject_Core_Model_Actions_System($container);
    }
    
    /**
     * Returns the array with the available extensions.
     * 
     * @return array The available extensions
     */
    public function getExtensions()
    {
    	return $this->_extensions;
    }

    /**
     * Helper method to map field types while transforming 
     * the entity XML files into MDB2_Schema definition.
     * 
     * Mapping is necessary, because entity XML files contains
     * mysql specific types that has to be converted.
     * 
     * @param string $mysqlType
     * 		The mysql field type
     * @param string $length
     * 		The mysql field length
     * @return the mapped length
     */
    public static function datatypeMapping($mysqlType)
    {
    	// check if a mapping is available	
    	if (array_key_exists($mysqlType, self::$_datatypeMapping)) {
    		return self::$_datatypeMapping[$mysqlType];
    	}
		// if not, throw an exception
    	throw new Exception("Invalid datatype $mysqlType");
    }

    /**
     * Helper method to map field length while transforming 
     * the entity XML files into MDB2_Schema definition.
     * 
     * Mapping is necessary, because entity XML files contains
     * mysql specific types and length that has to be converted.
     * 
     * @param string $mysqlType
     * 		The mysql field type
     * @param string $length
     * 		The mysql field length
     * @return the mapped length
     */
    public static function lengthMapping($mysqlType, $length)
    {
    	// check passed mysql type
    	if ($mysqlType == 'enum') {
    		return 255;
    	}
    	elseif ($mysqlType == 'text') {
    	    return '';
    	}
		// return passed length
    	return $length;
    }

    /**
     * Helper method to map reference options while transforming 
     * the entity XML files into MDB2_Schema definition.
     * 
     * @param string $referenceOption
     * 		The reference option to map
     * @return the mapped reference option
     */
    public static function referenceOptionMapping($referenceOption)
    {
    	// check the passed reference option
    	if ($referenceOption == 'null') {
    		return 'SET NULL';
    	}
    	elseif ($referenceOption == 'cascade') {
    	    return 'CASCADE';
    	}
    	elseif ($referenceOption == 'restrict') {
    	    return 'RESTRICT';
    	}
    	else {
    		return 'NO ACTION';
    	}
    }

    /**
     * Parse the entity XML definition files in META-INF/entities folder
     * of the available packages.
     * 
     * @param TechDivision_Util_Interfaces_DataSource $dataSource
     * 		The data source instance
     * @return DOMDocument
     * 		The XML structure with the MDB2_Schema definition
     * @throws Exception
     * 		Is thrown if the parsing has not successfull
     */
    public function parseEntities(
    	TechDivision_Util_Interfaces_DataSource $dataSource)
    {   	
        // create the directory iterator
        $it = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator(getcwd())
        );
        // initialize the XSLT processor + PHP functions
        $processor = new XSLTProcessor();
        $processor->registerPHPFunctions();
        // initialize the stylesheet
        $stylesheet = new DOMDocument();
        // load the stylesheet data
        $data = file_get_contents('TDProject/Core/Model/Actions/System/Table.xsl', true);
        // initialize the stylesheet itself
        if (!$stylesheet->loadXML($data)) {
        	throw new Exception("Can't load stylesheet for XSLT transformation");
        }
        // let the XSLT processor import the stylesheet
        $processor->importStylesheet($stylesheet);
        // initialize the MDB2_Schema
        $schema = new DOMDocument();
        // initialize the root node
        $database = $schema->createElement('database');
        // set the database information
        $database->appendChild($schema->createElement('name', $dataSource->getDatabase()));
        $database->appendChild($schema->createElement('charset', $dataSource->getEncoding()));
        $database->appendChild($schema->createElement('create', 'true'));
        $database->appendChild($schema->createElement('overwrite', 'false'));
        // iterate over the directory recursively and look for configurations
        while ($it->valid()) {
            if (!$it->isDot()) {
                // if an entity XML file was found
                if (preg_match('/META-INF\/entities/', $it->getSubPath())) {
                    // initialize the XML with the tabel definition
                    $table = new DOMDocument();
                    $table->load($it->getSubPathName());
                    // transform the table into a valid MDB2_Schema
                    if ($doc = $processor->transformToDoc($table)) {
                    	$node = $schema->importNode($doc->firstChild, true);
                    	$database->appendChild($node);
                    }
                    else {
                    	throw new Exception(
                    		'Error transforming ' . $it->getSubPathName()
                    	);
                    }
                }
            }
            // proceed with the next folder
            $it->next();
        }
        // append the database node to the schema
        $schema->appendChild($database);
        // return the MDB2_Schema
        return $schema;
    }

    /**
     * Installs a new schema and inserts initial data.
     * 
     * @param TechDivision_Model_Interfaces_Container $container
     * 		The container instance
     * @param array $options Installation options
     * @throws Exception
     * 		Is thrown if the installation fails
     */
    public function runSystemInstall(
    	TechDivision_Model_Interfaces_Container $container, 
    	array $options = array())
    {
    	// merge the passed options with the default ones
    	$options = array_merge($this->_options, $options);    	
    	// create a new data source first
    	$dataSource = new TechDivision_Util_XMLDataSource(
	    	'master',
	    	'master',
	    	$options['db_host'],
	    	3306,
	    	$options['db_name'],
	    	'mysqli',
	    	$options['db_user'],
	    	$options['db_pass'],
	    	$encoding = $options['db_charset'],
	    	'',
	    	$autocommit = false
    	);
    	// save the data source
    	$dataSource->toXML()
    		->save('app/code/core/TDProject/META-INF/ds.xml');
    	// save the property file with the DB connection for the resources
    	$this->savePropertyFile(
    		$dataSource,
    		'app/code/core/TDProject/WEB-INF/dbresources.properties'
    	);
		// parse the entity XML files
        $this->parseEntities($dataSource, $options)->save('/tmp/generated-schema.xml');
		// set the options
        $schemaOptions = array(
            'log_line_break' => '<br>',
            'idxname_format' => '%s',
            'debug' => true,
            'quote_identifier' => true,
            'force_defaults' => false,
            'portability' => false,
            'parser' => 'MDB2_Schema_Parser2',
    		'seqcol_name' => 'id' // because we use DB for DB_NestedSet
        );
        // load the DSN for connection
        $dsn = $dataSource->getConnectionString();
        // create the schema instance
        $schema =& MDB2_Schema::factory($dsn, $schemaOptions);
		// check if the schema is available
        if (PEAR::isError($schema)) {
            $error = $schema->getMessage();
        }
        else {
            // first run with queries disabled to make sure everything is allright
            $disableQuery = false;
            // load the database definition
            $definition = $schema->parseDatabaseDefinitionFile('/tmp/generated-schema.xml');
            // create the schema
            $op = $schema->createDatabase($definition, array(), $disableQuery);
			// check if the update has been ok
            if (PEAR::isError($op)) {
                throw new Exception($op->toString());
            }
        }
		// disconnect the schema
        $schema->disconnect();
    }

    /**
     * Update the actual schema.
     * 
     * @param TechDivision_Model_Interfaces_Container $container
     * 		The container instance
     * @param array $options Update options
     * @throws Exception
     * 		Is thrown if the update fails
     */
    public function runSystemUpdate(
    	TechDivision_Model_Interfaces_Container $container, 
    	array $options = array())
    {
    	// merge the passed options with the default ones
    	$options = array_merge($this->_options, $options);
        // load the datasource
        $dataSource = $container->getMasterManager()->getDataSource();    	
		// parse the entity XML files
        $this->parseEntities($dataSource, $options)->save('/tmp/generated-schema.xml');
		// set the options
        $schemaOptions = array(
            'log_line_break' => '<br>',
            'idxname_format' => '%s',
            'debug' => true,
            'quote_identifier' => true,
            'force_defaults' => false,
            'portability' => false,
            'parser' => 'MDB2_Schema_Parser2',
    		'seqcol_name' => 'id' // because we use DB for DB_NestedSet
        );
        // load the DSN for connection
        $dsn = $dataSource->getConnectionString();
        // create the schema instance
        $schema =& MDB2_Schema::factory($dsn, $schemaOptions);
		// check if the schema is available
        if (PEAR::isError($schema)) {
            $error = $schema->getMessage();
        }
        else {
            // first run with queries disabled to make sure everything is allright
            $disableQuery = false;
			// load the actual schema
            $previousSchema = $schema->getDefinitionFromDatabase();
            // update the schema
            $op = $schema->updateDatabase(
            	'/tmp/generated-schema.xml', 
            	$previousSchema, 
            	array(), 
            	$disableQuery
            );
			// check if the update has been ok
            if (PEAR::isError($op)) {
                throw new Exception($op->toString());
            }
        }
		// disconnect the schema
        $schema->disconnect();
    }

    /**
     * Runs the generator.
     * 
     * @param TechDivision_Model_Interfaces_Container $container
     * 		The container instance
     * @param array $options Update options
     * @throws Exception
     * 		Is thrown if the update fails
     */
    public function runGeneration(
    	TechDivision_Model_Interfaces_Container $container, 
    	array $options = array())
    {
    	// merge the passed options with the default ones
    	$options = array_merge($this->_options, $options);
    	
        // initialize the XSLT processor + PHP functions
        $processor = new XSLTProcessor();
        $processor->registerPHPFunctions();
        // initialize the stylesheet
        $stylesheet = new DOMDocument();
        // load the stylesheet data
        $data = file_get_contents('TDProject/Core/Model/Actions/System/Generator.xsl', true);
        // initialize the stylesheet itself
        if (!$stylesheet->loadXML($data)) {
        	throw new Exception("Can't load stylesheet for XSLT transformation");
        }
        // let the XSLT processor import the stylesheet
        $processor->importStylesheet($stylesheet);

    	foreach ($this->getExtensions() as $extension) {
    		
    		list ($namespace, $module) = explode("_", $extension);
    		
    		$config = new DOMDocument();
    		$extension = $config->createElement('extension');
    		$extension->setAttribute('namespace', $namespace);
    		$extension->setAttribute('module', $module);
    		$config->appendChild($extension);
    		
    		if ($processor->transformToUri($config, $uri = '/tmp/generator.xml')) {
				$generator = new TechDivision_Generator_Implementation($uri);
		        $generator->initialize();
		        $generator->generate();
    		}
    	}
    }
    
    /**
     * Creates the property file for the database connection used
     * by the resource bundle.
     * 
     * The following properties has to be created (dummy values):
     * 
     * db.charset					   = utf8
     * db.connect.driver               = mysqli
     * db.connect.user                 = tdproject
     * db.connect.password             = somesecret
     * db.connect.database             = tdproject
     * db.connect.host                 = localhost
     * db.connect.port                 = 3306
     * db.connect.options              =
     * db.sql.table                    = resource
     * db.sql.locale.column            = resource_locale
     * db.sql.key.column               = key
     * db.sql.val.column               = message
     * resource.cache 				   = true
     *
	 * @return TDProject_Core_Model_Actions_System
	 * 		The instance itself
     */
    public function savePropertyFile($dataSource, $filename)
    {
    	// initialize the properties
    	$properties = TechDivision_Properties_Properties::create();
    	// set the values
    	$properties->setProperty(
    		TechDivision_Resources_DBResourceBundle::DB_SQL_TABLE,
    		'resource'
    	);
    	$properties->setProperty(
    		TechDivision_Resources_DBResourceBundle::DB_SQL_LOCALE_COLUMN, 
    		'resource_locale'
    	);
    	$properties->setProperty(
    		TechDivision_Resources_DBResourceBundle::DB_SQL_KEY_COLUMN, 
    		'key'
    	);
    	$properties->setProperty(
    		TechDivision_Resources_DBResourceBundle::DB_SQL_VAL_COLUMN,
    		'message'
    	);
    	$properties->setProperty(
    		TechDivision_Resources_DBResourceBundle::RESOURCE_CACHE,
    		'true'
    	);
    	$properties->setProperty(
    		TechDivision_Resources_DBResourceBundle::DB_CHARSET,
    		$dataSource->getEncoding()
    	);
    	$properties->setProperty(
    		TechDivision_Util_DataSource::DB_CONNECT_DRIVER,
    		$dataSource->getDriver()
    	);
    	$properties->setProperty(
    		TechDivision_Util_DataSource::DB_CONNECT_USER,
    		$dataSource->getUser()
    	);
    	$properties->setProperty(
    		TechDivision_Util_DataSource::DB_CONNECT_PASSWORD,
    		$dataSource->getPassword()
    	);
    	$properties->setProperty(
    		TechDivision_Util_DataSource::DB_CONNECT_DATABASE,
    		$dataSource->getDatabase()
    	);
    	$properties->setProperty(
    		TechDivision_Util_DataSource::DB_CONNECT_HOST,
    		$dataSource->getHost()
    	);
    	$properties->setProperty(
    		TechDivision_Util_DataSource::DB_CONNECT_PORT,
    		$dataSource->getPort()
    	);
    	$properties->setProperty(
    		TechDivision_Util_DataSource::DB_CONNECT_OPTIONS,
    		$dataSource->getOptions()
    	);
    	// save the properties
    	$properties->store($filename);
    	// return the instance itself
    	return $this;
    }
}