<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Product
 *
 * @ORM\Table(name="products", uniqueConstraints={
 *  @ORM\UniqueConstraint(name="unique_product", columns={"affiliation_id", "number", "model_id"})
 * }, 
 *      indexes={
 
 *          @ORM\Index(name="key_product_fk_subcat_affiliation_id", columns={"fk_subcat_affiliation_id"}),
 *          @ORM\Index(name="key_product_in_model", columns={"is_active","model_id","price"}),
 *          @ORM\Index(name="key_product_number", columns={"number"}),
 *          @ORM\Index(name="key_product_impression_link", columns={"impression_link"}),
 *          @ORM\Index(name="key_aff_number", columns={"affiliation_id","number"}),
 *          @ORM\Index(name="key_aff_is_active", columns={"is_active", "to_update","affiliation_id"}),
 *          @ORM\Index(name="key_aff_lastRead", columns={"affiliation_id","last_read"}),
 *          @ORM\Index(name="key_aff_period_views", columns={"affiliation_id","period_views"}),
 *          @ORM\Index(name="key_model_minPrice", columns={"model_id","price"}), 
 *          @ORM\Index(name="key_cat_subcat_typo", columns={"category_id","subcategory_id","typology_id"}),
 *          @ORM\Index(name="key_aff_cat_subcat_typo", columns={"affiliation_id","category_id","subcategory_id","typology_id"})
 *      }
 * )
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProductRepository")
 */
