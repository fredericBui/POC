<?php

// Appel de la classe noyau de symfony
use App\Kernel;

// Cette ligne permet d'utiliser l'auto-loader
require_once dirname(__DIR__).'/vendor/autoload_runtime.php';

return function (array $context) {
    return new Kernel($context['APP_ENV'], (bool) $context['APP_DEBUG']);
};
