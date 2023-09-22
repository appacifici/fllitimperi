<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MicroSection
 *
 * @ORM\Table(name="micro_sections", uniqueConstraints={
 *      @ORM\UniqueConstraint(name="unq_micro_section", columns={"name_url"})
 * },
 *  indexes={
 *          @ORM\Index(name="key_subcat_typology_microsec", columns={"subcategory_id","typology_id"})
 *      }
 * )
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MicroSectionRepository")
 * @ORM\Cache("NONSTRICT_READ_WRITE",  region="my_micro_section_region_result")
 */
class MicroSection {

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
     * @var string
     *
     * @ORM\Column(name="name_url_pm", type="string", length=250, nullable=true)
     */
    private $nameUrlPm;

    /**
     * @var string
     *
     * @ORM\Column(name="name_url_ide", type="string", length=250, nullable=true)
     */
    private $nameUrlIde;

    /**
     * @var integer
     * @ORM\ManyToOne(targetEntity="Category", fetch="EAGER")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id", nullable=false)
     */
    private $category;

    /**
     * @var integer
     * @ORM\ManyToOne(targetEntity="Subcategory", inversedBy="microSection", fetch="EAGER")
     * @ORM\JoinColumn(name="subcategory_id", referencedColumnName="id", nullable=false)
     */
    private $subcategory;

    /**
     * @var integer
     * @ORM\ManyToOne(targetEntity="Typology", inversedBy="microSection", fetch="EAGER")
     * @ORM\JoinColumn(name="typology_id", referencedColumnName="id")
     */
    private $typology;

    /**
     * @ORM\OneToMany(targetEntity="Model", mappedBy="microSection")
     * @ORM\JoinColumn(name="model_id", referencedColumnName="id")
     */
    protected $model;

    /**
     * @ORM\OneToMany(targetEntity="Product", mappedBy="microSection")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     */
    protected $product;

    /**
     * @var string
     *
     * @ORM\Column(name="metaH1", type="string", length=250, nullable=true)
     */
    private $metaH1;

    /**
     * @var string
     *
     * @ORM\Column(name="meta_title", type="string", length=250, nullable=true)
     */
    private $metaTitle;

    /**
     * @var string
     *
     * @ORM\Column(name="meta_description", type="string", length=500, nullable=true)
     */
    private $metaDescription;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", length=65535, nullable=true)
     */
    private $description;
                
    /**
     * @var string
     *
     * @ORM\Column(name="body", type="text", length=65535, nullable=true)
     */
    private $body; 

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_active", type="boolean", nullable=true, options={"default" = 1})
     */
    private $isActive;

    /**
     * @var string
     *
     * @ORM\Column(name="img", type="string", length=250, nullable=true)
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
     * @var integer
     *
     * @ORM\Column(name="has_products", type="integer", nullable=true, options={"default" = 0})
     */
    private $hasProducts;

    /**
     * Constructor
     */
    public function __construct() {
        
    }

    public function setWidthSmall($widthSmall) {
        $this->widthSmall = $widthSmall;

        return $this;
    }

    public function getWidthSmall() {
        return $this->widthSmall;
    }

    public function setHeightSmall($heightSmall) {
        $this->heightSmall = $heightSmall;

        return $this;
    }

