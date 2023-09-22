<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Category
 *
 * @ORM\Table(name="categories", uniqueConstraints={
 *      @ORM\UniqueConstraint(name="unq_categories", columns={"name", "name_url"})
 * },
 * indexes={
 *          @ORM\Index( name="categoruNameUrl", columns={ "name_url" } ),
 *          @ORM\Index( name="key_cat_isactive", columns={ "is_active"  } )
 *      }
 * )
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CategoryRepository")
 * @ORM\Cache(usage="NONSTRICT_READ_WRITE", region="my_category_region_result" )
 */
class Category {

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
     * @Assert\NotBlank(message="Specificare un nome")
     * @ORM\Column(name="name", type="string", length=64)
     */
    private $name;
    
    /**
     * @var string
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
     * 
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
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
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
     * @ORM\Column(name="color", type="string", length=64, nullable=true)
     */
    private $color;
    
    /**
     * @var string
     * @Assert\NotBlank(message="Specificare un valore")
     * @ORM\Column(name="bg_color", type="string", length=255)
     */
    private $bgColor;
    
    /**
     * @ORM\OneToMany(targetEntity="DataArticle", mappedBy="category")
     * @ORM\Cache("NONSTRICT_READ_WRITE")
     */
    protected $dataArticle;
    
    /**
     * @var boolean
     * @ORM\Column(name="is_active", type="boolean", options={"default" = 1})  
     * @Assert\NotBlank(message="Selezionare uno stato valido")
     */
    private $isactive;
    
    /**
     * @ORM\OneToMany(targetEntity="Subcategory", mappedBy="category")
     * @ORM\JoinColumn(name="subcategory_id", referencedColumnName="id")
     */
    protected $subcategories;
    
    /**
     * @ORM\OneToMany(targetEntity="Typology", mappedBy="category")
     */
    protected $typology;
    
    /**
     * @var boolean
     * @ORM\Column(name="is_reserved", type="boolean", options={"default" = 0})
     */
    private $isReserved;
    
    /**
     * @var boolean
     * @ORM\Column(name="is_top_user_reserved", type="boolean", options={"default" = 0})
     */
    private $isTopUserReserved;
    
    /**
     * @ORM\OneToMany(targetEntity="Product", mappedBy="category")
     */
    protected $product;
    
    /**
     * @ORM\OneToMany(targetEntity="Model", mappedBy="category")
     */
    protected $model;
    
    /**
     * @ORM\OneToMany(targetEntity="SearchTerm", mappedBy="category")
     */
    protected $searchTerm;
    
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
     *
     * @ORM\Column(name="order_cat", type="integer", nullable=true, options={"default" = 10})
     */
    private $order;

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
     * @return Category
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
     * @return Category
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
     * @param string $description
     *
     * @return Category
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get $description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set color
     *
     * @param string $color
     *
     * @return Category
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
     * Set bgColor
     *
     * @param string $bgColor
     *
     * @return Category
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
     * Set isReserved
     *
     * @param boolean $isReserved
     *
     * @return Category
     */
    public function setIsReserved($isReserved)
    {
        $this->isReserved = $isReserved;

        return $this;
    }

    /**
     * Get isReserved
     *
     * @return boolean
     */
    public function getIsReserved()
    {
        return $this->isReserved;
    }

    /**
     * Set isTopUserReserved
     *
     * @param boolean $isTopUserReserved
     *
     * @return Category
     */
    public function setIsTopUserReserved($isTopUserReserved)
    {
        $this->isTopUserReserved = $isTopUserReserved;

        return $this;
    }

    /**
     * Get isTopUserReserved
     *
     * @return boolean
     */
    public function getIsTopUserReserved()
    {
        return $this->isTopUserReserved;
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
     * Add dataArticle
     *
     * @param \AppBundle\Entity\DataArticle $dataArticle
     *
     * @return Category
     */
    public function addDataArticle(\AppBundle\Entity\DataArticle $dataArticle)
    {
        $this->dataArticle[] = $dataArticle;

        return $this;
    }

    /**
     * Remove dataArticle
     *
     * @param \AppBundle\Entity\DataArticle $dataArticle
     */
    public function removeDataArticle(\AppBundle\Entity\DataArticle $dataArticle)
    {
        $this->dataArticle->removeElement($dataArticle);
    }

    /**
     * Get dataArticle
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDataArticle()
    {
        return $this->dataArticle;
    }

    /**
     * Add subcategory
     *
     * @param \AppBundle\Entity\Subcategory $subcategory
     *
     * @return Category
     */
    public function addSubcategory(\AppBundle\Entity\Subcategory $subcategory)
    {
        $this->subcategories[] = $subcategory;

        return $this;
    }

    /**
     * Remove subcategory
     *
     * @param \AppBundle\Entity\Subcategory $subcategory
     */
    public function removeSubcategory(\AppBundle\Entity\Subcategory $subcategory)
    {
        $this->subcategories->removeElement($subcategory);
    }

    /**
     * Get subcategories
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSubcategories()
    {
        return $this->subcategories;
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
     * @return Category
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
     * Remove model
     *
     * @param \AppBundle\Entity\Model $model
     */
    public function removeModel(\AppBundle\Entity\Model $model)
    {
        $this->product->removeElement($model);
    }

    /**
     * Get product
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getModel()
    {
        return $this->model;
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
     * Set order
     *
     * @param boolean order
     *
     * @return order
     */
    public function setOrder($order)
    {
        $this->order = $order;

        return $this;
    }

    /**
     * Get order
     *
     * @return boolean
     */
    public function getOrder()
    {
        return $this->order;
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



    