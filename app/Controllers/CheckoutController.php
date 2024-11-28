<?php



namespace App\Controllers;



use App\Controllers\BaseController;

use CodeIgniter\HTTP\ResponseInterface;

use App\Libraries\CIAuth;

use App\Models\UserModel;

use App\Models\OrderModel;





class CheckoutController extends BaseController

{



    public function startCheckout()

    {

        $cart = \Config\Services::cart();

    

        if ($cart->totalItems() == 0) {

            return redirect()->to('/cart')->with('error', 'Your cart is empty.');

        }

    

        $cartItems = $cart->contents();

    

        if (!session()->has('logged_in') || !session()->get('logged_in')) {

                        session()->set('redirect_url', current_url());



            return redirect()->to('/login')->with('error', 'Please log in to proceed.');

        }



        

    

        $userId = session()->get('user_id');

    

        $userModel = new UserModel();

        $user = $userModel->find($userId);

    



        if (!$user) {

            return redirect()->to('/login')->with('error', 'User not found. Please log in.');

        }

    

            

            // Fetch user data

            $userModel = new UserModel();

            $userData = $userModel->find($userId);

        



        $data = [

            'cartItems' => $cartItems,

            'total' => $cart->total(),

            'user' => $user,

            'userData' => $userData, 

            'counties' => $this->getCounties(), 

        ];

    

        return view('backend/pages/checkout/checkout', $data);

    }

    

  

    private function getCounties()

    {

        return [

            'BARINGO' => 'Baringo County',

            'BOMET' => 'Bomet County',

            'BUNGOMA' => 'Bungoma County',

            'BUSIA' => 'Busia County',

            'ELGEYO-MARAKWET' => 'Elgeyo-Marakwet County',

            // ... (other counties)

            'WEST POKOT' => 'West Pokot County',

        ];

    }

    

    

    public function saveUserDetails()

{

    $request = \Config\Services::request();

    $db = \Config\Database::connect();

    

    $userData = [

        'username' => $request->getPost('full_name'),

        'phone' => $request->getPost('phone'),

        'additionalPhone' => $request->getPost('additional_phone'),

        'address1' => $request->getPost('address'),

        'address2' => $request->getPost('address2'),

        'region' => $request->getPost('region'),

    ];



    $builder = $db->table('users');

    

    $userId = session()->get('user_id');

    if ($userId) {

        $builder->where('id', $userId)->update($userData);

    } else {

        $builder->insert($userData);

       

        session()->set('user_id', $db->insertID());

    }





    return redirect()->to(base_url().'/checkout');

}

  
   public function saveBillingDetails()
    {
        $request = $this->request;

        // Retrieve billing details from the POST request
        $billingAddress = $request->getPost('billing_address');
        $billingPhone = $request->getPost('billing_phone');

        // Validation (optional but recommended)
        if (!$this->validate([
            'billing_address' => 'required|max_length[255]',
            'billing_phone' => 'required|max_length[15]',
        ])) {
            return redirect()->back()->with('error', 'Please fill in all required fields correctly.');
        }

        // Save or update the billing details in the database
        $userId = session()->get('user_id'); // Assuming the user is logged in
        $userModel = new UserModel();
        $userModel->update($userId, [
            'billing_address' => $billingAddress,
            'billing_phone' => $billingPhone,
        ]);

        // Redirect to the next tab or return a success response
        return redirect()->to('/checkout')->with('success', 'Billing details saved successfully.');
    }




}



