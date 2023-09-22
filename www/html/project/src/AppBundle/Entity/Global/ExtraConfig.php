<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * ExtraConfig
 *
 * @ORM\Table(name="extra_configs", uniqueConstraints={
 * })
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ExtraConfigRepository")
 * @ORM\Cache("NONSTRICT_READ_WRITE", region="my_extra_config_region_result")
 */
class ExtraConfig {

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
     * @ORM\Column(name="key_name", type="string", length=255)
     */
    private $keyName;
    
    /**
     * @var string
     * @ORM\Column(name="value", type="text", nullable=true)
     */
    private $value;
    

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
     * Set keyName
     *
     * @param string $keyName
     *
     * @return ExtraConfig
     */
    public function setKeyName($keyName)
    {
        $this->keyName = $keyName;

        return $this;
    }

    /**
     * Get keyName
     *
     * @return string
     */
    public function getKeyName()
    {
        return $this->keyName;
    }

    /**
     * Set value
     *
     * @param string $value
     *
     * @return ExtraConfig
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }
}
