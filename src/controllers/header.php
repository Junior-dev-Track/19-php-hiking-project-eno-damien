<?php
namespace Application\Controllers;

class Header 
{
    public function execute()
    {
        require(__DIR__ . '/../view/header.view.php');
    }
}