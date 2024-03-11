<?php

/**
 * This controller shows an area that's only visible for logged in users (because of Auth::checkAuthentication(); in line 16)
 */
class MessageController extends Controller
{
    /**
     * Construct this object by extending the basic Controller class
     */
    public function __construct()
    {
        parent::__construct();

        // this entire controller should only be visible/usable by logged in users, so we put authentication-check here
        Auth::checkAuthentication();
    }

    /**
     * This method controls what happens when you move to /message/index in your app.
     */
    public function index()
    {
        $this->View->render('message/index', array(
          'users' => MessageModel::getAllUsers(Session::get('user_id')))
      );
    }

    public function getMessagesForUser($userId)
    {
        $this->View->render('message/index', array(
          'messages' => MessageModel::getAllMessages($userId))
      );
    }

}
