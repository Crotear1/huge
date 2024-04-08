<?php

/**
 * CloudController
 * Controls everything that is user-related
 */
class CloudController extends Controller
{
    /**
     * Construct this object by extending the basic Controller class.
     */
    public function __construct()
    {
        parent::__construct();

        // VERY IMPORTANT: All controllers/areas that should only be usable by logged-in users
        // need this line! Otherwise not-logged in users could do actions.
        Auth::checkAuthentication();
    }

    /**
     * Show user's PRIVATE profile
     */
    public function index()
    {
        $this->View->render('cloud/index', array(
            'createUserFolder' => CloudModel::createUserFolder(Session::get('user_id')),
            'images' => CloudModel::getImagesByUserId(Session::get('user_id'))

        ));
    }

    /**
     * Upload a picture
     */
    public function upload(){
        CloudModel::uploadPicture(Session::get('user_id'));
        Redirect::to('cloud/index');
    }

    // /**
    //  * Perform the upload of the avatar
    //  * POST-request
    //  */
    // public function uploadAvatar_action()
    // {
    //     AvatarModel::createAvatar();
    //     Redirect::to('user/editAvatar');
    // }

    // /**
    //  * Delete the current user's avatar
    //  */
    // public function deleteAvatar_action()
    // {
    //     AvatarModel::deleteAvatar(Session::get("user_id"));
    //     Redirect::to('user/editAvatar');
    // }
}
