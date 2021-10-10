<?php
declare(strict_types=1);
use Cake\Core\Configure;

if (Configure::read('debug')) {
    echo $this->Html->script('http://localhost:3000/@vite/client', ['type' => 'module']);
    echo $this->Html->script('http://localhost:3000/frontend/js/main.js', ['type' => 'module']);
} else {
    echo $this->Vite->css('frontend/css/main.css');
    echo $this->Vite->script('frontend/js/main.js');
}