<?php
class Search_Controller extends Website_Controller {

    public function index()
    {
        $this->template->title = 'Home::Mongodb Project';
        $this->template->content = new View('pages/search');
		require_once'Db.php';
		global $mongo;
	    define('MONGODB_NAME', 'nicolas');
		
    }

}

?>