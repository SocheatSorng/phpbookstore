<?php

class CategoryEdit extends Controller {
    
    public function index() {
        // Check if user is logged in
        if(!Auth::logged_in()) {
            $this->redirect('login');
        }

        $data['page_title'] = "Edit Category";
        
        // Load the view
        $this->view('categoryEdit', $data);
    }
}
