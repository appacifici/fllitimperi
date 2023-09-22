<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SearchTerm
 *
 * @ORM\Table(name="search_terms",
 * indexes={
 *          @ORM\Index( name="searchTerm_subcat_isTested_typo", columns={ "subcategory_id", "is_tested", "typology_id" } ),
 *          @ORM\Index( name="searchTerm_section", columns={ "section" } )
 *      })
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SearchTermRepository")
 */
class SearchTerm
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @var string
     *
     * @ORM\Column(name="related_id", type="integer", nullable=true)
     */
    private $releatedId;
    
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=250, nullable=false)
     */
    private $name;
    
    /**
     * @var string
     *
     * @ORM\Column(name="display_label", type="string", length=250, nullable=true)
     */
    private $displayLabel;
    
    /**
     * @var string
     *
     * @ORM\Column(name="sex", type="string", length=250, nullable=true)
     */
    private $sex;
    
    /**
     * @var string
     *
     * @ORM\Column(name="route_name", type="string", length=250, nullable=false)
     */
    private $routeName;
    
    /**
     * @var integer
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="searchTerm", fetch="EAGER")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
    private $category;
    
    /**
     * @var integer
     * @ORM\ManyToOne(targetEntity="Subcategory", inversedBy="searchTerm", fetch="EAGER")
     * @ORM\JoinColumn(name="subcategory_id", referencedColumnName="id")
     */
    private $subcategory;
    
    /**
     * @var integer
     * @ORM\ManyToOne(targetEntity="Typology", inversedBy="searchTerm", fetch="EAGER")
     * @ORM\JoinColumn(name="typology_id", referencedColumnName="id")
     */
    private $typology;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_active", type="boolean", nullable=true, options={"default" = 1})
     */
    private $isActive;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="is_tested", type="boolean", nullable=true, options={"default" = 0})
     */
    private $isTested;
    
    /**
     * @var string
     *
     * @ORM\Column(name="meta_title", type="string", length=250, nullable=true)
     */
    private $metaTitle;
    
    /**
     * @var string
     *
     * @ORM\Column(name="meta_description", type="string", length=250, nullable=true)
     */
    private $metaDescription;
    
    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=250, nullable=true)
     */
    private $title;
    
    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=250, nullable=true)
     */
    private $description;
    
    /**
     * @var string
     *
     * @ORM\Column(name="body", type="text")
     */
    private $body;
    
    /**
     * @var string
     *
     * @ORM\Column(name="section", type="string", length=250, nullable=false)
     */
    private $section;
    

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
     * Set $name
     *
     * @param string $name
     *
     * @return name
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
     * Set $sex
     *
     * @param string $sex
     *
     * @return name
     */
    public function setSex($sex)
    {
        $this->sex = $sex;

        return $this;
    }
    
    /**
     * Get sex
     *
     * @return string
     */
    public function getSex()
    {
        return $this->sex;
    }
    
    /**
     * Set $metaTitle
     *
     * @param string $metaTitle
     *
     * @return metatitle
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
     * Set $metaDescription
     *
     * @param string $metaDescription
     *
     * @return metaDescription
     */
    public function setMetaDescription($metaDescription)
    {
        $this->metaDescription = $metaDescription;

        return $this;
    }    
    
    
    /**
     * Set $metaDescription
     *
     * @param string $metaDescription
     *
     * @return metaDescription
     */
    public function getMetaDescription()
    {
        return $this->metaDescription;

        return $this;
    }    
    
    /**
     * Set $title
     *
     * @param string $title
     *
     * @return title
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }
    
    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }
    
    /**
     * Set $description
     *
     * @param string $description
     *
     * @return description
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }    
     
    /**
     * Get metaDescription
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }
    
    /**
     * Get $body
     *
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }
        
    /**
     * Set $body
     *
     * @param string $body
     *
     * @return $body
     */
    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }
   
    
    /**
     * Set $section
     *
     * @param string $section
     *
     * @return section
     */
    public function setSection($section)
    {
        $this->section = $section;

        return $this;
    }
    
    /**
     * Get section
     *
     * @return string
     */
    public function getSection()
    {
        return $this->section;
    }
    
    /**
     * Set $displayLabel
     *
     * @param string $displayLabel
     *
     * @return name
     */
    public function setDisplayLabel($displayLabel)
    {
        $this->displayLabel = $displayLabel;

        return $this;
    }
    
     /**
     * Get displayLabel
     *
     * @return string
     */
    public function getDisplayLabel()
    {
        return $this->displayLabel;
    }
    
    /**
     * Set $routeName
     *
     * @param string $routeName
     *
     * @return routeName
     */
    public function setRouteName($routeName)
    {
        $this->routeName = $routeName;

        return $this;
    }

    /**
     * Get routeName
     *
     * @return string
     */
    public function getRouteName()
    {
        return $this->routeName;
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
     * Set isActive
     *
     * @param boolean $isActive
     *
     * @return Product
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
     * Set isTested
     *
     * @param boolean $isTested
     *
     * @return isTested
     */
    public function setIsTested($isTested)
    {
        $this->isTested = $isTested;

        return $this;
    }

    /**
     * Get isTested
     *
     * @return boolean
     */
    public function getReleatedId()
    {
        return $this->releatedId;
    }
    
    /**
     * Set $releatedId
     *
     * @param boolean $releatedId
     *
     * @return $releatedId
     */
    public function setReleatedId($releatedId)
    {
        $this->releatedId = $releatedId;

        return $this;
    }

    /**
     * Get isTested
     *
     * @return boolean
     */
    public function getIsTested()
    {
        return $this->isTested;
    }
    
}
