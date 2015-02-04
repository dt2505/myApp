<?php
/**
 * This file is Copyright (c)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SecretBase\AppBundle\Services\Util;


class TokenGenerator
{
    /**
     * @param $min
     * @param $max
     * @return int
     * @link: http://php.net/manual/en/function.openssl-random-pseudo-bytes.php#104322
     */
    function crypto_rand_secure($min, $max) {
        $range = $max - $min;
        if ($range < 0) {
            return $min;                    // not so random...
        }

        $log = log($range, 2);
        $bytes = (int) ($log / 8) + 1;      // length in bytes
        $bits = (int) $log + 1;             // length in bits
        $filter = (int) (1 << $bits) - 1;   // set all lower bits to 1

        do {
            $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
            $rnd = $rnd & $filter;          // discard irrelevant bits
        } while ($rnd >= $range);

        return $min + $rnd;
    }

    /**
     * @param $length
     * @return string
     */
    function generate($length){
        $token = "";
        $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
        $codeAlphabet.= "0123456789";
        for($i = 0; $i < $length; $i++) {
            $token .= $codeAlphabet[$this->crypto_rand_secure(0, strlen($codeAlphabet))];
        }
        return $token;
    }
}
 