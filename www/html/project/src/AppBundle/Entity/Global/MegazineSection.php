<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Category
 *
 * @ORM\Table(name="megazine_sections", uniqueConstraints={
 *      @ORM\UniqueConstraint(name="unq_megazine_sections", columns={"name", "name_url"})
 * },
 * indexes={
 *          @ORM\Index( name="megazine_sectionsUrl", columns={ "name_url" } ),
 *          @ORM\Index( name="key_megazine_sections_isactive", columns={ "is_active"  } )
 *      }
 * )
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MegazineSectionRepository")
 * @ORM\Cache(usage="NONSTRICT_READ_WRITE", region="my_megazine_sections_region_result" )
 */
class MegazineSection {

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
     * 
     * @ORM\Column(name="img", type="string", length=255, nullable=true)
     */
    private $img;
    
    /**
     * @ORM\OneToMany(targetEntity="DataArticle", mappedBy="megazineSection")
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

}
