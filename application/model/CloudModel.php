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

    public static function getAllImageNames($userId){
        $basePath = Config::get('PATH_USER_FOLDER');

        $userFolderPath = $basePath . DIRECTORY_SEPARATOR . $userId;

        $files = scandir($userFolderPath);

        // Remove the first two elements from the array
        unset($files[0]);
        unset($files[1]);

        return $files;
    }

    public static function showImages($userId, $fileName){
        $basePath = Config::get('PATH_USER_FOLDER');

        // Append the user id to the base path
        $userFolderPath = $basePath . DIRECTORY_SEPARATOR . $userId . DIRECTORY_SEPARATOR . $fileName;

        $images = readfile($userFolderPath);

        return $images;
    }

    public static function deletePicture($userId, $fileName){
        $basePath = Config::get('PATH_USER_FOLDER');

        // Append the user id to the base path
        $userFolderPath = $basePath . DIRECTORY_SEPARATOR . $userId . DIRECTORY_SEPARATOR . $fileName;

        unlink($userFolderPath);
    }

    public static function writeImageToDatabase($userId, $fileName){
        $db = DatabaseFactory::getFactory()->getConnection();

        $query = $db->prepare("INSERT INTO Images (userid, imageName) VALUES (:userid, :imageName)");
        $query->execute(array(':userid' => $userId, ':imageName' => $fileName));


    }


    public static function checkIfSharedImageExists($userId, $imageName){
        $db = DatabaseFactory::getFactory()->getConnection();

        $query = $db->prepare("SELECT * FROM Images WHERE userid = :userid AND imageName = :imageName");
        $query->execute(array(':userid' => $userId, ':imageName' => $imageName));

        if($query->rowCount() > 0){
            self::showImages($userId, $imageName);
        } else {
            Redirect::to('cloud/index');
        }
    }

    public static function removeSharedImage($imageName){
        $db = DatabaseFactory::getFactory()->getConnection();

        $id = Session::get('user_id');

        $query = $db->prepare("DELETE FROM Images WHERE imageName = :imageName AND userid = :id");
        $query->execute(array(':imageName' => $imageName, ':id' => $id));
    }

    public static function sendEmail($imageName){
        $mail = new Mail();
        $success = $mail->sendMail($_POST['email'], Config::get('EMAIL_SMTP_USERNAME'), 'Charlie', 'subject', $imageName);

        if($success){
            echo Session::add('feedback_positive', 'Email wurde erfolgreich versendet');
        } else {
            echo Session::add('feedback_negative', $mail->getError());
        }
    }
}
