<?php
declare(strict_types=1);

/**
 * @var \App\View\AppView $this
 */
use Cake\Core\Configure;

echo $this->Html->script('https://kit.fontawesome.com/c45baf632e.js', [
    'crossorigin' => 'anonymous',
]);

if (Configure::read('debug')) {
    echo $this->Html->script('http://localhost:3000/@vite/client', ['type' => 'module']);
    echo $this->Html->script('http://localhost:3000/frontend/main.js', ['type' => 'module']);
} else {
    echo $this->Vite->css('frontend/main.js');
    echo $this->Vite->script('frontend/main.js');
}