<?php
require_once("connect_db.php");
    class model_cart{
        private $db;
        private $userID;
        public function __construct($userID){
            $this->db = new Database();
            $this->userID = $userID;
        }

        public function get_All_cart(){
            $connect = $this->db->connect_db();
            if($connect){
                $query = "SELECT c.IDSanPham, p.TenSP, p.DonGia , p.IMG , c.SoLuong FROM `giohang` as c left JOIN khachhang as a on c.IDKhachHang = a.IDKhachHang left JOIN sanpham as p on c.IDSanPham = p.IDSanPham WHERE a.IDKhachHang = '".$this->userID."'";
                $stmt = $connect ->prepare($query);
                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                if($result){
                    $this->db->disconnect_db($connect);
                    return $result;
                }else{
                    $this->db->disconnect_db($connect);
                    return false;
                }
            }
           

        }

        public function AddtoCart($IDSanPham){
            $connect = $this->db->connect_db();
            if($connect){
            //Kiểm tra bản ghi đã tồn tại
            $Search_query = "SELECT * FROM giohang WHERE IDKhachHang = $this->userID AND IDSanPham = $IDSanPham";
            $Search_result = $connect->query($Search_query);
                if($Search_result->rowCount() >0){
                    $query = "UPDATE giohang SET SoLuong = SoLuong + 1 WHERE IDKhachHang = $this->userID AND IDSanPham = $IDSanPham";
                    $stmt = $connect ->prepare($query);
                    $result= $stmt->execute();
                    if($result){
                        $this->db->disconnect_db($connect);
                        return $result;
                    }else{
                        $this->db->disconnect_db($connect);
                        return false;
                    }
                }else{
                    $query = "insert into giohang values(".$this->userID.",$IDSanPham , 1)";
                    $stmt = $connect ->prepare($query);
                    $result= $stmt->execute();
                    if($result){
                        $this->db->disconnect_db($connect);
                        return $result;
                    }else{
                        $this->db->disconnect_db($connect);
                        return false;
                    }
                }
                
            }
           

        }

        public function PlusCart($IDSanPham,$IDKhachHang){
            $connect = $this->db->connect_db();
            if($connect){
                $query = "update giohang set SoLuong = SoLuong + 1 where IDKhachHang = $IDKhachHang and IDSanPham = $IDSanPham";
                $stmt = $connect ->prepare($query);
                $result= $stmt->execute();
                if($result){
                    $this->db->disconnect_db($connect);
                    return $result;
                }else{
                    $this->db->disconnect_db($connect);
                    return false;
                }
            }
           

        }

        public function MinusCart($IDSanPham,$IDKhachHang){
            $connect = $this->db->connect_db();
            if($connect){
                $query = "update giohang set SoLuong = SoLuong - 1 where IDKhachHang = $IDKhachHang and IDSanPham = $IDSanPham";
                $stmt = $connect ->prepare($query);
                $result= $stmt->execute();
                if($result){
                    $this->db->disconnect_db($connect);
                    return $result;
                }else{
                    $this->db->disconnect_db($connect);
                    return false;
                }
            }
           

        }
    }