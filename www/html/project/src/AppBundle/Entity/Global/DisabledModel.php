<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DisabledModel
 *
 * @ORM\Table(name="disabled_models", uniqueConstraints={
 *      @ORM\UniqueConstraint(name="unq_disabled_model", columns={"name_url","subcategory_id"})
 * },
 *  indexes={
 *          @ORM\Index(name="key_models_name_url_pgm_name", columns={"name_url_pm","name"}),
 *          @ORM\Index(name="key_models_name", columns={"name"}) 
 *      }
 * )
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DisabledModelRepository")
 * @ORM\Cache("NONSTRICT_READ_WRITE",  region="my_model_region_result")
 */
class DisabledModel
{
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
     * @ORM\Column(name="name", type="string", length=250, nullable=false)
     */
    private $name;
    
    /**
     * @var string
     *
     * @ORM\Column(name="name_url", type="string", length=250, nullable=false)
     */
    private $nameUrl;    
    
    /**
     * @var string
     *
     * @ORM\Column(name="name_url_tp", type="string", length=250, nullable=true)
     */
    private $nameUrlTp;    
    
    /**
     * @var string
     *
     * @ORM\Column(name="name_url_pm", type="string", length=250, nullable=true)
     */
    private $nameUrlPm;            
    
    /**
     * @var string
     *
     * @ORM\Column(name="name_url_ide", type="string", length=250, nullable=true)
     */
    private $nameUrlIde;            
     
    /**
     * @var integer
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="model", fetch="EAGER")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
    private $category;
    
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
     * @ORM\ManyToOne(targetEntity="MicroSection", inversedBy="model")
     * @ORM\JoinColumn(name="micro_section_id", referencedColumnName="id")
     */
    private $microSection; 
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="is_active", type="boolean", nullable=true, options={"default" = 0})
     */
    private $isActive;    
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_import", type="datetime", nullable=false))
     */
    private $dateImport;    
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="is_top", type="integer", nullable=true, options={"default" = 10})
     */
    private $isTop;    
    
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->setDateImport(new \DateTime('now'));
        $this->product = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * @return Model
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
     * @return Model
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
     * Set $nameUrlTp
     *
     * @param string $nameUrlTp
     *
     * @return Model
     */
    public function setNameUrlTp($nameUrlTp)
    {
        $this->nameUrlTp = $nameUrlTp;

        return $this;
    }

    /**
     * Get nameUrl
     *
     * @return string
     */
    public function getNameUrlTp()
    {
        return $this->nameUrlTp ;
    }
    
    /**
     * Set $nameUrlPm
     *
     * @param string $nameUrlPm
     *
     * @return Model
     */
    public function setNameUrlPm($nameUrlPm)
    {
        $this->nameUrlPm = $nameUrlPm;

        return $this;
    }

    /**
     * Get nameUrl
     *
     * @return string
     */
    public function getNameUrlPm()
    {
        return $this->nameUrlPm;
    }
    
    
    /**
     * Set $nameUrlIde
     *
     * @param string $nameUrlIde
     *
     * @return Model
     */
    public function setNameUrlIde($nameUrlIde)
    {
        $this->nameUrlIde = $nameUrlIde;

        return $this;
    }

    /**
     * Get $nameUrlIde
     *
     * @return string
     */
    public function getNameUrlIde()
    {
        return $this->nameUrlIde;
    }
    
    /**
     * Set category
     *
     * @param \AppBundle\Entity\Category $category
     *
     * @return Model
     */
    public function setCategory(\AppBundle\Entity\Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \AppBundle\Entity\Category
     */
    public function getCategory()
    {
        return $this->category;
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
     * Set microSection
     *
     * @param \AppBundle\Entity\MicroSection $microSection
     *
     * @return Model
     */
    public function setMicroSection(\AppBundle\Entity\MicroSection $microSection = null)
    {
        $this->microSection = $microSection;

        return $this;
    }

    /**
     * Get microSection
     *
     * @return \AppBundle\Entity\MicroSection
     */
    public function getMicroSection()
    {
        return $this->microSection;
    }

     /**
     * Set isActive
     *
     * @param boolean $isActive
     *
     * @return Model
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean
     */
    public function getIsActive()
    {
        return $this->isActive;
    }
    
     /**
     * Set dateImport
     *
     * @param \DateTime $dateImport
     *
     * @return Product
     */
    public function setDateImport($dateImport)
    {
        $this->dateImport = $dateImport;

        return $this;
    }
    
     /**
     * Get dateImport
     *
     * @return \DateTime
     */
    public function getDateImport()
    {
        return $this->dateImport;
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
    
}


