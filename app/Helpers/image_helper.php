<?php

if (!function_exists('get_image_url')) {
    function get_image_url($imageFileName)
    {
        $config = config('App');
        return base_url($config->baseImagePath . $imageFileName);
    }
}
