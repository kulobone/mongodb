<?php defined('SYSPATH') or die('No direct script access.');

class Altags_Controller extends Website_Controller {

    public function index()
    {
        $this->template->title = 'Home::Mongodb view all tags';
        $this->template->content = new View('pages/altags');

    }

}


