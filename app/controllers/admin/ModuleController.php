<?php

namespace app\controllers\admin;

use core\Controller;
use app\models\Module;

class ModuleController extends Controller
{
    public function index()
    {
        $modules = Module::all();
        return $this->view('admin/modules/index', ['modules' => $modules]);
    }
}
