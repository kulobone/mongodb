<?php defined('SYSPATH') or die('No direct script access.');

class Tags_Controller extends Website_Controller {

    public function index()
    {
        $this->template->title = 'Home::Mongodb Add tags';
        $this->template->content = new View('pages/tags');

    }

}


