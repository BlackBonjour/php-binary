<?php
declare(strict_types=1);
namespace BlackBonjour\Binary;

/**
 * Helper class for various binary stuff
 *
 * @author      Erick Dyck <info@erickdyck.de>
 * @since       18.10.2017
 * @package     BlackBonjour\Binary
 * @copyright   Copyright (c) 2017 Erick Dyck
 */
class Binary
{
    /**
     * Convert given HEX string to opposite endian
     *
     * @param   string  $hex
     * @return  string
     */
    public static function convertEndianness(string $hex) : string
    {
        return implode('', array_reverse(str_split($hex, 2)));
    }

    /**
     * Convert HEX string to 32bit float
     *
     * @param   string  $hex
     * @return  float
     */
    public static function hexTo32Float(string $hex) : float
    {
        $packed   = pack('H*', $hex);
        $reversed = strrev($packed);
        $unpack   = unpack('f', $reversed);

        return array_shift($unpack);
    }

    /**
     * Convert HEX string into human readable string
     *
     * @param   string  $hex
     * @return  string
     */
    public static function hexToString(string $hex) : string
    {
        $length = strlen($hex);
        $string = '';

        for ($i = 0; $i < $length; $i += 2) {
            $string .= chr(hexdec(substr($hex, $i, 2)));
        }

        return $string;
    }

    /**
     * Checks if current system is little endian
     *
     * @return  boolean
     */
    public static function isLittleEndian() : bool
    {
        return unpack('S', "\x01\x00")[1] === 1;
    }
}
