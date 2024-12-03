<?php
defined('PREVENT_DIRECT_ACCESS') or exit('No direct script access allowed');

class Home extends Controller
{

    public function __construct()
    {
        parent::__construct();

        if (!logged_in()) {
            redirect('auth');
        }
        $this->call->model('Product_Model');
    }

    public function dashboard()
    {
        // Fetch all users
        $products = $this->db->table('products')->get_all();

        // Get the count of products (length of the result array)
        $productCount = count($products);

        // Pass the user count to the view
        $this->call->view('pages/dashboard/dashboardlayout', ['productCount' => $productCount]);
    }




}

?>