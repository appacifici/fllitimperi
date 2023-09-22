<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;


/**
 *
 * @ORM\Table(name="banners", uniqueConstraints={
 *      @ORM\UniqueConstraint(name="unq_banners", columns={"position","site","screen","is_active","name"})      
 *      },
 *      indexes={
 *          @ORM\Index(name="searchBanner", columns={"site","is_active","screen"})
 *      }
 * )
 * @ORM\Entity(repositoryClass="AppBundle\Repository\BannerRepository")
 * @ORM\Cache("NONSTRICT_READ_WRITE", region="my_banner_region_result" )
 */
class Banner { 

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
     * @Assert\NotBlank(message="Specificare un valore")
     * @ORM\Column(name="site", type="string", length=255)
     */
    private $site;

    /**
     * @var string
     * @Assert\NotBlank(message="Specificare un valore")
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     * @Assert\NotBlank(message="Specificare un valore")
     * @ORM\Column(name="screen", type="string", length=20, options={"default" = "all"})
     */
    private $screen;

    /**
     * @var string
     * @Assert\NotBlank(message="Specificare una posizione")
     * @ORM\Column(name="position", type="string", length=255)
     */
    private $position;

    
    /**
     * @var string
     * 
     * @ORM\Column(name="text", type="text", nullable=true)
     */
    private $text;
    
    /**
     * @var string
     * @Assert\NotBlank(message="Specificare la sezione")
     * @ORM\Column(name="route", type="string", length=255, nullable=true)
     */
    private $route;
    
    /**
     * @var string
     * @ORM\Column(name="header_code", type="text", nullable=true)
     */
    private $headerCode;

    /**
     * @var string
     * @ORM\Column(name="code", type="text", nullable=true)
     */
    private $code;

    /**
     * @var string
     * @ORM\Column(name="calls_code", type="text", nullable=true)
     */
    private $callsCode;
        
    /**
     * @var string
     * @ORM\Column(name="code_amp", type="text", nullable=true)
     */
    private $codeAmp;
    
    /**
     * @var string
     *
     * @ORM\Column(name="img", type="string", length=255, nullable=true)
     */
    private $img;
    
    /**
     * @var string
     * @ORM\Column(name="url", type="string", nullable=true)
     */
    private $url;
    
    /**
     * @var string
     * @Assert\NotBlank(message="Specificare un valore")
     * @ORM\Column(name="is_active", type="smallint", options={"default" = 0})
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
     * Set position
     *
     * @param string $position
     *
     * @return Banner
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return string
     */
    public function getPosition()
    {
        return $this->position;
    }

     /**
     * Set position
     *
     * @param string $route
     *
     * @return Banner
     */
    public function setRoute($route)
    {
        $this->route = $route;

        return $this;
    }

    /**
     * Get route
     *
     * @return string
     */
    public function getRoute()
    {
        return $this->route;
    }

    
    /**
     * Set code
     *
     * @param string $code
     *
     * @return Banner
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set callsCode
     *
     * @param string $callsCode
     *
     * @return Banner
     */
    public function setCallsCode($callsCode)
    {
        $this->callsCode = $callsCode;

        return $this;
    }

    /**
     * Get callsCode
     *
     * @return string
     */
    public function getCallsCode()
    {
        return $this->callsCode;
    }

    /**
     * Set active
     *
     * @param integer $isactive
     *
     * @return Banner
     */
    public function setIsactive($isactive)
    {
        $this->isactive = $isactive;

        return $this;
    }

    /**
     * Get active
     *
     * @return integer
     */
    public function getIsactive()
    {
        return $this->isactive;
    }

    /**
     * Set headerCode
     *
     * @param string $headerCode
     *
     * @return Banner
     */
    public function setHeaderCode($headerCode)
    {
        $this->headerCode = $headerCode;

        return $this;
    }

    /**
     * Get headerCode
     *
     * @return string
     */
    public function getHeaderCode()
    {
        return $this->headerCode;
    }

    /**
     * Set site
     *
     * @param string $site
     *
     * @return Banner
     */
    public function setSite($site)
    {
        $this->site = $site;

        return $this;
    }

    /**
     * Get site
     *
     * @return string
     */
    public function getSite()
    {
        return $this->site;
    }

    /**
     * Set screen
     *
     * @param string $screen
     *
     * @return Banner
     */
    public function setScreen($screen)
    {
        $this->screen = $screen;

        return $this;
    }

    /**
     * Get screen
     *
     * @return string
     */
    public function getScreen()
    {
        return $this->screen;
    }

    /**
     * Set img
     *
     * @param string $img
     *
     * @return Banner
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
     * Set url
     *
     * @param string $url
     *
     * @return Banner
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Banner
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
     * @param string $name
     *
     * @return Banner
     */
    public function setText($name)
    {
        $this->text = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }
    /**
     * Set name
     *
     * @param string $name
     *
     * @return Banner
     */
    public function setCodeAmp($name)
    {
        $this->codeAmp = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getCodeAmp()
    {
        return $this->codeAmp;
    }
    
    
}
