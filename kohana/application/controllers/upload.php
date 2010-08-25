<?php defined('SYSPATH') or die('No direct script access.');

class Upload_Controller extends Website_Controller {

    public function index()
    {
        $this->template->title = 'Home::Mongodb Post Upload';
        $this->template->content = new View('pages/upload');

    }

}


