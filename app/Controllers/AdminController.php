<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AdminModel;
use CodeIgniter\HTTP\ResponseInterface;
use App\Libraries\CIAuth;
use App\Models\Tickets;
use App\Models\Subcategory;
use App\Models\Replies;
use App\Models\UserModel;
use App\Models\RoleModel;
use App\Models\Categories;

use \Mberecall\CI_Slugify\SlugService;
use SSP;


class AdminController extends BaseController
{
    protected $helpers = ['url', 'form', 'CIMail', 'CIFunctions'];
    protected $db;
    public function __construct()
    {
        //require_once APPPATH . 'ThirdParty/ssp.php';
        $this->db = db_connect();
    }

    public function forgotPassword()
    {
        $usermodel = new UserModel();

    }
    public function default(){
        
        return redirect()->to(base_url('/admin/login'));
    }
    
    public function index()
{
    $data['full_name'] = getLoggedInUserName();
    $session = session();
    $userId = $session->get('user_id');
    $userRole = $session->get('role');
    if (!$userId || $userRole != 'admin') {
        return redirect()->to('/admin/login');
    }
    
    return view('admin/pages/home', $data);
}

  
   public function logoutHandler()
{
    CIAuth::forget();
    return redirect()->to(base_url('admin/login'))->with('fail', 'You are logged out');
}



public function getAdmin()
{
    $data['full_name'] = getLoggedInUserName();

    $roleModel = new RoleModel();
    $data['roles'] = $roleModel->findAll();

    $userModel = new AdminModel();
    $data['users'] = $userModel
        ->select('admins.*, roles.name as role_name')
        ->join('roles', 'admins.role = roles.id', 'left')
        ->findAll();

    return view('admin/pages/users', $data);
}



    public function create()
    {
        $roleModel = new RoleModel();
        $roles = $roleModel->findAll();

        $data = [
            'pageTitle' => 'Add User',
        ];
        $data['full_name'] = getLoggedInUserName();
        $data['roles'] = $roles;

        return view('admin/pages/users/create', $data);
    }

    public function store()
{
    $userModel = new AdminModel();

    $rawPassword = bin2hex(random_bytes(4));
    $hashedPassword = password_hash($rawPassword, PASSWORD_DEFAULT);

    $data = [
        'username' => $this->request->getPost('name'),
        'email' => $this->request->getPost('email'),
        'role' => $this->request->getPost('role_id'),
        'password' => $hashedPassword 
    ];
    log_message('debug', 'User data to be inserted: ' . json_encode($data));
    if ($userModel->insert($data) === false) {
        log_message('error', 'User insertion failed: ' . json_encode($userModel->errors()));
        return redirect()->back()->withInput()->with('errors', $userModel->errors());
    } else {
        log_message('debug', 'User inserted successfully with ID: ' . $userModel->insertID());
        $this->sendPasswordEmail($data['email'], $rawPassword);
    }

    return redirect()->to(base_url('admin/users'));
}
protected function sendPasswordEmail($email, $password)
{
    $emailService = \Config\Services::email();
    $emailService->setTo($email);
    $emailService->setFrom('faith.chepngetich@zetech.ac.ke', 'Admin');
    $emailService->setSubject('Your Account Password');
    $emailService->setMessage("Welcome! Your account has been created. Here is your password: $password");

    if ($emailService->send()) {
        log_message('debug', 'Password email sent successfully to ' . $email);
    } else {
        log_message('error', 'Failed to send password email: ' . $emailService->printDebugger(['headers']));
    }
}


public function edit($id)
{
    $userModel = new AdminModel();
    $user = $userModel->find($id);

    if (!$user) {
        log_message('error', "User with ID {$id} not found.");

        return redirect()->to(base_url('admin/users'))->with('error', 'User not found');
    }

    $rolesModel = new RoleModel();
    $roles = $rolesModel->findAll();
    $full_name= getLoggedInUserName();
    $data = [
        'user' => $user,
        'roles' => $roles,
        'full_name' => $full_name
    ];

    return view('admin/pages/users/edit', $data);
}


public function update($id)
{
    $userModel = new AdminModel();
    $user = $userModel->find($id);
    
    if (!$user) {
        return redirect()->to(base_url('admin/users'))->with('error', 'User not found');
    }

    $validation = \Config\Services::validation();
    $validation->setRules([
        'name'     => 'required',
        'email'    => 'required|valid_email',
        'role_id'  => 'required|integer'
    ]);

    if (!$validation->withRequest($this->request)->run()) {
        log_message('warning', 'Validation errors: ' . json_encode($validation->getErrors()));
        return redirect()->back()->withInput()->with('errors', $validation->getErrors());
    }

    $data = [
        'username' => $this->request->getPost('name'),
        'email'    => $this->request->getPost('email'),
        'role'  => $this->request->getPost('role_id') 
    ];

    if ($userModel->update($id, $data)) {
        return redirect()->to(base_url('admin/users'))->with('success', 'User updated successfully');
    } else {
        return redirect()->back()->withInput()->with('error', 'Failed to update user');
    }
}



public function delete($id)
{
    $userModel = new AdminModel(); 

    if ($userModel->delete($id)) {
        return redirect()->to(base_url('admin/users'))->with('success', 'User deleted successfully');
    } else {
        return redirect()->to(base_url('admin/users'))->with('error', 'Failed to delete user');
    }
}

