<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Affiliation
 *
 * @ORM\Table(name="affiliations", indexes={})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AffiliationRepository")
 */
class Affiliation
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
     * @ORM\Column(name="last_read", type="string", length=50, nullable=true)
     */
    private $lastRead;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="text", length=65535, nullable=false)
     */
    private $url;

    /**
     * @var string
     *
     * @ORM\Column(name="link_last_update", type="text", length=65535, nullable=true)
     */
    private $linkLastUpdate;

    /**
     * @var integer
     *
     * @ORM\Column(name="has_products", type="integer", nullable=true, options={"default" = 0})
     */
    private $hasProducts;

    /**
     * @var string
     *
     * @ORM\Column(name="img", type="string", length=100, nullable=true)
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
     * @ORM\Column(name="width_big", type="smallint", nullable=true)
     */
    private $widthBig;
    
    /**
     * @ORM\Column(name="height_big", type="smallint", nullable=true)
     */
    private $heightBig;

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
     * @var boolean
     *
     * @ORM\Column(name="is_top", type="boolean", nullable=true, options={"default" = 0})
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
     * @ORM\Column(name="payments", type="json_array",  nullable=true)
     */
    private $payments;
    
    /**
     * @var string
     *
     * @ORM\Column(name="contact", type="string", length=255, nullable=true)
     */
    private $contact;
    
    /**
     * @ORM\OneToMany(targetEntity="SubcategorySiteAffiliation", mappedBy="affiliation")
     * @ORM\JoinColumn(name="subcatAffiliation_id", referencedColumnName="id")
     */
    protected $subcatAffiliation;
    
    /**
     * @ORM\OneToMany(targetEntity="Product", mappedBy="affiliation")
     */
    protected $product;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->subcatAffiliation = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Affiliation
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
     * Set name
     *
     * @param string $url
     *
     * @return Affiliation
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set lastRead
     *
     * @param string $lastRead
     *
     * @return Affiliation
     */
    public function setLastRead($lastRead)
    {
        $this->lastRead = $lastRead;

        return $this;
    }

    /**
     * Get lastRead
     *
     * @return string
     */
    public function getLastRead()
    {
        return $this->lastRead;
    }
    
    /**
     * Set linkLastUpdate
     *
     * @param string $linkLastUpdate
     *
     * @return Affiliation
     */
    public function setLinkLastUpdate($linkLastUpdate)
    {
        $this->linkLastUpdate = $linkLastUpdate;

        return $this;
    }

    /**
     * Get linkLastUpdate
     *
     * @return string
     */
    public function getLinkLastUpdate()
    {
        return $this->linkLastUpdate;
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
     * Set img
     *
     * @param string $img
     *
     * @return Affiliation
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
     * Set views
     *
     * @param integer $views
     *
     * @return Affiliation
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
     * @return Affiliation
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
     * @param boolean payments
     *
     * @return affiliation
     */
    public function setPayments($payments)
    {
        $this->payments = $payments;

        return $this;
    }

    /**
     * Get payments
     *
     * @return boolean
     */
    public function getPayments()
    {
        if(is_array( $this->payments ) )
            return $this->payments;
        
        return json_decode($this->payments);
    }
    /**
     * Set $contact
     *
     * @param boolean payments
     *
     * @return affiliation
     */
    public function setContact($contact)
    {
        $this->contact = $contact;

        return $this;
    }

    /**
     * Get $contact
     *
     * @return boolean
     */
    public function getContact()
    {
        return $this->contact;
    }
    
    /**
     * Add subcatAffiliation
     *
     * @param \AppBundle\Entity\SubcategorySiteAffiliation $subcatAffiliation
     *
     * @return Affiliation
     */
    public function addSubcatAffiliation(\AppBundle\Entity\SubcategorySiteAffiliation $subcatAffiliation)
    {
        $this->subcatAffiliation[] = $subcatAffiliation;

        return $this;
    }

    /**
     * Remove subcatAffiliation
     *
     * @param \AppBundle\Entity\SubcategorySiteAffiliation $subcatAffiliation
     */
    public function removeSubcatAffiliation(\AppBundle\Entity\SubcategorySiteAffiliation $subcatAffiliation)
    {
        $this->subcatAffiliation->removeElement($subcatAffiliation);
    }

    /**
     * Get subcatAffiliation
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSubcatAffiliation()
    {
        return $this->subcatAffiliation;
    }

    /**
     * Add product
     *
     * @param \AppBundle\Entity\Product $product
     *
     * @return Affiliation
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
     * Set widthBig
     *
     * @param integer $widthBig
     *
     * @return ImageArticle
     */
    public function setWidthBig($widthBig)
    {
        $this->widthBig = $widthBig;

        return $this;
    }

    /**
     * Get widthBig
     *
     * @return integer
     */
    public function getWidthBig()
    {
        return $this->widthBig;
    }

    /**
     * Set heightBig
     *
     * @param integer $heightBig
     *
     * @return ImageArticle
     */
    public function setHeightBig($heightBig)
    {
        $this->heightBig = $heightBig;

        return $this;
    }

    /**
     * Get heightBig
     *
     * @return integer
     */
    public function getHeightBig()
    {
        return $this->heightBig;
    }
    
}
