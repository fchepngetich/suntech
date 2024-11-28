<?php

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
