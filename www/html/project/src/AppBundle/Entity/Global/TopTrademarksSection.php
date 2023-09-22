<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TopTrademarksSection
 *
 * @ORM\Table(name="topTrademarksSection", 
 *     
 *      indexes={
 *          @ORM\Index(name="key_typology_is_active", columns={"is_active","typology_id"}),
 *          @ORM\Index(name="key_subcat_is_active", columns={"is_active","subcategory_id"}),
 *          @ORM\Index(name="key_subcat_trademark", columns={"subcategory_id","trademark_id"}),
 *          @ORM\Index(name="key_typology_trademark", columns={"typology_id","trademark_id"}),
 *          @ORM\Index(name="key_position", columns={"position"})
 *      }
 * )
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TopTrademarksSectionRepository")
 */
class TopTrademarksSection
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
     * @ORM\Column(name="subcategory_id", type="integer", nullable=true )
     */
    private $subcategoryId;
    
    /**
     * @var string
     *
     * @ORM\Column(name="typology_id", type="integer", nullable=true )
     */
    private $typologyId;

    /**
     * @var string
     *
     * @ORM\Column(name="trademark_id", type="integer", nullable=false)
     */
    private $trademarkId;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="is_active", type="boolean", nullable=true, options={"default" = 1})
     */
    private $isActive;
    
    /**
     * @var int
     *
     * @ORM\Column(name="position", type="integer", nullable=true)
     */
    private $position;
    
    /**
     * @var int
     *
     * @ORM\Column(name="limit_models", type="integer", nullable=true)
     */
    private $limitModels;
    

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
     * Set $subcategoryId
     *
     * @param string $subcategoryId
     *
     * @return SubcategorySiteAffiliation
     */
    public function setSubcategoryId($subcategoryId)
    {
        $this->subcategoryId = $subcategoryId;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getSubcategoryId()
    {
        return $this->subcategoryId;
    }

    /**
     * Set $typologyId
     *
     * @param string $typologyId
     *
     * @return SubcategorySiteAffiliation
     */
    public function setTypologyId($typologyId)
    {
        $this->typologyId = $typologyId;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getTypologyId()
    {
        return $this->typologyId;
    }

    /**
     * Set trademark_id
     *
     * @param string trademark_id
     *
     * @return SubcategorySiteAffiliation
     */
    public function setTrademarkId($trademarkId)
    {
        $this->trademarkId = $trademarkId;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getTrademarkId()
    {
        return $this->trademarkId;
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
     * Set limitModels
     *
     * @param integer $limitModels
     *
     * @return limitModels
     */
    public function setLimitModels($limitModels)
    {
        $this->limitModels = $limitModels;

        return $this;
    }

    /**
     * Get limitModels
     *
     * @return integer
     */
    public function getLimitModels()
    {
        return $this->limitModels;
    }
    
}
