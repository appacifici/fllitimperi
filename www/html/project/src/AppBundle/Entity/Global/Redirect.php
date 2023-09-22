<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * Group
 *
 * @ORM\Table(name="redirects", uniqueConstraints={
 * })
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PollRepository")
 * @ORM\Cache("NONSTRICT_READ_WRITE", region="my_poll_region_result")
 */
class Redirect {
     
    /**
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * 
     * @Assert\NotBlank(message="Inserire la url di origine")
     * @ORM\Column(name="original_url", type="string", length=500)
     */
    private $originalUrl;
    
    /**
     * 
     * @ORM\Column(name="new_url", type="string", length=500)
     */
    private $newUrl; 
    
  
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
     * Set question
     *
     * @param string $question
     *
     * @return Poll
     */
    public function setOriginalUrl($originalUrl)
    {
        $this->originalUrl = $originalUrl;

        return $this;
    }

    /**
     * Get question
     *
     * @return string
     */
    public function getOriginalUrl()
    {
        return $this->originalUrl;
    }

    /**
     * Set jsonAnswers
     *
     * @param array $jsonAnswers
     *
     * @return Poll
     */
    public function setNewUrl($newUrl)
    {
        $this->newUrl = $newUrl;

        return $this;
    }

    /**
     * Get jsonAnswers
     *
     * @return array
     */
    public function getNewUrl()
    {
        return $this->newUrl;
    }
    

}
