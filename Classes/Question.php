<?php
require_once "Database.php";

class Question extends Database{

    public function __construct() {

        parent::__construct();
    }

    public function createQuestion($userId, $discutionId, $question) {
        $stmt = $this->executeQuery("INSERT INTO question (user_id, question, discution_id) VALUES (?, ?, ?)", "isi", "$_SERVER[HTTP_REFERER]", $userId, $question, $discutionId);

        $stmt->close();
        return true;
    }

    public function getQuestionsFromDiscution($discutionId) {
        $stmt = $this->executeQuery("SELECT * FROM question WHERE discution_id = ?", "i", "$_SERVER[HTTP_REFERER]", $discutionId);

        $result_set = $stmt->get_result();

         if($result_set->num_rows < 1) {
            return false;
        }
        
        $row = $result_set->fetch_all(MYSQLI_ASSOC); 
        $questionUser = $this->getQuestionUser($row[0]['user_id']);
        $stmt->close();

        return [$row, $questionUser];           
    }

   public function getQuestionUser($userId) {
        $stmt = $this->executeQuery("SELECT username, profile_image FROM user WHERE id = ?", "i", "$_SERVER[HTTP_REFERER]", $userId);

        $result_set = $stmt->get_result();

        if($result_set->num_rows < 1) {
            return false;
        }
    
        $row = $result_set->fetch_assoc(); 
        $stmt->close();

        return $row;
    }
}