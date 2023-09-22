<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * StatsFeedAffiliation
 *
 * @ORM\Table(name="statsFeedAffiliations", indexes={})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\StatsFeedAffiliationRepository")
 */
class StatsFeedAffiliation
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
     * @var integer
     *
     * @ORM\Column(name="affiliation", type="integer", nullable=true)
     */
    private $affiliation;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="data_start", type="datetime", nullable=true)
     */
    private $datastart;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="data_end", type="datetime", nullable=true)
     */
    private $dataend;

    /**
     * @var string
     *
     * @ORM\Column(name="kb_feed", type="string", length=50, nullable=false)
     */
    private $kbfeed;

    /**
     * @var string
     *
     * @ORM\Column(name="duration_download_feed", type="string", length=50, nullable=false)
     */
    private $durationdownloadfeed;

    /**
     * @var string
     *
     * @ORM\Column(name="duration_import", type="string", length=50, nullable=false)
     */
    private $durationimport;

    /**
     * @var string
     *
     * @ORM\Column(name="duration_global", type="string", length=50, nullable=false)
     */
    private $durationglobal;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_active", type="boolean", nullable=true)
     */
    private $isactive;

    /**
     * @var integer
     *
     * @ORM\Column(name="num_element", type="integer", nullable=false)
     */
    private $numelement;

    /**
     * @var integer
     *
     * @ORM\Column(name="num_import", type="integer", nullable=false)
     */
    private $numimport;

    /**
     * @var integer
     *
     * @ORM\Column(name="num_update", type="integer", nullable=false)
     */
    private $numupdate;

    /**
     * @var integer
     *
     * @ORM\Column(name="num_disabled", type="integer", nullable=false)
     */
    private $numdisabled;

    /**
     * @var integer
     *
     * @ORM\Column(name="products_active", type="integer", nullable=false)
     */
    private $productsactive;

    /**
     * @var integer
     *
     * @ORM\Column(name="products_disabled", type="integer", nullable=false)
     */
    private $productsdisabled;

    /**
     * @var string
     *
     * @ORM\Column(name="message", type="text", length=65535, nullable=true)
     */
    private $message;

    /**
     * Set $affiliation
     *
     * @param integer $affiliation
     *
     * @return Statsfeedaffiliation
     */
    public function setAffiliation($affiliation)
    {
        $this->affiliation = $affiliation;

        return $this;
    }

    /**
     * Get fkaffiliation
     *
     * @return integer
     */
    public function getAffiliation()
    {
        return $this->affiliation;
    }

    /**
     * Set datastart
     *
     * @param \DateTime $datastart
     *
     * @return Statsfeedaffiliation
     */
    public function setDatastart($datastart)
    {
        $this->datastart = $datastart;

        return $this;
    }

    /**
     * Get datastart
     *
     * @return \DateTime
     */
    public function getDatastart()
    {
        return $this->datastart;
    }

    /**
     * Set dataend
     *
     * @param \DateTime $dataend
     *
     * @return Statsfeedaffiliation
     */
    public function setDataend($dataend)
    {
        $this->dataend = $dataend;

        return $this;
    }

    /**
     * Get dataend
     *
     * @return \DateTime
     */
    public function getDataend()
    {
        return $this->dataend;
    }

    /**
     * Set kbfeed
     *
     * @param string $kbfeed
     *
     * @return Statsfeedaffiliation
     */
    public function setKbfeed($kbfeed)
    {
        $this->kbfeed = $kbfeed;

        return $this;
    }

    /**
     * Get kbfeed
     *
     * @return string
     */
    public function getKbfeed()
    {
        return $this->kbfeed;
    }

    /**
     * Set durationdownloadfeed
     *
     * @param string $durationdownloadfeed
     *
     * @return Statsfeedaffiliation
     */
    public function setDurationdownloadfeed($durationdownloadfeed)
    {
        $this->durationdownloadfeed = $durationdownloadfeed;

        return $this;
    }

    /**
     * Get durationdownloadfeed
     *
     * @return string
     */
    public function getDurationdownloadfeed()
    {
        return $this->durationdownloadfeed;
    }

    /**
     * Set durationimport
     *
     * @param string $durationimport
     *
     * @return Statsfeedaffiliation
     */
    public function setDurationimport($durationimport)
    {
        $this->durationimport = $durationimport;

        return $this;
    }

    /**
     * Get durationimport
     *
     * @return string
     */
    public function getDurationimport()
    {
        return $this->durationimport;
    }

    /**
     * Set durationglobal
     *
     * @param string $durationglobal
     *
     * @return Statsfeedaffiliation
     */
    public function setDurationglobal($durationglobal)
    {
        $this->durationglobal = $durationglobal;

        return $this;
    }

    /**
     * Get durationglobal
     *
     * @return string
     */
    public function getDurationglobal()
    {
        return $this->durationglobal;
    }

    /**
     * Set status
     *
     * @param boolean $isactive
     *
     * @return Statsfeedaffiliation
     */
    public function setIsactive($isactive)
    {
        $this->isactive = $isactive;

        return $this;
    }

    /**
     * Get status
     *
     * @return boolean
     */
    public function getIsactive()
    {
        return $this->isactive;
    }

    /**
     * Set numelement
     *
     * @param integer $numelement
     *
     * @return Statsfeedaffiliation
     */
    public function setNumelement($numelement)
    {
        $this->numelement = $numelement;

        return $this;
    }

    /**
     * Get numelement
     *
     * @return integer
     */
    public function getNumelement()
    {
        return $this->numelement;
    }

    /**
     * Set numimport
     *
     * @param integer $numimport
     *
     * @return Statsfeedaffiliation
     */
    public function setNumimport($numimport)
    {
        $this->numimport = $numimport;

        return $this;
    }

    /**
     * Get numimport
     *
     * @return integer
     */
    public function getNumimport()
    {
        return $this->numimport;
    }

    /**
     * Set numupdate
     *
     * @param integer $numupdate
     *
     * @return Statsfeedaffiliation
     */
    public function setNumupdate($numupdate)
    {
        $this->numupdate = $numupdate;

        return $this;
    }

    /**
     * Get numupdate
     *
     * @return integer
     */
    public function getNumupdate()
    {
        return $this->numupdate;
    }

    /**
     * Set numdisabled
     *
     * @param integer $numdisabled
     *
     * @return Statsfeedaffiliation
     */
    public function setNumdisabled($numdisabled)
    {
        $this->numdisabled = $numdisabled;

        return $this;
    }

    /**
     * Get numdisabled
     *
     * @return integer
     */
    public function getNumdisabled()
    {
        return $this->numdisabled;
    }

    /**
     * Set productsactive
     *
     * @param integer $productsactive
     *
     * @return Statsfeedaffiliation
     */
    public function setProductsactive($productsactive)
    {
        $this->productsactive = $productsactive;

        return $this;
    }

    /**
     * Get productsactive
     *
     * @return integer
     */
    public function getProductsactive()
    {
        return $this->productsactive;
    }

    /**
     * Set productsdisabled
     *
     * @param integer $productsdisabled
     *
     * @return Statsfeedaffiliation
     */
    public function setProductsdisabled($productsdisabled)
    {
        $this->productsdisabled = $productsdisabled;

        return $this;
    }

    /**
     * Get productsdisabled
     *
     * @return integer
     */
    public function getProductsdisabled()
    {
        return $this->productsdisabled;
    }

    /**
     * Set message
     *
     * @param string $message
     *
     * @return Statsfeedaffiliation
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get message
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Get iddebug
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
}
