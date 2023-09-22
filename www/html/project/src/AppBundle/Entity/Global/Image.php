<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 *
 * @ORM\Table(name="images", uniqueConstraints={
 *      @ORM\UniqueConstraint(name="unq_images", columns={"src"})
 * })
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ImageRepository")
 * @ORM\Cache("NONSTRICT_READ_WRITE",    region="my_image_region_result") 
 */
class Image {
 
    const EXISTANCE_CHECK_FIELD = 'Name';
    
    public function __construct() {
        $this->dataArticles = new ArrayCollection();    
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
     * @Assert\NotBlank(message="Selezionare un'immagine valida")
     * @ORM\Column(name="src", type="string", length=255)
     */
    private $src;
    
    /**
     * @Assert\NotBlank(message="Inserisci un titolo per l'immagine")
     * @ORM\Column(name="title_img", type="string", length=255, nullable=true)
     */
    private $titleImg;

    /** 
     * @ORM\Column(name="width_small", type="smallint")
     */
    private $widthSmall;
    
    /**
     * @ORM\Column(name="height_small", type="smallint")
     */
    private $heightSmall;
    
    /** 
     * @ORM\Column(name="width_medium", type="smallint")
     */
    private $widthMedium;
    
    /**
     * @ORM\Column(name="height_medium", type="smallint")
     */
    private $heightMedium;
    
    /** 
     * @ORM\Column(name="width_big", type="smallint")
     */
    private $widthBig;
    
    /**
     * @ORM\Column(name="height_big", type="smallint")
     */
    private $heightBig;
    
    /**
     * @ORM\Column(name="search", type="boolean", options={"default" = TRUE}, nullable=true)
     */
    private $search;
   
    /**
     * @ORM\ManyToMany(targetEntity="DataArticle", mappedBy="images")
     * @ORM\Cache("NONSTRICT_READ_WRITE", region="my_images_data_article_region_result")   
     */
    protected $dataArticles;
    
    /**
     * @Assert\Callback
     */
    public function validate(ExecutionContextInterface $context) {
//        echo $this->getSrc().'<==';
//        if( $this->getSrc() == null ) {
//            $context->buildViolation('This name sounds totally fake!')
//                ->atPath('src')
//                ->addViolation();
//        }
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
     * Set dataArticle
     *
     * @param integer $dataArticle
     *
     * @return ImageArticle
     */
    public function setDataArticle($dataArticle)
    {
        $this->dataArticle = $dataArticle;

        return $this;
    }

    /**
     * Get dataArticle
     *
     * @return integer
     */
    public function getDataArticle()
    {
        return $this->dataArticle;
    }

    /**
     * Set src
     *
     * @param string $src
     *
     * @return ImageArticle
     */
    public function setSrc($src)
    {
        $this->src = $src;

        return $this;
    }

    /**
     * Get src
     *
     * @return string
     */
    public function getSrc()
    {
        return $this->src;
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
     * Set widthMedium
     *
     * @param integer $widthMedium
     *
     * @return ImageArticle
     */
    public function setWidthMedium($widthMedium)
    {
        $this->widthMedium = $widthMedium;

        return $this;
    }

    /**
     * Get widthMedium
     *
     * @return integer
     */
    public function getWidthMedium()
    {
        return $this->widthMedium;
    }

    /**
     * Set heightMedium
     *
     * @param integer $heightMedium
     *
     * @return ImageArticle
     */
    public function setHeightMedium($heightMedium)
    {
        $this->heightMedium = $heightMedium;

        return $this;
    }

    /**
     * Get heightMedium
     *
     * @return integer
     */
    public function getHeightMedium()
    {
        return $this->heightMedium;
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

    /**
     * Add dataArticle
     *
     * @param \AppBundle\Entity\DataArticle $dataArticle
     *
     * @return ImageArticle
     */
    public function addDataArticle(\AppBundle\Entity\DataArticle $dataArticle)
    {
        $this->dataArticles[] = $dataArticle;

        return $this;
    }

    /**
     * Remove dataArticle
     *
     * @param \AppBundle\Entity\DataArticle $dataArticle
     */
    public function removeDataArticle(\AppBundle\Entity\DataArticle $dataArticle)
    {
        $this->dataArticles->removeElement($dataArticle);
    }

    /**
     * Get dataArticles
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDataArticles()
    {
        return $this->dataArticles;
    }

    /**
     * Set titleImg
     *
     * @param string $titleImg
     *
     * @return Image
     */
    public function setTitleImg($titleImg)
    {
        $this->titleImg = $titleImg;

        return $this;
    }

    /**
     * Get titleImg
     *
     * @return string
     */
    public function getTitleImg()
    {
        return $this->titleImg;
    }
    
    /**
     * Set titleImg
     *
     * @param string search
     *
     * @return Image
     */
    public function setSearch($search)
    {
        $this->search = $search;

        return $this;
    }

    /**
     * Get search
     *
     * @return string
     */
    public function getSearch()
    {
        return $this->search;
    }
}
