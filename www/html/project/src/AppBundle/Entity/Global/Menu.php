<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Team
 *
 * @ORM\Table(name="menus", uniqueConstraints={
 *      @ORM\UniqueConstraint(name="unq_menus", columns={"category_id","position"})
 * },
 * 
 * indexes={
 *          @ORM\Index( name="searchDataAtricleOrderMenu1", columns={ "position", "subcategory_id", "order_menu"} ),
 *          @ORM\Index( name="searchDataAtricleOrderMenu2", columns={ "parent_id", "subcategory_id", "order_menu", "position"} ),
 *      }
 * )
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MenuRepository")
 * @ORM\Cache(usage="NONSTRICT_READ_WRITE", region="my_menu_region_result")
 */
class Menu  {

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
     * @ORM\ManyToOne(targetEntity="Category")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id", onDelete="CASCADE")     
     * @ORM\Cache(usage="NONSTRICT_READ_WRITE")
     */
    protected $category;
    
    /**
     * @ORM\Column(name="parent_id", type="integer", nullable=true)
     */
    private $parentId;
    
    /**
     * @ORM\ManyToOne(targetEntity="Subcategory")
     * @ORM\JoinColumn(name="subcategory_id", referencedColumnName="id", onDelete="CASCADE")
     * @ORM\Cache(usage="NONSTRICT_READ_WRITE")
     */
    private $subcategory;
    
    /**
     * @ORM\ManyToOne(targetEntity="Typology")
     * @ORM\JoinColumn(name="typology_id", referencedColumnName="id", onDelete="CASCADE")
     * @ORM\Cache(usage="NONSTRICT_READ_WRITE")
     */
    private $typology;
    
    /**
     * @var string
     *
     * @ORM\Column(name="position", type="integer")
     */
    private $position;

    /**
     * @var string
     *
     * @ORM\Column(name="order_menu", type="integer")
     */
    private $orderMenu; 
    
    
     /**
     * @var string
     *
     * @ORM\Column(name="color", type="string", length=10)
     */
    private $color;
    

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
     * Set category
     *
     * @param integer $category
     *
     * @return Menu
     */
    public function setCategory($category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return integer
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set position
     *
     * @param integer $position
     *
     * @return Menu
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return integer
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Set order
     *
     * @param integer $order
     *
     * @return Menu
     */
    public function setOrder($order)
    {
        $this->order = $order;

        return $this;
    }

    /**
     * Get order
     *
     * @return integer
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * Set parentId
     *
     * @param integer $parentId
     *
     * @return Menu
     */
    public function setParentId($parentId)
    {
        $this->parentId = $parentId;

        return $this;
    }

    /**
     * Get parentId
     *
     * @return integer
     */
    public function getParentId()
    {
        return $this->parentId;
    }

    /**
     * Set color
     *
     * @param string $color
     *
     * @return Menu
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
     * Set orderMenu
     *
     * @param integer $orderMenu
     *
     * @return Menu
     */
    public function setOrderMenu($orderMenu)
    {
        $this->orderMenu = $orderMenu;

        return $this;
    }

    /**
     * Get orderMenu
     *
     * @return integer
     */
    public function getOrderMenu()
    {
        return $this->orderMenu;
    }

    

    /**
     * Set subcategory
     *
     * @param \AppBundle\Entity\Subcategory $subcategory
     *
     * @return Menu
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
     * @return Menu
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
    
    
}
