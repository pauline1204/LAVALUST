<?php
defined('PREVENT_DIRECT_ACCESS') or exit('No direct script access allowed');

// In Products_Controller.php
class Product_Controller extends Controller
{
    public function __construct()
    {
        parent::__construct();

        if (!logged_in()) {
            redirect('auth');
        }

        // Load the product model
        $this->call->model('Product_Model');
    }

    public function index()
    {
        // Get all products
        $products = $this->db->table('products')->get_all();

        // Pass products data to the view
        $this->call->view('pages/products/productslayout', ['products' => $products]);
    }

    // Function to handle adding a new product
    public function addProduct()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Get the form data
            $name = $_POST['name'];
            $price = $_POST['price'];
            $stock = $_POST['stock'];

            // Perform form validation (optional)
            if (empty($name) || empty($price) || empty($stock)) {
                // Handle validation error (you can add messages to display)
                $this->call->view('pages/products/addProduct', ['error' => 'All fields are required']);
                return;
            }

            // Insert the new product into the database
            $this->db->table('products')->insert([
                'name' => $name,
                'price' => $price,
                'stock' => $stock
            ]);

            // Redirect to the product list after adding the product
            redirect('products');
        }

        // Show the form to add a new product (GET request)
        $this->call->view('pages/products/productslayout');
    }

    public function editProduct()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Get form data
            $id = $_POST['id'];
            $name = $_POST['name'];
            $price = $_POST['price'];
            $stock = $_POST['stock'];
    
            // Perform validation (optional)
            if (empty($id) || empty($name) || empty($price) || empty($stock)) {
                $this->call->view('pages/products/productslayout', ['error' => 'All fields are required']);
                return;
            }
    
            // Update the product in the database
            $this->db->table('products')->where('id', $id)->update([
                'name' => $name,
                'price' => $price,
                'stock' => $stock,
            ]);
    
            // Redirect to the product list after editing
            redirect('products');
        }
    }
    
    

}
