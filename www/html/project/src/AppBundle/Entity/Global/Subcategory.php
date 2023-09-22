<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Team
 *
 * @ORM\Table(name="subcategories", uniqueConstraints={
 *  @ORM\UniqueConstraint(name="unq_subcategories", columns={"category_id", "name_url"})
 * },
 *  indexes={
 *          @ORM\Index(name="key_subcategories_name_url", columns={"name_url"}), 
 *          @ORM\Index( name="key_subcat_isactive", columns={ "is_active"  } )
 *      }
 * ))
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SubcategoryRepository")
 * @ORM\Cache(usage="NONSTRICT_READ_WRITE", region="my_subcategory_region_result")
 */
class Subcategory {

    const EXISTANCE_CHECK_FIELD = 'Name';
     
    
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="subcategories", cascade={"persist"}, fetch="EAGER")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
    protected $category;
    
    /**
     * @ORM\OneToMany(targetEntity="MicroSection", mappedBy="subcategory")
     * @ORM\JoinColumn(name="micro_section_id", referencedColumnName="id")
     */
    protected $microSection;
    
    /**
     * @var int
     * @ORM\Column(name="last_db_id", type="integer", nullable=true)
     */
    private $lastDbId;
    
    /**
     * @var int
     * @ORM\Column(name="last_term_id", type="integer", nullable=true)
     */
    private $lastTermId;
    
    /**
     * @var string
     * @Assert\NotBlank(message="Specificare un valore")
     * @ORM\Column(name="name", type="string", length=64)
     */
    private $name;

    /**
     * @var string
     * @Assert\NotBlank()
     * @ORM\Column(name="name_url", type="string", length=64)
     */
    private $nameUrl;

    /**
     * @var string
     * @ORM\Column(name="anchor_menu", type="string", length=64, nullable=true)
     */
    private $anchorMenu;
    
    
    /**
     * @var string
     * @ORM\Column(name="singular_name", type="string", length=64, nullable=true)
     */
    private $singularName;

    /**
     * @var string
     * @ORM\Column(name="singular_name_url", type="string", length=64, nullable=true)
     */
    private $singularNameUrl;
        
    /**
     * @var string
     *
     * @ORM\Column(name="synonyms", type="text", nullable=true)
     */
    private $synonyms;
    
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
     * @var string
     * @ORM\Column(name="label", type="string", length=64, nullable=true)
     */
    private $label;
    
    /**
     * @var string
     * @ORM\Column(name="img", type="string", length=255, nullable=true)
     */
    private $img;
    
    /**
     * @var string
     * @ORM\Column(name="meta_title", type="string", length=255, nullable=true)
     */
    private $metaTitle;
    
    /**
     * @var string
     * @ORM\Column(name="meta_keyword", type="string", length=255, nullable=true)
     */
    private $metaKeyword;
    
    /**
     * @var string
     * @ORM\Column(name="meta_description", type="string", length=255, nullable=true)
     */
    private $metaDescription;
        
    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", length=65535, nullable=true)
     */
    private $description;    
        
    /**
     * @var string
     *
     * @ORM\Column(name="body", type="text", length=65535, nullable=true)
     */
    private $body;    
    
    /**
     * @var string
     * @Assert\NotBlank(message="Specificare un valore")
     * @ORM\Column(name="bg_color", type="string", length=255, nullable=true)
     */
    private $bgColor;
    
    /**
     * @var string
     * @Assert\NotBlank(message="Specificare un valore")
     * @ORM\Column(name="color", type="string", length=255, nullable=true)
     */
    private $color;
          
    /**
     * @var string
     *
     * @ORM\Column(name="sex", type="string", length=25, nullable=true)
     */
    private $sex;
          
    /**
     * @var string
     *
     * @ORM\Column(name="seeAlso", type="string", length=500, nullable=true)
     */
    private $seeAlso;
    
    /**
     * @var boolean
     * @ORM\Column(name="is_active", type="boolean", options={"default" = 1})  
     * @Assert\NotBlank(message="Selezionare uno stato valido")
     */
    private $isactive;    
    
    /**
     * @var integer
     *
     * @ORM\Column(name="has_models", type="integer", nullable=true, options={"default" = 0})
     */
    private $hasModels;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="has_products", type="integer", nullable=true, options={"default" = 0})
     */
    private $hasProducts;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="is_top", type="integer", nullable=true, options={"default" = 10})
     */
    private $isTop;
    
    /**
     * @var boolean
     * @ORM\Column(name="filter_model_completed", type="boolean", options={"default" = 0})  
     */
    private $filterModelCompleted;
            
    /**
     * @var boolean
     * @ORM\Column(name="filter_similar_models", type="boolean", options={"default" = 0})  
     */
    private $filterSimilarModels;    
    
        /**
     * @var boolean
     * @ORM\Column(name="filter_all_models_trademark", type="boolean", options={"default" = 0})  
     */
    private $filterAllModelsTrademark;  
    
    /**
     * @var boolean
     * @ORM\Column(name="filter_trademarks_section", type="string", nullable=true)  
     */
    private $filterTrademarksSection;  
    
    /**
     * @ORM\OneToMany(targetEntity="Typology", mappedBy="subcategory")
     */
    protected $typology;
    
    /**
     * @ORM\OneToMany(targetEntity="Model", mappedBy="subcategory")
     */
    protected $model;
    
    /**
     * @ORM\OneToMany(targetEntity="Product", mappedBy="subcategory")
     */
    protected $product;
    
    /**
     * @ORM\OneToMany(targetEntity="SearchTerm", mappedBy="subcategory")
     */
    protected $searchTerm;
    
    private $subcatSiteAffiliation;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->typology = new \Doctrine\Common\Collections\ArrayCollection();
        $this->model = new \Doctrine\Common\Collections\ArrayCollection();
        $this->product = new \Doctrine\Common\Collections\ArrayCollection();
        $this->subcatSiteAffiliation = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set lastDbId
     *
     * @param integer $lastDbId
     *
     * @return Subcategory
     */
    public function setLastDbId($lastDbId)
    {
        $this->lastDbId = $lastDbId;

        return $this;
    }

    /**
     * Get lastDbId
     *
     * @return integer
     */
    public function getLastDbId()
    {
        return $this->lastDbId;
    }

    /**
     * Set lastTermId
     *
     * @param integer $lastTermId
     *
     * @return Subcategory
     */
    public function setLastTermId($lastTermId)
    {
        $this->lastTermId = $lastTermId;

        return $this;
    }

    /**
     * Get lastTermId
     *
     * @return integer
     */
    public function getLastTermId()
    {
        return $this->lastTermId;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Subcategory
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
     * @return Subcategory
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
     * Set singularName
     *
     * @param string $singularName
     *
     * @return singularName
     */
    public function setSingularName($singularName)
    {
        $this->singularName = $singularName;

        return $this;
    }

    /**
     * Get nameUrl
     *
     * @return string
     */
    public function getSingularName()
    {
        return $this->singularName;
    }    
    
    /**
     * Set singularNameUrl
     *
     * @param string $singularNameUrl
     *
     * @return singularName
     */
    public function setSingularNameUrl($singularNameUrl)
    {
        $this->singularNameUrl = $singularNameUrl;

        return $this;
    }

    /**
     * Get singularNameUrl
     *
     * @return string
     */
    public function getSingularNameUrl()
    {
        return $this->singularNameUrl;
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
     * Set name
     *
     * @param string $label
     *
     * @return Subcategory
     */
    public function setLabel($label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Set img
     *
     * @param string $img
     *
     * @return Subcategory
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
     * @return Subcategory
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
     * @return Subcategory
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
     * @return Subcategory
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
     * Set description
     *
     * @param string $description
     *
     * @return Typology
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
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
     * Set bgColor
     *
     * @param string $bgColor
     *
     * @return Subcategory
     */
    public function setBgColor($bgColor)
    {
        $this->bgColor = $bgColor;

        return $this;
    }

    /**
     * Get bgColor
     *
     * @return string
     */
    public function getBgColor()
    {
        return $this->bgColor;
    }

    /**
     * Set color
     *
     * @param string $color
     *
     * @return Subcategory
     */
    public function setColor($color)
    {
        $this->color = $color;

        return $this;
    }

    /**
     * Get color
     *
     * @return string
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * Set status
     *
     * @param boolean $isactive
     *
     * @return Subcategory
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
     * Set $hasProducts
     *
     * @param string $hasProducts
     *
     * @return Typology
     */
    public function setHasProducts($hasProducts)
    {
        $this->hasProducts = $hasProducts;

        return $this;
    }

    /**
     * Get $hasProducts
     *
     * @return string
     */
    public function getHasProducts()
    {
        return $this->hasProducts;
    }
    
    /**
     * Set $hasModels
     *
     * @param string $hasModels
     *
     * @return Typology
     */
    public function setHasModels($hasModels)
    {
        $this->hasModels = $hasModels;

        return $this;
    }

    /**
     * Get $hasModels
     *
     * @return string
     */
    public function getHasModels()
    {
        return $this->hasModels;
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
     * Set sex
     *
     * @param boolean sex
     *
     * @return sex
     */
    public function setSex($sex)
    {
        $this->sex = $sex;

        return $this;
    }

    /**
     * Get isTop
     *
     * @return boolean
     */
    public function getSex()
    {
        return $this->sex;
    }
    
    
    /**
     * Set $seeAlso
     *
     * @param boolean $seeAlso
     *
     * @return sex
     */
    public function setSeeAlso($seeAlso)
    {
        $this->seeAlso = $seeAlso;

        return $this;
    }

    /**
     * Get isTop
     *
     * @return boolean
     */
    public function getSeeAlso()
    {
        return $this->seeAlso;
    }
    
    /**
     * Set $filterModelCompleted
     *
     * @param boolean $filterModelCompleted
     *
     * @return $filterModelCompleted
     */
    public function setFilterModelCompleted($filterModelCompleted)
    {
        $this->filterModelCompleted = $filterModelCompleted;

        return $this;
    }

    /**
     * Get $filterModelCompleted
     *
     * @return boolean
     */
    public function getFilterModelCompleted()
    {
        return $this->filterModelCompleted;
    }
    
    /**
     * Set $filterSimilarModels
     *
     * @param boolean $filterSimilarModels
     *
     * @return $filterSimilarModels
     */
    public function setFilterSimilarModels($filterSimilarModels)
    {
        $this->filterSimilarModels = $filterSimilarModels;

        return $this;
    }

    /**
     * Get $filterModelCompleted
     *
     * @return boolean
     */
    public function getFilterSimilarModels()
    {
        return $this->filterSimilarModels;
    }    
    
    /**
     * Set $filterAllModelsTrademark
     *
     * @param boolean $filterAllModelsTrademark
     *
     * @return $filterAllModelsTrademark
     */
    public function setFilterAllModelsTrademark($filterAllModelsTrademark)
    {
        $this->filterAllModelsTrademark = $filterAllModelsTrademark;

        return $this;
    }

    /**
     * Get $filterModelCompleted
     *
     * @return boolean
     */
    public function getFilterAllModelsTrademark()
    {
        return $this->filterAllModelsTrademark;
    }   
    
    /**
     * Set filterTrademarksSection
     *
     * @param boolean filterTrademarksSection
     *
     * @return filterTrademarksSection
     */
    public function setFilterTrademarksSection($filterTrademarksSection)
    {
        $this->filterTrademarksSection = $filterTrademarksSection;

        return $this;
    }

    /**
     * Get filterTrademarksSection
     *
     * @return boolean
     */
    public function getFilterTrademarksSection()
    {
        return $this->filterTrademarksSection;
    }    

    /**
     * Set category
     *
     * @param \AppBundle\Entity\Category $category
     *
     * @return Subcategory
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
     * Add typology
     *
     * @param \AppBundle\Entity\Typology $typology
     *
     * @return Subcategory
     */
    public function addTypology(\AppBundle\Entity\Typology $typology)
    {
        $this->typology[] = $typology;

        return $this;
    }

    /**
     * Remove typology
     *
     * @param \AppBundle\Entity\Typology $typology
     */
    public function removeTypology(\AppBundle\Entity\Typology $typology)
    {
        $this->typology->removeElement($typology);
    }

    /**
     * Get typology
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTypology()
    {
        return $this->typology;
    }

    /**
     * Add model
     *
     * @param \AppBundle\Entity\Model $model
     *
     * @return Subcategory
     */
    public function addModel(\AppBundle\Entity\Model $model)
    {
        $this->model[] = $model;

        return $this;
    }

    /**
     * Remove model
     *
     * @param \AppBundle\Entity\Model $model
     */
    public function removeModel(\AppBundle\Entity\Model $model)
    {
        $this->model->removeElement($model);
    }

    /**
     * Get model
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getModel()
    {
        return $this->model;
    }
    
    /**
     * Add searchTerm
     *
     * @param \AppBundle\Entity\SearchTerm $searchTerm
     *
     * @return Subcategory
     */
    public function addSearchTerm(\AppBundle\Entity\SearchTerm $searchTerm)
    {
        $this->searchTerm[] = $searchTerm;

        return $this;
    }

    /**
     * Remove searchTerm
     *
     * @param \AppBundle\Entity\SearchTerm $searchTerm
     */
    public function removeSearchTerm(\AppBundle\Entity\SearchTerm $searchTerm)
    {
        $this->model->removeElement($searchTerm);
    }

    /**
     * Get searchTerm
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSearchTerm()
    {
        return $this->searchTerm;
    }

    /**
     * Add product
     *
     * @param \AppBundle\Entity\Product $product
     *
     * @return Subcategory
     */
    public function addProduct(\AppBundle\Entity\Product $product)
    {
        $this->product[] = $product;

        return $this;
    }

    /**
     * Remove product
     *
     * @param \AppBundle\Entity\Product $product
     */
    public function removeProduct(\AppBundle\Entity\Product $product)
    {
        $this->product->removeElement($product);
    }

    /**
     * Get product
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * Add subcatSiteAffiliation
     *
     * @param \AppBundle\Entity\SubcategorySiteAffiliation $subcatSiteAffiliation
     *
     * @return Subcategory
     */
    public function addSubcatSiteAffiliation(\AppBundle\Entity\SubcategorySiteAffiliation $subcatSiteAffiliation)
    {
        $this->subcatSiteAffiliation[] = $subcatSiteAffiliation;

        return $this;
    }

    /**
     * Remove subcatSiteAffiliation
     * 
     * @param \AppBundle\Entity\SubcategorySiteAffiliation $subcatSiteAffiliation
     */
    public function removeSubcatSiteAffiliation(\AppBundle\Entity\SubcategorySiteAffiliation $subcatSiteAffiliation)
    {
        $this->subcatSiteAffiliation->removeElement($subcatSiteAffiliation);
    }

    /**
     * Get subcatSiteAffiliation
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSubcatSiteAffiliation()
    {
        return $this->subcatSiteAffiliation;
    }
    
      /**
     * Set $anchorMenu
     *
     * @param string $anchorMenu
     *
     * @return Typology
     */
    public function setAnchorMenu($anchorMenu)
    {
        $this->anchorMenu = $anchorMenu;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getAnchorMenu()
    {
        return $this->anchorMenu;
    }
    
}
