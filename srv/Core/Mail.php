<?php


class Srv_Core_Mail
{
    /**
     * @var null
     */
    private $sender = null;
    /**
     * @var array
     */
    private $recipients = array();
    /**
     * @var string
     */
    private $subject = '';
    /**
     * @var string
     */
    private $message = '';
    /**
     * @var string
     */
    private $mimeVersion = '1.0';
    /**
     * @var string
     */
    private $contentType = 'text/html';
    /**
     * @var string
     */
    private $charset = 'UTF-8';
    /**
     * @var string
     */
    private $name_prefix = '=?utf-8?B?';
    /**
     * @var string
     */
    private $name_postfix = '?=';

    function send()
    {
        $headers = "MIME-Version: $this->mimeVersion\r\n";
        $headers .= "Content-type: $this->contentType; charset=$this->charset\r\n";
        if (!$this->sender) {
            $this->setDefaultSender();
        }
        $headers .= $this->sender;
        mail(implode(", ", $this->recipients), $this->subject, $this->message, $headers);
    }

    function setMessage($subject, $message)
    {
        $this->subject = $this->name_prefix . base64_encode($subject) . $this->name_postfix;
        $this->message = $message;
        return $this;
    }

    function setSender($name, $email)
    {
        $this->sender = "From: $this->name_prefix" . base64_encode($name) . "$this->name_postfix <$email>\r\n";
        return $this;
    }

    private function setDefaultSender()
    {
        $this->sender = "From: $this->name_prefix" . base64_encode(Srv_Settings::getName()) . "$this->name_postfix <" . Srv_Settings::getEmail() . ">\r\n";
    }

    function addRecipient($email, $name = null)
    {
        $r = array();
        if ($name) {
            $r[] = $this->name_prefix . base64_encode($name) . $this->name_postfix;
        }
        $r[] = "<$email>";
        $this->recipients[] = implode(" ", $r);
        return $this;
    }
}