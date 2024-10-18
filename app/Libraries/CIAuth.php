<?php 
namespace App\Libraries;

class CIAuth {

 
    public static function login($result, $isAdmin = false) {
        $session = session();
        
        // Set session data
        $array = ['logged_in' => true, 'is_admin' => $isAdmin]; // Track if user is an admin
        $userdata = $result;
        
        $session->set('userdata', $userdata);
        $session->set($array);
    }

    public static function id(){
        $session = session();
        if ($session->has('logged_in')){
            if($session->has('userdata')){
                return $session->get('userdata')['user_id'];
            }else{
                return null;
            }
        }else{
            return null;
        }
    }
    


    public static function fullName() {
        $session = session();
        if ($session->has('logged_in')) {
            if ($session->has('userdata')) {
                return $session->get('userdata')['username']; 
            }
        }
        return null;
    }

    public static function check() {
        $session = session();
        return $session->has('logged_in');
    }

    public static function isAdmin() {
        $session = session();
        return $session->get('is_admin') ?? false; // Returns true if the user is an admin
    }

    public static function forget() {
        $session = session();
        $session->remove('logged_in');
        $session->remove('userdata');
        $session->remove('is_admin'); // Remove admin flag on logout
    }

    public static function user() {
        $session = session();
        if ($session->has('logged_in')) {
            return $session->get('userdata') ?? null;
        }
        return null;
    }
}
