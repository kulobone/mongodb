<?php defined('SYSPATH') or die('No direct script access.');

class Deleted_Controller extends Website_Controller {

    public function index()
    {
        $this->template->title = 'delete';
        $this->template->content = new View('pages/deleted');
		 global $artId;
		
    }

}


