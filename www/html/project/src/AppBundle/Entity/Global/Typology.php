<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Typology
 *
 * @ORM\Table(name="typologies", uniqueConstraints={
 *  @ORM\UniqueConstraint(name="name", columns={"name_url", "subcategory_id"})
 * }, 
 *      indexes={
 *          @ORM\Index(name="key_subcategory_id_has_model", columns={"subcategory_id","has_models"}),
 *          @ORM\Index(name="key_subcategory", columns={"subcategory_id"}),
 *          @ORM\Index(name="key_subcategory_typoName", columns={"subcategory_id", "name"})
 *      }
 * )
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TypologyRepository")
 */
class Typology
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
     * @ORM\Column(name="anchor_menu", type="string", length=64, nullable=true)
     */
    private $anchorMenu;
    
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
     * @ORM\Column(name="synonyms", type="string", length=1000, nullable=true)
     */
    private $synonyms;

    /**
     * @var \AppBundle\Entity\Subcategory
     * @ORM\ManyToOne(targetEntity="Subcategory", inversedBy="typology", cascade={"persist"}, fetch="EAGER")
     * @ORM\JoinColumn(name="subcategory_id", referencedColumnName="id")
     */
    private $subcategory; 
    
    /**
     * @var \AppBundle\Entity\Category
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="typology", cascade={"persist"}, fetch="EAGER")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
    private $category; 
    
    /**
     * @ORM\OneToMany(targetEntity="MicroSection", mappedBy="typology")
     * @ORM\JoinColumn(name="micro_section_id", referencedColumnName="id")
     */
    protected $microSection; 
          
    /**
     * @var string
     *
     * @ORM\Column(name="sex", type="string", length=25, nullable=true)
     */
    private $sex;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="is_active", type="boolean", nullable=true, options={"default" = 1})
     */
    private $isActive;

    /**
     * @var integer
     *
     * @ORM\Column(name="views", type="integer", nullable=true, options={"default" = 0})
     */
    private $views;

    /**
     * @var integer
     *
     * @ORM\Column(name="period_views", type="integer", nullable=true, options={"default" = 0})
     */
    private $periodViews;

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
     * @ORM\Column(name="filter_trademarks_section", type="text", nullable=true)  
     */
    private $filterTrademarksSection;  
    
    /**
     * @var string
     *
     * @ORM\Column(name="seeAlso", type="string", length=500, nullable=true)
     */
    private $seeAlso;
    
    /**
     * @ORM\OneToMany(targetEntity="Model", mappedBy="typology")
     * @ORM\JoinColumn(name="model_id", referencedColumnName="id")
     */
    protected $model;
    
    /**
     * @ORM\OneToMany(targetEntity="SearchTerm", mappedBy="typology")
     */
    protected $searchTerm;
    
    /**
     * @ORM\OneToMany(targetEntity="Product", mappedBy="typology")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     */
    protected $product;
    
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
     * Constructor
     */
    public function __construct()
    {
        $this->model = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Typology
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
     * @return Typology
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
     * Set isActive
     *
     * @param boolean isActive
     *
     * @return Typology
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
     * Set numProducts
     *
     * @param integer $numProducts
     *
     * @return Typology
     */
    public function setNumProducts($numProducts)
    {
        $this->numProducts = $numProducts;

        return $this;
    }

    /**
     * Get numProducts
     *
     * @return integer
     */
    public function getNumProducts()
    {
        return $this->numProducts;
    }

    /**
     * Set views
     *
     * @param integer $views
     *
     * @return Typology
     */
    public function setViews($views)
    {
        $this->views = $views;

        return $this;
    }

    /**
     * Get views
     *
     * @return integer
     */
    public function getViews()
    {
        return $this->views;
    }

    /**
     * Set periodViews
     *
     * @param integer $periodViews
     *
     * @return Typology
     */
    public function setPeriodViews($periodViews)
    {
        $this->periodViews = $periodViews;

        return $this;
    }

    /**
     * Get periodViews
     *
     * @return integer
     */
    public function getPeriodViews()
    {
        return $this->periodViews;
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
     * Set description
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
     * Get description
     *
     * @return string
     */
    public function getHasModels()
    {
        return $this->hasModels;
    }

    /**
     * Set description
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
     * Get description
     *
     * @return string
     */
    public function getHasProducts()
    {
        return $this->hasProducts;
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
     * Add typology
     *
     * @param \AppBundle\Entity\MicroSection $microSection
     *
     * @return Subcategory
     */
    public function addMicroSection(\AppBundle\Entity\MicroSection $microSection)
    {
        $this->microSection[] = $microSection;

        return $this;
    }

    /**
     * Remove $microSection
     *
     * @param \AppBundle\Entity\MicroSection $microSection
     */
    public function removeMicroSection(\AppBundle\Entity\MicroSection $microSection)
    {
        $this->typology->removeElement($microSection);
    }

    /**
     * Get $microSection
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMicroSection()
    {
        return $this->microSection;
    }
    
    /**
     * Set subcategory
     *
     * @param \AppBundle\Entity\Subcategory $subcategory
     *
     * @return Typology
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
     * Set category
     *
     * @param \AppBundle\Entity\Category $category
     *
     * @return Typology
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
     * Get $filterModelCompleted
     *
     * @return boolean
     */
    public function getFilterSimilarModels()
    {
        return $this->filterSimilarModels;
    }    
    
    /**
     * Set subcategoryAffiliation
     *
     * @param \AppBundle\Entity\SubcategorySiteAffiliation $subcategoryAffiliation
     *
     * @return Typology
     */
    public function setSubcategoryAffiliation(\AppBundle\Entity\SubcategorySiteAffiliation $subcategoryAffiliation = null)
    {
        $this->subcategoryAffiliation = $subcategoryAffiliation;

        return $this;
    }

    /**
     * Get subcategoryAffiliation
     *
     * @return \AppBundle\Entity\SubcategorySiteAffiliation
     */
    public function getSubcategoryAffiliation()
    {
        return $this->subcategoryAffiliation;
    }

    /**
     * Add model 
     *
     * @param \AppBundle\Entity\Model $model
     *
     * @return Typology
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
     * @return Typology
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
