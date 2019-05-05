<?php
require_once 'app/controllers/product.php';

class Pretzels extends Controller
{
    public function index()
    {
        $obj = new Product();
        $catalog = $obj->getProductCatalog('pretzel');
        $data['catalog']=$catalog;
        $data['username']=$this->getUsername();
        $this->view('Pretzels/index', $data);
    }
}