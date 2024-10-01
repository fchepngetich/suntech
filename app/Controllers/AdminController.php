<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Libraries\CIAuth;
use App\Models\User;
use App\Models\Roles;
use App\Models\Students;
use App\Models\School;
use App\Models\Course;
use App\Models\Logs;


use \Mberecall\CI_Slugify\SlugService;
use SSP;


class AdminController extends BaseController
{
    protected $helpers = ['url', 'form', 'CIMail', 'CIFunctions'];
    protected $db;
    public function __construct()
    {
        require_once APPPATH . 'ThirdParty/ssp.php';
        $this->db = db_connect();
    }

    public function forgotPassword()
    {
        $usermodel = new User();

    }
    public function default()
    {

        return redirect()->to(base_url('/admin/login'));
    }

    public function index()
    {
        $full_name = CIAuth::StudentName();
        $students = new Students();

        $data = ['full_name' => $full_name];
        return view('backend/pages/home', $data);
    }

    // public function logoutHandler()
    // {
    //     $userId = CIAuth::id();
        
    //     $userModel = new User();
    //     $currentUser = $userModel->find($userId);
        
        
    //     if ($currentUser && $currentUser['usertype'] !== 'student') {
    //         $userName = $currentUser['full_name'] ?? 'Unknown User';
    
    //         $logModel = new Logs();
    //         $logModel->save([
    //             'user_id' => $userId,
    //             'action' => 'User Logged out',
    //             'details' => sprintf('User %s logged out.', esc($userName))
    //         ]);
    //     }
    
    //     CIAuth::forget();
    
    //     return redirect()->to(base_url('admin/login'))->with('success', 'You are logged out');
    // }
    
    

    public function getUsers()
{
    $db = \Config\Database::connect();
    $full_name = CIAuth::fullName();
    $roleModel = new Roles();
    $roles = $roleModel->findAll();

    $userModel = new User();
    
    $search = $this->request->getPost();

    $query = $userModel;

    if (!empty($search['full_name'])) {
        $query->like('full_name', $search['full_name']);
    }
    if (!empty($search['email'])) {
        $query->like('email', $search['email']);
    }
    if (!empty($search['role'])) {
        $query->where('role_id', $search['role']);
    }

    $users = $query->orderBy('full_name', 'ASC')->findAll();

    $data = [
        'full_name' => $full_name,
        'roles' => $roles,
        'users' => $users,
        'search' => $search 
    ];

    return view('backend/pages/users', $data);
}


    public function addUser()
    {
        $roleModel = new Roles();
        $roles = $roleModel->findAll();

        $data = [
            'pageTitle' => 'Add User',
        ];
        $full_name = CIAuth::fullName();

        $data['full_name'] = $full_name;
        $data['roles'] = $roles;

        return view('backend/pages/new-user', $data);
    }

