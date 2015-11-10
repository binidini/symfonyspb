<?php
/**
 * Message class for sending email from symfony.spb.ru
 *
 * @author Denis Manilo
 */

namespace Spb\SymfonyBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class Message {

    /**
     * @Assert\NotBlank()
     */    
    protected $name;

    /**
     * @Assert\NotBlank()     
     * @Assert\Email(
     *     checkMX = true
     * )
     */    
    protected $email;
    
    /**
     * @Assert\NotBlank()
     */    
    protected $subject;
    
    /**
     * @Assert\NotBlank()
     */    
    protected $msg;

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getSubject() {
        return $this->subject;
    }

    public function setSubject($subject) {
        $this->subject = $subject;
    }

    public function getMsg() {
        return $this->msg;
    }

    public function setMsg($msg) {
        $this->msg = $msg;
    }

}

?>
