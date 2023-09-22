<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;


/**
 *
 * @ORM\Table(name="dinamyc_pages", uniqueConstraints={
 *      @ORM\UniqueConstraint(name="unq_banners", columns={"page"})      
 *      },
 *      indexes={
 *          @ORM\Index(name="search_dynamy_page", columns={"page"})
 *      }
 * )
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DinamycPageRepository")
 * @ORM\Cache("NONSTRICT_READ_WRITE", region="my_dinamyc_page_region_result" )
 */
class DinamycPage { 

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
     * @ORM\Column(name="page", type="string", length=255)
     */
    private $page;

    /**
     * @var string
     * @Assert\NotBlank(message="Specificare un valore")
     * @ORM\Column(name="body", type="text")
     */
    private $body;
    

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
     * Set page
     *
     * @param string $page
     *
     * @return DinamycPage
     */
    public function setPage($page)
    {
        $this->page = $page;

        return $this;
    }

    /**
     * Get page
     *
     * @return string
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * Set body
     *
     * @param string $body
     *
     * @return DinamycPage
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
}
