<?php

namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 *
 * @ORM\Table(name="question", uniqueConstraints={
 *      @ORM\UniqueConstraint(name="unq_question", columns={"data_article_id","question"})      
 * },
 *      indexes={
 *          @ORM\Index(name="key_question_is_active", columns={"is_active"}),
 *      }
 * )
 * @ORM\Entity(repositoryClass="AppBundle\Repository\QuestionRepository")
 * @ORM\Cache("NONSTRICT_READ_WRITE", region="my_question_region_result" )
 */
class Question { 

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
     * @ORM\Column(name="question", type="string", length=500)
     */
    private $question;

    /**
     * @var string
     * @ORM\Column(name="anwser", type="text", nullable=true)
     */
    private $anwser;    
           
    /**
     * @var string
     * @Assert\NotBlank(message="Specificare un valore")
     * @ORM\Column(name="is_active", type="smallint", options={"default" = 0})
     */
    private $isActive;

    /**
     * @ORM\ManyToOne(targetEntity="DataArticle", cascade={"persist"})
     * @ORM\JoinColumn(name="data_article_id", referencedColumnName="id", nullable=true))
     */
    protected $dataArticle;
    
    
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
     * Set active
     *
     * @param integer question
     *
     * @return Banner
     */
    public function setQuestion($question)
    {
        $this->question = $question;

        return $this;
    }

    /**
     * Get active
     *
     * @return integer
     */
    public function getQuestion()
    {
        return $this->question;
    }
    
    /**
     * Set active
     *
     * @param integer question
     *
     * @return Banner
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get active
     *
     * @return integer
     */
    public function getIsActive()
    {
        return $this->isActive;
    }
 
    /**
     * Set url
     *
     * @param string $anwser
     *
     * @return Banner
     */
    public function setAnwser($anwser)
    {
        $this->anwser = $anwser;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getAnwser()
    {
        return $this->anwser;
    }

     /**
     * Set $dataArticle
     *
     * @param \AppBundle\Entity\DataArticle $dataArticle
     *
     * @return DataArticle
     */
    public function setDataArticle(\AppBundle\Entity\DataArticle $dataArticle = null)
    {
        $this->dataArticle = $dataArticle;

        return $this;
    }

    /**
     * Get Typology
     *
     * @return \AppBundle\Entity\DataArticle
     */
    public function getDataArticle()
    {
        return $this->dataArticle;
    }
}