<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Category
 *
 * @ORM\Table(name="dictionary", uniqueConstraints={
 *      @ORM\UniqueConstraint(name="unq_dictionary", columns={"name_url"})
 * },
 * indexes={
 *          @ORM\Index( name="dictionaryUrl", columns={ "name_url" } )
 *      }
 * )
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DictionaryRepository")
 * @ORM\Cache(usage="NONSTRICT_READ_WRITE", region="my_category_region_result" )
 */
class Dictionary {

    const EXISTANCE_CHECK_FIELD = 'Name';
    
    public function __construct() {
  
    }

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
     * @Assert\NotBlank(message="Specificare un nome")
     * @ORM\Column(name="name", type="string", length=64)
     */
    private $name;
    
    /**
     * @var string
     * @Assert\NotBlank(message="Specificare un nome")
     * @ORM\Column(name="name_url", type="string", length=64)
     */
    private $nameUrl;
        
    /**
     * @var string
     * @Assert\NotBlank(message="Specificare un nome")
     * @ORM\Column(name="body", type="text", length=65535, nullable=true)
     */
    private $body;  
       
    /**
     * @var boolean
     * @ORM\Column(name="is_active", type="boolean", options={"default" = 1})  
     * @Assert\NotBlank(message="Selezionare uno stato valido")
     */
    private $isactive;
    
     /**
     * @var integer
     * @ORM\ManyToOne(targetEntity="Subcategory", inversedBy="model", fetch="EAGER")
     * @ORM\JoinColumn(name="subcategory_id", referencedColumnName="id")
     */
    private $subcategory;
    
    /**
     * @var integer
     * @ORM\ManyToOne(targetEntity="Typology", inversedBy="model", fetch="EAGER")
     * @ORM\JoinColumn(name="typology_id", referencedColumnName="id")     
     */
    private $typology;
    

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
     * Set name
     *
     * @param string $name
     *
     * @return Category
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
     * Set nameUrl
     *
     * @param string $nameUrl
     *
     * @return Category
     */
    public function setNameUrl($nameUrl)
    {
        $this->nameUrl = $nameUrl;

        return $this;
    }

    /**
     * Get nameUrl
     *
     * @return string
     */
    public function getNameUrl()
    {
        return $this->nameUrl;
    }

    /**
     * Set status
     *
     * @param boolean $isactive
     *
     * @return Category
     */
    public function setIsactive($isactive)
    {
        $this->isactive = $isactive;

        return $this;
    }

    /**
     * Get status
     *
     * @return boolean
     */
    public function getIsactive()
    {
        return $this->isactive;
    }

    /**
     * Set subcategory
     *
     * @param \AppBundle\Entity\Subcategory $subcategory
     *
     * @return Model
     */
    public function setSubcategory(\AppBundle\Entity\Subcategory $subcategory = null)
    {
        $this->subcategory = $subcategory;

        return $this;
    }

    /**
     * Get subcategory
     *
     * @return \AppBundle\Entity\Subcategory
     */
    public function getSubcategory()
    {
        return $this->subcategory;
    }

    /**
     * Set typology
     *
     * @param \AppBundle\Entity\Typology $typology
     *
     * @return Model
     */
    public function setTypology(\AppBundle\Entity\Typology $typology = null)
    {
        $this->typology = $typology;

        return $this;
    }

    /**
     * Get typology
     *
     * @return \AppBundle\Entity\Typology
     */
    public function getTypology()
    {
        return $this->typology;
    }
    
    
    /**
     * Set $body
     *
     * @param string $body
     *
     * @return Typology
     */
    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }
     
}



    