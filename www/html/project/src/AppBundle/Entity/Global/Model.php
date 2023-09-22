<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Model
 *
 * @ORM\Table(name="models", uniqueConstraints={
 *      @ORM\UniqueConstraint(name="unq_model", columns={"name_url","subcategory_id"})
 * },
 *  indexes={
 *          @ORM\Index(name="key_model_has_products", columns={"has_products"}),
 *          @ORM\Index(name="key_model_nameUrlTP_trademark", columns={"name_url_tp","trademark_id"}),
 *          @ORM\Index(name="key_models_name_url_pgm_name", columns={"name_url_pm","name"}),
 *          @ORM\Index(name="key_models_name", columns={"name"}),
 *          @ORM\Index(name="key_models_last_read_price", columns={"last_read_price"}),
 *          @ORM\Index(name="key_models_is_active_is_completed", columns={"is_active","is_completed"}),
 *          @ORM\Index(name="key_models_isTop_dateImport", columns={"is_top", "date_import"}),
 *          @ORM\Index(name="key_models_subcat_name", columns={"subcategory_id", "name"}),
 *          @ORM\Index(name="key_models_typo_name", columns={"typology_id", "name"}),
 *          @ORM\Index(name="key_models_dateImport", columns={"date_import"}),
 *          @ORM\Index(name="key_models_dateRelease", columns={"date_release"}),
 *          @ORM\Index(name="key_models_activeTrademarkSucatTypo", columns={"is_active","trademark_id","subcategory_id","typology_id"}),
 *          @ORM\Index(name="key_models_activeSucat_showcase", columns={"is_active","subcategory_id","in_showcase"}),
 *          @ORM\Index(name="key_models_activeTypo_showcase", columns={"is_active","typology_id","in_showcase"}),
 *          @ORM\Index(name="key_models_distinctTra_subcat", columns={"subcategory_id","is_active","has_products"}),
 *          @ORM\Index(name="key_models_distinctTra_typo", columns={"is_active","has_products","typology_id"}),
 *          @ORM\Index(name="key_models_activeTrademarkSucatTypo2", columns={"price","last_price","category_id","subcategory_id","typology_id"}),
 *      }
 * )
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ModelRepository")
 * @ORM\Cache("NONSTRICT_READ_WRITE",  region="my_model_region_result")
 */
