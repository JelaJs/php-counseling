<?php
require_once "../Classes/Database.php";

class User extends Database{

    private $profileImgName;
    private $profileImgType;
    private $profileImgFullPath;
    private $profileImgTmpName;
    private $profileImgError;
    private $profileImgSize;
    private $profileImgExt;
    private $allowedExt = ['jpg', 'jpeg', 'png', 'webp'];
    private $profileImgUploadName;

    public function __construct() {

        parent::__construct();
    }

    public function setProfileImgInfo($file) {

        $this->profileImgName = $file['name'];
        $this->profileImgType = $file['type']; 
        $this->profileImgFullPath = $file['full_path'];
        $this->profileImgTmpName = $file['tmp_name']; 
        $this->profileImgError = $file['error'];
        $this->profileImgSize = $file['size'];
        
        $this->profileImgExt = explode('.', $this->profileImgName);
        $this->profileImgExt = strtolower(end($this->profileImgExt));
    }

    public function isExtensionAllowed() {
        return in_array($this->profileImgExt, $this->allowedExt);
    }

    public function errorExist() {
        return $this->profileImgError;
    }

    public function isImageSizeCorrect() {
        return $this->profileImgSize < 1000000;
    }

    private function setProfileimgUploadName() {
        $this->profileImgUploadName = $this->profileImgName . "_" . $_SESSION['user_id'] . "." . $this->profileImgExt;
    }

    public function uploadImage($file) {
  
        $this->setProfileimgUploadName();
        $filenameDestionation = '../uploads/'.$this->profileImgUploadName;
        move_uploaded_file($this->profileImgTmpName, $filenameDestionation);

        $filenameDestionationFromIndex = 'uploads/'.$this->profileImgUploadName;
        $this->updateProfileImage($filenameDestionationFromIndex);
        header("Location: ../index.php");
    }

    private function updateProfileImage($filenameDestination) {
        $stmt = $this->executeQuery("UPDATE user SET profile_image = ? WHERE id = ?", "si", "../index.php", $filenameDestination, $_SESSION['user_id']);
        
        $stmt->close();
        $this->getProfileImgFromDB();
    }

    private function getProfileImgFromDB() {
        $stmt = $this->executeQuery("SELECT profile_image FROM user WHERE id = ?", "i", "../index.php", $_SESSION['user_id']);

        $result_set = $stmt->get_result();

        if($result_set->num_rows < 1) {
            $_SESSION['profile_image'] = "";
        }
                
        $row = $result_set->fetch_assoc(); 
        $_SESSION['profile_image'] = $row['profile_image'];
                
        $stmt->close();
    }
}