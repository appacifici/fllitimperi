<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 *
 * @ORM\Table(name="chat_messages")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ChatMessageRepository")
 * @ORM\Cache("NONSTRICT_READ_WRITE", region="my_chat_region_result" )
 */
class ChatMessage extends BetradarEntity { 

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * 
     * @ORM\Column(name="text", type="string", length=255)
     */
    private $text;
    
    /**
     * @var datetime
     *
     * @ORM\Column(name="create_at", type="datetime")
     */
    private $createAt;

    /**
     * @ORM\Column(name="user", type="string", length=255)
     */
    private $user;   
    

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
     * Set text
     *
     * @param string $text
     *
     * @return Comment
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }
    
    /**
     * Set createAt
     *
     * @param \DateTime $createAt
     *
     * @return Comment
     */
    public function setCreateAt($createAt)
    {
        $this->createAt = $createAt;

        return $this;
    }

    /**
     * Get createAt
     *
     * @return \DateTime
     */
    public function getCreateAt()
    {
        return $this->createAt;
    }

  
    /**
     * Set createAt
     *
     * @param \DateTime $createAt
     *
     * @return Comment
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get createAt
     *
     * @return \DateTime
     */
    public function getUser()
    {
        return $this->user;
    }

  
   
}
