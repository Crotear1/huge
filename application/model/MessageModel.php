<?php
class MessageModel
{
    /**
     * Get all the users, except the one with the given user_id
     * @param int $userId
     * @return array an array with several objects (the results)
    */
    public static function getAllUsers($userId)
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "SELECT user_id, user_name FROM users WHERE user_id != $userId";
        $query = $database->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

     /**
      * Get all the messages
      * @return array an array with several objects (the results)
      */
    public static function getAllMessages($userId)
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "SELECT message_id, user_id, message_text, message_image, message_created_at FROM messages WHERE user_id = $userId";
        $query = $database->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    /**
     * Set a message as read
     * @param int $message_id id of the specific message
     * @return bool feedback (was the message marked as read?)
     */
    public static function createMessage($message_text)
    {
        if (!$message_text || strlen($message_text) == 0) {
            Session::add('feedback_negative', Text::get('FEEDBACK_MESSAGE_CREATION_FAILED'));
            return false;
        }

        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "INSERT INTO messages (message_text, message_image, message_created_at, user_id) VALUES (:message_text, :message_image, :message_created_at, :user_id)";
        $query = $database->prepare($sql);
        $query->execute(array(':message_text' => $message_text, ':message_image' => '', ':message_created_at' => time(), ':user_id' => Session::get('user_id')));

        if ($query->rowCount() == 1) {
            Session::add('feedback_positive', Text::get('FEEDBACK_MESSAGE_CREATION_SUCCESSFUL'));
            return true;
        }

        // default return
        Session::add('feedback_negative', Text::get('FEEDBACK_MESSAGE_CREATION_FAILED'));
        return false;
    }

}

?>
