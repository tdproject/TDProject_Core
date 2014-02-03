<?php

/**
 * TDProject_Core_Block_Action_Messages
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

require_once 'TDProject/Core/Block/Abstract.php';
require_once 'TechDivision/Controller/Action/Messages.php';

/**
 * @category    TDProject
 * @package     TDProject_Core
 * @copyright   Copyright (c) 2010 <info@techdivision.com> - TechDivision GmbH
 * @license     http://opensource.org/licenses/osl-3.0.php
 *              Open Software License (OSL 3.0)
 * @author      Tim Wagner <tw@techdivision.com>
 */
class TDProject_Core_Block_Action_Messages 
    extends TDProject_Core_Block_Abstract {
    
    /**
     * Initialize the block with the
     * apropriate template and name.
     * 
     * @return void
     */
    public function __construct(TechDivision_Controller_Interfaces_Context $context)
    {
        // set the internal name
        $this->_setBlockName('messages');
        // set the template name
        $this->_setTemplate('www/design/core/templates/action/messages.phtml');
        // call the parent constructor
        parent::__construct($context);
    }
    
    /**
     * Returns the ActionMessages container initialized
     * in the Controller or the ActionForm.
     * 
     * @return TechDivision_Controller_Action_Messages
     * 		The container with the error messages
     */
    public function getMessages()
    {
        $messages = $this->getRequest()
            ->getAttribute(TechDivision_Controller_Action_Messages::ACTION_MESSAGES);
            
        if (empty($messages)) {
            $messages = new TechDivision_Controller_Action_Messages();
        }
        
        return $messages;
    }
}