<?php defined('SYSPATH') or die('No direct script access.');

class Alcom_Controller extends Website_Controller {

    public function index()
    {
        $this->template->title = 'Home::Mongodb view all comments';
        $this->template->content = new View('pages/alcom');

    }

}


