<?php
class CartController
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
    public function upQuality($id)
    {
        foreach ($_SESSION['cart'] as &$item) {
            if ($item->id == $id ) {
                $item->quantity ++;
                break;
            }
        }
        header('Location: /chieu2/cart/show');
    }
    public function downQuality($id)
    {
        foreach ($_SESSION['cart'] as &$item) {
            if ($item->id == $id &&  $item->quantity>1) {
                $item->quantity --;
                break;
            }
        }
        header('Location: /chieu2/cart/show');
    }


    public function delete($id)
    {
        foreach ($_SESSION['cart'] as $key => $item) {
            if ($item->id == $id) {
                unset($_SESSION['cart'][$key]);
                break; 
            }
        }
        header('Location: /chieu2/cart/show');
    }

    public function Add($id)
    {
        // Khởi tạo một phiên cart nếu chưa tồn tại
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        // Lấy sản phẩm từ ProductModel bằng $id
        $product = $this->productModel->getProductById($id);

        // Nếu sản phẩm tồn tại, thêm vào giỏ hàng
        if ($product) {
            // Kiểm tra xem sản phẩm đã tồn tại trong giỏ hàng chưa
            $productExist = false;
            foreach ($_SESSION['cart'] as &$item) {
                if ($item->id == $id) {
                    $item->quantity++;
                    $productExist = true;
                    break;
                }
            }

            // Nếu sản phẩm chưa tồn tại trong giỏ hàng, thêm mới vào
            if (!$productExist) {
                $product->quantity = 1;
                $_SESSION['cart'][] = $product;
            }

            header('Location: /chieu2/cart/show');
        } else {
            echo "Không tìm thấy sản phẩm với ID này!";
        }
    }

   

    public function process_order()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $hoTen = $_POST['hoTen'] ?? '';
            $dienThoai = $_POST['dienThoai'] ?? '';
            $email = $_POST['email'] ?? '';
            $diachi = $_POST['diachi'] ?? '';
            $ghichu = $_POST['ghichu'] ?? '';
            $phuongThucThanhToan = $_POST['phuongThucThanhToan'] ?? '';
          
            if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
                echo "Giỏ hàng trống!";
            } else {
                $result = $this->orderModel->createOrder($hoTen, $dienThoai, $email, $diachi, $ghichu, $phuongThucThanhToan);
                foreach ($_SESSION['cart'] as $item) {
                    $orderID=$result;
                    $productID = $item->id;
                    $soLuong = $item->quantity;
                    $giaTien = $item->price;
                    $thanhTien = intval($soLuong) * floatval($giaTien);
                    $a = $this->orderDetailModel->createDetailOrder( $orderID,$productID, $soLuong, $giaTien, $thanhTien);   
                }
            }
            if ($result !== false) {
          
                $_SESSION['order_details'] = $this->getOrderDetails($orderID);
                unset($_SESSION['cart']);
                header('Location: /chieu2/cart/confirm');
                exit(); 
            } else {
                $errors = $result;
                include 'app/views/cart/index.php'; 
                exit(); 
            }
        }
    }

    private function getOrderDetails($orderId)
    {
        $sql = "SELECT p.name, od.soLuong, p.price
        FROM orderdetails od
        JOIN products p ON od.productID = p.id
        WHERE od.orderID = ?;";
        $stmt = $this->dbp->prepare($sql); 
        $stmt->execute([$orderId]);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
    
     
    function order(){
        include_once 'app/views/cart/order.php';
    }
    function show()
    {
        include_once 'app/views/cart/index.php';
        
    }
    public function confirm()
    {
        include_once 'app/views/cart/confirm.php';
    }

    function checkout(){
        if(!Auth::isLoggedIn()){
            echo "<script>alert('Xin lỗi, bạn chưa đăng nhập');</script>";
            header('Location: /chieu2/account/login');
            exit(); 
        } else {
            header('Location: /chieu2/cart/order');
            exit(); 
        }
    }
  
}
