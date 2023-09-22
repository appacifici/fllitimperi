<?php

namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 *
 * @ORM\Table(name="tecnicalTemplates", uniqueConstraints={
 *      @ORM\UniqueConstraint(name="unq_TecnicalTemplates", columns={"name"})      
 * },
 *      indexes={
 *          @ORM\Index(name="key_TecnicalTemplates_name", columns={"name"}),
 *      }
 * )
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TecnicalTemplateRepository")
 * @ORM\Cache("NONSTRICT_READ_WRITE", region="my_TecnicalTemplate_region_result" )
 */
class TecnicalTemplate { 

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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     * @Assert\NotBlank(message="Specificare un valore")
     * @ORM\Column(name="template", type="text")
     */
    private $template;

    /**
     * @var string
     * @Assert\NotBlank(message="Specificare un valore")
     * @ORM\Column(name="vocabulary", type="text")
     */
    private $vocabulary;

    /**
     * @var string
     * @Assert\NotBlank(message="Specificare un valore")
     * @ORM\Column(name="bullet_points", type="text")
     */
    private $bulletPoints;

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
     * @ORM\OneToMany(targetEntity="Model", mappedBy="tecnicalTemplate")
     * @ORM\JoinColumn(name="model_id", referencedColumnName="id")
     */
    protected $model;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->model = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
     /**
     * Add model 
     *
     * @param \AppBundle\Entity\Model $model
     *
     * @return Typology
     */
    public function addModel(\AppBundle\Entity\Model $model)
    {
        $this->model[] = $model;

        return $this;
    }

    /**
     * Remove model
     *
     * @param \AppBundle\Entity\Model $model
     */
    public function removeModel(\AppBundle\Entity\Model $model)
    {
        $this->model->removeElement($model);
    }

    /**
     * Get model
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getModel()
    {
        return $this->model;
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
     * Set name
     *
     * @param string $name
     *
     * @return Model
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
     * Set template
     *
     * @param string template
     *
     * @return Model
     */
    public function setTemplate($template)
    {
        $this->template = $template;

        return $this;
    }

    /**
     * Get template
     *
     * @return string
     */
    public function getTemplate()
    {
        return $this->template;
    }
    
     /**
     * Set $vocabulary
     *
     * @param string $vocabulary
     *
     * @return Model
     */
    public function setVocabulary($vocabulary)
    {
        $this->vocabulary = $vocabulary;

        return $this;
    }

    /**
     * Get template
     *
     * @return string
     */
    public function getVocabulary()
    {
        return $this->vocabulary;
    }
    
     /**
     * Set $bulletPoints
     *
     * @param string $bulletPoints
     *
     * @return Model
     */
    public function setBulletPoints($bulletPoints)
    {
        $this->bulletPoints = $bulletPoints;

        return $this;
    }

    /**
     * Get template
     *
     * @return string
     */
    public function getBulletPoints()
    {
        return $this->bulletPoints;
    }
    
    
    /**
     * Set $nameUrlTp
     *
     * @param string $nameUrlTp
     *
     * @return Model
     */
    public function setNameUrlTp($nameUrlTp)
    {
        $this->nameUrlTp = $nameUrlTp;

        return $this;
    }

    /**
     * Get nameUrl
     *
     * @return string
     */
    public function getNameUrlTp()
    {
        return $this->nameUrlTp ;
    }
    
    /**
     * Set $nameUrlPm
     *
     * @param string $nameUrlPm
     *
     * @return Model
     */
    public function setNameUrlPm($nameUrlPm)
    {
        $this->nameUrlPm = $nameUrlPm;

        return $this;
    }

    /**
     * Get nameUrl
     *
     * @return string
     */
    public function getNameUrlPm()
    {
        return $this->nameUrlPm;
    }
    
    
    /**
     * Set $nameUrlIde
     *
     * @param string $nameUrlIde
     *
     * @return Model
     */
    public function setNameUrlIde($nameUrlIde)
    {
        $this->nameUrlIde = $nameUrlIde;

        return $this;
    }

    /**
     * Get $nameUrlIde
     *
     * @return string
     */
    public function getNameUrlIde()
    {
        return $this->nameUrlIde;
    }
  
    
}