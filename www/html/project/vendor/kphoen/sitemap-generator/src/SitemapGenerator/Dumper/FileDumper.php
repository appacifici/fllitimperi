<?php

namespace SitemapGenerator\Dumper;

/**
 * Dump the sitemap into a file.
 *
 * @see SitemapGenerator\Dumper\GzFileDumper
 */
class FileDumper implements DumperFileInterface
{
    protected $filename = null;
    protected $handle = null;

    /**
     * Constructor.
     *
     * @param string $filename The filename. Must be acessible in write mode.
     */
    public function __construct($filename)
    {
        $this->filename = $filename;
    }

    /**
     * {@inheritdoc}
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * {@inheritdoc}
     */
    public function setFilename($filename)
    {
        $this->clearHandle();
        $this->filename = $filename;
    }

    /**
     * {@inheritdoc}
     */
    public function clearHandle()
    {
        if ($this->handle !== null) {
            fclose($this->handle);
            $this->handle = null;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function dump($string)
    {
        if ($this->handle == null) {
            $this->openFile();
        }

        fwrite($this->handle, $string);
    }

    protected function openFile()
    {
        $this->handle = fopen($this->filename, 'w');

        if ($this->handle === false) {
            throw new \RuntimeException(sprintf('Impossible to open the file %s in write mode', $this->filename));
        }
    }

    public function __destruct()
    {
        $this->clearHandle();
    }
}
