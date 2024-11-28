<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\RoleModel;

class RolesController extends BaseController
{
    public function index()
    {

        $roleModel = new RoleModel();

        $session = session();
        $userId = $session->get('user_id');

        $userModel = new \App\Models\AdminModel();
        $user = $userModel->find($userId);


        $full_name = $user ? $user['username'] : 'Guest';


        $data = [
            'full_name' => $full_name
        ];


        
        $data['roles'] = $roleModel->findAll();
        return view('admin/pages/roles/index', $data);
    }

    public function create()
    {
        $session = session();
        $userId = $session->get('user_id');

        $userModel = new \App\Models\AdminModel();
        $user = $userModel->find($userId);

        $full_name = $user ? $user['username'] : 'Guest';


        $data = [
            'full_name' => $full_name
        ];

        return view('admin/pages/roles/create',$data);
    }

    public function store()
    {
        $roleModel = new RoleModel();
    
        // Retrieve input with proper field name
        $data = [
            'name' => $this->request->getPost('role_name')  // Ensure this matches the form field name
        ];
    
        // Check if data was received correctly
        if (empty($data['name'])) {
            return redirect()->back()->withInput()->with('error', 'Role name is required.');
        }
    
        // Save role and check for success
        if ($roleModel->save($data)) {
            return redirect()->to('admin/roles')->with('success', 'Role added successfully.');
        } else {
            return redirect()->back()->withInput()->with('error', 'Failed to save role.');
        }
    }
    
    

    public function edit($id)
    {
        $roleModel = new RoleModel();
        $session = session();
        $userId = $session->get('user_id');

        $userModel = new \App\Models\AdminModel();
        $user = $userModel->find($userId);

        $full_name = $user ? $user['username'] : 'Guest';


        $data = [
            'full_name' => $full_name
        ];
        $data['role'] = $roleModel->find($id);
        return view('admin/pages/roles/edit', $data);
    }

    public function update($id)
    {
        $roleModel = new RoleModel();
        
        // Validate input
        $this->validate([
            'role_name' => 'required|min_length[3]|max_length[100]'
        ]);
    
        // Retrieve form data
        $data = [
            'name' => $this->request->getPost('role_name')
        ];
    
        // Attempt to update
        if ($roleModel->update($id, $data)) {
            return redirect()->to('admin/roles')->with('success', 'Role updated successfully');
        } else {
            return redirect()->back()->with('error', 'Failed to update role');
        }
    }
    

    public function delete($id)
    {
        $roleModel = new RoleModel();
        $roleModel->delete($id);
        return redirect()->to('admin/roles');
    }
}