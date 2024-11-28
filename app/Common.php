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


 use App\Models\AdminModel;
 
 if (!function_exists('getLoggedInUserName')) {
     function getLoggedInUserName()
     {
         $session = session();
         $userId = $session->get('user_id');
 
         if (!$userId) {
             return 'Guest';
         }
 
         $userModel = new AdminModel();
         $user = $userModel->find($userId);
 
         return $user ? $user['username'] : 'Guest';
     }
 }
 
