<?php

class Sml extends App_core
{
    public $a_page_data;
    function __construct()
    {
        parent::__construct();
        $this->a_page_data = [];
    }

    public function registration()
    {
        $this->a_page_data['pages'] = 'scholarship/form/form_sml';
        $this->load->view('registration/layout', $this->a_page_data);
    }
}

?>