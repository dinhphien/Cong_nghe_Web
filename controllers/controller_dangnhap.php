<?php
require_once ("base_controller.php");
require_once ("../models/model_taikhoan.php");
require_once ("../models/model_khachhang.php");
class controller_dangnhap extends base_controller {
    private $modelTK;
    private $modelKH;

    /**
     * controller_dangnhap constructor.
     * @param $modelTK
     * @param $modelKH
     */
    public function __construct()
    {
        $this->modelTK = new Model_Taikhoan();
        $this->modelKH = new Model_Khachhang();
    }
    public function Login(){
        $array= array();
        if(!empty($_POST)){
            $username=$_POST['username'];
            $password=$_POST['password'];
            $taikhoan=$this->modelTK->getTaiKhoan($username,$password);
            if($taikhoan!=null){
                $_SESSION['logged_in']=$taikhoan;
                $array['mesage']='success';
                $array['tentaikhoan']=$taikhoan->getTentaikhoan();
                $array['vaitro']=$taikhoan->getVaitro();
            }
        }else{
            $array['mesage']='failed';
        }
        echo json_encode($array);

    }
    public function Logout(){
        session_destroy();
        echo 'suceess';
    }
    public function Register(){
        if(!empty($_POST)){
            $usr=$_POST['username_register'];
            $psd=$_POST['password_register'];
            $fulname=$_POST['fullname_register'];
            $email=$_POST['email_register'];
            $phone=$_POST['mobilephone_register'];
            $adr=$_POST['address_register'];
            $message=$this->modelTK->insertTaiKhoan($usr,$psd);
            if($message=='true'){
                $lastid=$this->modelTK->getLast_id_inserted();
                $message=$this->modelKH->insertKhachHang($lastid,$fulname,$email,$phone,$adr);
                echo json_encode("true");
            }

        }else{
            echo json_encode("false");
        }
    }


}
?>