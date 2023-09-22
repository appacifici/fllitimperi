<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Sitemaps
 *
 * @ORM\Table(name="sitemaps", indexes={@ORM\Index(name="sitemapsType", columns={"type"})})
 * @ORM\Entity
 */
class Sitemaps
{
    /**
     * @var string
     *
     * @ORM\Column(name="file", type="string", length=250, nullable=true)
     */
    private $file;

    /**
     * @var string
     *
     * @ORM\Column(name="records", type="string", length=250, nullable=true)
     */
    private $records;

    /**
     * @var integer
     *
     * @ORM\Column(name="last_insert_id", type="integer", nullable=true)
     */
    private $lastinsertid;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=25, nullable=true)
     */
    private $type;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;



    /**
     * Set file
     *
     * @param string $file
     *
     * @return Sitemaps
     */
    public function setFile($file)
    {
        $this->file = $file;

        return $this;
    }

    /**
     * Get file
     *
     * @return string
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Set records
     *
     * @param string $records
     *
     * @return Sitemaps
     */
    public function setRecords($records)
    {
        $this->records = $records;

        return $this;
    }

    /**
     * Get records
     *
     * @return string
     */
    public function getRecords()
    {
        return $this->records;
    }

    /**
     * Set lastinsertid
     *
     * @param integer $lastinsertid
     *
     * @return Sitemaps
     */
    public function setLastinsertid($lastinsertid)
    {
        $this->lastinsertid = $lastinsertid;

        return $this;
    }

    /**
     * Get lastinsertid
     *
     * @return integer
     */
    public function getLastinsertid()
    {
        return $this->lastinsertid;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return Sitemaps
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
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
}
