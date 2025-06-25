<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Snappy PDF / Image Configuration
    |--------------------------------------------------------------------------
    */
    
    'pdf' => [
        'enabled' => true,
        // PERUBAHAN DI SINI: Path disesuaikan untuk Windows
        'binary'  => '"C:\\Program Files\\wkhtmltopdf\\bin\\wkhtmltopdf.exe"',
        'timeout' => false,
        'options' => [],
        'env'     => [],
    ],
    
    'image' => [
        'enabled' => true,
        // PERUBAHAN DI SINI: Path disesuaikan untuk Windows
        'binary'  => '"C:\\Program Files\\wkhtmltopdf\\bin\\wkhtmltoimage.exe"',
        'timeout' => false,
        'options' => [],
        'env'     => [],
    ],

];