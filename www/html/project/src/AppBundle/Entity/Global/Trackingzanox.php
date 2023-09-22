<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trackingzanox
 *
 * @ORM\Table(name="tracking_zanox")
 * @ORM\Entity
 */
class TrackingZanox
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
     * @ORM\Column(name="transaction_type", type="string", length=10, nullable=true)
     */
    private $transactiontype;

    /**
     * @var integer
     *
     * @ORM\Column(name="app_id", type="integer", nullable=true)
     */
    private $appid;

    /**
     * @var string
     *
     * @ORM\Column(name="ad_space_url", type="string", length=250, nullable=true)
     */
    private $adspaceurl;

    /**
     * @var integer
     *
     * @ORM\Column(name="ad_space_id", type="integer", nullable=true)
     */
    private $adspaceid;

    /**
     * @var integer
     *
     * @ORM\Column(name="user_id", type="integer", nullable=true)
     */
    private $userid;

    /**
     * @var string
     *
     * @ORM\Column(name="user_name", type="string", length=250, nullable=true)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="cid", type="string", length=250, nullable=true)
     */
    private $cid;

    /**
     * @var string
     *
     * @ORM\Column(name="program_name", type="string", length=250, nullable=true)
     */
    private $programname;

    /**
     * @var string
     *
     * @ORM\Column(name="sub_id", type="string", length=250, nullable=true)
     */
    private $subid;

    /**
     * @var string
     *
     * @ORM\Column(name="commission", type="string", length=15, nullable=true)
     */
    private $commission;

    /**
     * @var string
     *
     * @ORM\Column(name="valute_commussion", type="string", length=10, nullable=true)
     */
    private $valutecommussion;

    /**
     * @var string
     *
     * @ORM\Column(name="tracking_time", type="string", length=50, nullable=true)
     */
    private $trackingtime;

    /**
     * @var string
     *
     * @ORM\Column(name="total_price_program_currency", type="string", length=15, nullable=true)
     */
    private $totalpriceprogramcurrency;

    /**
     * @var string
     *
     * @ORM\Column(name="program_currency", type="string", length=10, nullable=true)
     */
    private $programcurrency;

    /**
     * @var string
     *
     * @ORM\Column(name="total_price_tracking_currency", type="string", length=15, nullable=true)
     */
    private $totalpricetrackingcurrency;

    /**
     * @var string
     *
     * @ORM\Column(name="tracking_currency", type="string", length=10, nullable=true)
     */
    private $trackingcurrency;

    /**
     * @var string
     *
     * @ORM\Column(name="tracking_id", type="string", length=100, nullable=true)
     */
    private $trackingid;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="data", type="datetime", nullable=true)
     */
    private $data;
    
    /**
     * Set transactiontype
     *
     * @param string $transactiontype
     *
     * @return Trackingzanox
     */
    public function setTransactiontype($transactiontype)
    {
        $this->transactiontype = $transactiontype;

        return $this;
    }

    /**
     * Get transactiontype
     *
     * @return string
     */
    public function getTransactiontype()
    {
        return $this->transactiontype;
    }

    /**
     * Set appid
     *
     * @param integer $appid
     *
     * @return Trackingzanox
     */
    public function setAppid($appid)
    {
        $this->appid = $appid;

        return $this;
    }

    /**
     * Get appid
     *
     * @return integer
     */
    public function getAppid()
    {
        return $this->appid;
    }

    /**
     * Set adspaceurl
     *
     * @param string $adspaceurl
     *
     * @return Trackingzanox
     */
    public function setAdspaceurl($adspaceurl)
    {
        $this->adspaceurl = $adspaceurl;

        return $this;
    }

    /**
     * Get adspaceurl
     *
     * @return string
     */
    public function getAdspaceurl()
    {
        return $this->adspaceurl;
    }

    /**
     * Set adspaceid
     *
     * @param integer $adspaceid
     *
     * @return Trackingzanox
     */
    public function setAdspaceid($adspaceid)
    {
        $this->adspaceid = $adspaceid;

        return $this;
    }

    /**
     * Get adspaceid
     *
     * @return integer
     */
    public function getAdspaceid()
    {
        return $this->adspaceid;
    }

    /**
     * Set userid
     *
     * @param integer $userid
     *
     * @return Trackingzanox
     */
    public function setUserid($userid)
    {
        $this->userid = $userid;

        return $this;
    }

    /**
     * Get userid
     *
     * @return integer
     */
    public function getUserid()
    {
        return $this->userid;
    }

    /**
     * Set username
     *
     * @param string $username
     *
     * @return Trackingzanox
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set cid
     *
     * @param string $cid
     *
     * @return Trackingzanox
     */
    public function setCid($cid)
    {
        $this->cid = $cid;

        return $this;
    }

    /**
     * Get cid
     *
     * @return string
     */
    public function getCid()
    {
        return $this->cid;
    }

    /**
     * Set programname
     *
     * @param string $programname
     *
     * @return Trackingzanox
     */
    public function setProgramname($programname)
    {
        $this->programname = $programname;

        return $this;
    }

    /**
     * Get programname
     *
     * @return string
     */
    public function getProgramname()
    {
        return $this->programname;
    }

    /**
     * Set subid
     *
     * @param string $subid
     *
     * @return Trackingzanox
     */
    public function setSubid($subid)
    {
        $this->subid = $subid;

        return $this;
    }

    /**
     * Get subid
     *
     * @return string
     */
    public function getSubid()
    {
        return $this->subid;
    }

    /**
     * Set commission
     *
     * @param string $commission
     *
     * @return Trackingzanox
     */
    public function setCommission($commission)
    {
        $this->commission = $commission;

        return $this;
    }

    /**
     * Get commission
     *
     * @return string
     */
    public function getCommission()
    {
        return $this->commission;
    }

    /**
     * Set valutecommussion
     *
     * @param string $valutecommussion
     *
     * @return Trackingzanox
     */
    public function setValutecommussion($valutecommussion)
    {
        $this->valutecommussion = $valutecommussion;

        return $this;
    }

    /**
     * Get valutecommussion
     *
     * @return string
     */
    public function getValutecommussion()
    {
        return $this->valutecommussion;
    }

    /**
     * Set trackingtime
     *
     * @param string $trackingtime
     *
     * @return Trackingzanox
     */
    public function setTrackingtime($trackingtime)
    {
        $this->trackingtime = $trackingtime;

        return $this;
    }

    /**
     * Get trackingtime
     *
     * @return string
     */
    public function getTrackingtime()
    {
        return $this->trackingtime;
    }

    /**
     * Set totalpriceprogramcurrency
     *
     * @param string $totalpriceprogramcurrency
     *
     * @return Trackingzanox
     */
    public function setTotalpriceprogramcurrency($totalpriceprogramcurrency)
    {
        $this->totalpriceprogramcurrency = $totalpriceprogramcurrency;

        return $this;
    }

    /**
     * Get totalpriceprogramcurrency
     *
     * @return string
     */
    public function getTotalpriceprogramcurrency()
    {
        return $this->totalpriceprogramcurrency;
    }

    /**
     * Set programcurrency
     *
     * @param string $programcurrency
     *
     * @return Trackingzanox
     */
    public function setProgramcurrency($programcurrency)
    {
        $this->programcurrency = $programcurrency;

        return $this;
    }

    /**
     * Get programcurrency
     *
     * @return string
     */
    public function getProgramcurrency()
    {
        return $this->programcurrency;
    }

    /**
     * Set totalpricetrackingcurrency
     *
     * @param string $totalpricetrackingcurrency
     *
     * @return Trackingzanox
     */
    public function setTotalpricetrackingcurrency($totalpricetrackingcurrency)
    {
        $this->totalpricetrackingcurrency = $totalpricetrackingcurrency;

        return $this;
    }

    /**
     * Get totalpricetrackingcurrency
     *
     * @return string
     */
    public function getTotalpricetrackingcurrency()
    {
        return $this->totalpricetrackingcurrency;
    }

    /**
     * Set trackingcurrency
     *
     * @param string $trackingcurrency
     *
     * @return Trackingzanox
     */
    public function setTrackingcurrency($trackingcurrency)
    {
        $this->trackingcurrency = $trackingcurrency;

        return $this;
    }

    /**
     * Get trackingcurrency
     *
     * @return string
     */
    public function getTrackingcurrency()
    {
        return $this->trackingcurrency;
    }

    /**
     * Set trackingid
     *
     * @param string $trackingid
     *
     * @return Trackingzanox
     */
    public function setTrackingid($trackingid)
    {
        $this->trackingid = $trackingid;

        return $this;
    }

    /**
     * Get trackingid
     *
     * @return string
     */
    public function getTrackingid()
    {
        return $this->trackingid;
    }

    /**
     * Set data
     *
     * @param \DateTime $data
     *
     * @return Trackingzanox
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Get data
     *
     * @return \DateTime
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Get idtrack
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
}
