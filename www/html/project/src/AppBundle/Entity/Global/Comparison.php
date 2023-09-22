<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Comparisons
 *
 * @ORM\Table(name="comparisons", uniqueConstraints={
 *      @ORM\UniqueConstraint(name="unq_categories", columns={"model_id_one", "model_id_two"})
 * },
 * indexes={
 *          @ORM\Index( name="comparisons_check_device", columns={ "model_id_one", "model_id_two" } )
 *      }
 * )
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ComparisonRepository")
 * @ORM\Cache(usage="NONSTRICT_READ_WRITE", region="my_category_region_result" )
 */
class Comparison {

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
     * @ORM\ManyToOne(targetEntity="Model")
     * @ORM\JoinColumn(name="model_id_one", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     * @Assert\NotBlank(message="Specificare un nome")
     */
    private $modelOne;
    
    /**
     * @ORM\ManyToOne(targetEntity="Model")
     * @ORM\JoinColumn(name="model_id_two", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     * @Assert\NotBlank(message="Specificare un nome")
     */
    private $modelTwo;    
    
    /**
     * @var string
     * @ORM\Column(name="name_url", type="string", length=255)
     * @Assert\NotBlank(message="Specificare un nome")
     */
    private $nameUrl;      
    
    /**
     * @var string
     * @ORM\Column(name="meta_title", type="string", length=255, nullable=true)
     */
    private $metaTitle;
    
    /**
     * @var string
     * @ORM\Column(name="meta_description", type="string", length=255, nullable=true)
     */
    private $metaDescription;
    
    /**
     * @var string
     * @ORM\Column(name="title", type="string", length=255, nullable=true)
     */
    private $title;
            
    /**
     * @var string
     *
     * @ORM\Column(name="body", type="text", length=65535, nullable=true)
     */
    private $body;          
    
    /**
     * @var boolean
     * @ORM\Column(name="is_active", type="boolean", options={"default" = 1})  
     * @Assert\NotBlank(message="Selezionare uno stato valido")
     */
    private $isActive;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="is_top", type="integer", nullable=true, options={"default" = 0})
     */
    private $isTop;
    
    /**
     *  @var \DateTime
     *
     * @ORM\Column(name="create_date", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $createDate;
    
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
     * Set img
     *
     * @param string $img
     *
     * @return Category
     */
    public function setImg($img)
    {
        $this->img = $img;

        return $this;
    }

    /**
     * Get img
     *
     * @return string
     */
    public function getImg()
    {
        return $this->img;
    }

    /**
     * Set metaTitle
     *
     * @param string $metaTitle
     *
     * @return Category
     */
    public function setMetaTitle($metaTitle)
    {
        $this->metaTitle = $metaTitle;

        return $this;
    }

    /**
     * Get metaTitle
     *
     * @return string
     */
    public function getMetaTitle()
    {
        return $this->metaTitle;
    }

    /**
     * Set metaKeyword
     *
     * @param string $metaKeyword
     *
     * @return Category
     */
    public function setMetaKeyword($metaKeyword)
    {
        $this->metaKeyword = $metaKeyword;

        return $this;
    }

    /**
     * Get metaKeyword
     *
     * @return string
     */
    public function getMetaKeyword()
    {
        return $this->metaKeyword;
    }

    /**
     * Set metaDescription
     *
     * @param string $metaDescription
     *
     * @return Category
     */
    public function setMetaDescription($metaDescription)
    {
        $this->metaDescription = $metaDescription;

        return $this;
    }

    /**
     * Get metaDescription
     *
     * @return string
     */
    public function getMetaDescription()
    {
        return $this->metaDescription;
    }

    /**
     * Set $description
     *
     * @param string $title
     *
     * @return Category
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get $description
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }
    
    /**
     * Set isTop
     *
     * @param boolean isTop
     *
     * @return Typology
     */
    public function setIsTop($isTop)
    {
        $this->isTop = $isTop;

        return $this;
    }

    /**
     * Get isTop
     *
     * @return boolean
     */
    public function getIsTop()
    {
        return $this->isTop;
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
     
    /**
     * Set dataArticle
     *
     * @param integer $modelOne 
     *
     * @return ContentArticle
     */
    public function setModelOne($modelOne)
    {
        $this->modelOne = $modelOne;

        return $this;
    }

    /**
     * Get dataArticle
     *
     * @return integer
     */
    public function getModelOne()
    {
        return $this->modelOne;
    }
     
    /**
     * Set $modelOne
     *
     * @param integer $modelTwo
     *
     * @return ContentArticle
     */
    public function setModelTwo($modelTwo)
    {
        $this->modelTwo = $modelTwo;

        return $this;
    }

    /**
     * Get dataArticle
     *
     * @return integer
     */
    public function getModelTwo()
    {
        return $this->modelTwo;
    }
    
     
    /**
     * Set $isActive
     *
     * @param integer $isActive
     *
     * @return ContentArticle
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get dataArticle
     *
     * @return integer
     */
    public function getIsActive()
    {
        return $this->isActive;
    }
    
    /**
     * Set createDate.
     *
     * @param \DateTime|null $createDate
     *
     * @return Device
     */
    public function setCreateDate($createDate = null)
    {
        $this->createDate = $createDate;

        return $this;
    }

    /**
     * Get createDate.
     *
     * @return \DateTime|null
     */
    public function getCreateDate()
    {
        return $this->createDate;
    }
    
}