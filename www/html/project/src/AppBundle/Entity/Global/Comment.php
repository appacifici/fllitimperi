<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 *
 * @ORM\Table(name="comments")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CommentRepository")
 * @ORM\Cache("NONSTRICT_READ_WRITE", region="my_comment_region_result" )
 */
class Comment extends BetradarEntity { 

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
     * @ORM\Column(name="text", type="string", length=255)
     */
    private $text;
    
    /**
     * @var datetime
     *
     * @ORM\Column(name="create_at", type="datetime")
     */
    private $createAt;

    /**
     * @ORM\ManyToOne(targetEntity="ExternalUser", cascade={"persist"})
     * @ORM\JoinColumn(name="external_user_id", referencedColumnName="id"))
     */
    private $externalUser;
    
    /**
     * @ORM\ManyToOne(targetEntity="DataArticle", cascade={"persist"})
     * @ORM\JoinColumn(name="data_article_id", referencedColumnName="id", nullable=true))
     */
    private $dataArticle;
    

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
     * Set text
     *
     * @param string $text
     *
     * @return Comment
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }
    
    /**
     * Set createAt
     *
     * @param \DateTime $createAt
     *
     * @return Comment
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
     * Set externalUser
     *
     * @param \AppBundle\Entity\ExternalUser $externalUser
     *
     * @return Comment
     */
    public function setExternalUser(\AppBundle\Entity\ExternalUser $externalUser = null)
    {
        $this->externalUser = $externalUser;

        return $this;
    }

    /**
     * Get externalUser
     *
     * @return \AppBundle\Entity\ExternalUser
     */
    public function getExternalUser()
    {
        return $this->externalUser;
    }

    /**
     * Set dataArticle
     *
     * @param \AppBundle\Entity\DataArticle $dataArticle
     *
     * @return Comment
     */
    public function setDataArticle(\AppBundle\Entity\DataArticle $dataArticle = null)
    {
        $this->dataArticle = $dataArticle;

        return $this;
    }

    /**
     * Get dataArticle
     *
     * @return \AppBundle\Entity\DataArticle
     */
    public function getDataArticle()
    {
        return $this->dataArticle;
    }
}
