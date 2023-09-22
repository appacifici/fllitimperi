<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Team
 *
 * @ORM\Table(name="house") 
 * @ORM\Entity(repositoryClass="AppBundle\Repository\HouseRepository")
 */
class House  {

    const EXISTANCE_CHECK_FIELD = 'Name'; 
    
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
     * @ORM\Column(name="link", type="string")
     */
    private $link;
    
    /**
     * @var string
     *
     * @ORM\Column(name="price", type="string")
     */
    private $price;
    
    /**
     * 
     * @var string
     *
     * @ORM\Column(name="name", type="string")
     */
    private $name;
    
    /**
     * 
     * @var string
     *
     * @ORM\Column(name="locals", type="string")
     */
    private $locals;
    
    /**
     * 
     * @var string
     *
     * @ORM\Column(name="surface", type="string")
     */
    private $surface;
    
    /**
     * 
     * @var string
     *
     * @ORM\Column(name="bathroom", type="string")
     */
    private $bathroom;
    
    /**
     * 
     * @var string
     *
     * @ORM\Column(name="floor", type="string")
     */
    private $floor;
    
    /**
     * 
     * @var string
     *
     * @ORM\Column(name="img", type="text")
     */
    private $img;
    
    /**
     * 
     * @var string
     *
     * @ORM\Column(name="checkStatus", type="integer")
     */
    private $checkStatus;
    
    /**
     * 
     * @var string
     *
     * @ORM\Column(name="note", type="text")
     */
    private $note;
    

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
     * Set link
     *
     * @param integer $link
     *
     * @return Menu
     */
    public function setLink($link)
    {
        $this->link = $link;

        return $this;
    }

    /**
     * Get link
     *
     * @return integer
     */
    public function getLink()
    {
        return $this->link;
    }
    
    /**
     * Set name
     *
     * @param integer name
     *
     * @return Menu
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get link
     *
     * @return integer
     */
    public function getName()
    {
        return $this->name;
    }
   
    
    public function setLocals($locals)
    {
        $this->locals = $locals;

        return $this;
    }

    public function getLocals()
    {
        return $this->locals;
    }
    
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    public function getPrice()
    {
        return $this->price;
    }
    
    public function setSurface($surface)
    {
        $this->surface = $surface;

        return $this;
    }

    public function getSurface()
    {
        return $this->surface;
    }
   
    
    public function setBathroom($bathroom)
    {
        $this->bathroom = $bathroom;

        return $this;
    }

    public function getBathroom()
    {
        return $this->bathroom;
    }
   
    
    public function setFloor($floor)
    {
        $this->floor = $floor;

        return $this;
    }

    public function getFloor()
    {
        return $this->floor;
    }
   
    
    public function setCheckStatus($checkStatus)
    {
        $this->checkStatus = $checkStatus;

        return $this;
    }

    public function getCheckStatus()
    {
        return $this->checkStatus;
    }
    
    public function setNote($note)
    {
        $this->note = $note;

        return $this;
    }

    public function getNote()
    {
        return $this->note;
    }
    
    public function setImg($img)
    {
        $this->img = $img;

        return $this;
    }

    public function getImg()
    {
        return $this->img;
    }
   
}