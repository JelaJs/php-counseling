<?php
require_once "Database.php";

class User extends Database{

    private $file;
    private $profileImgName;
    private $profileImgType;
    private $profileImgFullPath;
    private $profileImgTmpName;
    private $profileImgError;
    private $profileImgSize;
    private $profileImgExt;
    private $allowedExt = ['jpg', 'jpeg', 'png'];
    private $profileImgUploadName;

    public function __construct($file) {
        $this->file = $file; 

        parent::__construct();
    }

    private function setProfileImgInfo() {
        $this->startSession();

        if($this->file['name'] == '') {
            $_SESSION['file_error'] = "You need to add image";
            header("Location: index.php");
            die();
        }

        $this->profileImgName = $this->file['name'];
        $this->profileImgType = $this->file['type']; 
        $this->profileImgFullPath = $this->file['full_path'];
        $this->profileImgTmpName = $this->file['tmp_name']; 
        $this->profileImgError = $this->file['error'];
        $this->profileImgSize = $this->file['size'];
        
        $this->profileImgExt = explode('.', $this->profileImgName);
        $this->profileImgExt = strtolower(end($this->profileImgExt));
    }

    private function isExtensionAllowed() {
        if(in_array($this->profileImgExt, $this->allowedExt)) {
            return true;
        } else {
            return false;
        }
    }

    public function errorExist() {
        if($this->profileImgError) {
            return true;
        } else {
            return false;
        }
    }

    public function isImageSizeCorrect() {
        if($this->profileImgSize < 1000000) {
            return true;
        } else {
            return false;
        }
    }

    private function setProfileimgUploadName() {
        $this->profileImgUploadName = $this->profileImgName . "_" . $_SESSION['user_id'] . "." . $this->profileImgExt;
    }

    public function uploadImage() {
        $this->setProfileImgInfo();

        if($this->isExtensionAllowed()) {
            if(!$this->errorExist()) {
                if($this->isImageSizeCorrect()) {
                    $this->setProfileimgUploadName();
                    $filenameDestionation = 'uploads/'.$this->profileImgUploadName;
                    move_uploaded_file($this->profileImgTmpName, $filenameDestionation);
                    $this->updateProfileImage($filenameDestionation);
                    header("Location: index.php");
                } else {
                    $_SESSION['file_error'] = "Your image is too big";
                    header("Location: index.php");
                    die();
                }
            } else {
                $_SESSION['file_error'] = "There was an error uploading your image";
                header("Location: index.php");
                die();
            }
        }else {
            $_SESSION['file_error'] = "You can't upload a file with this extension";
            header("Location: index.php");
            die();
        }
    }

    private function updateProfileImage($filenameDestination) {
        $query = "UPDATE user SET profile_image = ? WHERE id = ?";
        
        $stmt = $this->connection->prepare($query);
        
        if ($stmt) {
            $stmt->bind_param('si', $filenameDestination, $_SESSION['user_id']);
            
            $result = $stmt->execute();
            
            if ($result) {
                $this->getProfileImgFromDB();
            } else {
                $_SESSION['query_error'] = "Error updating profile image: " . $stmt->error;
                header("Location: index.php");
                die();
            }
            
            $stmt->close();
        } else {
            $this->startSession();
            $_SESSION['query_error'] = "Error preparing query: " . $this->connection->error;
            header("Location: index.php");
            die();
        }
    }

    private function getProfileImgFromDB() {
        $query = "SELECT profile_image FROM user WHERE id = ?";

        $stmt = $this->connection->prepare($query);

        if($stmt) {
            $stmt->bind_param('i', $_SESSION['user_id']);

            $result = $stmt->execute();

            if($result) {
                $result_set = $stmt->get_result();
    
                if ($result_set->num_rows > 0) {
                    $row = $result_set->fetch_assoc(); 
                    $_SESSION['profile_image'] = $row['profile_image'];
                } else {
                    $_SESSION['profile_image'] = "";
                }
            } else {
                $_SESSION['query_error'] = "Error executing query: " . $stmt->error;
                return;
            }

            $stmt->close();
        } else {
            $_SESSION['query_error'] = "Error preparing statement: " . $this->connection->error;
            return;
        }
    }

    /*public function getProfileImgData() {
        $data = [
            'name' =>  $this->profileImgName,
            'type' => $this->profileImgType,
            'fullPath' => $this->profileImgFullPath,
            'tmpName' => $this->profileImgTmpName,
            'error' => $this->profileImgError,
            'size' => $this->profileImgSize,
            'ext' => $this->profileImgExt
        ];

        return $data;
    }*/
}