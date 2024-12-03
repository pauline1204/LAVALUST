<?php
defined('PREVENT_DIRECT_ACCESS') or exit('No direct script access allowed');

// In Product_Model.php
class Product_Model extends Model
{
    public function getAllProducts()
    {
        $this->io->select('*');
        $this->io->from('products');
        $query = $this->io->get();
        return $query->result_array(); // Return as an array
    }

    
}


?>