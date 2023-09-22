<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * Group
 *
 * @ORM\Table(name="groups", uniqueConstraints={
 * })
 * @ORM\Entity(repositoryClass="AppBundle\Repository\GroupRepository")
 */
class Group {

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
     * @Assert\NotBlank(message="Inserire il nome")
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;
    
    /**
     * @var string
     * @ORM\Column(name="article", type="string", options={"default" = "0-0-0"}, nullable=true)
     */
    private $article;
    
    /**
     * @var string
     * @ORM\Column(name="banner", type="string", options={"default" = "0-0-0"}, nullable=true)
     */
    private $banner;
    
    /**
     * @var string
     * @ORM\Column(name="menu", type="string", options={"default" = "0-0-0"}, nullable=true)
     */
    private $menu;
    
    /**
     * @var string
     * @ORM\Column(name="category", type="string", options={"default" = "0-0-0"}, nullable=true)
     */
    private $category;
    
    /**
     * @var string
     * @ORM\Column(name="subcategory", type="string", options={"default" = "0-0-0"}, nullable=true)
     */
    private $subcategory;
    
    /**
     * @var string
     * @ORM\Column(name="user", type="string", options={"default" = "0-0-0"}, nullable=true)
     */
    private $user;
    
    /**
     * @var string
     * @ORM\Column(name="extra_config", type="string", options={"default" = "0-0-0"}, nullable=true)
     */
    private $extraConfig;
    
    /**
     * @var string
     * @ORM\Column(name="group_permission", type="string", options={"default" = "0-0-0"}, nullable=true)
     */
    private $groupPermission;
    
    /**
     * @var string
     * @ORM\Column(name="dinamyc_page", type="string", options={"default" = "0-0-0"}, nullable=true)
     */
    private $dinamycPage;
    
    /**
     * @var string
     * @ORM\Column(name="external_user", type="string", options={"default" = "0-0-0"}, nullable=true)
     */
    private $externalUser;
    
    /**
     * @var string
     * @ORM\Column(name="affiliation", type="string", options={"default" = "0-0-0"}, nullable=true)
     */
    private $affiliation;

    /**
     * @var string
     * @ORM\Column(name="typology", type="string", options={"default" = "0-0-0"}, nullable=true)
     */
    private $typology;
    
    /**
     * @var string
     * @ORM\Column(name="model", type="string", options={"default" = "0-0-0"}, nullable=true)
     */
    private $model;
    
    /**
     * @var string
     * @ORM\Column(name="product", type="string", options={"default" = "0-0-0"}, nullable=true)
     */
    private $product;
    
    /**
     * @var string
     * @ORM\Column(name="trademark", type="string", options={"default" = "0-0-0"}, nullable=true)
     */
    private $trademark;

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
     * @return Group
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
     * Set article
     *
     * @param string $article
     *
     * @return Group
     */
    public function setArticle($article)
    {
        $this->article = $article;

        return $this;
    }

    /**
     * Get article
     *
     * @return string
     */
    public function getArticle()
    {
        return $this->article;
    }

    /**
     * Set banner
     *
     * @param string $banner
     *
     * @return Group
     */
    public function setBanner($banner)
    {
        $this->banner = $banner;

        return $this;
    }

    /**
     * Get banner
     *
     * @return string
     */
    public function getBanner()
    {
        return $this->banner;
    }

    /**
     * Set menu
     *
     * @param string $menu
     *
     * @return Group
     */
    public function setMenu($menu)
    {
        $this->menu = $menu;

        return $this;
    }

    /**
     * Get menu
     *
     * @return string
     */
    public function getMenu()
    {
        return $this->menu;
    }

    /**
     * Set category
     *
     * @param string $category
     *
     * @return Group
     */
    public function setCategory($category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return string
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set user
     *
     * @param string $user
     *
     * @return Group
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return string
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set groupPermission
     *
     * @param string $groupPermission
     *
     * @return Group
     */
    public function setGroupPermission($groupPermission)
    {
        $this->groupPermission = $groupPermission;

        return $this;
    }

    /**
     * Get groupPermission
     *
     * @return string
     */
    public function getGroupPermission()
    {
        return $this->groupPermission;
    }

    /**
     * Set subcategory
     *
     * @param string $subcategory
     *
     * @return Group
     */
    public function setSubcategory($subcategory)
    {
        $this->subcategory = $subcategory;

        return $this;
    }

    /**
     * Get subcategory
     *
     * @return string
     */
    public function getSubcategory()
    {
        return $this->subcategory;
    }

    /**
     * Set dinamycPage
     *
     * @param string $dinamycPage
     *
     * @return Group
     */
    public function setDinamycPage($dinamycPage)
    {
        $this->dinamycPage = $dinamycPage;

        return $this;
    }

    /**
     * Get dinamycPage
     *
     * @return string
     */
    public function getDinamycPage()
    {
        return $this->dinamycPage;
    }
    /**
     * Set extraConfig
     *
     * @param string $extraConfig
     *
     * @return Group
     */
    public function setExtraConfig($extraConfig)
    {
        $this->extraConfig = $extraConfig;

        return $this;
    }

    /**
     * Get extraConfig
     *
     * @return string
     */
    public function getExtraConfig()
    {
        return $this->extraConfig;
    }
    
    /**
     * Set externalUser
     *
     * @param string $externalUser
     *
     * @return Group
     */
    public function setExternalUser($externalUser)
    {
        $this->externalUser = $externalUser;

        return $this;
    }

    /**
     * Get externalUser
     *
     * @return string
     */
    public function getExternalUser()
    {
        return $this->externalUser;
    }
    
    /**
     * Set externalUser
     *
     * @param string $affiliation
     *
     * @return Group
     */
    public function setAffiliation($affiliation)
    {
        $this->affiliation = $affiliation;

        return $this;
    }

    /**
     * Get externalUser
     *
     * @return string
     */
    public function getAffiliation()
    {
        return $this->affiliation;
    }
    
    /**
     * Set externalUser
     *
     * @param string $typology
     *
     * @return Group
     */
    public function setTypology($typology)
    {
        $this->typology = $typology;

        return $this;
    }

    /**
     * Get externalUser
     *
     * @return string
     */
    public function getTypology()
    {
        return $this->typology;
    }
    
    /**
     * Set externalUser
     *
     * @param string $model
     *
     * @return Group
     */
    public function setModel($model)
    {
        $this->model = $model;

        return $this;
    }

    /**
     * Get externalUser
     *
     * @return string
     */
    public function getModel()
    {
        return $this->model;
    }
    
    /**
     * Set externalUser
     *
     * @param string $product
     *
     * @return Group
     */
    public function setProduct($product)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Get externalUser
     *
     * @return string
     */
    public function getProduct()
    {
        return $this->product;
    }
    
    /**
     * Set externalUser
     *
     * @param string $trademark
     *
     * @return Group
     */
    public function setTrademark($trademark)
    {
        $this->trademark = $trademark;

        return $this;
    }

    /**
     * Get externalUser
     *
     * @return string
     */
    public function getTrademark()
    {
        return $this->trademark;
    }
}
