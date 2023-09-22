<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trademark
 *
 * @ORM\Table(name="trademarks", uniqueConstraints={
 *  @ORM\UniqueConstraint(name="unq_trademark", columns={"name_url"})
 * },   indexes={
 *          @ORM\Index(name="key_name", columns={"name"})
 *      }
 * )
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TrademarkRepository")
 */
class Trademark
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
     *
     * @ORM\Column(name="name_url_tp", type="string", length=250, nullable=true)
     */
    private $nameUrlTp;   
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="is_active", type="boolean", nullable=true, options={"default" = 1})
     */
    private $isActive;
    
    /**
     * @var string
     *
     * @ORM\Column(name="init_letter", type="string", length=1, nullable=false)
     */
    private $initletter;

    /**
     * @var integer
     *
     * @ORM\Column(name="top", type="integer", nullable=true, options={"default" = 0})
     */
    private $top;

    /**
     * @var string
     *
     * @ORM\Column(name="img", type="string", length=250, nullable=true)
     */
    private $img;

    /**
     * @var integer
     *
     * @ORM\Column(name="width", type="integer", nullable=true)
     */
    private $width;

    /**
     * @var integer
     *
     * @ORM\Column(name="height", type="integer", nullable=true)
     */
    private $height;

    /**
     * @var string
     *
     * @ORM\Column(name="ip", type="string", length=50, nullable=true)
     */
    private $ip;

    
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
    private $periodviews;

    /**
     * @var integer
     *
     * @ORM\Column(name="follows", type="integer", nullable=true, options={"default" = 0})
     */
    private $follows;

    /**
     * @var integer
     *
     * @ORM\Column(name="period_follows", type="integer", nullable=true, options={"default" = 0})
     */
    private $periodfollows;
    
    /**
     * @ORM\OneToMany(targetEntity="Model", mappedBy="trademark")
     * @ORM\JoinColumn(name="model_id", referencedColumnName="id")
     */
    protected $model;
    
    /**
     * @ORM\OneToMany(targetEntity="Product", mappedBy="trademark")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     */
    protected $product;

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
     * @return Trademark
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
     * @return Trademark
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
     * Set isActive
     *
     * @param boolean $isActive
     *
     * @return Trademark
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
     * Set initletter
     *
     * @param string $initletter
     *
     * @return Trademark
     */
    public function setInitletter($initletter)
    {
        $this->initletter = $initletter;

        return $this;
    }

    /**
     * Get initletter
     *
     * @return string
     */
    public function getInitletter()
    {
        return $this->initletter;
    }

    /**
     * Set top
     *
     * @param integer $top
     *
     * @return Trademark
     */
    public function setTop($top)
    {
        $this->top = $top;

        return $this;
    }

    /**
     * Get top
     *
     * @return integer
     */
    public function getTop()
    {
        return $this->top;
    }

    /**
     * Set img
     *
     * @param string $img
     *
     * @return Trademark
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
     * Set width
     *
     * @param integer $width
     *
     * @return Trademark
     */
    public function setWidth($width)
    {
        $this->width = $width;

        return $this;
    }

    /**
     * Get width
     *
     * @return integer
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * Set height
     *
     * @param integer $height
     *
     * @return Trademark
     */
    public function setHeight($height)
    {
        $this->height = $height;

        return $this;
    }

    /**
     * Get height
     *
     * @return integer
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * Set ip
     *
     * @param string $ip
     *
     * @return Trademark
     */
    public function setIp($ip)
    {
        $this->ip = $ip;

        return $this;
    }

    /**
     * Get ip
     *
     * @return string
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * Set numProducts
     *
     * @param integer $numProducts
     *
     * @return Trademark
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
     * @return Trademark
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
     * Set periodviews
     *
     * @param integer $periodviews
     *
     * @return Trademark
     */
    public function setPeriodviews($periodviews)
    {
        $this->periodviews = $periodviews;

        return $this;
    }

    /**
     * Get periodviews
     *
     * @return integer
     */
    public function getPeriodviews()
    {
        return $this->periodviews;
    }

    /**
     * Set follows
     *
     * @param integer $follows
     *
     * @return Trademark
     */
    public function setFollows($follows)
    {
        $this->follows = $follows;

        return $this;
    }

    /**
     * Get follows
     *
     * @return integer
     */
    public function getFollows()
    {
        return $this->follows;
    }

    /**
     * Set periodfollows
     *
     * @param integer $periodfollows
     *
     * @return Trademark
     */
    public function setPeriodfollows($periodfollows)
    {
        $this->periodfollows = $periodfollows;

        return $this;
    }

    /**
     * Get periodfollows
     *
     * @return integer
     */
    public function getPeriodfollows()
    {
        return $this->periodfollows;
    }

    /**
     * Add model
     *
     * @param \AppBundle\Entity\Model $model
     *
     * @return Trademark
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
     * Add product
     *
     * @param \AppBundle\Entity\Product $product
     *
     * @return Trademark
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
    
}
