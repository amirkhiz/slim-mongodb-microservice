<?php
/**
 * Created by PhpStorm.
 * User: Siavash Habil <habil@mysu.com>
 * Date: 21/08/2017
 * Time: 14:31
 */

/**
 * @param      $data
 * @param bool $die_flag
 * @param bool $return_flag
 *
 * @return string
 */
function debug_r($data, $die_flag = TRUE, $return_flag = FALSE)
{
    if ($return_flag) {
        return '<pre>' . print_r($data, TRUE) . '</pre>';
    } else {
        echo '<pre>';
        print_r($data);
        echo '</pre>';
    }

    if ($die_flag) {
        die;
    }
}

/**
 * Just for fix jenssegers/laravel-mongodb package issue to using outside of Laravel or Lumen
 */
function app()
{
    return new class
    {
        public function version()
        {
            return '5.4';
        }
    };
}