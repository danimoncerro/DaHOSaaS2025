<?php

namespace app\controllers\stores;

use core\Controller;
use app\models\Product;

class TarabaController extends Controller
{
    public function index()
    {
        // Preluăm toate produsele active din tabela `produse`
        $produse = Product::getAllForStore('taraba-hortigrup');

        // Pentru testare rapidă
        /*
        echo "<pre>";
        print_r($products);
        echo "</pre>";
        exit;
        */

        // Afișăm view-ul cu datele produselor
        $this->view('stores/taraba-view', ['produse' => $produse]);
    }
}

