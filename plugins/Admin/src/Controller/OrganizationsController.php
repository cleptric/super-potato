<?php
declare(strict_types=1);

namespace Admin\Controller;

use Admin\Controller\AppController;

class OrganizationsController extends AppController
{
    public function index()
    {
        $this->Authorization->skipAuthorization();
    }
}
