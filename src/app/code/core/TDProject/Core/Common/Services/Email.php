<?php

/**
 * TDProject_Core_Common_Services_Email
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

require_once 'swift_required.php';
require_once 'TechDivision/Lang/Object.php';
require_once 'TDProject/Core/Interfaces/Email.php';

/**
 * @category   	TDProject
 * @package    	TDProject_Project
 * @copyright  	Copyright (c) 2010 <info@techdivision.com> - TechDivision GmbH
 * @license    	http://opensource.org/licenses/osl-3.0.php
 * 				Open Software License (OSL 3.0)
 * @author      Tim Wagner <tw@techdivision.com>
 */
class TDProject_Core_Common_Services_Email 
	extends TechDivision_Lang_Object {
    
    /**
     * Protected constructor to prevent class
     * from direct instanciation.
	 *
	 * @return void
     */
    protected function __construct()
    {
        // prevent class from instanciation
    }
        
    /**
     * Factory method to create a new instance.
     * 
     * @return TDProject_Core_Common_Services_Email
     * 		The requested instance
     */
    public static function create()
    {
        return new TDProject_Core_Common_Services_Email();
    }
	
    /**
     * This method generates the email and sends it.
     *
     * @param TDProject_Core_Common_ValueObjects_SettingLightValue $setting
     * @param TDProject_Core_Interfaces_Email $dto
     * 		Holds the DTO with the email data
     * @return boolean
     * 		TRUE if the email can be sent successfully, else FALSE
     */	
	public function send(
		TDProject_Core_Common_ValueObjects_SettingLightValue $setting,
        TDProject_Core_Interfaces_Email $dto) {
		// create the MIME message itself
		$message = Swift_Message::newInstance()
			->setSubject($dto->getSubject())	// give the message a subject
			->setFrom($dto->getFrom()) // set the From address with an associative array
			->setTo($dto->getTo()) // set the To addresses with an associative array
			->setBody($dto->getBodyText()) // give it a default text body
			->addPart($dto->getBodyHtml(), 'text/html'); // give it the HTML body
		// check if SMTP should be used
		if ($setting->getUseSmtp()->booleanValue()) {
			// get SMTP host and port
			$smtpHost = $setting->getSmtpHost()->stringValue();
			$smtpPort = $setting->getSmtpPort()->intValue();
			// create a new SMPT transport instance
			$transport = Swift_SmtpTransport::newInstance($smtpHost, $smtpPort)
				->setUsername($setting->getSmtpUser()->stringValue())
			  	->setPassword($setting->getSmtpPassword()->stringValue());
		} 
		// else use PHP's mail function
		else {
			$transport = Swift_MailTransport::newInstance();
		}
		// create the mailer using the created transport
		$mailer = Swift_Mailer::newInstance($transport);
        // send the message
        return $mailer->send($message);
	}	
}