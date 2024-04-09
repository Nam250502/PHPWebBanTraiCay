<?php
class OrderDetailModel {
    private $conn;
    private $table_name = "orderdetails";
    private $table_nameP = "products";

    public function __construct($db) {
        $this->conn = $db;
    }

    function readAll() {
        $query = "SELECT od.orderDetailID, p.name, p.price FROM " . $this->table_name . " od, " . $this->table_nameP . " p WHERE od.productID = p.id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    
    function createDetailOrder($orderID, $productID, $soLuong, $donGia, $thanhTien)
    {
        $query = "INSERT INTO " . $this->table_name . " (orderID, productID, soLuong, donGia, thanhTien) VALUES (:orderID, :productID, :soLuong, :donGia, :thanhTien)";
        $stmt = $this->conn->prepare($query);

        $orderID = htmlspecialchars(strip_tags($orderID));
        $productID = htmlspecialchars(strip_tags($productID));
        $soLuong = htmlspecialchars(strip_tags($soLuong));
        $donGia = htmlspecialchars(strip_tags($donGia));
        $thanhTien = htmlspecialchars(strip_tags($thanhTien));
        $stmt->bindParam(':orderID', $orderID);
        $stmt->bindParam(':productID', $productID);
        $stmt->bindParam(':soLuong', $soLuong);
        $stmt->bindParam(':donGia', $donGia);
        $stmt->bindParam(':thanhTien', $thanhTien);
        if ($stmt->execute()) {
            return $this->conn->lastInsertId();
        }
    
        return false;
    }
    
    

    
}