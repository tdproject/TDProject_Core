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
	 ! Matches the entity node
	-->
	<xsl:template match="entity">
       <xsl:for-each select="tables/table"><table>
           <name><xsl:value-of select="@name"/></name>
           <!--
            ! Create table structure 
           -->
           <declaration>
               <!--
                ! Create the fields
               -->
               <xsl:for-each select="fields/field"><field>
                   <name><xsl:value-of select="@name"/></name>
                   <xsl:if test="@autoincrement"><autoincrement>1</autoincrement></xsl:if>
                   <type><xsl:value-of select="php:function('TDProject_Core_Model_Actions_System::datatypeMapping', string(@type))"/></type>
                   <xsl:if test="@default!='clob'"><default><xsl:value-of select="@default"/></default></xsl:if>
                   <xsl:choose><xsl:when test="@nullable='true'"><notnull>false</notnull></xsl:when><xsl:otherwise><notnull>true</notnull></xsl:otherwise></xsl:choose>
                   <length><xsl:value-of select="php:function('TDProject_Core_Model_Actions_System::lengthMapping', string(@type), string(@length))"/></length>
               </field></xsl:for-each>               
               <!--
                ! Create the primary keys
               -->
               <xsl:for-each select="keys/pk"><index>
                   <name><xsl:value-of select="@name"/></name>
                   <primary>true</primary>
                   <field>
                        <name><xsl:value-of select="@field"/></name>
                        <sorting>ascending</sorting>
                   </field>
               </index></xsl:for-each>               
               <!--
                ! Create the indexes
               -->
               <xsl:for-each select="keys/index"><index>
                   <name><xsl:value-of select="@name"/></name>
                   <field>
                        <name><xsl:value-of select="@field"/></name>
                        <sorting>ascending</sorting>
                   </field>
               </index></xsl:for-each>              
               <!--
                ! Create the unique keys
               -->
               <xsl:for-each select="keys/unique-multi"><index>
                   <name><xsl:value-of select="@name"/></name>
                   <unique>true</unique>
                   <xsl:for-each select="columns/column"><field>
                        <name><xsl:value-of select="."/></name>
                        <sorting>ascending</sorting>
                   </field></xsl:for-each>
               </index></xsl:for-each>
               <!--
                ! Create the foreign key constraints finally 
               -->
               <xsl:for-each select="keys/fk"><foreign>
                   <name><xsl:value-of select="@name"/></name>
                   <ondelete><xsl:value-of select="php:function('TDProject_Core_Model_Actions_System::referenceOptionMapping', string(@on-delete))"/></ondelete>
                   <onupdate><xsl:value-of select="php:function('TDProject_Core_Model_Actions_System::referenceOptionMapping', string(@on-update))"/></onupdate>
                   <field><xsl:value-of select="@field"/></field>
                   <references>
                        <table><xsl:value-of select="@target-table"/></table>
                        <field><xsl:value-of select="@target-field"/></field>
                   </references>
               </foreign></xsl:for-each>
           </declaration>
           <!--
            ! Create initial table data
           -->
           <initialization>
                <xsl:for-each select="initial-data/rows/row"><insert>    
                    <xsl:for-each select="col"><field>
                        <name><xsl:value-of select="@name"/></name>
                        <value><xsl:value-of select="."/></value>
                    </field></xsl:for-each>
                </insert></xsl:for-each>
           </initialization>
       </table></xsl:for-each>
    </xsl:template>        
</xsl:stylesheet>