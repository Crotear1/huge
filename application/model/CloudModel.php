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
     * Validates the image
     * Only accepts gif, jpg, png types
     * @see http://php.net/manual/en/function.image-type-to-mime-type.php
     *
     * @return bool
    */
    public static function validateImageFile()
    {
        if (!isset($_FILES['avatar_file'])) {
            Session::add('feedback_negative', Text::get('FEEDBACK_AVATAR_IMAGE_UPLOAD_FAILED'));
            return false;
        }

        // if input file too big (>5MB)
        if ($_FILES['avatar_file']['size'] > 5000000) {
            Session::add('feedback_negative', Text::get('FEEDBACK_AVATAR_UPLOAD_TOO_BIG'));
            return false;
        }

        // get the image width, height and mime type
        $image_proportions = getimagesize($_FILES['avatar_file']['tmp_name']);

        // if input file too small, [0] is the width, [1] is the height
        if ($image_proportions[0] < Config::get('AVATAR_SIZE') OR $image_proportions[1] < Config::get('AVATAR_SIZE')) {
            Session::add('feedback_negative', Text::get('FEEDBACK_AVATAR_UPLOAD_TOO_SMALL'));
            return false;
        }

        // if file type is not jpg, gif or png
        if (!in_array($image_proportions['mime'], array('image/jpeg', 'image/gif', 'image/png'))) {
            Session::add('feedback_negative', Text::get('FEEDBACK_AVATAR_UPLOAD_WRONG_TYPE'));
            return false;
        }

        return true;
    }

    /**
     * Resize avatar image (while keeping aspect ratio and cropping it off in a clean way).
     * Only works with gif, jpg and png file types. If you want to change this also have a look into
     * method validateImageFile() inside this model.
     *
     * TROUBLESHOOTING: You don't see the new image ? Press F5 or CTRL-F5 to refresh browser cache.
     *
     * @param string $source_image The location to the original raw image
     * @param string $destination The location to save the new image
     * @param int $final_width The desired width of the new image
     * @param int $final_height The desired height of the new image
     *
     * @return bool success state
     */
    public static function resizeAvatarImage($source_image, $destination, $final_width = 44, $final_height = 44)
    {
        $imageData = getimagesize($source_image);
        $width = $imageData[0];
        $height = $imageData[1];
        $mimeType = $imageData['mime'];

        if (!$width || !$height) {
            return false;
        }

        switch ($mimeType) {
            case 'image/jpeg': $myImage = imagecreatefromjpeg($source_image); break;
            case 'image/png': $myImage = imagecreatefrompng($source_image); break;
            case 'image/gif': $myImage = imagecreatefromgif($source_image); break;
            default: return false;
        }

        // calculating the part of the image to use for thumbnail
        if ($width > $height) {
            $verticalCoordinateOfSource = 0;
            $horizontalCoordinateOfSource = ($width - $height) / 2;
            $smallestSide = $height;
        } else {
            $horizontalCoordinateOfSource = 0;
            $verticalCoordinateOfSource = ($height - $width) / 2;
            $smallestSide = $width;
        }

        // copying the part into thumbnail, maybe edit this for square avatars
        $thumb = imagecreatetruecolor($final_width, $final_height);
        imagecopyresampled($thumb, $myImage, 0, 0, $horizontalCoordinateOfSource, $verticalCoordinateOfSource, $final_width, $final_height, $smallestSide, $smallestSide);

        // add '.jpg' to file path, save it as a .jpg file with our $destination_filename parameter
        imagejpeg($thumb, $destination . '.jpg', Config::get('AVATAR_JPEG_QUALITY'));
        imagedestroy($thumb);

        if (file_exists($destination)) {
            return true;
        }
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
        // Get the base path
        $basePath = Config::get('PATH_USER_FOLDER');

        // Append the user id to the base path
        $userFolderPath = $basePath . DIRECTORY_SEPARATOR . $userId;

        // Get all files in the folder
        $files = scandir($userFolderPath);

        // Remove . and .. from the array
        $files = array_diff($files, array('.', '..'));

        // Create an array to store the images
        $images = array();

        // Loop through the files
        foreach ($files as $file) {
            // Get the file path
            $filePath = $userFolderPath . DIRECTORY_SEPARATOR . $file;

            // Get the image id
            $imageId = substr($file, 0, 5);

            // Create an object to store the image
            $image = new stdClass();
            $image->image_id = $imageId;
            $image->file_path = $filePath;

            // Add the image to the array
            $images[] = $image;
        }

        return $images;
      }

      public function displayImage($imagePath) {
        // Überprüfen Sie, ob die Datei existiert und lesbar ist
        if (file_exists($imagePath) && is_readable($imagePath)) {
            // Holen Sie sich den MIME-Typ des Bildes
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mimeType = finfo_file($finfo, $imagePath);
            finfo_close($finfo);

            // Setzen Sie den Content-Type auf den MIME-Typ des Bildes
            header("Content-Type: $mimeType");

            // Lesen Sie die Bilddatei und senden Sie den Inhalt an den Browser
            readfile($imagePath);
        } else {
            // Die Datei konnte nicht gefunden werden oder ist nicht lesbar
            http_response_code(404);
            echo "File not found.";
        }
    }

}