    public function getHeightSmall() {
        return $this->heightSmall;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Model
     */
    public function setName($name) {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Set nameUrl
     *
     * @param string $nameUrl
     *
     * @return Model
     */
    public function setNameUrl($nameUrl) {
        $this->nameUrl = $nameUrl;

        return $this;
    }

    /**
     * Get nameUrl
     *
     * @return string
     */
    public function getNameUrl() {
        return $this->nameUrl;
    }

    /**
     * Set $nameUrlTp
     *
     * @param string $nameUrlTp
     *
     * @return Model
     */
    public function setNameUrlTp($nameUrlTp) {
        $this->nameUrlTp = $nameUrlTp;

        return $this;
    }

    /**
     * Get nameUrl
     *
     * @return string
     */
    public function getNameUrlTp() {
        return $this->nameUrlTp;
    }

    /**
     * Set $nameUrlPm
     *
     * @param string $nameUrlPm
     *
     * @return Model
     */
    public function setNameUrlPm($nameUrlPm) {
        $this->nameUrlPm = $nameUrlPm;

        return $this;
    }

    /**
     * Get nameUrl
     *
     * @return string
     */
    public function getNameUrlPm() {
        return $this->nameUrlPm;
    }

    /**
     * Set $nameUrlIde
     *
     * @param string $nameUrlIde
     *
     * @return Model
     */
    public function setNameUrlIde($nameUrlIde) {
        $this->nameUrlIde = $nameUrlIde;

        return $this;
    }

    /**
     * Get $nameUrlIde
     *
     * @return string
     */
    public function getNameUrlIde() {
        return $this->nameUrlIde;
    }

    /**
     * Set metH1
     *
     * @param string $metaH1
     *
     * @return Model
     */
    public function setMetaH1($metaH1) {
        $this->metaH1 = $metaH1;

        return $this;
    }

    /**
     * Get metaTitle
     *
     * @return string
     */
    public function getMetaH1() {
        return $this->metaH1;
    }

    /**
     * Set metaTitle
     *
     * @param string $metaTitle
     *
     * @return Model
     */
    public function setMetaTitle($metaTitle) {
        $this->metaTitle = $metaTitle;

        return $this;
    }

    /**
     * Get metaTitle
     *
     * @return string
     */
    public function getMetaTitle() {
        return $this->metaTitle;
    }

    /**
     * Set metaDescription
     *
     * @param string $metaDescription
     *
     * @return Model
     */
    public function setMetaDescription($metaDescription) {
        $this->metaDescription = $metaDescription;

        return $this;
    }

    /**
     * Get metaDescription
     *
     * @return string
     */
    public function getMetaDescription() {
        return $this->metaDescription;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Typology
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }
    
    
    /**
     * Set $body
     *
     * @param string $body
     *
     * @return Typology
     */
    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     *
     * @return Model
     */
    public function setIsActive($isActive) {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean
     */
    public function getIsActive() {
        return $this->isActive;
    }

    /**
     * Set img
     *
     * @param string $img
     *
     * @return Model
     */
    public function setImg($img) {
        $this->img = $img;

        return $this;
    }

    /**
     * Get img
     *
     * @return string
     */
    public function getImg() {
        return $this->img;
    }

    /**
     * Set description
     *
     * @param string $hasProducts
     *
     * @return Typology
     */
    public function setHasProducts($hasProducts) {
        $this->hasProducts = $hasProducts;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getHasProducts() {
        return $this->hasProducts;
    }

    /**
     * Set category
     *
     * @param \AppBundle\Entity\Category $category
     *
     * @return Model
     */
    public function setCategory(\AppBundle\Entity\Category $category = null) {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \AppBundle\Entity\Category
     */
    public function getCategory() {
        return $this->category;
    }

    /**
     * Set subcategory
     *
     * @param \AppBundle\Entity\Subcategory $subcategory
     *
     * @return Model
     */
    public function setSubcategory(\AppBundle\Entity\Subcategory $subcategory = null) {
        $this->subcategory = $subcategory;

        return $this;
    }

    /**
     * Get subcategory
     *
     * @return \AppBundle\Entity\Subcategory
     */
    public function getSubcategory() {
        return $this->subcategory;
    }

    /**
     * Set typology
     *
     * @param \AppBundle\Entity\Typology $typology
     *
     * @return Model
     */
    public function setTypology(\AppBundle\Entity\Typology $typology = null) {
        $this->typology = $typology;

        return $this;
    }

    /**
     * Get typology
     *
     * @return \AppBundle\Entity\Typology
     */
    public function getTypology() {
        return $this->typology;
    }

    /**
     * Set model
     *
     * @param \AppBundle\Entity\Model $model
     *
     * @return Model
     */
    public function setModel(\AppBundle\Entity\Model $model = null) {
        $this->model = $model;

        return $this;
    }

    /**
     * Get model
     *
     * @return \AppBundle\Entity\Model
     */
    public function getModel() {
        return $this->model;
    }

}
