<?php
defined('PREVENT_DIRECT_ACCESS') or exit('No direct script access allowed');

class Inventory extends Controller
{

    public function __construct()
    {
        parent::__construct();

        if (!logged_in()) {
            redirect('auth');
        }
    }

    public function index()
    {
        $this->call->view('inventory');
    }
}
?>