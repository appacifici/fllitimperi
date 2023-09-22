<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
/**
 *
 * @ORM\Table(name="content_articles", uniqueConstraints={
 *      @ORM\UniqueConstraint(name="unq_content_articles", columns={"data_article_id"})
 * },
 * indexes={
 *          @ORM\Index( name="serachArticle", columns={ "title", "sub_heading" } )
 *      }
 * ))

 * @ORM\Entity(repositoryClass="AppBundle\Repository\ContentArticleRepository")
 * @ORM\Cache("NONSTRICT_READ_WRITE",  region="my_content_article_region_result")
 * @ORM\HasLifecycleCallbacks
 */
class ContentArticle {

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
     * @var int
     *
     * @ORM\OneToOne(targetEntity="DataArticle", inversedBy="contentArticle", fetch="LAZY", cascade={"persist"})
     * @ORM\JoinColumn(name="data_article_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     * @ORM\Cache("NONSTRICT_READ_WRITE")
     */
    private $dataArticle;

    /**
     * @Assert\NotBlank(message="Specificare un titolo per l'articolo")
     * @Assert\Length(
     *      min = 4,
     *      max = 120,
     *      minMessage = "Inserisci un titolo di almeno 4 caratteri",
     *      maxMessage = "Inserisci un titolo di massimo 120 caratteri"
     * )
     * @ORM\Column(name="title", type="string", length=255 )
     * 
     */
    private $title;
    
    /**      
     * @ORM\Column(name="sub_heading", type="string", length=255, nullable=true )     
     */
    private $subHeading;
    
    /**
     * @Assert\NotBlank(message="Inserire il testo dell'articolo")
     * @ORM\Column(name="body", type="text")
     */
    private $body;
   
    /**
     * @Assert\Length(
     *      min = 20,
     *      max = 82,
     *      minMessage = "Inserisci un meta titolo di almeno 20 caratteri",
     *      maxMessage = "Inserisci un meta titolo di massimo 82 caratteri"
     * )
     * @ORM\Column(name="meta_title", type="text", nullable=true)
     */
    private $metaTitle;
    
    /**
     * @ORM\Column(name="meta_description", type="text", nullable=true)
     */
    private $metaDescription;
    
    /**
     * @ORM\Column(name="label_ranking", type="text", nullable=true)
     */
    private $labelRanking;
    
    /**
     * @ORM\Column(name="fb_meta_title", type="string", length=255, nullable=true)
     */
    private $fbMetaTitle;
    
    /**
     * @ORM\Column(name="twitter_meta_title", type="string", length=255, nullable=true)
     */
    private $twitterMetaTitle;
    
    /**
     * @Assert\Length(
     *      max = 255,
     *      maxMessage = "Inserisci una meta descrizione di massimo 255 caratteri"
     * )
     * @ORM\Column(name="fb_meta_description", type="string", length=255, nullable=true)
     */
    private $fbMetaDescription;
    
    /**
     * * @Assert\Length(
     *      max = 255,
     *      maxMessage = "Inserisci una meta descrizione di massimo 255 caratteri"
     * )
     * @ORM\Column(name="twitter_meta_description", type="string", length=255, nullable=true)
     */
    private $twitterMetaDescription;
    
    /**
     * @ORM\Column(name="video_file", type="string", length=255, nullable=true)
     */
    private $videoFile;
    
    /**
     * @ORM\Column(name="video", type="text", nullable=true)
     */
    private $video;
    
    /**
     * @ORM\Column(name="signature",  type="string", length=255, nullable=true)
     */
    private $signature;
    
    /**
     * @ORM\Column(name="source", type="string", length=255, nullable=true)
     */
    private $source;    
    
    /**
     * @ORM\Column(name="scripts",  type="text", nullable=true)
     */
    private $scripts;
    
    /**
     * @ORM\Column(name="top_scripts",  type="text", nullable=true)
     */
    private $topScripts;
        
    /** 
     * @ORM\Column(name="permalink", type="string", length=255)     
     */
    private $permalink;
    
    /**
     * @Assert\Callback
     */
    public function validate(ExecutionContextInterface $context) {
//        echo $this->getTitle().'    ';
//        echo $this->getSource();
//        if( $this->getTitle() == null ) {
//            $context->buildViolation('This name sounds totally fake!')
//                ->atPath('title')
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
     * @return ContentArticle
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
     * Set title
     *
     * @param string $title
     *
     * @return ContentArticle
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }
    
    /**
     * Set permalink
     *
     * @param string $permalink
     *
     * @return ContentArticle
     */
    public function setPermalink($permalink)
    {
        $this->permalink = $permalink;

        return $this;
    }

    /**
     * Get $permalink
     *
     * @return string
     */
    public function getPermalink()
    {
        return $this->permalink;
    }

    /**
     * Set subHeading
     *
     * @param string $subHeading
     *
     * @return ContentArticle
     */
    public function setSubHeading($subHeading)
    {
        $this->subHeading = $subHeading;

        return $this;
    }

    /**
     * Get subHeading
     *
     * @return string
     */
    public function getSubHeading()
    {
        return $this->subHeading;
    }

    /**
     * Set body
     *
     * @param string $body
     *
     * @return ContentArticle
     */
    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }

