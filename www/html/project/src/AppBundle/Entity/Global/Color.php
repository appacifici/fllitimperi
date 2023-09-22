<?php

namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 *
 * @ORM\Table(name="colors", uniqueConstraints={
 *      @ORM\UniqueConstraint(name="unq_colors", columns={"name","name_url"})      
 *      }
 * )
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ColorRepository")
 * @ORM\Cache("NONSTRICT_READ_WRITE", region="my_color_region_result" )
 */
class Color { 

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
     * @Assert\NotBlank(message="Specificare un valore")
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     * @ORM\Column(name="name_url", type="string", nullable=true)
     */
    private $nameUrl;    
    
    /**
     * @var string
     *
     * @ORM\Column(name="synonyms", type="string", length=250, nullable=true)
     */
    private $synonyms;
    
    /**
     * @var string
     * @Assert\NotBlank(message="Specificare un valore")
     * @ORM\Column(name="is_active", type="smallint", options={"default" = 0})
     */
    private $isActive;

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
     * Set active
     *
     * @param integer $isActive
     *
     * @return Banner
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get active
     *
     * @return integer
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

 
    /**
     * Set url
     *
     * @param string $url
     *
     * @return Banner
     */
    public function setNameUrl($nameUrl)
    {
        $this->nameUrl = $nameUrl;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getNameUrl()
    {
        return $this->nameUrl;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Banner
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }    
    
    /**
     * Set description
     *
     * @param string $synonyms
     *
     * @return Typology
     */
    public function setSynonyms($synonyms)
    {
        $this->synonyms = $synonyms;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getSynonyms()
    {
        return $this->synonyms;
    }
    
}
