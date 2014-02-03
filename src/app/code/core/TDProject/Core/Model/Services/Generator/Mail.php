<?php

/**
 * TDProject_Core_Model_Services_Generator_Mail
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

require_once 'swift_required.php';

/**
 * @category   	TDProject
 * @package    	TDProject_Core
 * @copyright  	Copyright (c) 2010 <info@techdivision.com> - TechDivision GmbH
 * @license    	http://opensource.org/licenses/osl-3.0.php
 * 				Open Software License (OSL 3.0)
 * @author      Bastian Stangl <b.stangl@techdivision.com>
 */
class TDProject_Core_Model_Services_Generator_Mail
    extends TechDivision_Lang_Object {
	
    /**
     * The settings instance.
     * @var TDProject_Core_Model_Entities_Setting
     */
    protected $_setting = null; 

    /**
     * Factory method to create a new instance.
     *
     * @param TechDivision_Model_Interfaces_Container $container The container instance
     * @return TDProject_Channel_Model_Actions_Category
     * 		The requested instance
     */
    public static function create(TechDivision_Model_Interfaces_Container $container)
    {
        return new TDProject_Core_Model_Services_Generator_Mail($container);
    }
    
	/**
     * This method looks which active-status is set 
     * and runs analogical method 
     *
     * @param TDProject_Core_Common_ValueObjects_UserLightValue $user Holds the lvo with the user data
     * @return boolean
     */ 
	public function generateActiveMail(
	    TDProject_Core_Common_ValueObjects_UserLightValue $user) {
		// check if the user is enabled
	    if ($user->getEnabled()->booleanValue()) {
	        // if yes, release the user
			return $this->_releaseUser($user);
		}
		// if not, lock the user
		return $this->_lockUser($user);
	}

    /**
     * This method generate the email with a new password
     * if a user has lost it.
     *
     * @param TDProject_Core_Common_ValueObjects_UserLightValue $user Holds the dto with the user data
     * @param TechDivision_Lang_String $password Holds the new password of the user
     * @return boolean
     */ 
	public function sendPassword(
        TDProject_Core_Common_ValueObjects_UserLightValue $user) {
		$message = Swift_Message::newInstance()
		//Give the message a subject
		->setSubject('Ihr Passwort')

		//Set the From address with an associative array
		->setFrom(
		    array(
		    	$this->_getSetting()->getEmailSupport()->stringValue() => 
		    		'Webserver'
		    )
		)

		//Set the To addresses with an associative array
		->setTo(array($user->getEmail()->__toString()))

		//Give it a body
		->setBody("Hallo " . $user->getUsername() . ",\n\n
            Sie haben ein neues Passwort für die Nutzung unserer Sortimentsanalyse angefordert. Wir haben für Sie folgendes neues Passwort generiert:\n\n" . 
            $user->getPassword()->__toString() . "\n\n
            Sollten Sie Probleme bei der Anmeldung haben können Sie uns selbstverständlich jederzeit kontaktieren.\n\n
            Mit freundlichen Grüßen\n
            Ihr Support Team\n
            TechDivision Sortimentsanalyse"
        )

        //And optionally an alternative body
        ->addPart("Hallo " . $user->getUsername() . ",<br /><br />
            Sie haben ein neues Passwort für die Nutzung unserer Sortimentsanalyse angefordert. Wir haben für Sie folgendes neues Passwort generiert:<br /><br />" .
            $user->getPassword()->__toString() . "<br /><br />
            Sollten Sie Probleme bei der Anmeldung haben können Sie uns selbstverständlich jederzeit kontaktieren.<br /><br />
            Mit freundlichen Grüßen<br />
            Ihr Support Team<br />
            TechDivision Sortimentsanalyse", 'text/html'
        );
        // send the message
        return $this->_getMailTransport()->send($message);
	}

    /**
     * This method generate the affirmation mail for a user
     * when the support team has released his account.
     *
     * @param TDProject_Core_Common_ValueObjects_UserLightValue $user Holds the dto with the user data
     * @return boolean
     */ 
    protected function _releaseUser(
        TDProject_Core_Common_ValueObjects_UserLightValue $user) {
		$message = Swift_Message::newInstance()
		//Give the message a subject
		->setSubject('Freigabe Sortimentsanalyse')

		//Set the From address with an associative array
		->setFrom(
		    array(
		    	$this->_getSetting()->getEmailSupport()->stringValue() => 
		    		'Webserver'
		    )
		)

		//Set the To addresses with an associative array
		->setTo(array($user->getEmail()))

		//Give it a body
		->setBody("Hallo " . $user->getUsername() . ",\n\n
            ihr Account wurde für die Benutzung der Sortimentsanalyse freigegeben und sie können nun diese im vollen Umfang benutzen.\n\n
            Sollten Sie weitere Fragen haben, können Sie uns selbstverständlich jederzeit kontaktieren.\n\n
            Mit freundlichen Grüßen\n
            Ihr Support Team\n
            TechDivision Sortimentsanalyse"
        )

        //And optionally an alternative body
        ->addPart("Hallo " . $user->getUsername() . ",<br /><br />
            ihr Account wurde für die Benutzung der Sortimentsanalyse freigegeben und sie können nun diese im vollen Umfang benutzen.<br /><br />
            Sollten Sie weitere Fragen haben, können Sie uns selbstverständlich jederzeit kontaktieren.<br /><br />
            Mit freundlichen Grüßen<br />
            Ihr Support Team<br />
            TechDivision Sortimentsanalyse", 'text/html'
        );
        // send the message
        return $this->_getMailTransport()->send($message);
	}

    /**
     * This method generate the affirmation mail for a user
     * when the support team has locked his account.
     *
     * @param TDProject_Core_Common_ValueObjects_UserLightValue $user Holds the dto with the user data
     * @return boolean
     */ 
	protected function _lockUser(
        TDProject_Core_Common_ValueObjects_UserLightValue $user) {
		$message = Swift_Message::newInstance()
		// give the message a subject
		->setSubject('Sperrung Sortimentsanalyse')
		// set the From address with an associative array
		->setFrom(
		    array(
		    	$this->_getSetting()->getEmailSupport()->stringValue() => 
		    		'Webserver'
		    )
		)
		// set the To addresses with an associative array
		->setTo(array($user->getEmail()))
		// give it a body
		->setBody("Hallo " . $user->getUsername() . ",\n\n
            ihr Account wurde für die weitere Benutzung gesperrt.\n
            Sollten Sie Fragen diesbezüglich haben, können Sie uns selbstverständlich jederzeit kontaktieren.\n\n
            Mit freundlichen Grüßen\n
            Ihr Support Team\n
            TechDivision GmbH"
        )

        //And optionally an alternative body
        ->addPart("Hallo " . $user->getUsername() . ",<br /><br />
            ihr Account wurde für die weitere Benutzung gesperrt.<br /><br />
            Sollten Sie Fragen diesbezüglich haben, können Sie uns selbstverständlich jederzeit kontaktieren.<br /><br />
            Mit freundlichen Grüßen<br />
            Ihr Support Team<br />
            TechDivision GmbH", 'text/html'
        );
        // send the message
        return $this->_getMailTransport()->send($message);
	}
	
	/**
	 * Loads the settings and return the
	 * instance.
	 * 
	 * @return TDProject_Core_Model_Entities_Setting The instance
	 */
	protected function _getSetting()
	{
	    // check if the settings are already initialized
	    if ($this->_setting == null) {
            // if not, initialize a new LocalHome
    	    $home = TDProject_Core_Model_Utils_SettingUtil::getHome($this->getContainer());
    	    // load the settings if available
    	    $settings = $home->findAll();
    	    // iterate over the settings and return the first one
    	    for($i = 0; $i < $settings->size(); $i++) {
    	        $this->_setting = $settings->get($i);
    	    }
	    }
	    // return the settings
	    return $this->_setting;
	}
	
	/**
	 * Initializes the Mailer and returns
	 * the instance.
	 * 
	 * @return Swift_SmtpTransport The instance
	 */
	protected function _getMailTransport()
	{
	    // load the settings
	    $setting = $this->_getSetting();
        // check if LDAP has to be used
        if ($setting->getUseSmtp()->booleanValue()) {
            //Create the Transport the call setUsername() and setPassword()
            $transport = Swift_SmtpTransport::newInstance(
            	$setting->getSmtpHost()->stringValue(), 
                $setting->getSmtpPort()->intValue()
            );
            // authenticate with username and password
            $transport
              ->setUsername($setting->getSmtpUser()->stringValue())
              ->setPassword($setting->getSmtpPassword()->stringValue());
            // create the Mailer using your created Transport
            return Swift_Mailer::newInstance($transport);
        }
        // using sendmail if SMTP is disabled
        $transport = Swift_SendmailTransport::newInstance('/usr/sbin/sendmail -bs');
        // create the Mailer using your created Transport
        return Swift_Mailer::newInstance($transport);
	}
}