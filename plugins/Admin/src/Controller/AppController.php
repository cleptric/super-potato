<?php
declare(strict_types=1);

namespace Admin\Controller;

use App\Controller\AppController as BaseController;

class AppController extends BaseController
{
    public function initialize(): void
    {
        parent::initialize();

        $this->viewBuilder()->setLayout('Admin.default');
    }
}
