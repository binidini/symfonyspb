<?php

namespace Spb\SymfonyBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Subscription
 *
 * @ORM\Table(name="t01_subscription")
 * @ORM\Entity
 * @UniqueEntity("email")
 */
class Subscription
{
    /**
     * @var integer
     *
     * @ORM\Column(name="c01_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
    /**
     * @Assert\NotBlank()     
     * @Assert\Email(
     *     checkMX = true
     * )
     * 
     * @ORM\Column(name="c01_email", type="string", length=128, unique=true)
     */
    private $email;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Subscription
     */
    public function setEmail($email)
    {
        $this->email = $email;
    
        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }
       
}