<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
// , uniqueConstraints={
// *      @ORM\UniqueConstraint(name="unq_data_article", columns={"publish_at","category_id"})
// * }

/**
 * @ORM\Table(name="data_articles",
 * indexes={
 *          @ORM\Index( name="searchDataAtricle", columns={ "category_id", "status", "publish_at", "top_news", "subcategory_one_id", "subcategory_two_id" } ),
 *          @ORM\Index( name="searchDataAtricleFrontentend1", columns={  "category_id", "status", "publish_at" } ),
 *          @ORM\Index( name="searchDataAtricleCount", columns={ "status", "subcategory_one_id", "subcategory_two_id", "top_news", "publish_at" } ),
 *          @ORM\Index( name="searchDataAtricleTopNews", columns={ "status", "top_news", "publish_at"} ),
 *          @ORM\Index( name="adminUsersPublish", columns={  "user_publish_id","publish_at" } ),
 *          @ORM\Index( name="adminUsersCreateAt", columns={  "user_create_id","publish_at" } ),
 *          @ORM\Index( name="publish_at", columns={ "status", "publish_at" } ),
 *          @ORM\Index( name="priorityImg_id", columns={ "priorityImg_id" } ),
 *          @ORM\Index( name="views", columns={ "views" } ),
 *          @ORM\Index( name="modelId", columns={ "model_id" } ),
 *      }
 * )
 * 
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DataArticleRepository")
 * @ORM\Cache("NONSTRICT_READ_WRITE",  region="my_data_article_region_result")
 */
class DataArticle {

    const EXISTANCE_CHECK_FIELD = 'Name';
    