    public function createUser()
    {
        $request = \Config\Services::request();

        if ($request->isAJAX()) {
            $validation = \Config\Services::validation();

            $validation->setRules([
                'full_name' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Full name is required',
                    ]
                ],
                'email' => [
                    'rules' => 'required|valid_email|is_unique[users.email]|regex_match[/^[\w\.\-]+@zetech\.ac\.ke$/]',
                    'errors' => [
                        'required' => 'Email is required',
                        'valid_email' => 'Please provide a valid email address',
                        'is_unique' => 'This email is already registered',
                        'regex_match' => 'Email must be a zetech.ac.ke email address',
                    ]
                ],
                'role_id' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Role is required',
                    ]
                ],
            ]);

            if (!$validation->withRequest($this->request)->run()) {
                $errors = $validation->getErrors();
                return $this->response->setJSON([
                    'status' => 0,
                    'token' => csrf_hash(),
                    'errors' => $errors
                ]);
            } else {
                $userModel = new User();
                $password = $this->generatePassword(8);
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                $data = [
                    'full_name' => $this->request->getPost('full_name'),
                    'email' => $this->request->getPost('email'),
                    'role_id' => (int) $this->request->getPost('role_id'), 
                    'password' => $hashedPassword,
                ];

                if ($userModel->save($data)) {
                    $userId = \App\Libraries\CIAuth::id();
                    $message = "User Full name: {$data['full_name']} with email: {$data['email']} was created.";
                    log_action($userId, $message);

                    $email = \Config\Services::email();
                    $email->setFrom('noreplyzetech@attachmentportal.com', 'Attachment Portal');
                    $email->setTo($data['email']);
                    $email->setSubject('Attachment User Credentials');

                    $message = "
                    <html>
                    <head>
                        <title>Attachment Portal User Credentials</title>
                    </head>
                    <body>
                        <h2>Welcome to the Attachment Portal</h2>
                        <p>Dear {$data['full_name']},</p>
                        <p>You have been added as a user in the Attachment Portal. Here are your credentials:</p>
                        <table>
                            <tr>
                                <td><strong>Username:</strong></td><td>{$data['email']}</td>
                            </tr>
                            <tr>
                                <td><strong>Password:</strong></td><td>{$password}</td>
                            </tr>
                             <tr>
                                <td><strong>Password:</strong></td><td> <a href='https://demo.zetech.ac.ke/attachment'>Attachment Portal</a></td>
                            </tr>
                           
                        </table>
                        <p>Please make sure to change your password after your first login.</p>
                        <br>
                        <p>Best Regards,</p>
                        <p>Attachment Portal Team</p>
                    </body>
                    </html>";

                    $email->setMessage($message);
                    $email->setMailType('html');

                    if ($email->send()) {
                        return $this->response->setJSON([
                            'status' => 1,
                            'msg' => 'User added successfully. Password has been sent to their email.',
                            'token' => csrf_hash()
                        ]);
                    } else {
                        return $this->response->setJSON([
                            'status' => 1,
                            'msg' => 'User added successfully. Failed to send the password email.',
                            'token' => csrf_hash()
                        ]);
                    }
                } else {
                    return $this->response->setJSON([
                        'status' => 0,
                        'msg' => 'Failed to add user. Please try again.',
                        'token' => csrf_hash(),
                    ]);
                }
            }
        } else {
            return $this->response->setStatusCode(400, 'Bad Request');
        }
    }

    private function generatePassword($length = 8)
    {
        $uppercase = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $lowercase = 'abcdefghijklmnopqrstuvwxyz';
        $numbers = '0123456789';
        $specialCharacters = '!@#$%^&*()-_+=<>?';

        $allCharacters = $uppercase . $lowercase . $numbers . $specialCharacters;
        $password = [
            $uppercase[rand(0, strlen($uppercase) - 1)],
            $lowercase[rand(0, strlen($lowercase) - 1)],
            $numbers[rand(0, strlen($numbers) - 1)],
            $specialCharacters[rand(0, strlen($specialCharacters) - 1)]
        ];

        for ($i = 4; $i < $length; $i++) {
            $password[] = $allCharacters[rand(0, strlen($allCharacters) - 1)];
        }

        shuffle($password);

        return implode('', $password);
    }


    public function changePassword()
    {
        $full_name = CIAuth::fullName();

        $data['full_name'] = $full_name;
        return view('backend/pages/auth/change_password', $data);
    }
    public function updatePassword()
    {
        $session = session();
        $userModel = new User();
    
        $currentPassword = $this->request->getPost('current_password');
        $newPassword = $this->request->getPost('new_password');
        $confirmPassword = $this->request->getPost('confirm_password');
    
        $validationRules = [
            'new_password' => [
                'rules' => 'required|min_length[8]|regex_match[/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[^a-zA-Z0-9]).+$/]',
                'errors' => [
                    'required' => 'New password is required.',
                    'min_length' => 'New password must be at least 8 characters long.',
                    'regex_match' => 'New password must contain at least one uppercase letter, one lowercase letter, one number, and one special character.'
                ]
            ],
            'confirm_password' => [
                'rules' => 'required|matches[new_password]',
                'errors' => [
                    'required' => 'Confirm password is required.',
                    'matches' => 'Confirm password does not match the new password.'
                ]
            ]
        ];
    
        if (!$this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }
    
        $userId = CIAuth::id();
        $user = $userModel->find($userId);
    
        if (is_null($user)) {
            $session->setFlashdata('fail', 'User not found.');
            return redirect()->back();
        } elseif (!isset($user['password'])) {
            $session->setFlashdata('fail', 'Password field not found in user data.');
            return redirect()->back();
        }
    
        if (!password_verify($currentPassword, $user['password'])) {
            $session->setFlashdata('fail', 'Current password is incorrect.');
            return redirect()->back();
        }
    
        $updateData = ['password' => password_hash($newPassword, PASSWORD_DEFAULT)];
        
        if ($user['password_reset_required'] == 0) {
            $updateData['password_reset_required'] = 1;
        }
    
        $userModel->update($userId, $updateData);
    
        $session->setFlashdata('success', 'Password successfully updated.');
        return redirect()->to(base_url('/admin/home'));
    }
    
    public function profile()
    {
        $session = session();
        $userId = CIAuth::id();
        $userType = CIAuth::userType();
        $full_name = 'Unknown';

        if ($userType === 'student') {
            $studentModel = new Students();
            $user = $studentModel->find($userId);
            if (!is_null($user)) {
                $full_name = $user['full_name'] ?? 'Unknown Student';
            }
        } elseif ($userType === 'user') {
            $userModel = new User();
            $user = $userModel->find($userId);
            if (!is_null($user)) {
                $full_name = $user['full_name'] ?? 'Unknown User';
            }
        } elseif ($userType === 'lecturer') {
            $lecturerModel = new User();
            $user = $lecturerModel->find($userId);
            if (!is_null($user)) {
                $full_name = $user['full_name'] ?? 'Unknown Lecturer';
            }
        } else {
            $full_name = 'Guest';
        }

        if (is_null($user)) {
            $session->setFlashdata('fail', 'User not found.');
            return redirect()->to('backend/pages/auth/profile');
        }

        return view('backend/pages/auth/profile', [
            'user' => $user,
            'full_name' => $full_name
        ]);
    }


}

