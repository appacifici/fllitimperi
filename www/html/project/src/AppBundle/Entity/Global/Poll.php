<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * Group
 *
 * @ORM\Table(name="polls", uniqueConstraints={
 * })
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PollRepository")
 * @ORM\Cache("NONSTRICT_READ_WRITE", region="my_poll_region_result")
 */
class Poll {
     
    /**
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * 
     * @Assert\NotBlank(message="Inserire la domanda")
     * @ORM\Column(name="question", type="string", length=255)
     */
    private $question;
    
    /**
     * 
     * @ORM\Column(name="json_answers", type="json_array")
     */
    private $jsonAnswers; 
    
    /**
     * @var int
     *
     * @ORM\Column(name="data_article_id", type="integer", nullable=true)
     */
    private $dataArticleId;

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
     * Set question
     *
     * @param string $question
     *
     * @return Poll
     */
    public function setQuestion($question)
    {
        $this->question = $question;

        return $this;
    }

    /**
     * Get question
     *
     * @return string
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * Set jsonAnswers
     *
     * @param array $jsonAnswers
     *
     * @return Poll
     */
    public function setJsonAnswers($jsonAnswers)
    {
        $this->jsonAnswers = $jsonAnswers;

        return $this;
    }

    /**
     * Get jsonAnswers
     *
     * @return array
     */
    public function getJsonAnswers()
    {
        return $this->jsonAnswers;
    }
    
    /**
     * Set jsonAnswers
     *
     * @param array $jsonAnswers
     *
     * @return Poll
     */
    public function setDataArticleId($dataArticleId)
    {
        $this->dataArticleId = $dataArticleId;

        return $this;
    }

    /**
     * Get jsonAnswers
     *
     * @return array
     */
    public function getDataArticleId()
    {
        return $this->dataArticleId;
    }
}
