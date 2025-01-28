<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your settings for cross-origin resource sharing
    | or "CORS". This determines what cross-origin operations may execute
    | in web browsers. You are free to adjust these settings as needed.
    |
    | To learn more: https://developer.mozilla.org/en-US/docs/Web/HTTP/CORS
    |
    */

    'paths' => ['api/*', 'sanctum/csrf-cookie'], // Path yang diizinkan untuk akses CORS

    'allowed_methods' => ['*'], // Semua metode HTTP diizinkan (GET, POST, PUT, DELETE, dll.)

    'allowed_origins' => ['*'], // Mengizinkan semua domain untuk akses API. Bisa diganti dengan domain spesifik.

    'allowed_origins_patterns' => [], // Pola domain yang diizinkan (jika perlu menggunakan regex).

    'allowed_headers' => ['*'], // Semua header diizinkan

    'max_age' => 0, // Durasi cache untuk preflight requests (opsional).

    'supports_credentials' => false, // Izinkan penggunaan credentials (seperti cookies dan authorization headers).

];
