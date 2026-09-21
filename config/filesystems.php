<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application for file storage.
    |
    */

    'default' => env('FILESYSTEM_DISK', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Below you may configure as many filesystem disks as necessary, and you
    | may even configure multiple disks for the same driver. Examples for
    | most supported storage drivers are configured here for reference.
    |
    | Supported drivers: "local", "ftp", "sftp", "s3"
    |
    */

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app/private'),
            'serve' => true,
            'throw' => false,
            'report' => false,
        ],

        // Every upload site-wide (gallery photos, resource PDFs, article
        // covers, team/partner/testimonial photos) lives here — an
        // S3-compatible bucket (Neon Storage), not local disk, since the
        // app now runs against production data from any machine and local
        // disk storage doesn't travel with the database. The bucket is
        // private and this provider doesn't support per-object ACLs
        // (setting 'visibility' => 'public' makes every write 501), so
        // every read goes through storage_url() (app/helpers.php), which
        // signs a time-limited temporaryUrl() instead of a plain url().
        'public' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL'),
            'endpoint' => env('AWS_ENDPOINT'),
            'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
            'throw' => false,
            'report' => false,
            // Same class of bug as the Redis/Postgres timeouts fixed
            // earlier: this array is passed straight into the AWS SDK's
            // S3Client constructor, which has no request timeout by
            // default — an unreachable/slow Neon Storage hangs the whole
            // request until PHP's 30s max_execution_time kills it with a
            // FatalError instead of a catchable exception.
            'http' => [
                'connect_timeout' => env('AWS_CONNECT_TIMEOUT', 5),
                'timeout' => env('AWS_REQUEST_TIMEOUT', 10),
            ],
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Symbolic Links
    |--------------------------------------------------------------------------
    |
    | Here you may configure the symbolic links that will be created when the
    | `storage:link` Artisan command is executed. The array keys should be
    | the locations of the links and the values should be their targets.
    |
    */

    'links' => [
        public_path('storage') => storage_path('app/public'),
    ],

];