class Model
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
     * @var string
     *
     * @ORM\Column(name="name_url_product_ide", type="string", length=250, nullable=true)
     */
    private $nameUrlProductIde;            
    
    /**
     * @var integer
     * @ORM\ManyToOne(targetEntity="TecnicalTemplate", inversedBy="model")
     * @ORM\JoinColumn(name="tecnical_template_id", referencedColumnName="id")
     */
    private $tecnicalTemplate;    
            
    /**
     * @ORM\Column(name="link_category_amazon", type="string", length=500, nullable=true)
     */
    private $linkCategoryAmazon;
    
    /**
     * @ORM\Column(name="video", type="text", nullable=true)
     */
    private $video;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="releatedCodeAmazon", type="string", length=250, nullable=true )
     */
    private $releatedCodeAmazon;
    
    /**
     * @var string
     *
     * @ORM\Column(name="technical_specifications", type="text", nullable=true)
     */
    private $technicalSpecifications;    
    
    /**
     * @var string
     *
     * @ORM\Column(name="images_gallry", type="text", nullable=true)
     */
    private $imagesGallery;
    
    /**
     * @var string
     * @ORM\Column(name="manual_url", type="string", length=250, nullable=true )  
     */
    private $manualUrl;   
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_release", type="datetime", nullable=false))
     */
    private $dateRelease;  
    
    /**
     * @var float
     *
     * @ORM\Column(name="advised_price", type="string", length=250, nullable=true)
     */
    private $advisedPrice;
    
    /**
     * @var float
     *
     * @ORM\Column(name="price", type="float", precision=10, scale=0, nullable=true)
     */
    private $price;    
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="revisioned", type="boolean", nullable=true, options={"default" = 0})
     */
    private $revisioned;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="is_completed", type="boolean", nullable=false, options={"default" = 0})
     */
    private $isCompleted;
    
    /**
     * @var string
     *
     * @ORM\Column(name="bullet_points", type="text", nullable=true)
     */
    private $bulletPoints;
    
    /**
     * @var string
     *
     * @ORM\Column(name="bullet_points_guide", type="text", nullable=true)
     */
    private $bulletPointsGuide;
    
    /**
     * @var string
     *
     * @ORM\Column(name="amazon_asin_review", type="string", length=250, nullable=true)
     */
    private $amazonAsinReview;    
    
    /**
     * @var string
     *
     * @ORM\Column(name="search_tag_terms", type="string", length=500, nullable=true)
     */
    private $searchTagTerms; 
    
    /**
     * @var string
     *
     * @ORM\Column(name="grouping_product", type="string", length=1000, nullable=true)
     */
    private $groupingProduct;    
    
    /**
     * @var string
     *
     * @ORM\Column(name="alphaCheckModel", type="string", length=500, nullable=true)
     */
    private $alphaCheckModel;
    
    /**
     * @var string
     *
     * @ORM\Column(name="synonyms", type="string", length=500, nullable=true)
     */
    private $synonyms;
    
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
     * @var integer
     * @ORM\ManyToOne(targetEntity="Trademark", inversedBy="model", fetch="EAGER")
     * @ORM\JoinColumn(name="trademark_id", referencedColumnName="id", nullable=true)
     */
    private $trademark;
    
    /**
     * @ORM\OneToMany(targetEntity="Product", mappedBy="model")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     */
    private $product;
    
    /**
     * @var string
     *
     * @ORM\Column(name="metaH1", type="string", length=250, nullable=true)
     */
    private $metaH1;
    
    /**
     * @var string
     *
     * @ORM\Column(name="meta_title", type="string", length=250, nullable=true)
     */
    private $metaTitle;

    /**
     * @var string
     *
     * @ORM\Column(name="meta_description", type="string", length=500, nullable=true)
     */
    private $metaDescription;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="is_active", type="boolean", nullable=true, options={"default" = 0})
     */
    private $isActive;    
    
    /**
     * @var string
     *
     * @ORM\Column(name="img", type="string", length=250, nullable=true)
     */
    private $img;    
    
    /** 
     * @ORM\Column(name="width_small", type="smallint", nullable=true)
     */
    private $widthSmall;
    
    /**
     * @ORM\Column(name="height_small", type="smallint", nullable=true)
     */
    private $heightSmall;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="has_products", type="integer", nullable=true, options={"default" = 0})
     */
    private $hasProducts;        
    
    /**
     * @var integer
     *
     * @ORM\Column(name="has_products_ide", type="integer", nullable=true, options={"default" = 0})
     */
    private $hasProductsIde;    
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="is_top", type="integer", nullable=true, options={"default" = 10})
     */
    private $isTop;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="in_showcase", type="boolean", nullable=true, options={"default" = 0})
     */
    private $inShowcase;
    
    /**
     * @var string
     *
     * @ORM\Column(name="long_description", type="text", nullable=true)
     */
    private $longDescription;
    
    /**
     * @var string
     *
     * @ORM\Column(name="short_description", type="string", length=500, nullable=true)
     */
    private $shortDescription;        

    /**
     * @var float
     *
     * @ORM\Column(name="last_price", type="float", precision=10, scale=0, nullable=true)
     */
    private $lastPrice;

    /**
     * @var string
     *
     * @ORM\Column(name="prices", type="text", nullable=true)
     */
    private $prices;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_import", type="datetime", nullable=false))
     */
    private $dateImport;          
        
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="last_modify", type="datetime", nullable=false))
     */
    private $lastModify; 
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="last_read_price", type="datetime", nullable=true))
     */
    private $lastReadPrice;            
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_zero_product", type="datetime", nullable=true))
     */
    private $dateZeroProduct;            
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="last_read_ide", type="datetime", nullable=true)
     */
    private $lastReadIde;
    
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
     * @var integer
     *
     * @ORM\Column(name="disabled_views", type="integer", nullable=true, options={"default" = 0})
     */
    private $disabledViews;
            
    /**
     * @var string
     * @ORM\Column(name="comparison_models", type="string", length=250, nullable=true )  
     */
    private $comparisonModels;   
    
    /**
     * @var string
     * @ORM\Column(name="product_page_url", type="string", length=250, nullable=true )  
     */
    private $productPageUrl;                       
    
    /**
     * @var int
     *
     * @ORM\OneToOne(targetEntity="ExternalTecnicalTemplate", inversedBy="model", cascade={"persist"})
     * @ORM\JoinColumn(name="external_tecnical_id", referencedColumnName="id", nullable=true,  onDelete="CASCADE")
     * @ORM\Cache("NONSTRICT_READ_WRITE")
     */
    private $externalTecnicalTemplate;
    
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->setDateImport(new \DateTime('now'));
        $this->setDateRelease(new \DateTime('now'));
        $this->setLastReadIde(new \DateTime('now'));
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
     * Set $nameUrlIde
     *
     * @param string $nameUrlIde
     *
     * @return Model
     */
    public function setNameUrlProductIde($nameUrlProductIde)
    {
        $this->nameUrlProductIde = $nameUrlProductIde;

        return $this;
    }

    /**
     * Get $nameUrlIde
     *
     * @return string
     */
    public function getNameUrlProductIde()
    {
        return $this->nameUrlProductIde;
    }
    
    /**
     * Set $amazonAsinReview
     *
     * @param string $amazonAsinReview
     *
     * @return Model
     */
    public function setAmazonAsinReview($amazonAsinReview)
    {
        $this->amazonAsinReview = $amazonAsinReview;

        return $this;
    }

    /**
     * Get amazonAsinReview
     *
     * @return string
     */
    public function getAmazonAsinReview()
    {
        return $this->amazonAsinReview;
    }

    /**
     * Set description
     *
     * @param string $alphaCheckModel
     *
     * @return Typology
     */
    public function setAlphaCheckModel($alphaCheckModel)
    {
        $this->alphaCheckModel = $alphaCheckModel;

        return $this;
    }

    /**
     * Get alphaCheckModel
     *
     * @return string
     */
    public function getAlphaCheckModel()
    {
        return $this->alphaCheckModel;
    }
    
     /**
     * Set description
     *
     * @param string grouping
     *
     * @return Typology
     */
    public function setGroupingProduct($groupingProduct)
    {
        $this->groupingProduct = $groupingProduct;

        return $this;
    }

    /**
     * Get groupingProduct
     *
     * @return string
     */
    public function getGroupingProduct()
    {
        return $this->groupingProduct;
    }
    
    
    /**
     * Set description
     *
     * @param string $imagesGallery
     *
     * @return Typology
     */
    public function setImagesGallery( $imagesGallery )
    {
        $this->imagesGallery = $imagesGallery;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getImagesGallery()
    {
        return $this->imagesGallery;
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
     * Set metH1
     *
     * @param string $metaH1
     *
     * @return Model
     */
    public function setMetaH1($metaH1)
    {
        $this->metaH1 = $metaH1;

        return $this;
    }

    /**
     * Get metaTitle
     *
     * @return string
     */
    public function getMetaH1()
    {
        return $this->metaH1;
    }
    
    /**
     * Set metaTitle
     *
     * @param string $metaTitle
     *
     * @return Model
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
     * Set metaDescription
     *
     * @param string $metaDescription
     *
     * @return Model
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
     * Set revisioned
     *
     * @param boolean $revisioned
     *
     * @return Model
     */
    public function setRevisioned($revisioned)
    {
        $this->revisioned = $revisioned;

        return $this;
    }

    /**
     * Get revisioned
     *
     * @return boolean
     */
    public function getRevisioned()
    {
        return $this->revisioned;
    }

    /**
     * Set img
     *
     * @param string $img
     *
     * @return Model
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
     * @param string hasProductsIde
     *
     * @return hasProductsIde
     */
    public function setHasProductsIde($hasProductsIde)
    {
        $this->hasProductsIde = $hasProductsIde;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getHasProductsIde()
    {
        return $this->hasProductsIde;
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
     * Set 
     *
     * @param boolean inShowcase
     *
     * @return Typology
     */
    public function setInShowcase($inShowcase)
    {
        $this->inShowcase = $inShowcase;

        return $this;
    }

    /**
     * Get inShowcase
     *
     * @return boolean
     */
    public function getInShowcase()
    {
        return $this->inShowcase;
    }
    
     /**
     * Set 
     *
     * @param boolean $isCompleted
     *
     * @return model
     */
    public function setIsCompleted($isCompleted)
    {
        $this->isCompleted = $isCompleted;

        return $this;
    }

    /**
     * Get $isCompleted
     *
     * @return boolean
     */
    public function getIsCompleted()
    {
        return $this->isCompleted;
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
     * Set trademark
     *
     * @param \AppBundle\Entity\Trademark $trademark
     *
     * @return Model
     */
    public function setTrademark(\AppBundle\Entity\Trademark $trademark = null)
    {
        $this->trademark = $trademark;

        return $this;
    }

    /**
     * Get trademark
     *
     * @return \AppBundle\Entity\Trademark
     */
    public function getTrademark()
    {
        return $this->trademark;
    }
    
    /**
     * Set $externalTecnicalTemplate
     *
     * @param \AppBundle\Entity\ExternalTecnicalTemplate $externalTecnicalTemplate
     *
     * @return Model
     */
    public function setExternalTecnicalTemplate(\AppBundle\Entity\ExternalTecnicalTemplate $externalTecnicalTemplate = null)
    {
        $this->externalTecnicalTemplate = $externalTecnicalTemplate;

        return $this;
    }

    /**
     * Get externalTecnicalTemplate
     *
     * @return \AppBundle\Entity\ExternalTecnicalTemplate
     */
    public function getExternalTecnicalTemplate()
    {
        return $this->externalTecnicalTemplate;
    }

    /**
     * Add product
     *
     * @param \AppBundle\Entity\Product $product
     *
     * @return Model
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
     * Set advisedPrice
     *
     * @param float $advisedPrice
     *
     * @return Model
     */
    public function setAdvisedPrice($advisedPrice)
    {
        $this->advisedPrice = $advisedPrice;

        return $this;
    }

    /**
     * Get advisedPrice
     *
     * @return float
     */
    public function getAdvisedPrice()
    {
        return $this->advisedPrice;
    }
    
    /**
     * Set bulletPoints
     *
     * @param string $bulletPoints
     *
     * @return Model
     */
    public function setBulletPoints($bulletPoints)
    {
        $this->bulletPoints = $bulletPoints;

        return $this;
    }

    /**
     * Get bulletPoints
     *
     * @return string
     */
    public function getBulletPoints()
    {
        return $this->bulletPoints;
    }
    
    /**  
     * Set bulletPoints
     *
     * @param string $bulletPoints
     *
     * @return Model
     */
    public function setBulletPointsGuide($bulletPointsGuide)
    {
        $this->bulletPointsGuide = $bulletPointsGuide;

        return $this;
    }

    /**
     * Get bulletPoints
     *
     * @return string
     */
    public function getBulletPointsGuide()
    {
        return $this->bulletPointsGuide;
    }
    
    /**
     * Set longDescription
     *
     * @param string $longDescription
     *
     * @return Model
     */
    public function setLongDescription($longDescription)
    {
        $this->longDescription = $longDescription;

        return $this;
    }

    /**
     * Get longDescription
     *
     * @return string
     */
    public function getLongDescription()
    {
        return $this->longDescription;
    }
    
    /**
     * Set shortDescription
     *
     * @param string $shortDescription
     *
     * @return Model
     */
    public function setShortDescription($shortDescription)
    {
        $this->shortDescription = $shortDescription;

        return $this;
    }

    /**
     * Get shortDescription
     *
     * @return string
     */
    public function getShortDescription()
    {
        return $this->shortDescription;
    }
    
    
    /**
     * Set price
     *
     * @param float $price
     *
     * @return Product
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set lastPrice
     *
     * @param float $lastPrice
     *
     * @return Product
     */
    public function setLastPrice($lastPrice)
    {
        $this->lastPrice = $lastPrice;

        return $this;
    }

    /**
     * Get lastPrice
     *
     * @return float
     */
    public function getLastPrice()
    {
        return $this->lastPrice;
    }

    /**
     * Set prices
     *
     * @param string $prices
     *
     * @return Product
     */
    public function setPrices($prices)
    {
        $this->prices = $prices;

        return $this;
    }

    /**
     * Get prices
     *
     * @return string
     */
    public function getPrices()
    {
        return $this->prices;
    }
    
    
    /**
     * Set widthSmall
     *
     * @param integer $widthSmall
     *
     * @return ImageArticle
     */
    public function setWidthSmall($widthSmall)
    {
        $this->widthSmall = $widthSmall;

        return $this;
    }

    /**
     * Get widthSmall
     *
     * @return integer
     */
    public function getWidthSmall()
    {
        return $this->widthSmall;
    }

    /**
     * Set heightSmall
     *
     * @param integer $heightSmall
     *
     * @return ImageArticle
     */
    public function setHeightSmall($heightSmall)
    {
        $this->heightSmall = $heightSmall;

        return $this;
    }

    /**
     * Get heightSmall
     *
     * @return integer
     */
    public function getHeightSmall()
    {
        return $this->heightSmall;
    }
    
    /**
     * Set technicalSpecifications
     *
     * @param integer $technicalSpecifications
     *
     * @return ImageArticle
     */
    public function setTechnicalSpecifications($technicalSpecifications)
    {
        $this->technicalSpecifications = $technicalSpecifications;

        return $this;
    }

    /**
     * Get technicalSpecifications
     *
     * @return integer
     */
    public function getTechnicalSpecifications()
    {
        return $this->technicalSpecifications;
    }
    
    /**
     * Set video
     *
     * @param string $video
     *
     * @return ContentArticle
     */
    public function setVideo($video)
    {
        $this->video = $video;

        return $this;
    }

    /**
     * Get video
     *
     * @return string
     */
    public function getVideo()
    {
        return $this->video;
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
     * Set lastModify
     *
     * @param datetime lastModify
     *
     * @return Product
     */
    public function setLastModify($lastModify)
    {
        $this->lastModify = $lastModify;

        return $this;
    }

    /**
     * Get dateRelease
     *
     * @return integer
     */
    public function getLastModify()
    {
        return $this->lastModify;
    }
    
    /**
     * Set $dateRelease
     *
     * @param datetime $dateRelease
     *
     * @return Product
     */
    public function setDateRelease($dateRelease)
    {
        $this->dateRelease = $dateRelease;

        return $this;
    }

    /**
     * Get dateRelease
     *
     * @return integer
     */
    public function getDateRelease()
    {
        return $this->dateRelease;
    }    
    
    /**
     * Set lastReadIde
     *
     * @param \DateTime $lastReadIde
     *
     * @return Product
     */
    public function setLastReadIde($lastReadIde)
    {
        $this->lastReadIde = $lastReadIde;

        return $this;
    }

    /**
     * Get lastReadIde
     *
     * @return \DateTime
     */
    public function getLastReadIde()
    {
        return $this->lastReadIde;
    }

    
    /**
     * Set views
     *
     * @param integer $views
     *
     * @return Product
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
     * @return Product
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
     * Set $disabledViews
     *
     * @param integer $disabledViews
     *
     * @return Product
     */
    public function setDisabledViews($disabledViews)
    {
        $this->disabledViews = $disabledViews;

        return $this;
    }

    /**
     * Get disabledViews
     * 
     * @return integer 
     */ 
    public function getDisabledViews()
    {
        return $this->disabledViews;
    }
    
    
    /**
     * Set $comparisonModels
     *
     * @param boolean $comparisonModels
     *
     * @return $comparisonModels
     */
    public function setComparisonModels($comparisonModels)
    {
        $this->comparisonModels = $comparisonModels;

        return $this;
    }

    /**
     * Get comparisonModels
     *
     * @return boolean
     */
    public function getComparisonModels()
    {
        return $this->comparisonModels;
    }
    
    /**
     * Set $productPageUrl
     *
     * @param boolean $productPageUrl
     *
     * @return $productPageUrl
     */
    public function setProductPageUrl($productPageUrl)
    {
        $this->productPageUrl = $productPageUrl;

        return $this;
    }

    /**
     * Get comparisonModels
     *
     * @return boolean
     */
    public function getProductPageUrl()
    {
        return $this->productPageUrl;
    }
    
    /**
     * Set $manualUrl
     *
     * @param boolean $manualUrl
     *
     * @return $manualUrl
     */
    public function setManualUrl($manualUrl)
    {
        $this->manualUrl = $manualUrl;

        return $this;
    }

    /**
     * Get $manualUrl
     *
     * @return boolean
     */
    public function getManualUrl()
    {
        return $this->manualUrl;
    }        
    
    /**
     * Set $tecnicalTemplate
     *
     * @param boolean $tecnicalTemplate
     *
     * @return $manualUrl
     */
    public function setTecnicalTemplate($tecnicalTemplate)
    {
        $this->tecnicalTemplate = $tecnicalTemplate;

        return $this;
    }

    /**
     * Get $manualUrl
     *
     * @return boolean
     */
    public function getTecnicalTemplate()
    {
        return $this->tecnicalTemplate;
    }
    
    
    /**
     * Set $releatedCodeAmazon
     *
     * @param boolean $releatedCodeAmazon
     *
     * @return $releatedCodeAmazon
     */
    public function setReleatedCodeAmazon($releatedCodeAmazon)
    {
        $this->releatedCodeAmazon = $releatedCodeAmazon;

        return $this;
    }

    /**
     * Get $manualUrl
     *
     * @return boolean
     */
    public function getReleatedCodeAmazon()
    {
        return $this->releatedCodeAmazon;
    }        
    
    /**
     * Set $searchTagTerms
     *
     * @param boolean $searchTagTerms
     *
     * @return $searchTagTerms
     */
    public function setSearchTagTerms($searchTagTerms)
    {
        $this->searchTagTerms = $searchTagTerms;

        return $this;
    }

    /**
     * Get $manualUrl
     *
     * @return boolean
     */
    public function getSearchTagTerms()
    {
        return $this->searchTagTerms;
    }
    
     /**
     * Set views
     *
     * @param datetime $lastReadPrice
     *
     * @return Product
     */
    public function setLastReadPrice($lastReadPrice)
    {
        $this->lastReadPrice = $lastReadPrice;

        return $this;
    }

    /**
     * Get datetime
     *
     * @return integer
     */
    public function getLastReadPrice()
    {
        return $this->lastReadPrice;
    }
    
    /**
     * Set $linkCategoryAmazon
     *
     * @param string $linkCategoryAmazon
     *
     * @return ContentArticle
     */
    public function setLinkCategoryAmazon($linkCategoryAmazon)
    {
        $this->linkCategoryAmazon = $linkCategoryAmazon;

        return $this;
    }

    /**
     * Get scripts
     *
     * @return string
     */
    public function getLinkCategoryAmazon()
    {
        return $this->linkCategoryAmazon;
    }
    
    
    /**
     * Set $dateZeroProduct
     *
     * @param string dateZeroProduct
     *
     * @return ContentArticle
     */
    public function setDateZeroProduct($dateZeroProduct)
    {
        $this->dateZeroProduct = $dateZeroProduct;

        return $this;
    }

    /**
     * Get scripts
     *
     * @return string
     */
    public function getDateZeroProduct()
    {
        return $this->dateZeroProduct;
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
    
    public function  getSubcategoryOrNull() {
        return !empty( $this->subcategory ) ? $this->subcategory->getId() : 999999999;
    }
    
    public function  getTypologyOrNull() {
        return !empty( $this->typology ) ? $this->typology->getId() : 999999999;
    }
    
    public function  getSubcategoryNameOrNull() {
        return !empty( $this->subcategory ) ? $this->subcategory->getName() : '';
    }
    
    public function  getSubcategorySingularNameOrNull() {
        return !empty( $this->subcategory ) ? $this->subcategory->getSingularName() : '';
    }
    
    public function  getTrademarkOrNull() {        
        return !empty( $this->trademark ) ? $this->trademark->getId() : 999999999;
    }
    
    public function  getTrademarkNameOrNull() {        
        return !empty( $this->trademark ) ? $this->trademark->getName() : '';
    }
    
    public function  getTypologyNameOrNull() {        
        return !empty( $this->typology ) ? $this->typology->getName() : '';
    }
    
    public function  getTypologySynonymsNameOrNull() {        
        return !empty( $this->typology ) ? $this->typology->getSynonyms() : '';
    }
    
    public function  getTypologySingularNameOrNull() {
        return !empty( $this->typology ) ? $this->typology->getSingularName() : '';
    }
    
    public function  getExternalTecnicalTemplateIde() {
        return !empty( $this->externalTecnicalTemplate ) ? $this->externalTecnicalTemplate->getTecnicalIde() : '';
    }
    
    public function  getExternalTecnicalTemplatePm() {
        return !empty( $this->externalTecnicalTemplate ) ? $this->externalTecnicalTemplate->getTecnicalPm() : '';
    }
    
    public function  getExternalTecnicalTemplateTp() {
        return !empty( $this->externalTecnicalTemplate ) ? $this->externalTecnicalTemplate->getTecnicalTp() : '';
    }
    
}


