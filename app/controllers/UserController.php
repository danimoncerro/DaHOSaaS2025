<?php
namespace app\controllers;
echo "Metoda Usercontroller1 din controllers a fost apelata!";
class UserController {
    public function index() {
        die("Metoda index() a fost apelată corect.");
        echo "Metoda Usercontroller2 din controllers a fost apelata!";
        echo "UserController@index";
    }
}
