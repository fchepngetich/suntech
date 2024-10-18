<?php

/**
 * The goal of this file is to allow developers a location
 * where they can overwrite core procedural functions and
 * replace them with their own. This file is loaded during
 * the bootstrap process and is called during the framework's
 * execution.
 *
 * This can be looked at as a `master helper` file that is
 * loaded early on, and may also contain additional functions
 * that you'd like to use throughout your entire application
 *
 * @see: https://codeigniter.com/user_guide/extending/common.html
 */


// if (!function_exists('generate_breadcrumb')) {
//     function generate_breadcrumb($segments = [])
//     {
//         $output = '<nav aria-label="breadcrumb"><ol class="breadcrumb">';

//         // Home link
//         $output .= '<li class="breadcrumb-item"><a href="' . base_url() . '">Home</a></li>';

//         // Generate other breadcrumbs
//         $segment_url = '';
//         foreach ($segments as $key => $segment) {
//             $segment_url .= '/' . $segment['url'];
//             if ($key === count($segments) - 1) {
//                 // Last segment (active)
//                 $output .= '<li class="breadcrumb-item active" aria-current="page">' . esc($segment['name']) . '</li>';
//             } else {
//                 // Intermediate segments (links)
//                 $output .= '<li class="breadcrumb-item"><a href="' . base_url($segment_url) . '">' . esc($segment['name']) . '</a></li>';
//             }
//         }

//         $output .= '</ol></nav>';
//         return $output;
//     }
// }
