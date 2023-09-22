<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * subcatSiteAffiliation
 *
 * @ORM\Table(name="subcategorySiteAffiliations", 
 *      uniqueConstraints={@ORM\UniqueConstraint(name="nameSubcatAffiliation", columns={"name", "affiliation_id"})
 * },   
 *      indexes={
 *          @ORM\Index(name="key_lookupSubcategory", columns={"affiliation_id","name","is_active"}),
 *      }
 * )
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SubcategorySiteAffiliationRepository")
 */
class SubcategorySiteAffiliation
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
     * @ORM\Column(name="name", type="string", length=250, nullable=false)
     */
    private $name;
    
    /**
     * @var string
     *
     * @ORM\Column(name="label", type="string", length=250, nullable=false)
     */
    private $label;
    
    /**
     * @ORM\ManyToOne(targetEntity="Affiliation", inversedBy="subcatAffiliation", cascade={"persist"})
     * @ORM\JoinColumn(name="affiliation_id", referencedColumnName="id")
     */
    protected $affiliation;

    /**
     * @var string
     *
     * @ORM\Column(name="is_active", type="string", length=1, nullable=true, options={"default" = 0})
     */
    private $isActive;
    

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
     * @return SubcategorySiteAffiliation
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
     * Set label
     *
     * @param string $label
     *
     * @return SubcategorySiteAffiliation
     */
    public function setLabel($label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Set isactive
     *
     * @param string $isActive
     *
     * @return SubcategorySiteAffiliation
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get isactive
     *
     * @return string
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * Set affiliation
     *
     * @param \AppBundle\Entity\Affiliation $affiliation
     *
     * @return SubcategorySiteAffiliation
     */
    public function setAffiliation(\AppBundle\Entity\Affiliation $affiliation = null)
    {
        $this->affiliation = $affiliation;

        return $this;
    }

    /**
     * Get affiliation
     *
     * @return \AppBundle\Entity\Affiliation
     */
    public function getAffiliation()
    {
        return $this->affiliation;
    }
}
