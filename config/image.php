<?php

return [
    /*
      |--------------------------------------------------------------------------
      | Image Driver
      |--------------------------------------------------------------------------
      |
      | Intervention Image supports "GD Library" and "Imagick" to process images
      | internally. You may choose one of them according to your PHP
      | configuration. By default PHP's "GD Library" implementation is used.
      |
      | Supported: "gd", "imagick"
      |
     */

    'driver' => 'gd',
    'paths'  => [
        'topics'  => 'img/topics',
        'authors' => 'img/topics/authors',
    ],
    'sizes' => [
        'topics' => [
            'width'  => 600,
            'height' => 400,
        ],
        'authors' => [
            'thumbnail' => [
                'width'  => 150,
                'height' => 100,
            ],
        ],
    ],
];
