<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ImageProduct
 *
 * @ORM\Table(name="image_products")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ImageProductRepository")
 */
class ImageProduct
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
     * @ORM\Column(name="img", type="string", length=250, nullable=false)
     */
    private $img;

    /**
     * @var integer
     *
     * @ORM\Column(name="width_small", type="integer", nullable=false)
     */
    private $widthsmall;

    /**
     * @var integer
     *
     * @ORM\Column(name="height_small", type="integer", nullable=false)
     */
    private $heightsmall;

    /**
     * @var integer
     *
     * @ORM\Column(name="width_medium", type="integer", nullable=true)
     */
    private $widthmedium;

    /**
     * @var integer
     *
     * @ORM\Column(name="height_medium", type="integer", nullable=true)
     */
    private $heightmedium;

    /**
     * @var integer
     *
     * @ORM\Column(name="width_large", type="integer", nullable=true)
     */
    private $widthlarge;

    /**
     * @var integer
     *
     * @ORM\Column(name="height_large", type="integer", nullable=true)
     */
    private $heightlarge;

    /**
     * @var \AppBundle\Entity\Product
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\ManyToMany(targetEntity="Product", mappedBy="images")
     * @ORM\JoinTable(name="product_imageproduct", joinColumns={@ORM\JoinColumn(name="image_product_id", referencedColumnName="id", onDelete="CASCADE")})
     */
    private $product;
    
    /**
     * Constructor
     */
    public function __construct()
    {
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
     * Set img
     *
     * @param string $img
     *
     * @return Imageproduct
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
     * Set widthsmall
     *
     * @param integer $widthsmall
     *
     * @return Imageproduct
     */
    public function setWidthsmall($widthsmall)
    {
        $this->widthsmall = $widthsmall;

        return $this;
    }

    /**
     * Get widthsmall
     *
     * @return integer
     */
    public function getWidthsmall()
    {
        return $this->widthsmall;
    }

    /**
     * Set heightsmall
     *
     * @param integer $heightsmall
     *
     * @return Imageproduct
     */
    public function setHeightsmall($heightsmall)
    {
        $this->heightsmall = $heightsmall;

        return $this;
    }

    /**
     * Get heightsmall
     *
     * @return integer
     */
    public function getHeightsmall()
    {
        return $this->heightsmall;
    }

    /**
     * Set widthmedium
     *
     * @param integer $widthmedium
     *
     * @return Imageproduct
     */
    public function setWidthmedium($widthmedium)
    {
        $this->widthmedium = $widthmedium;

        return $this;
    }

    /**
     * Get widthmedium
     *
     * @return integer
     */
    public function getWidthmedium()
    {
        return $this->widthmedium;
    }

    /**
     * Set heightmedium
     *
     * @param integer $heightmedium
     *
     * @return Imageproduct
     */
    public function setHeightmedium($heightmedium)
    {
        $this->heightmedium = $heightmedium;

        return $this;
    }

    /**
     * Get heightmedium
     *
     * @return integer
     */
    public function getHeightmedium()
    {
        return $this->heightmedium;
    }

    /**
     * Set widthlarge
     *
     * @param integer $widthlarge
     *
     * @return Imageproduct
     */
    public function setWidthlarge($widthlarge)
    {
        $this->widthlarge = $widthlarge;

        return $this;
    }

    /**
     * Get widthlarge
     *
     * @return integer
     */
    public function getWidthlarge()
    {
        return $this->widthlarge;
    }

    /**
     * Set heightlarge
     *
     * @param integer $heightlarge
     *
     * @return Imageproduct
     */
    public function setHeightlarge($heightlarge)
    {
        $this->heightlarge = $heightlarge;

        return $this;
    }

    /**
     * Get heightlarge
     *
     * @return integer
     */
    public function getHeightlarge()
    {
        return $this->heightlarge;
    }

    /**
     * Add product
     *
     * @param \AppBundle\Entity\Product $product
     *
     * @return Imageproduct
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
}
