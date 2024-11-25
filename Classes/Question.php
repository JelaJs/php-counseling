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

    public function getQuestionsAndUserFromDiscution($discutionId) {
        $stmt = $this->executeQuery("SELECT q.*, u.username, u.profile_image FROM question AS q INNER JOIN user AS u ON u.id = q.user_id WHERE q.discution_id = ?", "i", "$_SERVER[HTTP_REFERER]", $discutionId);
        $result_set = $stmt->get_result();

         if($result_set->num_rows < 1) {
            return false;
        }
        
        $row = $result_set->fetch_all(MYSQLI_ASSOC); 
        $questionUser = ['username' => $row[0]['username'], 'profile_image' => $row[0]['profile_image']];
        $stmt->close();
        
        return [$row, $questionUser];           
    }
}