class Product
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
     * @var integer
     *
     * @ORM\Column(name="fk_subcat_affiliation_id", type="integer", nullable=true)
     */
    private $fkSubcatAffiliation;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=250, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="to_update", type="boolean", nullable=true, options={"default" = 1})
     */
    private $toUpdate;
    
    /**
     * @var string
     *
     * @ORM\Column(name="bullet_points", type="text", nullable=true)
     */
    private $bulletPoints;
    
    /**
     * @var string
     *
     * @ORM\Column(name="fake_product", type="boolean", nullable=true, options={"default" = 0})
     */
    private $fakeProduct;
            
    /**
     * @ORM\Column(name="link_category_amazon", type="string", length=500, nullable=true)
     */
    private $linkCategoryAmazon;
    
    /**
     * @var float
     *
     * @ORM\Column(name="price", type="float", precision=10, scale=0, nullable=true)
     */
    private $price;

    /**
     * @var float
     *
     * @ORM\Column(name="last_price", type="float", precision=10, scale=0, nullable=true)
     */
    private $lastPrice;

    /**
     * @var string
     *
     * @ORM\Column(name="prices", type="string", length=500, nullable=true)
     */
    private $prices;

    /**
     * @var string
     *
     * @ORM\Column(name="deep_link", type="text", length=65535, nullable=false)
     */ 
    private $deepLink;
        
    /**
     * @var string
     *
     * @ORM\Column(name="impression_link", type="string", length=50, nullable=false, options={"default" = NULL})
     */
    private $impressionLink; 
        
    /**
     * @var string 
     *
     * @ORM\Column(name="original_link", type="text", length=1000, nullable=true, options={"default" = NULL})
     */
    private $originalLink; 

    /**
     * @var string
     *
     * @ORM\Column(name="number", type="string", length=250, nullable=true)
     */
    private $number;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="data_import", type="datetime", nullable=true)
     */
    private $dataImport;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="last_read", type="datetime", nullable=true)
     */
    private $lastRead;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="last_modify", type="datetime", nullable=true)
     */
    private $lastModify;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="last_change_price", type="datetime", nullable=true)
     */
    private $lastChangePrice;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="data_disabled", type="datetime", nullable=true)
     */
    private $dataDisabled;

    /**
     * @var integer
     *
     * @ORM\Column(name="go_to_click", type="integer", nullable=true, options={"default" = 0})
     */
    private $goToClick;

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
     * @var boolean
     *
     * @ORM\Column(name="is_active", type="boolean", nullable=true, options={"default" = 1})
     */
    private $isActive;       

    /**
     * @var boolean
     *
     * @ORM\Column(name="manual_off", type="boolean", nullable=true, options={"default" = 0})
     */
    private $manualOff;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_amazon", type="boolean", nullable=true, options={"default" = 0})
     */
    private $isAmazon;

    /**
     * @var boolean
     *
     * @ORM\Column(name="handling_cost", type="float", precision=10, scale=0, nullable=true)
     */
    private $handlingCost;

    /**
     * @var boolean
     *
     * @ORM\Column(name="delivery_time", type="string", length=250, nullable=true)
     */
    private $deliveryTime;

    /**
     * @var boolean
     *
     * @ORM\Column(name="stock_amount", type="integer", nullable=true, options={"default" = 0})
     */
    private $stockAmount;

    /**
     * @var boolean
     *
     * @ORM\Column(name="size_stock_status", type="string", length=25, nullable=true)
     */
    private $sizeStockStatus;

    /**
     * @var boolean
     *
     * @ORM\Column(name="ean", type="string", length=250, nullable=true)
     */
    private $ean;
    
    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=500, nullable=true)
     */
    private $description;
    
    /**
     * @var string
     *
     * @ORM\Column(name="colors", type="string", length=500, nullable=true)
     */
    private $colors;
    
    /**
     * @var string
     *
     * @ORM\Column(name="sizes", type="string", length=500, nullable=true)
     */
    private $sizes;
    
    /**
     * @var \AppBundle\Entity\Sex
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Sex", inversedBy="product")
     * @ORM\JoinColumn(name="sex_id", referencedColumnName="id", nullable=true)
     */
    private $sex;

    /**
     * @var \AppBundle\Entity\Affiliation
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Affiliation", inversedBy="product")
     * @ORM\JoinColumn(name="affiliation_id", referencedColumnName="id")
     */
    private $affiliation;

    /**
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="product")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
    private $category;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Subcategory", inversedBy="product")
     * @ORM\JoinColumn(name="subcategory_id", referencedColumnName="id")
     */ 
    private $subcategory;

    /**
     * @var \AppBundle\Entity\Trademark
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Trademark", inversedBy="product")
     * @ORM\JoinColumn(name="trademark_id", referencedColumnName="id")
     */
    private $trademark;

    /**
     * @var \AppBundle\Entity\Typology
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Typology", inversedBy="product")
     * @ORM\JoinColumn(name="typology_id", referencedColumnName="id")
     */
    private $typology;
    
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\MicroSection", inversedBy="product")
     * @ORM\JoinColumn(name="micro_section_id", referencedColumnName="id")
     */
    private $microSection; 
    
    /**
     * @var \AppBundle\Entity\Model
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Model", inversedBy="product")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="model_id", referencedColumnName="id", onDelete="CASCADE")
     * })
     */
    private $model;

    /**
     * @ORM\ManyToMany(targetEntity="ImageProduct", inversedBy="product")
     * @ORM\JoinTable(name="product_imageproduct", joinColumns={@ORM\JoinColumn(name="product_id", referencedColumnName="id", onDelete="CASCADE")})
     */
    private $images;
    
    /**
     * @ORM\ManyToOne(targetEntity="ImageProduct")
     * @ORM\Cache("NONSTRICT_READ_WRITE")
     * @ORM\JoinColumn(name="priority_img_id", referencedColumnName="id", nullable=true)
     */
    protected $priorityImg; 
        
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
     * @var string
     *
     * @ORM\Column(name="merchant_img", type="string", nullable=true)
     */
    private $merchantImg;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->images = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set fkSubcatAffiliation
     *
     * @param integer $fkSubcatAffiliation
     *
     * @return Product
     */
    public function setFkSubcatAffiliation($fkSubcatAffiliation)
    {
        $this->fkSubcatAffiliation = $fkSubcatAffiliation;

        return $this;
    }

    /**
     * Get fkSubcatAffiliation
     *
     * @return integer
     */
    public function getFkSubcatAffiliation()
    {
        return $this->fkSubcatAffiliation;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Product
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
    public function getToUpdate()
    {
        return $this->toUpdate;
    }
    
    /**
     * Set name
     *
     * @param string $toUpdate
     *
     * @return Product
     */
    public function setToUpdate($toUpdate)
    {
        $this->toUpdate = $toUpdate;

        return $this;
    }
    
    /**
     * Get name
     *
     * @return string
     */
    public function getFakeProduct()
    {
        return $this->fakeProduct;
    }
    
    /**
     * Set name
     *
     * @param string $toUpdate
     *
     * @return Product
     */
    public function setFakeProduct($fakeProduct)
    {
        $this->fakeProduct = $fakeProduct;

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
     * Set deepLink
     *
     * @param string $deepLink
     *
     * @return Product
     */
    public function setDeepLink($deepLink)
    {
        $this->deepLink = $deepLink;

        return $this;
    }

    /**
     * Get deepLink
     *
     * @return string
     */
    public function getDeepLink()
    {
        return $this->deepLink;
    }

    /**
     * Set impressionLink
     *
     * @param string impressionLink
     *
     * @return Product
     */
    public function setImpressionLink($impressionLink)
    {
        $this->impressionLink = $impressionLink;

        return $this;
    }

    /**
     * Get impressionLink
     *
     * @return string
     */
    public function getImpressionLink()
    {
        return $this->impressionLink;
    }

    /**
     * Set impressionLink
     *
     * @param string impressionLink
     *
     * @return Product
     */
    public function setOriginalLink($originalLink)
    {
        $this->originalLink = $originalLink;

        return $this;
    }

    /**
     * Get impressionLink
     *
     * @return string
     */
    public function getOriginalLink()
    {
        return $this->originalLink;
    }

    /**
     * Set number
     *
     * @param string $number
     *
     * @return Product
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * Get number
     *
     * @return string
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Set dataImport
     *
     * @param \DateTime $dataImport
     *
     * @return Product
     */
    public function setDataImport($dataImport)
    {
        $this->dataImport = $dataImport;

        return $this;
    }

    /**
     * Get dataImport
     *
     * @return \DateTime
     */
    public function getDataImport()
    {
        return $this->dataImport;
    }

    /**
     * Set lastRead
     *
     * @param \DateTime $lastRead
     *
     * @return Product
     */
    public function setLastRead($lastRead)
    {
        $this->lastRead = $lastRead;

        return $this;
    }

    /**
     * Get lastRead
     *
     * @return \DateTime
     */
    public function getLastRead()
    {
        return $this->lastRead;
    }

    /**
     * Set lastModify
     *
     * @param \DateTime $lastModify
     *
     * @return Product
     */
    public function setLastModify($lastModify)
    {
        $this->lastModify = $lastModify;

        return $this;
    }

    /**
     * Get lastModify
     *
     * @return \DateTime
     */
    public function getLastModify()
    {
        return $this->lastModify;
    }

    /**
     * Set $lastChangePrice
     *
     * @param \DateTime $lastChangePrice
     *
     * @return Product
     */
    public function setLastChangePrice($lastChangePrice)
    {
        $this->lastChangePrice = $lastChangePrice;

        return $this;
    }

    /**
     * Get lastModify
     *
     * @return \DateTime
     */
    public function getLastChangePrice()
    {
        return $this->lastChangePrice;
    }

    /**
     * Set dataDisabled
     *
     * @param \DateTime $dataDisabled
     *
     * @return Product
     */
    public function setDataDisabled($dataDisabled)
    {
        $this->dataDisabled = $dataDisabled;

        return $this;
    }

    /**
     * Get dataDisabled
     *
     * @return \DateTime
     */
    public function getDataDisabled()
    {
        return $this->dataDisabled;
    }

    /**
     * Set $goToClick
     *
     * @param integer $goToClick
     *
     * @return Product
     */
    public function setGoToClick($goToClick)
    {
        $this->goToClick = $goToClick;

        return $this;
    }

    /**
     * Get $click
     *
     * @return integer
     */
    public function getGoToClick()
    {
        return $this->goToClick;
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
     * Set disabledViews
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
     * Set $manualOff
     *
     * @param boolean $manualOff
     *
     * @return Product
     */
    public function setManualOff($manualOff)
    {
        $this->manualOff = $manualOff;

        return $this;
    }

    /**
     * Get $manualOff
     *
     * @return boolean
     */
    public function getManualOff()
    {
        return $this->manualOff;
    }

    /**
     * Set isAmazon
     *
     * @param boolean isAmazon
     *
     * @return Product
     */
    public function setIsAmazon($isAmazon)
    {
        $this->$isAmazon = $isAmazon;

        return $this;
    }

    /**
     * Get isAmazon
     *
     * @return boolean
     */
    public function getIsAmazon()
    {
        return $this->isAmazon;
    }

    /**
     * Set handlingCost
     *
     * @param boolean $handlingCost
     *
     * @return Product
     */
    public function setHandlingCost( $handlingCost )
    {
        $this->handlingCost = $handlingCost;

        return $this;
    }

    /**
     * Get handlingCost
     *
     * @return float
     */
    public function getHandlingCost()
    {
        return $this->handlingCost;
    }

    /**
     * Set deliveryTime
     *
     * @param boolean $deliveryTime
     *
     * @return Product
     */
    public function setDeliveryTime( $deliveryTime )
    {
        $this->deliveryTime = $deliveryTime;

        return $this;
    }

    /**
     * Get deliveryTime
     *
     * @return string
     */
    public function getDeliveryTime()
    {
        return $this->deliveryTime;
    }

    /**
     * Set stockAmount
     *
     * @param boolean $stockAmount
     *
     * @return Product
     */
    public function setStockAmount( $stockAmount )
    {
        $this->stockAmount = $stockAmount;

        return $this;
    }

    /**
     * Get stockAmount
     *
     * @return string
     */
    public function getStockAmount()
    {
        return $this->stockAmount;
    }

    /**
     * Set sizeStockStatus
     *
     * @param boolean $sizeStockStatus
     *
     * @return Product
     */
    public function setSizeStockStatus( $sizeStockStatus )
    {
        $this->sizeStockStatus = $sizeStockStatus;

        return $this;
    }

    /**
     * Get sizeStockStatus
     *
     * @return string
     */
    public function getSizeStockStatus()
    {
        return $this->sizeStockStatus;
    }

    /**
     * Set ean
     *
     * @param boolean $ean
     *
     * @return Product
     */
    public function setEan( $ean )
    {
        $this->ean = $ean;

        return $this;
    }

    /**
     * Get ean
     *
     * @return string
     */
    public function getEan()
    {
        return $this->ean;
    }

    /**
     * Set description
     *
     * @param boolean $description
     *
     * @return Product
     */
    public function setDescription( $description )
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
     * Set colors
     *
     * @param boolean $colors
     *
     * @return Product
     */
    public function setColors( $colors )
    {
        $this->colors = $colors;

        return $this;
    }

    /**
     * Get colors
     *
     * @return string
     */
    public function getColors()
    {
        return $this->colors;
    }  
    
    /**
     * Set sizes
     *
     * @param boolean $sizes
     *
     * @return Product
     */
    public function setSizes( $sizes )
    {
        $this->sizes = $sizes;

        return $this;
    }

    /**
     * Get sizes
     *
     * @return string
     */
    public function getSizes()
    {
        return $this->sizes;
    }  
    
    /**
     * Set sex
     *
     * @param \AppBundle\Entity\Category $sex
     *
     * @return Product
     */
    public function setSex(\AppBundle\Entity\Sex $sex = null)
    {
        $this->sex = $sex;

        return $this;
    }

    /**
     * Get sex
     *
     * @return \AppBundle\Entity\Sex
     */
    public function getSex()
    {
        return $this->sex;
    }
  
    /**
     * Set affiliation
     *
     * @param \AppBundle\Entity\Affiliation $affiliation
     *
     * @return Product
     */
    public function setAffiliation(\AppBundle\Entity\Affiliation $affiliation = null)
    {
        $this->affiliation = $affiliation;

        return $this;
    }

    /**
     * Get affiliation
     *
     * @return \AppBundle\Entity\Affiliation
     */
    public function getAffiliation()
    {
        return $this->affiliation;
    }

    /**
     * Set category
     *
     * @param \AppBundle\Entity\Category $category
     *
     * @return Product
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
     * @return Product
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
     * Set trademark
     *
     * @param \AppBundle\Entity\Trademark $trademark
     *
     * @return Product
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
     * Set typology
     *
     * @param \AppBundle\Entity\Typology $typology
     *
     * @return Product
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
     * Set model
     *
     * @param \AppBundle\Entity\Model $model
     *
     * @return Product
     */
    public function setModel(\AppBundle\Entity\Model $model = null)
    {
        $this->model = $model;

        return $this;
    }

    /**
     * Get model
     *
     * @return \AppBundle\Entity\Model
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Add image
     *
     * @param \AppBundle\Entity\ImageProduct $image
     *
     * @return Product
     */
    public function addImage(\AppBundle\Entity\ImageProduct $image)
    {
        $this->images[] = $image;

        return $this;
    }

    /**
     * Remove image
     *
     * @param \AppBundle\Entity\Imageproduct $image
     */
    public function removeImage(\AppBundle\Entity\ImageProduct $image)
    {
        $this->images->removeElement($image);
    }

    /** 
     * Get images
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getImages()
    {
        return $this->images;
    }
    
    /**
     * Set priorityImg
     *
     * @param \AppBundle\Entity\Image $priorityImg
     *
     * @return DataArticle
     */
    public function setPriorityImg(\AppBundle\Entity\ImageProduct $priorityImg = null)
    {
        $this->priorityImg = $priorityImg;

        return $this;
    }

    /**
     * Get priorityImg
     *
     * @return \AppBundle\Entity\Image
     */
    public function getPriorityImg()
    {
        return $this->priorityImg;
    }
    
      
    /**
     * Set opinionCm
     *
     * @param integer 
     *
     * @return DataArticle
     */
    public function setMerchantImg($merchantImg)
    {
        $this->merchantImg = $merchantImg;

        return $this;
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
     * Get opinionCm
     *
     * @return integer
     */
    public function getMerchantImg()
    {
        return $this->merchantImg;
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
    
    
    public function  getCategoryOrNull() {
        return !empty( $this->category ) ? $this->category->getId() : 999999999;
    }
    
    public function  getSubcategoryOrNull() {
        return !empty( $this->subcategory ) ? $this->subcategory->getId() : 999999999;
    }
    public function  getSubcategoryIsTopOrNull() {
        return !empty( $this->subcategory ) ? $this->subcategory->getIsTop() : 10;
    }
    
    public function  getTypologyOrNull() {
        return !empty( $this->typology ) ? $this->typology->getId() : 999999999;
    }
    
    public function  getTrademarkOrNull() {
        return !empty( $this->trademark ) ? $this->trademark->getId() : 999999999;
    }
    
    public function  getPriorityImgOrNull() {
        return !empty( $this->priorityImg ) ? $this->priorityImg->getImg() : '';
    }
    
    public function  getPriorityImgWidthSmallOrNull() {
        return !empty( $this->priorityImg ) ? $this->priorityImg->getWidthSmall() : 0;
    }
    public function  getPriorityImgHeightSmallOrNull() {
        return !empty( $this->priorityImg ) ? $this->priorityImg->getHeightSmall() : 0;
    }
    
    public function  getSexOrNull() {
        return !empty( $this->sex ) ? $this->sex->getId() : 999999999;
    }
    
     public function  getSubcategoryNameOrNull() {
        return !empty( $this->subcategory ) ? $this->subcategory->getName() : '';
    }
    
    public function  getSubcategorySingularNameOrNull() {
        return !empty( $this->subcategory ) ? $this->subcategory->getSingularName() : '';
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
}


