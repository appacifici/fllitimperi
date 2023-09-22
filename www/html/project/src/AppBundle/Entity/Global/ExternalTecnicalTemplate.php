<?php

namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 *
 * @ORM\Table(name="external_tecnical_template", uniqueConstraints={
 *      @ORM\UniqueConstraint(name="unq_externalTecnicalTemplates", columns={"model_id"})      
 * })
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ExternalTecnicalTemplateRepository")
 * @ORM\Cache("NONSTRICT_READ_WRITE", region="my_TecnicalTemplate_region_result" )
 */
class ExternalTecnicalTemplate { 

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @var \AppBundle\Entity\Model
     *
     * @ORM\OneToOne(targetEntity="Model", mappedBy="externalTecnicalTemplate" )
     * @ORM\JoinColumn(name="model_id", referencedColumnName="id", nullable=true, onDelete="CASCADE")
     */
    private $model;

    /**
     * @var string
     * @Assert\NotBlank(message="Specificare un valore")
     * @ORM\Column(name="tecnical_tp", type="text", nullable=true)
     */
    private $tecnicalTp;

    /**
     * @var string
     * @Assert\NotBlank(message="Specificare un valore")
     * @ORM\Column(name="tecnical_pm", type="text", nullable=true)
     */
    private $tecnicalPm;

    /**
     * @var string
     * @Assert\NotBlank(message="Specificare un valore")
     * @ORM\Column(name="tecnical_ide", type="text", nullable=true)
     */
    private $tecnicalIde;
    
    
     /**
     * Set model
     *
     * @param \AppBundle\Entity\Model $model
     *
     * @return Product
     */
    public function setModel(\AppBundle\Entity\Model $model = null)
    {
        $this->model = $model;

        return $this;
    }

    /**
     * Get model
     *
     * @return \AppBundle\Entity\Model
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
     * Set template
     *
     * @param string template
     *
     * @return Model
     */
    public function setTecnicalTp($tecnicalTp)
    {
        $this->tecnicalTp = $tecnicalTp;

        return $this;
    }

    /**
     * Get template
     *
     * @return string
     */
    public function getTecnicalTp()
    {
        return $this->tecnicalTp;
    }
    /**
     * Set template
     *
     * @param string template
     *
     * @return Model
     */
    public function setTecnicalPm($tecnicalPm)
    {
        $this->tecnicalPm = $tecnicalPm;

        return $this;
    }

    /**
     * Get template
     *
     * @return string
     */
    public function getTecnicalPm()
    {
        return $this->tecnicalPm;
    }

    /**
     * Get template
     *
     * @return string
     */
    public function getTecnicalIde()
    {
        return $this->tecnicalIde;
    }
    /**
     * Set $tecnicalIde
     *
     * @param string $tecnicalIde
     *
     * @return $tecnicalIde
     */
    public function setTecnicalIde($tecnicalIde)
    {
        $this->tecnicalIde = $tecnicalIde;

        return $this;
    }
        
}