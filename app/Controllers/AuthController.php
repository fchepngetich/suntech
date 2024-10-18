<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Students;
use CodeIgniter\HTTP\ResponseInterface;
use App\Libraries\CIAuth;
use App\Libraries\Hash;
use App\Models\UserModel;
use App\Models\AdminModel;

class AuthController extends BaseController
{

    protected $helpers = ['url', 'form'];
    public function adminLoginForm()
    {
        $data = [
            'pageTitle' => 'Login',
            'validation' => null
        ];
        return view('admin/pages/auth/login', $data);
    }
    public function userLoginForm()
    {
        $data = [
            'pageTitle' => 'Login',
            'validation' => null
        ];
        return view('backend/pages/auth/login', $data);
    }
    public function registerForm()
    {
        $data = [
            'pageTitle' => 'Register',
            'validation' => null
        ];
        return view('backend/pages/auth/register', $data);
    }

    public function registerHandler()
{
    helper(['form']); 

    // Define validation rules
    $validationRules = [
        'name' => [
            'rules' => 'required|min_length[3]|max_length[255]',
            'errors' => [
                'required' => 'Name is required',
                'min_length' => 'Name must be at least 3 characters',
                'max_length' => 'Name must not exceed 255 characters'
            ]
        ],
        'email' => [
            'rules' => 'required|valid_email|is_unique[users.email]',
            'errors' => [
                'required' => 'Email is required',
                'valid_email' => 'Please provide a valid email address',
                'is_unique' => 'This email is already registered'
            ]
        ],
        'password' => [
            'rules' => 'required|min_length[8]',
            'errors' => [
                'required' => 'Password is required',
                'min_length' => 'Password must be at least 8 characters long'
            ]
        ],
        'password_confirm' => [
            'rules' => 'matches[password]',
            'errors' => [
                'matches' => 'Password confirmation does not match the password'
            ]
        ]
    ];

    // Check if the form validation passes
    if (!$this->validate($validationRules)) {
        // If validation fails, reload the form with validation errors
        return view('backend/pages/auth/register', [
            'validation' => $this->validator
        ]);
    } else {
        // Validation passed, proceed with registration logic

        $userModel = new UserModel();

        // Save the user to the database
        $userModel->save([
            'username' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
        ]);

        // Redirect to login page with success message
        return redirect()->to(base_url('/login'))->with('success', 'Registration successful. Please log in.');
    }
}

    
private function performLogin($model, $email, $password, $loginType)
{
    // Query user by email
    $userInfo = $model->where('email', $email)->first();
    if (!$userInfo) {
        log_message('error', "User not found for email: {$email}");
        return redirect()->back()->with('fail', 'User does not exist')->withInput();
    }

    // Verify password
    if (!password_verify($password, $userInfo['password'])) {
        log_message('error', "Password mismatch for user: {$email}");
        return redirect()->back()->with('fail', 'Wrong password')->withInput();
    }

    // Set session data
    $sessionData = [
        'user_id'   => $userInfo['id'],
        'email'     => $userInfo['email'],
        'is_admin'  => ($loginType === 'admin'),
        'logged_in' => true,
    ];
    session()->set($sessionData);

    log_message('info', "Login successful for {$loginType}: {$email}");

    // Redirect based on login type
    return ($loginType === 'admin') 
        ? redirect()->to(base_url('/admin'))->with('success', 'Admin login successful')
        : redirect()->to(base_url('/'))->with('success', 'User login successful');
}
public function adminLoginHandler()
{
    try {
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        // Validate input
        if (!$this->validate(['email' => 'required|valid_email', 'password' => 'required|max_length[45]'])) {
            return view('backend/pages/auth/login', [
                'pageTitle'  => 'Admin Login',
                'validation' => $this->validator,
            ]);
        }

        log_message('debug', "Admin login attempt: {$email}");
        return $this->performLogin(new AdminModel(), $email, $password, 'admin');

    } catch (\Exception $e) {
        log_message('critical', "Admin login error: {$e->getMessage()}");
        return redirect()->back()->with('fail', 'An unexpected error occurred')->withInput();
    }
}

public function userLoginHandler()
{
    try {
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        // Validate input
        if (!$this->validate(['email' => 'required|valid_email', 'password' => 'required|max_length[45]'])) {
            return view('backend/pages/auth/login', [
                'pageTitle'  => 'User Login',
                'validation' => $this->validator,
            ]);
        }

        log_message('debug', "User login attempt: {$email}");
        return $this->performLogin(new UserModel(), $email, $password, 'user');

    } catch (\Exception $e) {
        log_message('critical', "User login error: {$e->getMessage()}");
        return redirect()->back()->with('fail', 'An unexpected error occurred')->withInput();
    }
}



  
    
   
    
    
    public function forgotPassword()
    {
        $data = array(
            'pageTitle' => 'Forgot Password',

        );
        return view('backend/pages/auth/forgot', $data);
    }

