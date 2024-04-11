<?php
class UserController
{
    private $productModel;
    private $orderModel;
    private $orderDetailModel;
    private $dbp;
    private $dbo;
    private $dbd;
    public function __construct()
    {
        $this->dbp = (new Database())->getConnection();
        $this->dbo = (new Database())->getConnection();
        $this->dbd = (new Database())->getConnection();
        $this-> orderModel = new OrderModel($this->dbo);
        $this-> productModel = new ProductModel($this->dbp);
        $this-> orderDetailModel = new OrderDetailModel($this->dbp);
    }
    public function listProducts()
    {
        $products = $this->productModel->readAll();
        include_once 'app/views/user/index.php';
    }
    public function showcart()
    {
        include_once 'app/views/user/cart.php';
    }
    public function home()
    {
        $products = $this->productModel->readAll();
        include_once 'app/views/user/index.php';
    }
    public function checkout()
    {
        include_once 'app/views/user/chekout.php';
    }

}