    /**
     * Get body
     *
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Set metaTitle
     *
     * @param string $metaTitle
     *
     * @return ContentArticle
     */
    public function setMetaTitle($metaTitle)
    {
        $this->metaTitle = $metaTitle;

        return $this;
    }

    /**
     * Get metaTitle
     *
     * @return string
     */
    public function getMetaTitle()
    {
        return $this->metaTitle;
    }
    
     /**
     * Set fbMetaTitle
     *
     * @param string fbMetaTitle
     *
     * @return ContentArticle
     */
    public function setFbMetaTitle($fbMetaTitle)
    {
        $this->fbMetaTitle = $fbMetaTitle;

        return $this;
    }
    
    /**
     * Get fbMetaTitle
     *
     * @return string
     */
    public function getFbMetaTitle()
    {
        return $this->fbMetaTitle;
    }
    
    /**
     * Set twitterMetaTitle
     *
     * @param string twitterMetaTitle
     *
     * @return ContentArticle
     */
    public function setTwitterMetaTitle($twitterMetaTitle)
    {
        $this->twitterMetaTitle = $twitterMetaTitle;

        return $this;
    }
    
    /**
     * Get twitterMetaTitle
     *
     * @return string
     */
    public function getTwitterMetaTitle()
    {
        return $this->twitterMetaTitle;
    }
    
    /**
     * Set fbMetaDescription
     *
     * @param string fbMetaDescription
     *
     * @return ContentArticle
     */
    public function setFbMetaDescription($fbMetaDescription)
    {
        $this->fbMetaDescription = $fbMetaDescription;

        return $this;
    }
    
    /**
     * Get fbMetaDescription
     *
     * @return string
     */
    public function getFbMetaDescription()
    {
        return $this->fbMetaDescription;
    }
    
    /**
     * Set twitterMetaDescription
     *
     * @param string twitterMetaDescription
     *
     * @return ContentArticle
     */
    public function setTwitterMetaDescription($twitterMetaDescription)
    {
        $this->twitterMetaDescription = $twitterMetaDescription;

        return $this;
    }
    
    /**
     * Get twitterMetaDescription
     *
     * @return string
     */
    public function getTwitterMetaDescription()
    {
        return $this->twitterMetaDescription;
    }

    /**
     * Set metaDescription
     *
     * @param string $metaDescription
     *
     * @return ContentArticle
     */
    public function setMetaDescription($metaDescription)
    {
        $this->metaDescription = $metaDescription;

        return $this;
    }

    /**
     * Get metaDescription
     *
     * @return string
     */
    public function getMetaDescription()
    {
        return $this->metaDescription;
    }

    /**
     * Set videoFile
     *
     * @param string $videoFile
     *
     * @return ContentArticle
     */
    public function setVideoFile($videoFile)
    {
        $this->videoFile = $videoFile;

        return $this;
    }

    /**
     * Get videoFile
     *
     * @return string
     */
    public function getVideoFile()
    {
        return $this->videoFile;
    }

    /**
     * Set video
     *
     * @param string $video
     *
     * @return ContentArticle
     */
    public function setVideo($video)
    {
        $this->video = $video;

        return $this;
    }

    /**
     * Get video
     *
     * @return string
     */
    public function getVideo()
    {
        return $this->video;
    }

    /**
     * Set signature
     *
     * @param string $signature
     *
     * @return ContentArticle
     */
    public function setSignature($signature)
    {
        $this->signature = $signature;

        return $this;
    }

    /**
     * Get signature
     *
     * @return string
     */
    public function getSignature()
    {
        return $this->signature;
    }

    /**
     * Set source
     *
     * @param string $source
     *
     * @return ContentArticle
     */
    public function setSource($source)
    {
        $this->source = $source;

        return $this;
    }

    /**
     * Get source
     *
     * @return string
     */
    public function getSource()
    {
        return $this->source;
    }
    
    /**
     * Set scripts
     *
     * @param string $scripts
     *
     * @return ContentArticle
     */
    public function setScripts($scripts)
    {
        $this->scripts = $scripts;

        return $this;
    }

    /**
     * Get scripts
     *
     * @return string
     */
    public function getScripts()
    {
        return $this->scripts;
    }
    
    /**
     * Set $topScripts
     *
     * @param string $topScripts
     *
     * @return ContentArticle
     */
    public function setTopScripts($topScripts)
    {
        $this->topScripts = $topScripts;

        return $this;
    }

    /**
     * Get scripts
     *
     * @return string
     */
    public function getTopScripts()
    {
        return $this->topScripts;
    }
    
    /**
     * Set $labelRanking
     *
     * @param string $labelRanking
     *
     * @return ContentArticle
     */
    public function setLabelRanking($labelRanking)
    {
        $this->labelRanking = $labelRanking;

        return $this;
    }

    /**
     * Get scripts
     *
     * @return string
     */
    public function getLabelRanking()
    {
        return $this->labelRanking;
    }
       

}
