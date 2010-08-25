<?php defined('SYSPATH') or die('No direct script access.');

class Blog_Controller extends Website_Controller {

    public function index()
    {
        $this->template->title = 'Home::Mongodb Project';
        $this->template->content = new View('pages/blog');
		require_once'Db.php';
		global $mongo;
	    define('MONGODB_NAME', 'nicolas');	
    }

}


