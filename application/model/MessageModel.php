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
    public static function getAllMessages($otherUserId, $userId)
    {
        $database = DatabaseFactory::getFactory()->getConnection();
        $sql = "SELECT id, sender_id, receiver_id, message, Viewed, timestamp FROM messages WHERE sender_id = $userId AND receiver_id = $otherUserId";
        $query = $database->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    /**
     * Set a message (create a new one)
     * @param int $receiverId id of the receiver
     * @param int $senderId id of the sender
     * @param string $message message that will be created
     * @return bool feedback (was the message created properly ?)
     */
    public static function createMessage($receiverId, $senderId, $message)
    {
        if (!$message || strlen($message) == 0) {
            Session::add('feedback_negative', Text::get('FEEDBACK_MESSAGE_CREATION_FAILED'));
            return false;
        }

        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "INSERT INTO messages (sender_id, receiver_id, message) VALUES (:sender_id, :receiver_id, :message)";
        $query = $database->prepare($sql);
        $query->execute(array(':sender_id' => $senderId, ':receiver_id' => $receiverId, ':message' => $message));

        if ($query->rowCount() == 1) {
            return true;
        }

        // default return
        Session::add('feedback_negative', Text::get('FEEDBACK_MESSAGE_CREATION_FAILED'));
        return false;
    }

}

?>
