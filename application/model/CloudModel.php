<?php

/**
 * CloudController
 * Controls everything that is user-related
 */
class CloudModel
{
  /**
   * Create a folder for the user
   * @param int $userId
   * @return void
   */
  public static function createUserFolder($userId)
  {
      // Get the base path
      $basePath = Config::get('PATH_USER_FOLDER');

      // Append the user id to the base path
      $userFolderPath = $basePath . DIRECTORY_SEPARATOR . $userId;

      // Check if the directory exists, if not, create it
      if (!file_exists($userFolderPath)) {
          mkdir($userFolderPath, 0777, true);
      }
  }

 /**
     * Checks if the avatar folder exists and is writable
     *
     * @return bool success status
     */
    public static function isAvatarFolderWritable()
    {
        if (is_dir(Config::get('PATH_AVATARS')) AND is_writable(Config::get('PATH_AVATARS'))) {
            return true;
        }

        Session::add('feedback_negative', Text::get('FEEDBACK_AVATAR_FOLDER_DOES_NOT_EXIST_OR_NOT_WRITABLE'));
        return false;
    }


    /**
     * Writes marker to database, saying user has an avatar now
     *
     * @param $user_id
     */
    public static function writeAvatarToDatabase($user_id)
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $query = $database->prepare("UPDATE users SET user_has_avatar = TRUE WHERE user_id = :user_id LIMIT 1");
        $query->execute(array(':user_id' => $user_id));
    }

    /**
     * Upload picture into the folder
     * @param int $userId
     * @return void
     */
    public static function uploadPicture($userId){
        // Get the base path
        $basePath = Config::get('PATH_USER_FOLDER');

        // Append the user id to the base path
        $userFolderPath = $basePath . DIRECTORY_SEPARATOR . $userId;

        // Get the file name
        $fileName = $_FILES['file']['name'];

        // Get the file path
        $filePath = $userFolderPath . DIRECTORY_SEPARATOR . $fileName;

        // Move the file to the folder
        move_uploaded_file($_FILES['file']['tmp_name'], $filePath);
    }

    /**
     * Get all images by user id
     * @param int $userId
     * @return array
     */
    public static function getImagesByUserId($userId){
        $basePath = Config::get('PATH_USER_FOLDER');

        // Append the user id to the base path
        $userFolderPath = $basePath . DIRECTORY_SEPARATOR . $userId;

        // // Get all files in the folder
        // $files = scandir($userFolderPath);
        header('Content-type: image/jpeg');
        $images = readfile($userFolderPath);

        return $images;
      }

    public static function getAllImageNames($userId){
        $basePath = Config::get('PATH_USER_FOLDER');

        // Append the user id to the base path
        $userFolderPath = $basePath . DIRECTORY_SEPARATOR . $userId;

        // Get all files in the folder
        $files = scandir($userFolderPath);

        // Filter out any non-image files
        // $imageFiles = array_filter($files, function($file) {
        //     $ext = pathinfo($file, PATHINFO_EXTENSION);
        //     return in_array($ext, ['jpg', 'jpeg', 'png', 'gif']);
        // });

        return $files;
    }

    public static function showImages($userId, $fileName){
        $basePath = Config::get('PATH_USER_FOLDER');

        // Append the user id to the base path
        $userFolderPath = $basePath . DIRECTORY_SEPARATOR . $userId . DIRECTORY_SEPARATOR . $fileName;

        $images = readfile($userFolderPath);

        return $images;
    }


}
