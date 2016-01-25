<?php
namespace Helpers\PhpMailer;

/*
 * Mail Helper
 *
 * @author David Carr - dave@simplemvcframework.com
 * @version 1.0
 * @date May 18 2015
 */
class Mail extends PhpMailer
{
    // Set default variables for all new objects
    public $From     = 'contact@meteo-colmar.fr';
    public $FromName = SITETITLE;
    public $Host     = 'node-email-1.pulsepanel.eu';
    public $Mailer   = 'smtp';
    public $SMTPAuth = true;
    public $Username = 'contact@meteo-colmar.fr';
    public $Password = 'wPhV9vPLIUpBtSx6HCm_zdENJlswrm4uQrM1Zqx2ICy5tbKLEDuQ2wpLmHR-H1y8';
    public $SMTPSecure = 'tls';
    public $WordWrap = 75;

    public function subject($subject)
    {
        $this->Subject = $subject;
    }

    public function body($body)
    {
        $this->Body = $body;
    }

    public function send()
    {
        $this->AltBody = strip_tags(stripslashes($this->Body))."\n\n";
        $this->AltBody = str_replace("&nbsp;", "\n\n", $this->AltBody);
        return parent::send();
    }
}
