<?php
declare(strict_types=1);
namespace BlackBonjour\Binary;

/**
 * Binary safe file reader
 *
 * @author      Erick Dyck <info@erickdyck.de>
 * @since       18.10.2017
 * @package     BlackBonjour\Binary
 * @copyright   Copyright (c) 2017 Erick Dyck
 */
class FileReader extends BinaryReader
{
    /** @var string */
    private $fileName;

    /** @var string */
    private $raw;

    /**
     * Constructor
     *
     * @param   string  $fileName
     * @throws  \InvalidArgumentException
     * @throws  \RuntimeException
     */
    public function __construct(string $fileName)
    {
        if (empty($fileName)) {
            throw new \InvalidArgumentException('File name cannot be empty!');
        }

        if (file_exists($fileName) === false) {
            throw new \RuntimeException('File not found!');
        }

        $this->raw      = file_get_contents($fileName);
        $this->fileName = $fileName;

        if (empty($this->raw) || is_string($this->raw) === false) {
            throw new \RuntimeException('Invalid file content!');
        }

        parent::__construct($this->raw);
    }

    /**
     * Returns current file name
     *
     * @return  string
     */
    public function getFileName() : string
    {
        return $this->fileName;
    }

    /**
     * Returns the raw file content
     *
     * @return  string
     */
    public function getRawFileContent() : string
    {
        return $this->raw;
    }

    /**
     * Sets new file name and resets binary reader
     *
     * @param   string  $fileName
     * @return  $this
     * @throws  \InvalidArgumentException
     * @throws  \RuntimeException
     */
    public function setFileName(string $fileName)
    {
        if (empty($fileName)) {
            throw new \InvalidArgumentException('File name cannot be empty!');
        }

        if (file_exists($fileName) === false) {
            throw new \RuntimeException('File not found!');
        }

        // Read file and reset binary reader
        $this->fileName = $fileName;
        $this->raw      = file_get_contents($fileName);

        if (empty($this->raw) || is_string($this->raw) === false) {
            throw new \RuntimeException('Invalid file content!');
        }

        return $this->setData($this->raw);
    }
}
