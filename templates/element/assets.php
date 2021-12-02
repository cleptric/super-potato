<?php
declare(strict_types=1);
use Cake\Core\Configure;

if (Configure::read('debug')) {
    echo $this->Html->script('http://localhost:3000/@vite/client', ['type' => 'module']);
    echo $this->Html->script('http://localhost:3000/frontend/main.js', ['type' => 'module']);
} else {
    echo $this->Vite->css('frontend/main.js');
    echo $this->Vite->script('frontend/main.js');
}