    public function roleName($roleId)
    {
        $roleModel = new RoleModel();

        $roleName = $roleModel->getRoleNameById($roleId);

        return $this->response->setJSON(['name' => $roleName]);
    }

    public function changePassword()
    {
        $data = [];
    
        if (session()->getFlashdata('validation')) {
            $data['validation'] = session()->getFlashdata('validation');
        }
        $data['full_name'] = getLoggedInUserName();

        return view('admin/pages/auth/change_password', $data);
    }
//  public function updatePassword()
// {
//     $session = session();
//     $userModel = new AdminModel();

//     $currentPassword = $this->request->getPost('current_password');
//     $newPassword = $this->request->getPost('new_password');
//     $confirmPassword = $this->request->getPost('confirm_password');

//     // Password validation rules
//     $validationRules = [
//         'new_password' => [
//             'rules' => 'required|min_length[8]|regex_match[/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[^a-zA-Z0-9]).+$/]',
//             'errors' => [
//                 'required' => 'New password is required.',
//                 'min_length' => 'New password must be at least 8 characters long.',
//                 'regex_match' => 'New password must contain at least one uppercase letter, one lowercase letter, one number, and one special character.'
//             ]
//         ],
//         'confirm_password' => [
//             'rules' => 'required|matches[new_password]',
//             'errors' => [
//                 'required' => 'Confirm password is required.',
//                 'matches' => 'Confirm password does not match the new password.'
//             ]
//         ]
//     ];

//     if (!$this->validate($validationRules)) {
//         return redirect()->back()->withInput()->with('validation', $this->validator);
//     }

//     $userId = $session->get('user_id');
//     $user = $userModel->find($userId);

//     if (is_null($user)) {
//         $session->setFlashdata('fail', 'User not found.');
//         return redirect()->back();
//     } elseif (!isset($user['password'])) {
//         $session->setFlashdata('fail', 'Password field not found in user data.');
//         return redirect()->back();
//     }

//     if (!password_verify($currentPassword, $user['password'])) {
//         $session->setFlashdata('fail', 'Current password is incorrect.');
//         return redirect()->back();
//     }

//     $userModel->update($userId, ['password' => password_hash($newPassword, PASSWORD_DEFAULT), 'password_reset_required' => 0]);

//     $session->setFlashdata('success', 'Password successfully updated.');
//     return redirect()->to(base_url('/admin'));
// }


public function updatePassword()
{
    $session = session();
    $userModel = new AdminModel();

    $currentPassword = $this->request->getPost('current_password');
    $newPassword = $this->request->getPost('new_password');
    $confirmPassword = $this->request->getPost('confirm_password');

    // Validation rules
    $validation = \Config\Services::validation();
    $validation->setRules([
        'current_password' => 'required',
        'new_password' => [
            'rules' => 'required|min_length[8]|regex_match[/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[^a-zA-Z0-9]).+$/]',
            'errors' => [
                'min_length' => 'Password must be at least 8 characters long.',
                'regex_match' => 'Password must include an uppercase letter, lowercase letter, number, and special character.',
            ]
        ],
        'confirm_password' => [
            'rules' => 'required|matches[new_password]',
            'errors' => [
                'matches' => 'Passwords do not match.',
            ]
        ],
    ]);

    // if (!$validation->withRequest($this->request)->run()) {
    //     // Validation failed
    //     return redirect()->back()->withInput()->with('validation', $validation);
    // }
    if (!$validation->withRequest($this->request)->run()) {
        $session->setFlashdata('validation', $validation);
        return redirect()->back()->withInput();
    }
    

    $userId = $session->get('user_id');
    $user = $userModel->find($userId);

    if (!$user || !isset($user['password'])) {
        $session->setFlashdata('fail', 'User not found or invalid user data.');
        return redirect()->back()->withInput();
    }

    if (!password_verify($currentPassword, $user['password'])) {
        // Current password is incorrect
        $session->setFlashdata('fail', 'Current password is incorrect.');
        return redirect()->back()->withInput();
    }

    // Update password in database
    $userModel->update($userId, [
        'password' => password_hash($newPassword, PASSWORD_DEFAULT),
        'password_reset_required' => 0
    ]);

    $session->setFlashdata('success', 'Password successfully updated.');
    return redirect()->to(base_url('/admin'));
}



public function profile()
    {
        $session = session();
        $userModel = new User();
        $full_name = CIAuth::fullName();
        $userId = $session->get('user_id');

        $user = $userModel->find($userId);

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