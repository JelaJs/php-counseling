<?php
require_once "Main.php";

class Answer extends Main{

    public function __construct() {

        parent::__construct();
    }

    public function createAnswer($discutionId, $answer) {
        $stmt = $this->executeQuery("INSERT INTO answer (discution_id, user_id, answer) VALUES (?, ?, ?)", "iis", "$_SERVER[HTTP_REFERER]", $discutionId, $_SESSION['user_id'], $answer);
        
        $stmt->close();
        $this->updateDiscutionState($discutionId, $this->connection);
    }

    private function updateDiscutionState($discutionId) {
        $stmt = $this->executeQuery("UPDATE discution SET have_answer = 1, advisor_id = ? WHERE id = ?", "ii", "$_SERVER[HTTP_REFERER]", $_SESSION['user_id'], $discutionId);
        
        header('Location: ' . $_SERVER['HTTP_REFERER']);    
        $stmt->close();
    }

    public function getAnswersFromDiscution($discutionId) {
        $stmt = $this->executeQuery("SELECT a.*, u.username, u.profile_image FROM answer AS a INNER JOIN user AS u ON u.id = a.user_id WHERE a.discution_id = ?", "i", "$_SERVER[HTTP_REFERER]", $discutionId);

        $result_set = $stmt->get_result();

        if($result_set->num_rows < 1) {
            return false;
        }
    
        $row = $result_set->fetch_all(MYSQLI_ASSOC); 
        $answerUser = ['username' => $row[0]['username'], 'profile_image' => $row[0]['profile_image']];
        $stmt->close();
        
        return [$row, $answerUser];
    }
}