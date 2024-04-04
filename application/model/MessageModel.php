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

        $sql = "CALL GetAllUsers(?)";
        $query = $database->prepare($sql);
        $query->bindParam(1, $userId, PDO::PARAM_INT);
        $query->execute();
        return $query->fetchAll();
    }

    /**
     * Get foreach user the amount of unread messages
     */
    public static function getUnreadMessages($userId)
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "CALL GetUnreadMessages(?)";
        $query = $database->prepare($sql);
        $query->bindParam(1, $userId, PDO::PARAM_INT);
        $query->execute();
        return $query->fetchAll();
    }

     /**
      * Get all the messages & set them to viewed
        * @param int $otherUserId id of the other user
        * @param int $userId id of the user
      * @return array an array with several objects (the results)
      */
    public static function getAllMessages($otherUserId, $userId)
    {
        $database = DatabaseFactory::getFactory()->getConnection();
        $sql = "SELECT id, sender_id, receiver_id, message, Viewed, timestamp FROM messages WHERE sender_id = $userId AND receiver_id = $otherUserId";
        $query = $database->prepare($sql);
        $query->execute();
        $chat1 = $query->fetchAll();

        $sql = "SELECT id, sender_id, receiver_id, message, Viewed, timestamp FROM messages WHERE sender_id = $otherUserId AND receiver_id = $userId";
        $query = $database->prepare($sql);
        $query->execute();
        $chat2 = $query->fetchAll();

        $chat = array_merge($chat1, $chat2);

        // Sort the chat by timestamp
        usort($chat, function($a, $b) {
            return $a->timestamp <=> $b->timestamp;
        });

        $sql = "UPDATE messages SET Viewed = 1 WHERE sender_id = $otherUserId AND receiver_id = $userId";
        $query = $database->prepare($sql);
        $query->execute();

        return $chat;
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

        $sql = "CALL CreateMessage(?, ?, ?)";
        $query = $database->prepare($sql);
        $query->bindParam(1, $senderId, PDO::PARAM_INT);
        $query->bindParam(2, $receiverId, PDO::PARAM_INT);
        $query->bindParam(3, $message, PDO::PARAM_STR);
        $query->execute();

        if ($query->rowCount() == 1) {
            return true;
        }

        // default return
        Session::add('feedback_negative', Text::get('FEEDBACK_MESSAGE_CREATION_FAILED'));
        return false;
    }

}
