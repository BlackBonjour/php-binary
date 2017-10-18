<?php
declare(strict_types=1);
namespace BlackBonjour\Binary;

/**
 * Binary reader
 *
 * @author      Erick Dyck <info@erickdyck.de>
 * @since       18.10.2017
 * @package     BlackBonjour\Binary
 * @copyright   Copyright (c) 2017 Erick Dyck
 */
class BinaryReader
{
    /** @var string */
    private $data;

    /** @var int */
    private $pointer = 0;

    /**
     * Constructor
     *
     * @param   string  $data
     * @throws  \InvalidArgumentException
     */
    public function __construct(string $data)
    {
        if (empty($data)) {
            throw new \InvalidArgumentException('Empty data given');
        }

        $this->data = $data;
    }

    /**
     * Sets the pointer to the end of the data
     *
     * @return  $this
     */
    public function end()
    {
        $this->pointer = strlen($this->data);
        return $this;
    }

    /**
     * Forward pointer by given amount
     *
     * @param   int $amount
     * @return  $this
     */
    public function forward(int $amount)
    {
        $this->pointer += $amount;
        return $this;
    }

    /**
     * @param   int     $amount
     * @param   boolean $convert
     * @return  string
     * @throws  \InvalidArgumentException
     */
    public function read(int $amount, bool $convert = true) : string
    {
        if ($amount < 1) {
            throw new \InvalidArgumentException('Cannot read less than a byte!');
        }

        $data = substr($this->data, $this->pointer, $amount);

        // Convert data
        if ($convert) {
            $data = bin2hex($data);

            if (Binary::isLittleEndian()) {
                $data = Binary::convertEndianness($data);
            }
        }

        // Update pointer
        $this->pointer += $amount;
        return $data;
    }

    /**
     * @param   int     $pointer
     * @param   int     $amount
     * @param   boolean $convert
     * @return  string
     * @throws  \InvalidArgumentException
     */
    public function readFromPointer(int $pointer, int $amount, bool $convert = true) : string
    {
        $oldPointer    = $this->pointer;
        $this->pointer = $pointer < 0 ? 0 : $pointer;

        // Get data
        $data = $this->read($amount, $convert);

        // Set pointer to old position and return result
        $this->pointer = $oldPointer;
        return $data;
    }

    /**
     * Sets pointer to the beginning of the data
     *
     * @return  $this
     */
    public function reset()
    {
        $this->pointer = 0;
        return $this;
    }

    /**
     * Sets new data and resets reader
     *
     * @param   string  $data
     * @return  $this
     * @throws  \InvalidArgumentException
     */
    public function setData(string $data)
    {
        if (empty($data)) {
            throw new \InvalidArgumentException('Empty data given!');
        }

        $this->data = $data;
        $this->reset();

        return $this;
    }
}
