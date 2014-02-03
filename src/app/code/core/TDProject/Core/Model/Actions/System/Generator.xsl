<?xml version="1.0" encoding="UTF-8"?>
<!-- 
/**
 * TDProject_Core
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */
-->
<xsl:stylesheet version="1.0"
	xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:str="http://xsltsl.org/string"
	xmlns:php="http://php.net/xsl">
    <!--
     ! XSL stylesheet to transform the model definition files
     ! of TechDivision_Model into a MDB2_Schema compatible XML
     ! structure.
     !
	 ! @category    TProject
	 ! @package     TDProject_Core
	 ! @copyright   Copyright (c) 2010 <info@techdivision.com> - TechDivision GmbH
	 ! @license     http://opensource.org/licenses/osl-3.0.php
	 !              Open Software License (OSL 3.0)
	 ! @author      Tim Wagner <tw@techdivision.com>
    -->
    <xsl:output encoding="UTF-8" method="xml"/>
	<!--
	 ! Matches the extension node
	-->
	<xsl:template match="extension">	
		<conf namespace="@namespace" module="@module">
			<includes>
				<include id="include_path_manager">TechDivision/Model/Manager/</include>
				<include id="include_path_entities"><xsl:value-of select="@namespace"/>/<xsl:value-of select="@module"/>/Model/Entities/</include>
				<include id="include_path_services"><xsl:value-of select="@namespace"/>/<xsl:value-of select="@module"/>/Model/Services/</include>
				<include id="include_path_assembler"><xsl:value-of select="@namespace"/>/<xsl:value-of select="@module"/>/Model/Assembler/</include>
				<include id="include_path_homes"><xsl:value-of select="@namespace"/>/<xsl:value-of select="@module"/>/Model/Homes/</include>
				<include id="include_path_utils"><xsl:value-of select="@namespace"/>/<xsl:value-of select="@module"/>/Model/Utils/</include>
				<include id="include_path_exceptions"><xsl:value-of select="@namespace"/>/<xsl:value-of select="@module"/>/Model/Exceptions/</include>
				<include id="include_path_value_objects"><xsl:value-of select="@namespace"/>/<xsl:value-of select="@module"/>/Common/ValueObjects/</include>
				<include id="include_path_mappings"><xsl:value-of select="@namespace"/>/<xsl:value-of select="@module"/>/Model/Mappings/</include>
			</includes>
			<plugins>
				<plugin name="CountExceptionPlugin" type="TechDivision_Generator_Plugins_Default"
					include="TechDivision/Generator/Plugins/Default.php">
					<input>app/code/<xsl:value-of select="@namespace"/>/<xsl:value-of select="@module"/>/META-INF/entities/</input>
					<output>app/code/<xsl:value-of select="@namespace"/>/<xsl:value-of select="@module"/>/Model/Exceptions/</output>
					<xsl>data/TechDivision_Generator/Templates/Model/CountException.xsl</xsl>
					<suffix>CountException</suffix>
					<prefix />
				</plugin>
				<plugin name="CreateExceptionPlugin" type="TechDivision_Generator_Plugins_Default"
					include="TechDivision/Generator/Plugins/Default.php">
					<input>app/code/<xsl:value-of select="@namespace"/>/<xsl:value-of select="@module"/>/META-INF/entities/</input>
					<output>app/code/<xsl:value-of select="@namespace"/>/<xsl:value-of select="@module"/>/Model/Exceptions/</output>
					<xsl>data/TechDivision_Generator/Templates/Model/CreateException.xsl</xsl>
					<suffix>CreateException</suffix>
					<prefix />
				</plugin>
				<plugin name="DeleteExceptionPlugin" type="TechDivision_Generator_Plugins_Default"
					include="TechDivision/Generator/Plugins/Default.php">
					<input>app/code/<xsl:value-of select="@namespace"/>/<xsl:value-of select="@module"/>/META-INF/entities/</input>
					<output>app/code/<xsl:value-of select="@namespace"/>/<xsl:value-of select="@module"/>/Model/Exceptions/</output>
					<xsl>data/TechDivision_Generator/Templates/Model/DeleteException.xsl</xsl>
					<suffix>DeleteException</suffix>
					<prefix />
				</plugin>
				<plugin name="FindExceptionPlugin" type="TechDivision_Generator_Plugins_Default"
					include="TechDivision/Generator/Plugins/Default.php">
					<input>app/code/<xsl:value-of select="@namespace"/>/<xsl:value-of select="@module"/>/META-INF/entities/</input>
					<output>app/code/<xsl:value-of select="@namespace"/>/<xsl:value-of select="@module"/>/Model/Exceptions/</output>
					<xsl>data/TechDivision_Generator/Templates/Model/FindException.xsl</xsl>
					<suffix>FindException</suffix>
					<prefix />
				</plugin>
				<plugin name="UpdateExceptionPlugin" type="TechDivision_Generator_Plugins_Default"
					include="TechDivision/Generator/Plugins/Default.php">
					<input>app/code/<xsl:value-of select="@namespace"/>/<xsl:value-of select="@module"/>/META-INF/entities/</input>
					<output>app/code/<xsl:value-of select="@namespace"/>/<xsl:value-of select="@module"/>/Model/Exceptions/</output>
					<xsl>data/TechDivision_Generator/Templates/Model/UpdateException.xsl</xsl>
					<suffix>UpdateException</suffix>
					<prefix />
				</plugin>
				<plugin name="LocalHomePlugin" type="TechDivision_Generator_Plugins_Default"
					include="TechDivision/Generator/Plugins/Default.php">
					<input>app/code/<xsl:value-of select="@namespace"/>/<xsl:value-of select="@module"/>/META-INF/entities/</input>
					<output>app/code/<xsl:value-of select="@namespace"/>/<xsl:value-of select="@module"/>/Model/Homes/</output>
					<xsl>data/TechDivision_Generator/Templates/Model/LocalHome.xsl</xsl>
					<suffix>LocalHome</suffix>
					<prefix />
				</plugin>
				<plugin name="LightValuePlugin" type="TechDivision_Generator_Plugins_Default"
					include="TechDivision/Generator/Plugins/Default.php">
					<input>app/code/<xsl:value-of select="@namespace"/>/<xsl:value-of select="@module"/>/META-INF/entities/</input>
					<output>app/code/<xsl:value-of select="@namespace"/>/<xsl:value-of select="@module"/>/Common/ValueObjects/</output>
					<xsl>data/TechDivision_Generator/Templates/Common/LightValue.xsl</xsl>
					<suffix>LightValue</suffix>
					<prefix />
				</plugin>
				<plugin name="LVOAssemblerPlugin" type="TechDivision_Generator_Plugins_Default"
					include="TechDivision/Generator/Plugins/Default.php">
					<input>app/code/<xsl:value-of select="@namespace"/>/<xsl:value-of select="@module"/>/META-INF/entities/</input>
					<output>app/code/<xsl:value-of select="@namespace"/>/<xsl:value-of select="@module"/>/Model/Assembler/</output>
					<xsl>data/TechDivision_Generator/Templates/Model/LVOAssembler.xsl</xsl>
					<suffix>LVOAssembler</suffix>
					<prefix />
				</plugin>
				<plugin name="StorablePlugin" type="TechDivision_Generator_Plugins_Default"
					include="TechDivision/Generator/Plugins/Default.php">
					<input>app/code/<xsl:value-of select="@namespace"/>/<xsl:value-of select="@module"/>/META-INF/entities/</input>
					<output>app/code/<xsl:value-of select="@namespace"/>/<xsl:value-of select="@module"/>/Model/Entities/</output>
					<xsl>data/TechDivision_Generator/Templates/Model/Entity.xsl</xsl>
					<suffix />
					<prefix />
				</plugin>
				<plugin name="UtilPlugin" type="TechDivision_Generator_Plugins_Default"
					include="TechDivision/Generator/Plugins/Default.php">
					<input>app/code/<xsl:value-of select="@namespace"/>/<xsl:value-of select="@module"/>/META-INF/entities/</input>
					<output>app/code/<xsl:value-of select="@namespace"/>/<xsl:value-of select="@module"/>/Model/Utils/</output>
					<xsl>data/TechDivision_Generator/Templates/Model/Util.xsl</xsl>
					<suffix>Util</suffix>
					<prefix />
				</plugin>
				<plugin name="ValuePlugin" type="TechDivision_Generator_Plugins_Default"
					include="TechDivision/Generator/Plugins/Default.php">
					<input>app/code/<xsl:value-of select="@namespace"/>/<xsl:value-of select="@module"/>/META-INF/entities/</input>
					<output>app/code/<xsl:value-of select="@namespace"/>/<xsl:value-of select="@module"/>/Common/ValueObjects/</output>
					<xsl>data/TechDivision_Generator/Templates/Common/Value.xsl</xsl>
					<suffix>Value</suffix>
					<prefix />
				</plugin>
				<plugin name="VOAssemblerPlugin" type="TechDivision_Generator_Plugins_Default"
					include="TechDivision/Generator/Plugins/Default.php">
					<input>app/code/<xsl:value-of select="@namespace"/>/<xsl:value-of select="@module"/>/META-INF/entities/</input>
					<output>app/code/<xsl:value-of select="@namespace"/>/<xsl:value-of select="@module"/>/Model/Assembler/</output>
					<xsl>data/TechDivision_Generator/Templates/Model/VOAssembler.xsl</xsl>
					<suffix>VOAssembler</suffix>
					<prefix />
				</plugin>
				<plugin name="DelegatePlugin" type="TechDivision_Generator_Plugins_Default"
					include="TechDivision/Generator/Plugins/Default.php">
					<input>app/code/<xsl:value-of select="@namespace"/>/<xsl:value-of select="@module"/>/META-INF/services/</input>
					<output>app/code/<xsl:value-of select="@namespace"/>/<xsl:value-of select="@module"/>/Common/Delegates/Interfaces/</output>
					<xsl>data/TechDivision_Generator/Templates/Common/Delegate.xsl</xsl>
					<suffix>Delegate</suffix>
					<prefix />
				</plugin>
				<plugin name="DelegateUtilPlugin" type="TechDivision_Generator_Plugins_Default"
					include="TechDivision/Generator/Plugins/Default.php">
					<input>app/code/<xsl:value-of select="@namespace"/>/<xsl:value-of select="@module"/>/META-INF/services/</input>
					<output>app/code/<xsl:value-of select="@namespace"/>/<xsl:value-of select="@module"/>/Common/Delegates/</output>
					<xsl>data/TechDivision_Generator/Templates/Common/DelegateUtil.xsl</xsl>
					<suffix>DelegateUtil</suffix>
					<prefix />
				</plugin>
				<plugin name="DelegateImplementationPlugin" type="TechDivision_Generator_Plugins_Default"
					include="TechDivision/Generator/Plugins/Default.php">
					<input>app/code/<xsl:value-of select="@namespace"/>/<xsl:value-of select="@module"/>/META-INF/services/</input>
					<output>app/code/<xsl:value-of select="@namespace"/>/<xsl:value-of select="@module"/>/Common/Delegates/</output>
					<xsl>data/TechDivision_Generator/Templates/Common/DelegateImplementation.xsl</xsl>
					<suffix>DelegateImplementation</suffix>
					<prefix />
				</plugin>
				<plugin name="AbstractProcessorPlugin" type="TechDivision_Generator_Plugins_Default"
					include="TechDivision/Generator/Plugins/Default.php">
					<input>app/code/<xsl:value-of select="@namespace"/>/<xsl:value-of select="@module"/>/META-INF/services/</input>
					<output>app/code/<xsl:value-of select="@namespace"/>/<xsl:value-of select="@module"/>/Model/Services/</output>
					<xsl>data/TechDivision_Generator/Templates/Model/AbstractProcessor.xsl</xsl>
					<suffix />
					<prefix>Abstract</prefix>
				</plugin>
				<plugin name="StorableQueryUtilPlugin" type="TechDivision_Generator_Plugins_Default" include="TechDivision/Generator/Plugins/Default.php">
					<input>app/code/<xsl:value-of select="@namespace"/>/<xsl:value-of select="@module"/>/META-INF/entities/</input>
					<output>app/code/<xsl:value-of select="@namespace"/>/<xsl:value-of select="@module"/>/Model/Homes/</output>
					<xsl>data/TechDivision_Generator/Templates/Model/QueryUtil.xsl</xsl>
					<suffix>QueryUtil</suffix>
					<prefix />
				</plugin>
				<plugin name="MappingPlugin" type="TechDivision_Generator_Plugins_Default"
					include="TechDivision/Generator/Plugins/Default.php">
					<input>app/code/<xsl:value-of select="@namespace"/>/<xsl:value-of select="@module"/>/META-INF/entities/</input>
					<output>app/code/<xsl:value-of select="@namespace"/>/<xsl:value-of select="@module"/>/Model/Mappings/</output>
					<xsl>data/TechDivision_Generator/Templates/Model/Mapping.xsl</xsl>
					<suffix>Mapping</suffix>
					<prefix />
				</plugin>
				<plugin name="AbstractBlockPlugin" type="TechDivision_Generator_Plugins_Default"
					include="TechDivision/Generator/Plugins/Default.php">
					<input>app/code/<xsl:value-of select="@namespace"/>/<xsl:value-of select="@module"/>/META-INF/entities/</input>
					<output>app/code/<xsl:value-of select="@namespace"/>/<xsl:value-of select="@module"/>/Block/Abstract/</output>
					<xsl>data/TechDivision_Generator/Templates/Block/Abstract.xsl</xsl>
					<suffix></suffix>
					<prefix />
				</plugin>
				<plugin name="CollectionPlugin" type="TechDivision_Generator_Plugins_Namespace"
					include="TechDivision/Generator/Plugins/Namespace.php">
					<input>app/code/<xsl:value-of select="@namespace"/>/<xsl:value-of select="@module"/>/META-INF/entities/</input>
					<output>app/code/<xsl:value-of select="@namespace"/>/<xsl:value-of select="@module"/>/Model/Entities/*/Collection</output>
					<xsl>data/TechDivision_Generator/Templates/Model/Collection.xsl</xsl>
					<suffix />
					<prefix />
				</plugin>
			</plugins>
		</conf>
	</xsl:template>
</xsl:stylesheet>