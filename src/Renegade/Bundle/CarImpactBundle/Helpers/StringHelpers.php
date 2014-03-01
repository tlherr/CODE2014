<?php
/**
 * Created by PhpStorm.
 * User: mark
 * Date: 2014-02-28
 * Time: 9:26 PM
 */

namespace Renegade\Bundle\CarImpactBundle\Helpers;


class StringHelpers {
    /**
     * Return the canonical value of the string
     *
     * @param $string
     * @return null|string
     */
    static public function getCanonical($string)
    {
        return null === $string ? null : mb_convert_case($string, MB_CASE_LOWER, mb_detect_encoding($string));
    }

    /**
     * Title case the string, uses dashes and spaces to split words
     *
     * @param $string
     * @param array $delimiters
     * @return string
     */
    static public function getTitleCase($string, $delimiters = array(" ", "-")) {
        /*
         * Exceptions in lower case are words you don't want converted
         * Exceptions all in upper case are any words you don't want converted to title case
         *   but should be converted to upper case, e.g.:
         *   king henry viii or king henry Viii should be King Henry VIII
         */
        foreach ($delimiters as $delimiter){
            $words = explode($delimiter, $string);
            $newwords = array();
            foreach ($words as $word){
                $word = ucfirst(StringHelpers::getCanonical($word));
                array_push($newwords, $word);
            }
            $string = join($delimiter, $newwords);
        }
        return $string;
    }

} 