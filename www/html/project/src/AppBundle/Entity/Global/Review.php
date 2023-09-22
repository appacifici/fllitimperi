<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Review
 *
 * @ORM\Table(name="review", uniqueConstraints={@ORM\UniqueConstraint(name="titleMd5", columns={"title_md5"})}, 
 * indexes={})
 * @ORM\Entity
 */
class Review
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
     * @ORM\ManyToOne(targetEntity="Product")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     */
    private $product;

    /**
     * @var integer
     * @ORM\ManyToOne(targetEntity="Trademark")
     * @ORM\JoinColumn(name="trademark_id", referencedColumnName="id")
     */
    private $trademark;
    
    /**
     * @var integer
     * @ORM\ManyToOne(targetEntity="Affiliation")
     * @ORM\JoinColumn(name="affiliate_id", referencedColumnName="id")
     */
    private $affiliate;

    /**
     * @var string
     *
     * @ORM\Column(name="permalink", type="string", length=500, nullable=false)
     */
    private $permalink;

    /**
     * @var string
     *
     * @ORM\Column(name="title_md5", type="string", length=150, nullable=false)
     */
    private $titlemd5;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=1000, nullable=false)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="anchor_title", type="string", length=1000, nullable=false)
     */
    private $anchortitle;

    /**
     * @var string
     *
     * @ORM\Column(name="abstract", type="text", length=65535, nullable=true)
     */
    private $abstract;

    /**
     * @var string
     *
     * @ORM\Column(name="articolo", type="text", length=65535, nullable=true)
     */
    private $articolo;

    /**
     * @var string
     *
     * @ORM\Column(name="fonte", type="string", length=150, nullable=false)
     */
    private $fonte;

    /**
     * @var string
     *
     * @ORM\Column(name="foto1", type="string", length=255, nullable=true)
     */
    private $foto1;

    /**
     * @var integer
     *
     * @ORM\Column(name="width_foto1", type="integer", nullable=true)
     */
    private $widthfoto1;

    /**
     * @var integer
     *
     * @ORM\Column(name="height_foto1", type="integer", nullable=true)
     */
    private $heightfoto1;

    /**
     * @var string
     *
     * @ORM\Column(name="ora_creazione", type="string", length=19, nullable=true)
     */
    private $oracreazione;

    /**
     * @var integer
     *
     * @ORM\Column(name="is_active", type="integer", nullable=false, options={"default" = 1})
     */
    private $isactive;

    /**
     * @var string
     *
     * @ORM\Column(name="tags", type="string", length=1000, nullable=true)
     */
    private $tags;

    /**
     * @var string
     *
     * @ORM\Column(name="link", type="string", length=500, nullable=true)
     */
    private $link;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="ORA", type="datetime", nullable=false)
     */
    private $ora = 'CURRENT_TIMESTAMP';

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
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set permalink
     *
     * @param string $permalink
     *
     * @return Review
     */
    public function setPermalink($permalink)
    {
        $this->permalink = $permalink;

        return $this;
    }

    /**
     * Get permalink
     *
     * @return string
     */
    public function getPermalink()
    {
        return $this->permalink;
    }

    /**
     * Set titlemd5
     *
     * @param string $titlemd5
     *
     * @return Review
     */
    public function setTitlemd5($titlemd5)
    {
        $this->titlemd5 = $titlemd5;

        return $this;
    }

    /**
     * Get titlemd5
     *
     * @return string
     */
    public function getTitlemd5()
    {
        return $this->titlemd5;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Review
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
     * Set anchortitle
     *
     * @param string $anchortitle
     *
     * @return Review
     */
    public function setAnchortitle($anchortitle)
    {
        $this->anchortitle = $anchortitle;

        return $this;
    }

    /**
     * Get anchortitle
     *
     * @return string
     */
    public function getAnchortitle()
    {
        return $this->anchortitle;
    }

    /**
     * Set abstract
     *
     * @param string $abstract
     *
     * @return Review
     */
    public function setAbstract($abstract)
    {
        $this->abstract = $abstract;

        return $this;
    }

    /**
     * Get abstract
     *
     * @return string
     */
    public function getAbstract()
    {
        return $this->abstract;
    }

    /**
     * Set articolo
     *
     * @param string $articolo
     *
     * @return Review
     */
    public function setArticolo($articolo)
    {
        $this->articolo = $articolo;

        return $this;
    }

    /**
     * Get articolo
     *
     * @return string
     */
    public function getArticolo()
    {
        return $this->articolo;
    }

    /**
     * Set fonte
     *
     * @param string $fonte
     *
     * @return Review
     */
    public function setFonte($fonte)
    {
        $this->fonte = $fonte;

        return $this;
    }

    /**
     * Get fonte
     *
     * @return string
     */
    public function getFonte()
    {
        return $this->fonte;
    }

    /**
     * Set foto1
     *
     * @param string $foto1
     *
     * @return Review
     */
    public function setFoto1($foto1)
    {
        $this->foto1 = $foto1;

        return $this;
    }

    /**
     * Get foto1
     *
     * @return string
     */
    public function getFoto1()
    {
        return $this->foto1;
    }

    /**
     * Set widthfoto1
     *
     * @param integer $widthfoto1
     *
     * @return Review
     */
    public function setWidthfoto1($widthfoto1)
    {
        $this->widthfoto1 = $widthfoto1;

        return $this;
    }

    /**
     * Get widthfoto1
     *
     * @return integer
     */
    public function getWidthfoto1()
    {
        return $this->widthfoto1;
    }

    /**
     * Set heightfoto1
     *
     * @param integer $heightfoto1
     *
     * @return Review
     */
    public function setHeightfoto1($heightfoto1)
    {
        $this->heightfoto1 = $heightfoto1;

        return $this;
    }

    /**
     * Get heightfoto1
     *
     * @return integer
     */
    public function getHeightfoto1()
    {
        return $this->heightfoto1;
    }

    /**
     * Set oracreazione
     *
     * @param string $oracreazione
     *
     * @return Review
     */
    public function setOracreazione($oracreazione)
    {
        $this->oracreazione = $oracreazione;

        return $this;
    }

    /**
     * Get oracreazione
     *
     * @return string
     */
    public function getOracreazione()
    {
        return $this->oracreazione;
    }

    /**
     * Set stato
     *
     * @param integer $isactive
     *
     * @return Review
     */
    public function setIsactive($isactive)
    {
        $this->isactive = $isactive;

        return $this;
    }

    /**
     * Get stato
     *
     * @return integer
     */
    public function getIsactive()
    {
        return $this->isactive;
    }

    /**
     * Set tags
     *
     * @param string $tags
     *
     * @return Review
     */
    public function setTags($tags)
    {
        $this->tags = $tags;

        return $this;
    }

    /**
     * Get tags
     *
     * @return string
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * Set link
     *
     * @param string $link
     *
     * @return Review
     */
    public function setLink($link)
    {
        $this->link = $link;

        return $this;
    }

    /**
     * Get link
     *
     * @return string
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * Set ora
     *
     * @param \DateTime $ora
     *
     * @return Review
     */
    public function setOra($ora)
    {
        $this->ora = $ora;

        return $this;
    }

    /**
     * Get ora
     *
     * @return \DateTime
     */
    public function getOra()
    {
        return $this->ora;
    }

    /**
     * Set views
     *
     * @param integer $views
     *
     * @return Review
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
     * @return Review
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
     * Set category
     *
     * @param \AppBundle\Entity\Trademark $trademark
     *
     * @return Review
     */
    public function setTrademark(\AppBundle\Entity\Trademark $trademark = null)
    {
        $this->trademark = $trademark;

        return $this;
    }

    /**
     * Get category
     *
     * @return \AppBundle\Entity\Trademark
     */
    public function getTrademark()
    {
        return $this->trademark;
    }

    /**
     * Set subcategory
     *
     * @param \AppBundle\Entity\Product $product
     *
     * @return Review
     */
    public function setProduct(\AppBundle\Entity\Product $product = null)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Get subcategory
     *
     * @return \AppBundle\Entity\Product
     */
    public function getProduct()
    {
        return $this->product;
    }
    
    /**
     * Set subcategory
     *
     * @param \AppBundle\Entity\Affiliation $affiliate
     *
     * @return Review
     */
    public function setAffiliate(\AppBundle\Entity\Affiliation $affiliate = null)
    {
        $this->affiliate = $affiliate;

        return $this;
    }

    /**
     * Get subcategory
     *
     * @return \AppBundle\Entity\Affiliation
     */
    public function getAffiliate()
    {
        return $this->affiliate;
    }
}