    public function __construct() {
        $this->images = new ArrayCollection();
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
     * @var datetime
     *
     * @ORM\Column(name="last_modify", type="datetime")
     */
    private $lastModify;
    
    /**
     * @var datetime
     *
     * @ORM\Column(name="create_at", type="datetime")
     */
    private $createAt;
    
    /**
     * @var boolean
     * @ORM\Column(name="top_news", type="boolean", options={"default" = FALSE})
     * @Assert\NotBlank(message="Selezionare un valore valido")
     */
    private $topNews;
        
    /**
     * @Assert\NotBlank(message="Selezionare uno stato valido")
     * @ORM\Column(name="status", type="smallint", options={"default" = 0})
     */
    private $status;
    
    /**
     * @var datetime
     * 
     * @ORM\Column(name="publish_at", type="datetime", nullable=true)
     * 
     */
    private $publishAt;
    
    
    /**
     * @ORM\ManyToOne(targetEntity="MegazineSection", inversedBy="dataArticle")
     * @ORM\JoinColumn(name="megazine_section_id", referencedColumnName="id", nullable=true)
     * @Assert\NotBlank(message="Selezionare uno stato valido")
     */
    protected $megazineSection;
    
    /**
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="dataArticle")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id", nullable=true)
     */
    protected $category;
    
    /**
     * @ORM\ManyToOne(targetEntity="Subcategory", cascade={"persist"})
     * @ORM\JoinColumn(name="subcategory_one_id", referencedColumnName="id", nullable=true))
     */
    protected $subcategoryOne;
    
    /**
     * @ORM\ManyToOne(targetEntity="Subcategory", cascade={"persist"})
     * @ORM\JoinColumn(name="subcategory_two_id", referencedColumnName="id", nullable=true)
     */
    protected $subcategoryTwo;
        
    /**
     * @ORM\ManyToOne(targetEntity="Typology", cascade={"persist"})
     * @ORM\JoinColumn(name="typology_id", referencedColumnName="id", nullable=true))
     */
    protected $typology;
    
    /**
     * @ORM\OneToOne(targetEntity="ContentArticle", mappedBy="dataArticle")
     * @ORM\Cache("NONSTRICT_READ_WRITE")
     */
    protected $contentArticle;    
     
    /**
     * @ORM\ManyToOne(targetEntity="User", fetch="LAZY")
     * @ORM\JoinColumn(name="user_create_id", referencedColumnName="id")
     * @ORM\Cache("NONSTRICT_READ_WRITE")
     */
    protected $userCreate;
    
    /**
     * @ORM\ManyToOne(targetEntity="User", fetch="LAZY")
     * @ORM\JoinColumn(name="user_publish_id", referencedColumnName="id")
     * @ORM\Cache("NONSTRICT_READ_WRITE")
     * @Assert\NotBlank(message="Selezionare un valore valido")
     */
    protected $userPublish;
    
    /**
     * @ORM\ManyToMany(targetEntity="Image", inversedBy="dataArticles")
     * @ORM\JoinTable(name="images_data_articles")
     * @Assert\NotBlank(message="Selezionare un'immagine valida")
     * @ORM\Cache("NONSTRICT_READ_WRITE", region="my_images_data_article_region_result")
     */
    protected $images;
    
    /**
     * @ORM\ManyToOne(targetEntity="Image")
     * @ORM\Cache("NONSTRICT_READ_WRITE")
     * @ORM\JoinColumn(name="priorityImg_id", referencedColumnName="id", nullable=true)
     */
    protected $priorityImg; 
    
    /**
     * @var string
     *
     * @ORM\Column(name="top_news_img", type="string", nullable=true)
     */
    private $topNewsImg;
    
    /**
     * @var string
     *
     * @ORM\Column(name="position_top_news_img", type="integer", nullable=true)
     */
    private $positionTopNewsImg;
    
    /**
     * @var string
     *
     * @ORM\Column(name="views", type="integer", nullable=true)
     */
    private $views;
    
    /**
     * @var string
     *
     * @ORM\Column(name="likes", type="integer", nullable=true, options={"default" = 0})
     */
    private $likes;
   
    /**
     * @var string
     *
     * @ORM\Column(name="article_id", type="integer", nullable=true)
     */
    private $articleId;
   
    /**
     * @var string
     *
     * @ORM\Column(name="model_id", type="string", nullable=true)
     */
    private $modelId;
    
    /**
     * @var string
     *
     * @ORM\Column(name="models_rank", type="string", nullable=true)
     */
    private $modelsRank;
    
    /**
     * @var string
     *
     * @ORM\Column(name="anchors", type="string", nullable=true)
     */
    private $anchors;
    
    /**
     * @var string
     *
     * @ORM\Column(name="releated_articles", type="string", nullable=true)
     */
    private $releatedArticles;
    
    /**
     * @var string
     *
     * @ORM\Column(name="label_releated", type="string", nullable=true)
     */
    private $labelReleated;
    
    /**
     * @var string
     *
     * @ORM\Column(name="is_category_guide", type="string", nullable=true, options={"default" = 0})
     */
    private $isCategoryGuide;
  
    
    /**
     * @Assert\Callback
     */
    public function validate(ExecutionContextInterface $context) {
//        if( empty( $this->getCategory() ) &&  empty( $this->getSubcategoryOne() ) ) {
//            $context->buildViolation('Seleziona una sottocategoria o una categoria')
//                ->atPath('category')                
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
     * Set category
     *
     * @param integer $category
     *
     * @return DataArticle
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
     * Set lastModify
     *
     * @param \DateTime $lastModify
     *
     * @return DataArticle
     */
    public function setLastModify($lastModify)
    {
        $this->lastModify = $lastModify;

        return $this;
    }

    /**
     * Get lastModify
     *
     * @return \DateTime
     */
    public function getLastModify()
    {
        return $this->lastModify;
    }

    /**
     * Set createAt
     *
     * @param \DateTime $createAt
     *
     * @return DataArticle
     */
    public function setCreateAt($createAt)
    {
        $this->createAt = $createAt;

        return $this;
    }

    /**
     * Get createAt
     *
     * @return \DateTime
     */
    public function getCreateAt()
    {
        return $this->createAt;
    }

    /**
     * Set topNews
     *
     * @param boolean $topNews
     *
     * @return DataArticle
     */
    public function setTopNews($topNews)
    {
        $this->topNews = $topNews;

        return $this;
    }

    /**
     * Get topNews
     *
     * @return boolean
     */
    public function getTopNews()
    {
        return $this->topNews;
    }
    
    /**
     * Set contentArticle
     *
     * @param \AppBundle\Entity\ContentArticle $contentArticle
     *
     * @return DataArticle
     */
    public function setContentArticle(\AppBundle\Entity\ContentArticle $contentArticle = null)
    {
        $this->contentArticle = $contentArticle;

        return $this;
    }

    /**
     * Get contentArticle
     *
     * @return \AppBundle\Entity\ContentArticle
     */
    public function getContentArticle()
    {
        return $this->contentArticle;
    }

    /**
     * Set userCreate
     *
     * @param \AppBundle\Entity\User $userCreate
     *
     * @return DataArticle
     */
    public function setUserCreate( $userCreate = null)
    {
        $this->userCreate = $userCreate;

        return $this;
    }

    /**
     * Get userCreate
     *
     * @return \AppBundle\Entity\User
     */
    public function getUserCreate()
    {
        return $this->userCreate;
    }

    /**
     * Set userPublish
     *
     * @param \AppBundle\Entity\User $userPublish
     *
     * @return DataArticle
     */
    public function setUserPublish($userPublish = null)
    {
        $this->userPublish = $userPublish;

        return $this;
    }

    /**
     * Get userPublish
     *
     * @return \AppBundle\Entity\User
     */
    public function getUserPublish()
    {
        return $this->userPublish;
    }

    /**
     * Set $megazineSection
     *
     * @param $megazineSection
     *
     * @return DataArticle
     */
    public function setMegazineSection(\AppBundle\Entity\MegazineSection $megazineSection)
    {
        $this->megazineSection = $megazineSection;

        return $this;
    }

    /**
     * Get userPublish
     *
     * @return \AppBundle\Entity\User
     */
    public function getMegazineSection()
    {
        return $this->megazineSection;
    }

    /**
     * Add image
     *
     * @param \AppBundle\Entity\ImageArticle $image
     *
     * @return DataArticle
     */
    public function addImage(\AppBundle\Entity\Image $image)
    {
        $this->images[] = $image;

        return $this;
    }

    /**
     * Remove image
     *
     * @param \AppBundle\Entity\ImageArticle $image
     */
    public function removeImage(\AppBundle\Entity\Image $image)
    {
        $this->images->removeElement($image);
    }

    /**
     * Get images
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * Set publishAt
     *
     * @param \DateTime $publishAt
     *
     * @return DataArticle
     */
    public function setPublishAt($publishAt)
    {
        $this->publishAt = $publishAt;

        return $this;
    }

    /**
     * Get publishAt
     *
     * @return \DateTime
     */
    public function getPublishAt()
    {
        return $this->publishAt;
    }

    /**
     * Set subcategoryOne
     *
     * @param \AppBundle\Entity\Subcategory $subcategoryOne
     *
     * @return DataArticle
     */
    public function setSubcategoryOne(\AppBundle\Entity\Subcategory $subcategoryOne = null)
    {
        $this->subcategoryOne = $subcategoryOne;

        return $this;
    }

    /**
     * Get subcategoryOne
     *
     * @return \AppBundle\Entity\Subcategory
     */
    public function getSubcategoryOne()
    {
        return $this->subcategoryOne;
    }

    /**
     * Set $typology
     *
     * @param \AppBundle\Entity\Typology $typology
     *
     * @return DataArticle
     */
    public function setTypology(\AppBundle\Entity\Typology $typology = null)
    {
        $this->typology = $typology;

        return $this;
    }

    /**
     * Get Typology
     *
     * @return \AppBundle\Entity\Typology
     */
    public function getTypology()
    {
        return $this->typology;
    }

    /**
     * Set subcategoryTwo
     *
     * @param \AppBundle\Entity\Subcategory $subcategoryTwo
     *
     * @return DataArticle
     */
    public function setSubcategoryTwo(\AppBundle\Entity\Subcategory $subcategoryTwo = null)
    {
        $this->subcategoryTwo = $subcategoryTwo;

        return $this;
    }

    /**
     * Get subcategoryTwo
     *
     * @return \AppBundle\Entity\Subcategory
     */
    public function getSubcategoryTwo()
    {
        return $this->subcategoryTwo;
    }

    /**
     * Set status
     *
     * @param integer $status
     *
     * @return DataArticle
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return integer
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set priorityImg
     *
     * @param \AppBundle\Entity\Image $priorityImg
     *
     * @return DataArticle
     */
    public function setPriorityImg(\AppBundle\Entity\Image $priorityImg = null)
    {
        $this->priorityImg = $priorityImg;

        return $this;
    }

    /**
     * Get priorityImg
     *
     * @return \AppBundle\Entity\Image
     */
    public function getPriorityImg()
    {
        return $this->priorityImg;
    }

    /**
     * Set topNewsImg
     *
     * @param \String $topNewsImg
     *
     * @return DataArticle
     */
    public function setTopNewsImg($topNewsImg)
    {
        $this->topNewsImg = $topNewsImg;

        return $this;
    }

    /**
     * Get topNewsImg
     *
     * @return \String
     */
    public function getTopNewsImg()
    {
        return $this->topNewsImg;
    }

    /**
     * Set topNewsImg
     *
     * @param \String $positionTopNewsImg
     *
     * @return DataArticle
     */
    public function setPositionTopNewsImg($positionTopNewsImg)
    {
        $this->positionTopNewsImg = $positionTopNewsImg;

        return $this;
    }

    /**
     * Get topNewsImg
     *
     * @return \String
     */
    public function getPositionTopNewsImg()
    {
        return $this->positionTopNewsImg;
    }
    
    /**
     * Set views
     *
     * @param \String
     *
     * @return DataArticle
     */
    public function setViews($views)
    {
        $this->views = $views;

        return $this;
    }

    /**
     * Get views
     *
     * @return \String
     */
    public function getViews()
    {
        return $this->views;
    }
    
    /**
     * Set likes
     *
     * @param \String
     *
     * @return DataArticle
     */
    public function setLikes($likes)
    {
        $this->likes = $likes;

        return $this;
    }

    /**
     * Get likes
     *
     * @return \String
     */
    public function getLikes()
    {
        return $this->likes;
    }
    
    /**
     * Set opinionCm
     *
     * @param integer $modelId
     *
     * @return DataArticle
     */
    public function setModelId($modelId)
    {
        $this->modelId = $modelId;

        return $this;
    }

    /**
     * Get opinionCm
     *
     * @return integer
     */
    public function getModelId()
    {
        return $this->modelId;
    }
    
    /**
     * Set opinionCm
     *
     * @param integer $modelsRank
     *
     * @return DataArticle
     */
    public function setModelsRank($modelsRank)
    {
        $this->modelsRank = $modelsRank;

        return $this;
    }

    /**
     * Get opinionCm
     *
     * @return integer
     */
    public function getModelsRank()
    {
        return $this->modelsRank;
    }
  
    
    /**
     * Set $anchors
     *
     * @param integer $anchors
     *
     * @return DataArticle
     */
    public function setAnchors($anchors)
    {
        $this->anchors = $anchors;

        return $this;
    }
        
    /**
     * Get 
     *
     * @return integer
     */
    public function getAnchors()
    {
        return $this->anchors;
    }

    /**
     * Get 
     *
     * @return integer
     */
    public function getReleatedArticles()
    {
        return $this->releatedArticles;
    }
    
    /**
     * Set $releatedIds
     *
     * @param integer $releatedIds
     *
     * @return DataArticle
     */
    public function setReleatedArticles($releatedArticles)
    {
        $this->releatedArticles = $releatedArticles;

        return $this;
    }
    
    /**
     * Get 
     *
     * @return integer
     */
    public function getLabelReleated()
    {
        return $this->labelReleated;
    }
    
    /**
     * Set $labelReleated
     *
     * @param integer $labelReleated
     *
     * @return DataArticle
     */
    public function setLabelReleated($labelReleated)
    {
        $this->labelReleated = $labelReleated;

        return $this;
    }

    
    /**
     * Set $anchors
     *
     * @param integer $anchors
     *
     * @return DataArticle
     */
    public function setIsCategoryGuide($isCategoryGuide)
    {
        $this->isCategoryGuide = $isCategoryGuide;

        return $this;
    }

    /**
     * Get 
     *
     * @return integer
     */
    public function getIsCategoryGuide()
    {
        return $this->isCategoryGuide;
    }

    
    /**
     * Set $articleId
     *
     * @param integer $articleId
     *
     * @return DataArticle
     */
    public function setArticleId($articleId)
    {
        $this->articleId = $articleId;

        return $this;
    }

    /**
     * Get 
     *
     * @return integer
     */
    public function getArticleId()
    {
        return $this->articleId;
    }
  
}
