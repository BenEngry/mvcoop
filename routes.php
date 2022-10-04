<?php
declare(strict_types=1);
/**
 * @by ProfStep, inc. 28.12.2020
 * @website: https://profstep.com
 **/

return (function(){
    $intGT0 = '[1-9]+\d*';
    $text = '[0-9aA-zZ_-]+';

    return [
        [
            'regex' => '/^$/',
            'controller' => 'messages/index'
        ],
        [
            'regex' => '/^messages\/?$/',
            'controller' => 'messages/index'
        ],
        [
            'regex' => '/^messages\/add\/?$/',
            'controller' => 'messages/add'
        ],
        [
            'regex' => '/^contacts$/',
            'controller' => 'contacts/contacts'
        ],
        [
            'regex' => '/^register$/',
            'controller' => 'reg/register'
        ],
        [
            'regex' => '/^login$/',
            'controller' => 'reg/login'
        ],
        [
            'regex' => '/^logout$/',
            'controller' => 'logout/logout'
        ],
        [
            'regex' => '/^profile$/',
            'controller' => 'profile/profile'
        ],
        [
            'regex' => '/^promotions$/',
            'controller' => 'promotions/promotions'
        ]
    ];
})();