  public function sendResetLink()
{
    $validation = \Config\Services::validation();

    $validation->setRules([
        'email' => [
            'rules' => 'required|valid_email',
            'errors' => [
                'required' => 'Email is required',
                'valid_email' => 'Please provide a valid email address'
            ]
        ],
    ]);

    if (!$validation->withRequest($this->request)->run()) {
        return redirect()->back()->withInput()->with('fail', $validation->getError('email'));
    }

    $email = $this->request->getPost('email');
    $userModel = new UserModel();

    $user = $userModel->where('email', $email)->first();

    if (!$user) {
        return redirect()->back()->withInput()->with('fail', 'This email is not registered');
    }

    $newPassword = $this->generatePassword();
    $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);

$userModel->update($user['id'], [
    'password' => $hashedPassword,
    'password_reset_required' => true
]);
    $username = 'User';

    $this->sendEmail($email, $username, $newPassword);
    
    return redirect()->to(base_url('/change-password'))->with('success', 'A new password has been sent to your email address.');
}


    private function generatePassword()
    {
        $length = 8;
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*()';
        $charactersLength = strlen($characters);
        $randomString = '';
        $randomString .= $characters[rand(0, 9)];
        $randomString .= $characters[rand(10, 35)];
        $randomString .= $characters[rand(36, 61)];
        $randomString .= $characters[rand(62, strlen($characters) - 1)];

        for ($i = 4; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        return str_shuffle($randomString);
    }

  private function sendEmail($to, $username, $newPassword)
{
    $email = \Config\Services::email();

    $email->setFrom('attachmentno-reply@zetech.ac.ke', 'Attachment Portal');
    $email->setTo($to);
    $email->setSubject('Password Reset');


    $message = "
        <html>
        <head>
            <title>Password Reset</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    line-height: 1.6;
                    color: #333;
                }
                .container {
                    max-width: 800px;
                    margin: 0 auto;
                    padding: 20px;
                    border: 1px solid #ddd;
                    border-radius: 10px;
                    background-color: #f9f9f9;
                }
                .header {
                    text-align: center;
                    padding: 10px 0;
                }
                .content {
                    margin-top: 20px;
                }
                .content p {
                    margin: 10px 0;
                }
                .content a {
                    color: #007bff;
                    text-decoration: none;
                }
                .content a:hover {
                    text-decoration: underline;
                }
                .footer {
                    text-align: center;
                    margin-top: 20px;
                    font-size: 0.9em;
                    color: #777;
                }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <h2>Attachment Portal</h2>
                </div>
                <div class='content'>
                    <p>Dear {$username},</p>
                    <p>Your password has been reset. Here are your new credentials:</p>
                    <p><strong>Email:</strong> {$to}</p>
                    <p><strong>Password:</strong> {$newPassword}</p>
                    <p>You can log in to the system using the following link:</p>
                    <p><a href='https://demo.zetech.ac.ke/attachment'>Attachment Portal</a></p>
                    <p>Please make sure to change your password after logging in for the first time.</p>
                </div>
                <div class='footer'>
                    <p>Best Regards,</p>
                    <p>Attachment Portal Team</p>
                </div>
            </div>
        </body>
        </html>
    ";

    $email->setMessage($message);
    $email->setMailType('html'); 


    if (!$email->send()) {
        log_message('error', 'Failed to send password reset email to ' . $to);
        log_message('error', 'Email Debugger Output: ' . $email->printDebugger(['headers', 'subject', 'body']));
    } else {
        log_message('debug', 'Email sent successfully to ' . $to);
    }
}


    public function changePassword()
    {
        $data = array(
            'pageTitle' => 'Change Password',

        );
        return view('backend/pages/auth/change_password', $data);
    }
  public function logoutHandler()
    {
        $userId = CIAuth::id();
        
        $userModel = new UserModel();
        $currentUser = $userModel->find($userId);
        
    
    
        CIAuth::forget();
    
        return redirect()->to(base_url('login'))->with('success', 'You are logged out');
    }
    
    

   
}
