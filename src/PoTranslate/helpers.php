<?php

if (!function_exists('_e')) {

    /**
     *
     * Return translate text
     *
     * @param $text
     * @return string
     */
    function _e($text)
    {
        if (empty($GLOBALS['_translate_from_catalog'])) {
            return $text;
        }
        return call_user_func($GLOBALS['_translate_from_catalog'], $text);
    }
}