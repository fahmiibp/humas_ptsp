<?php return array (
  'broadcasting' => 
  array (
    'default' => 'log',
    'connections' => 
    array (
      'reverb' => 
      array (
        'driver' => 'reverb',
        'key' => NULL,
        'secret' => NULL,
        'app_id' => NULL,
        'options' => 
        array (
          'host' => NULL,
          'port' => 443,
          'scheme' => 'https',
          'useTLS' => true,
        ),
        'client_options' => 
        array (
        ),
      ),
      'pusher' => 
      array (
        'driver' => 'pusher',
        'key' => NULL,
        'secret' => NULL,
        'app_id' => NULL,
        'options' => 
        array (
          'cluster' => NULL,
          'host' => 'api-mt1.pusher.com',
          'port' => 443,
          'scheme' => 'https',
          'encrypted' => true,
          'useTLS' => true,
        ),
        'client_options' => 
        array (
        ),
      ),
      'ably' => 
      array (
        'driver' => 'ably',
        'key' => NULL,
      ),
      'mercure' => 
      array (
        'driver' => 'mercure',
        'url' => NULL,
        'public_url' => NULL,
        'secret' => NULL,
        'encryption_key' => NULL,
        'claims' => 
        array (
          'iss' => NULL,
          'client_id' => 'Laravel',
        ),
        'cookie_name' => NULL,
        'subscribe_expiration' => 5,
        'async' => false,
      ),
      'log' => 
      array (
        'driver' => 'log',
      ),
      'null' => 
      array (
        'driver' => 'null',
      ),
    ),
  ),
  'concurrency' => 
  array (
    'default' => 'process',
  ),
  'cors' => 
  array (
    'paths' => 
    array (
      0 => 'api/*',
      1 => 'sanctum/csrf-cookie',
    ),
    'allowed_methods' => 
    array (
      0 => '*',
    ),
    'allowed_origins' => 
    array (
      0 => '*',
    ),
    'allowed_origins_patterns' => 
    array (
    ),
    'allowed_headers' => 
    array (
      0 => '*',
    ),
    'exposed_headers' => 
    array (
    ),
    'max_age' => 0,
    'supports_credentials' => false,
  ),
  'hashing' => 
  array (
    'driver' => 'bcrypt',
    'bcrypt' => 
    array (
      'rounds' => '12',
      'verify' => true,
      'limit' => NULL,
    ),
    'argon' => 
    array (
      'memory' => 65536,
      'threads' => 1,
      'time' => 4,
      'verify' => true,
    ),
    'rehash_on_login' => true,
  ),
  'images' => 
  array (
    'default' => 'gd',
  ),
  'view' => 
  array (
    'paths' => 
    array (
      0 => 'C:\\laragon\\www\\humas_ptsp\\resources\\views',
    ),
    'compiled' => 'C:\\laragon\\www\\humas_ptsp\\storage\\framework\\views',
  ),
  'app' => 
  array (
    'name' => 'Laravel',
    'env' => 'local',
    'debug' => true,
    'url' => 'http://127.0.0.1:8000',
    'frontend_url' => 'http://localhost:3000',
    'asset_url' => NULL,
    'timezone' => 'Asia/Jakarta',
    'locale' => 'en',
    'fallback_locale' => 'en',
    'faker_locale' => 'en_US',
    'cipher' => 'AES-256-CBC',
    'key' => 'base64:IHx0CwcTXhul6e2x16SXw8aoba1FdQLGYM6NFuCaDPM=',
    'previous_keys' => 
    array (
    ),
    'maintenance' => 
    array (
      'driver' => 'file',
      'store' => 'database',
    ),
    'providers' => 
    array (
      0 => 'Illuminate\\Auth\\AuthServiceProvider',
      1 => 'Illuminate\\Broadcasting\\BroadcastServiceProvider',
      2 => 'Illuminate\\Bus\\BusServiceProvider',
      3 => 'Illuminate\\Cache\\CacheServiceProvider',
      4 => 'Illuminate\\Foundation\\Providers\\ConsoleSupportServiceProvider',
      5 => 'Illuminate\\Concurrency\\ConcurrencyServiceProvider',
      6 => 'Illuminate\\Cookie\\CookieServiceProvider',
      7 => 'Illuminate\\Database\\DatabaseServiceProvider',
      8 => 'Illuminate\\Encryption\\EncryptionServiceProvider',
      9 => 'Illuminate\\Filesystem\\FilesystemServiceProvider',
      10 => 'Illuminate\\Image\\ImageServiceProvider',
      11 => 'Illuminate\\Foundation\\Providers\\FoundationServiceProvider',
      12 => 'Illuminate\\Hashing\\HashServiceProvider',
      13 => 'Illuminate\\Mail\\MailServiceProvider',
      14 => 'Illuminate\\Notifications\\NotificationServiceProvider',
      15 => 'Illuminate\\Pagination\\PaginationServiceProvider',
      16 => 'Illuminate\\Auth\\Passwords\\PasswordResetServiceProvider',
      17 => 'Illuminate\\Pipeline\\PipelineServiceProvider',
      18 => 'Illuminate\\Queue\\QueueServiceProvider',
      19 => 'Illuminate\\Redis\\RedisServiceProvider',
      20 => 'Illuminate\\Session\\SessionServiceProvider',
      21 => 'Illuminate\\Translation\\TranslationServiceProvider',
      22 => 'Illuminate\\Validation\\ValidationServiceProvider',
      23 => 'Illuminate\\View\\ViewServiceProvider',
      24 => 'App\\Providers\\AppServiceProvider',
      25 => 'App\\Providers\\Filament\\AdminPanelProvider',
    ),
    'aliases' => 
    array (
      'App' => 'Illuminate\\Support\\Facades\\App',
      'Arr' => 'Illuminate\\Support\\Arr',
      'Artisan' => 'Illuminate\\Support\\Facades\\Artisan',
      'Auth' => 'Illuminate\\Support\\Facades\\Auth',
      'Benchmark' => 'Illuminate\\Support\\Benchmark',
      'Blade' => 'Illuminate\\Support\\Facades\\Blade',
      'Broadcast' => 'Illuminate\\Support\\Facades\\Broadcast',
      'Bus' => 'Illuminate\\Support\\Facades\\Bus',
      'Cache' => 'Illuminate\\Support\\Facades\\Cache',
      'Concurrency' => 'Illuminate\\Support\\Facades\\Concurrency',
      'Config' => 'Illuminate\\Support\\Facades\\Config',
      'Context' => 'Illuminate\\Support\\Facades\\Context',
      'Cookie' => 'Illuminate\\Support\\Facades\\Cookie',
      'Crypt' => 'Illuminate\\Support\\Facades\\Crypt',
      'Date' => 'Illuminate\\Support\\Facades\\Date',
      'DB' => 'Illuminate\\Support\\Facades\\DB',
      'Eloquent' => 'Illuminate\\Database\\Eloquent\\Model',
      'Event' => 'Illuminate\\Support\\Facades\\Event',
      'File' => 'Illuminate\\Support\\Facades\\File',
      'Gate' => 'Illuminate\\Support\\Facades\\Gate',
      'Hash' => 'Illuminate\\Support\\Facades\\Hash',
      'Http' => 'Illuminate\\Support\\Facades\\Http',
      'Image' => 'Illuminate\\Support\\Facades\\Image',
      'Js' => 'Illuminate\\Support\\Js',
      'Lang' => 'Illuminate\\Support\\Facades\\Lang',
      'Log' => 'Illuminate\\Support\\Facades\\Log',
      'Mail' => 'Illuminate\\Support\\Facades\\Mail',
      'Notification' => 'Illuminate\\Support\\Facades\\Notification',
      'Number' => 'Illuminate\\Support\\Number',
      'Password' => 'Illuminate\\Support\\Facades\\Password',
      'Process' => 'Illuminate\\Support\\Facades\\Process',
      'Queue' => 'Illuminate\\Support\\Facades\\Queue',
      'RateLimiter' => 'Illuminate\\Support\\Facades\\RateLimiter',
      'Redirect' => 'Illuminate\\Support\\Facades\\Redirect',
      'Request' => 'Illuminate\\Support\\Facades\\Request',
      'Response' => 'Illuminate\\Support\\Facades\\Response',
      'Route' => 'Illuminate\\Support\\Facades\\Route',
      'Schedule' => 'Illuminate\\Support\\Facades\\Schedule',
      'Schema' => 'Illuminate\\Support\\Facades\\Schema',
      'Session' => 'Illuminate\\Support\\Facades\\Session',
      'Storage' => 'Illuminate\\Support\\Facades\\Storage',
      'Str' => 'Illuminate\\Support\\Str',
      'Uri' => 'Illuminate\\Support\\Uri',
      'URL' => 'Illuminate\\Support\\Facades\\URL',
      'Validator' => 'Illuminate\\Support\\Facades\\Validator',
      'View' => 'Illuminate\\Support\\Facades\\View',
      'Vite' => 'Illuminate\\Support\\Facades\\Vite',
    ),
  ),
  'auth' => 
  array (
    'defaults' => 
    array (
      'guard' => 'web',
      'passwords' => 'users',
    ),
    'guards' => 
    array (
      'web' => 
      array (
        'driver' => 'session',
        'provider' => 'users',
      ),
    ),
    'providers' => 
    array (
      'users' => 
      array (
        'driver' => 'eloquent',
        'model' => 'App\\Models\\User',
      ),
    ),
    'passwords' => 
    array (
      'users' => 
      array (
        'provider' => 'users',
        'table' => 'password_reset_tokens',
        'expire' => 60,
        'throttle' => 60,
      ),
    ),
    'password_timeout' => 10800,
  ),
  'cache' => 
  array (
    'default' => 'database',
    'stores' => 
    array (
      'array' => 
      array (
        'driver' => 'array',
        'serialize' => false,
      ),
      'session' => 
      array (
        'driver' => 'session',
        'key' => '_cache',
      ),
      'database' => 
      array (
        'driver' => 'database',
        'connection' => NULL,
        'table' => 'cache',
        'lock_connection' => NULL,
        'lock_table' => NULL,
      ),
      'file' => 
      array (
        'driver' => 'file',
        'path' => 'C:\\laragon\\www\\humas_ptsp\\storage\\framework/cache/data',
        'lock_path' => 'C:\\laragon\\www\\humas_ptsp\\storage\\framework/cache/data',
      ),
      'storage' => 
      array (
        'driver' => 'storage',
        'disk' => NULL,
        'path' => 'framework/cache/data',
      ),
      'memcached' => 
      array (
        'driver' => 'memcached',
        'persistent_id' => NULL,
        'sasl' => 
        array (
          0 => NULL,
          1 => NULL,
        ),
        'options' => 
        array (
        ),
        'servers' => 
        array (
          0 => 
          array (
            'host' => '127.0.0.1',
            'port' => 11211,
            'weight' => 100,
          ),
        ),
      ),
      'redis' => 
      array (
        'driver' => 'redis',
        'connection' => 'cache',
        'lock_connection' => 'default',
      ),
      'dynamodb' => 
      array (
        'driver' => 'dynamodb',
        'key' => '',
        'secret' => '',
        'region' => 'us-east-1',
        'table' => 'cache',
        'endpoint' => NULL,
      ),
      'octane' => 
      array (
        'driver' => 'octane',
      ),
      'failover' => 
      array (
        'driver' => 'failover',
        'stores' => 
        array (
          0 => 'database',
          1 => 'array',
        ),
      ),
    ),
    'prefix' => 'laravel-cache-',
    'serializable_classes' => false,
  ),
  'database' => 
  array (
    'default' => 'mysql',
    'connections' => 
    array (
      'sqlite' => 
      array (
        'driver' => 'sqlite',
        'url' => NULL,
        'database' => 'humas_ptsp',
        'prefix' => '',
        'foreign_key_constraints' => true,
        'busy_timeout' => NULL,
        'journal_mode' => NULL,
        'synchronous' => NULL,
        'transaction_mode' => 'DEFERRED',
      ),
      'mysql' => 
      array (
        'driver' => 'mysql',
        'url' => NULL,
        'host' => '127.0.0.1',
        'port' => '3306',
        'database' => 'humas_ptsp',
        'username' => 'root',
        'password' => '',
        'unix_socket' => '',
        'charset' => 'utf8mb4',
        'collation' => 'utf8mb4_unicode_ci',
        'prefix' => '',
        'prefix_indexes' => true,
        'strict' => true,
        'engine' => NULL,
        'options' => 
        array (
        ),
      ),
      'mariadb' => 
      array (
        'driver' => 'mariadb',
        'url' => NULL,
        'host' => '127.0.0.1',
        'port' => '3306',
        'database' => 'humas_ptsp',
        'username' => 'root',
        'password' => '',
        'unix_socket' => '',
        'charset' => 'utf8mb4',
        'collation' => 'utf8mb4_unicode_ci',
        'prefix' => '',
        'prefix_indexes' => true,
        'strict' => true,
        'engine' => NULL,
        'options' => 
        array (
        ),
      ),
      'pgsql' => 
      array (
        'driver' => 'pgsql',
        'url' => NULL,
        'host' => '127.0.0.1',
        'port' => '3306',
        'database' => 'humas_ptsp',
        'username' => 'root',
        'password' => '',
        'charset' => 'utf8',
        'prefix' => '',
        'prefix_indexes' => true,
        'search_path' => 'public',
        'sslmode' => 'prefer',
      ),
      'sqlsrv' => 
      array (
        'driver' => 'sqlsrv',
        'url' => NULL,
        'host' => '127.0.0.1',
        'port' => '3306',
        'database' => 'humas_ptsp',
        'username' => 'root',
        'password' => '',
        'charset' => 'utf8',
        'prefix' => '',
        'prefix_indexes' => true,
      ),
    ),
    'migrations' => 
    array (
      'table' => 'migrations',
      'update_date_on_publish' => true,
    ),
    'redis' => 
    array (
      'client' => 'phpredis',
      'options' => 
      array (
        'cluster' => 'redis',
        'prefix' => 'laravel-database-',
        'persistent' => false,
      ),
      'default' => 
      array (
        'url' => NULL,
        'host' => '127.0.0.1',
        'username' => NULL,
        'password' => NULL,
        'port' => '6379',
        'database' => '0',
        'max_retries' => 3,
        'backoff_algorithm' => 'decorrelated_jitter',
        'backoff_base' => 100,
        'backoff_cap' => 1000,
      ),
      'cache' => 
      array (
        'url' => NULL,
        'host' => '127.0.0.1',
        'username' => NULL,
        'password' => NULL,
        'port' => '6379',
        'database' => '1',
        'max_retries' => 3,
        'backoff_algorithm' => 'decorrelated_jitter',
        'backoff_base' => 100,
        'backoff_cap' => 1000,
      ),
    ),
  ),
  'filament-impersonate' => 
  array (
    'redirect_to' => '/admin',
    'leave_middleware' => 'web',
    'route_prefix' => NULL,
    'allow_soft_deleted' => false,
    'banner' => 
    array (
      'render_hook' => 'panels::body.start',
      'style' => 'dark',
      'fixed' => true,
      'position' => 'top',
      'styles' => 
      array (
        'light' => 
        array (
          'text' => '#1f2937',
          'background' => '#f3f4f6',
          'border' => '#e8eaec',
        ),
        'dark' => 
        array (
          'text' => '#f3f4f6',
          'background' => '#1f2937',
          'border' => '#374151',
        ),
      ),
    ),
  ),
  'filament-shield' => 
  array (
    'shield_resource' => 
    array (
      'slug' => 'shield/roles',
      'show_model_path' => true,
      'cluster' => NULL,
      'tabs' => 
      array (
        'pages' => true,
        'widgets' => true,
        'resources' => true,
        'custom_permissions' => false,
      ),
    ),
    'tenant_model' => NULL,
    'auth_provider_model' => 'App\\Models\\User',
    'super_admin' => 
    array (
      'enabled' => true,
      'name' => 'super_admin',
      'define_via_gate' => false,
      'intercept_gate' => 'before',
    ),
    'panel_user' => 
    array (
      'enabled' => true,
      'name' => 'panel_user',
    ),
    'permissions' => 
    array (
      'separator' => ':',
      'case' => 'pascal',
      'generate' => true,
      'format_custom_permission_keys' => true,
    ),
    'policies' => 
    array (
      'path' => 'C:\\laragon\\www\\humas_ptsp\\app\\Policies',
      'merge' => true,
      'generate' => true,
      'methods' => 
      array (
        0 => 'viewAny',
        1 => 'view',
        2 => 'create',
        3 => 'update',
        4 => 'delete',
        5 => 'deleteAny',
        6 => 'restore',
        7 => 'forceDelete',
        8 => 'forceDeleteAny',
        9 => 'restoreAny',
        10 => 'replicate',
        11 => 'reorder',
      ),
      'single_parameter_methods' => 
      array (
        0 => 'viewAny',
        1 => 'create',
        2 => 'deleteAny',
        3 => 'forceDeleteAny',
        4 => 'restoreAny',
        5 => 'reorder',
      ),
    ),
    'localization' => 
    array (
      'enabled' => false,
      'key' => 'filament-shield::filament-shield.resource_permission_prefixes_labels',
    ),
    'resources' => 
    array (
      'subject' => 'model',
      'manage' => 
      array (
        'BezhanSalleh\\FilamentShield\\Resources\\Roles\\RoleResource' => 
        array (
          0 => 'viewAny',
          1 => 'view',
          2 => 'create',
          3 => 'update',
          4 => 'delete',
        ),
      ),
      'exclude' => 
      array (
      ),
    ),
    'pages' => 
    array (
      'subject' => 'class',
      'prefix' => 'view',
      'exclude' => 
      array (
        0 => 'Filament\\Pages\\Dashboard',
      ),
    ),
    'widgets' => 
    array (
      'subject' => 'class',
      'prefix' => 'view',
      'exclude' => 
      array (
        0 => 'Filament\\Widgets\\AccountWidget',
        1 => 'Filament\\Widgets\\FilamentInfoWidget',
      ),
    ),
    'custom_permissions' => 
    array (
    ),
    'discovery' => 
    array (
      'discover_all_resources' => false,
      'discover_all_widgets' => false,
      'discover_all_pages' => false,
    ),
    'register_role_policy' => true,
  ),
  'filesystems' => 
  array (
    'default' => 'local',
    'disks' => 
    array (
      'local' => 
      array (
        'driver' => 'local',
        'root' => 'C:\\laragon\\www\\humas_ptsp\\storage\\app/private',
        'serve' => true,
        'throw' => false,
        'report' => false,
      ),
      'public' => 
      array (
        'driver' => 'local',
        'root' => 'C:\\laragon\\www\\humas_ptsp\\storage\\app/public',
        'url' => 'http://127.0.0.1:8000/storage',
        'visibility' => 'public',
        'throw' => false,
        'report' => false,
      ),
      's3' => 
      array (
        'driver' => 's3',
        'key' => '',
        'secret' => '',
        'region' => 'us-east-1',
        'bucket' => '',
        'url' => NULL,
        'endpoint' => NULL,
        'use_path_style_endpoint' => false,
        'throw' => false,
        'report' => false,
      ),
    ),
    'links' => 
    array (
      'C:\\laragon\\www\\humas_ptsp\\public\\storage' => 'C:\\laragon\\www\\humas_ptsp\\storage\\app/public',
    ),
  ),
  'livewire' => 
  array (
    'component_locations' => 
    array (
      0 => 'C:\\laragon\\www\\humas_ptsp\\resources\\views/components',
      1 => 'C:\\laragon\\www\\humas_ptsp\\resources\\views/livewire',
    ),
    'component_namespaces' => 
    array (
      'layouts' => 'C:\\laragon\\www\\humas_ptsp\\resources\\views/layouts',
      'pages' => 'C:\\laragon\\www\\humas_ptsp\\resources\\views/pages',
    ),
    'component_layout' => 'layouts::app',
    'component_placeholder' => NULL,
    'make_command' => 
    array (
      'type' => 'sfc',
      'emoji' => true,
      'with' => 
      array (
        'js' => false,
        'css' => false,
        'test' => false,
      ),
    ),
    'class_namespace' => 'App\\Livewire',
    'class_path' => 'C:\\laragon\\www\\humas_ptsp\\app\\Livewire',
    'view_path' => 'C:\\laragon\\www\\humas_ptsp\\resources\\views/livewire',
    'temporary_file_upload' => 
    array (
      'disk' => 'local',
      'rules' => NULL,
      'directory' => NULL,
      'middleware' => NULL,
      'preview_mimes' => 
      array (
        0 => 'png',
        1 => 'gif',
        2 => 'bmp',
        3 => 'svg',
        4 => 'wav',
        5 => 'mp4',
        6 => 'mov',
        7 => 'avi',
        8 => 'wmv',
        9 => 'mp3',
        10 => 'm4a',
        11 => 'jpg',
        12 => 'jpeg',
        13 => 'mpga',
        14 => 'webp',
        15 => 'wma',
      ),
      'max_upload_time' => 5,
      'cleanup' => true,
    ),
    'render_on_redirect' => false,
    'legacy_model_binding' => false,
    'inject_assets' => true,
    'navigate' => 
    array (
      'show_progress_bar' => true,
      'progress_bar_color' => '#2299dd',
    ),
    'inject_morph_markers' => true,
    'smart_wire_keys' => true,
    'pagination_theme' => 'tailwind',
    'release_token' => 'a',
    'csp_safe' => false,
    'payload' => 
    array (
      'max_size' => 1048576,
      'max_nesting_depth' => 10,
      'max_calls' => 50,
      'max_components' => 200,
    ),
  ),
  'logging' => 
  array (
    'default' => 'stack',
    'deprecations' => 
    array (
      'channel' => NULL,
      'trace' => false,
    ),
    'channels' => 
    array (
      'stack' => 
      array (
        'driver' => 'stack',
        'channels' => 
        array (
          0 => 'single',
        ),
        'ignore_exceptions' => false,
      ),
      'single' => 
      array (
        'driver' => 'single',
        'path' => 'C:\\laragon\\www\\humas_ptsp\\storage\\logs/laravel.log',
        'level' => 'debug',
        'replace_placeholders' => true,
      ),
      'daily' => 
      array (
        'driver' => 'daily',
        'path' => 'C:\\laragon\\www\\humas_ptsp\\storage\\logs/laravel.log',
        'level' => 'debug',
        'max_files' => 14,
        'replace_placeholders' => true,
      ),
      'monthly' => 
      array (
        'driver' => 'monthly',
        'path' => 'C:\\laragon\\www\\humas_ptsp\\storage\\logs/laravel.log',
        'level' => 'debug',
        'max_files' => 3,
        'replace_placeholders' => true,
      ),
      'slack' => 
      array (
        'driver' => 'slack',
        'url' => NULL,
        'username' => 'Laravel',
        'emoji' => ':boom:',
        'level' => 'debug',
        'replace_placeholders' => true,
      ),
      'papertrail' => 
      array (
        'driver' => 'monolog',
        'level' => 'debug',
        'handler' => 'Monolog\\Handler\\SyslogUdpHandler',
        'handler_with' => 
        array (
          'host' => NULL,
          'port' => NULL,
          'connectionString' => 'tls://:',
        ),
        'processors' => 
        array (
          0 => 'Monolog\\Processor\\PsrLogMessageProcessor',
        ),
      ),
      'stderr' => 
      array (
        'driver' => 'monolog',
        'level' => 'debug',
        'handler' => 'Monolog\\Handler\\StreamHandler',
        'handler_with' => 
        array (
          'stream' => 'php://stderr',
        ),
        'formatter' => NULL,
        'processors' => 
        array (
          0 => 'Monolog\\Processor\\PsrLogMessageProcessor',
        ),
      ),
      'syslog' => 
      array (
        'driver' => 'syslog',
        'level' => 'debug',
        'facility' => 8,
        'replace_placeholders' => true,
      ),
      'errorlog' => 
      array (
        'driver' => 'errorlog',
        'level' => 'debug',
        'replace_placeholders' => true,
      ),
      'null' => 
      array (
        'driver' => 'monolog',
        'handler' => 'Monolog\\Handler\\NullHandler',
      ),
      'emergency' => 
      array (
        'path' => 'C:\\laragon\\www\\humas_ptsp\\storage\\logs/laravel.log',
      ),
      'browser' => 
      array (
        'driver' => 'single',
        'path' => 'C:\\laragon\\www\\humas_ptsp\\storage\\logs\\browser.log',
        'level' => 'debug',
        'days' => 14,
      ),
    ),
  ),
  'mail' => 
  array (
    'default' => 'log',
    'mailers' => 
    array (
      'smtp' => 
      array (
        'transport' => 'smtp',
        'scheme' => NULL,
        'url' => NULL,
        'host' => '127.0.0.1',
        'port' => '2525',
        'username' => NULL,
        'password' => NULL,
        'timeout' => NULL,
        'local_domain' => '127.0.0.1',
      ),
      'ses' => 
      array (
        'transport' => 'ses',
      ),
      'postmark' => 
      array (
        'transport' => 'postmark',
      ),
      'resend' => 
      array (
        'transport' => 'resend',
      ),
      'sendmail' => 
      array (
        'transport' => 'sendmail',
        'path' => '/usr/sbin/sendmail -bs -i',
      ),
      'log' => 
      array (
        'transport' => 'log',
        'channel' => NULL,
      ),
      'array' => 
      array (
        'transport' => 'array',
      ),
      'failover' => 
      array (
        'transport' => 'failover',
        'mailers' => 
        array (
          0 => 'smtp',
          1 => 'log',
        ),
        'retry_after' => 60,
      ),
      'roundrobin' => 
      array (
        'transport' => 'roundrobin',
        'mailers' => 
        array (
          0 => 'ses',
          1 => 'postmark',
        ),
        'retry_after' => 60,
      ),
    ),
    'from' => 
    array (
      'address' => 'hello@example.com',
      'name' => 'Laravel',
    ),
    'markdown' => 
    array (
      'theme' => 'default',
      'paths' => 
      array (
        0 => 'C:\\laragon\\www\\humas_ptsp\\resources\\views/vendor/mail',
      ),
      'extensions' => 
      array (
      ),
    ),
  ),
  'permission' => 
  array (
    'models' => 
    array (
      'permission' => 'Spatie\\Permission\\Models\\Permission',
      'role' => 'Spatie\\Permission\\Models\\Role',
      'team' => NULL,
      'default_model' => NULL,
    ),
    'table_names' => 
    array (
      'roles' => 'roles',
      'permissions' => 'permissions',
      'model_has_permissions' => 'model_has_permissions',
      'model_has_roles' => 'model_has_roles',
      'role_has_permissions' => 'role_has_permissions',
    ),
    'column_names' => 
    array (
      'role_pivot_key' => NULL,
      'permission_pivot_key' => NULL,
      'model_morph_key' => 'model_id',
      'team_foreign_key' => 'team_id',
    ),
    'register_permission_check_method' => true,
    'register_octane_reset_listener' => false,
    'events_enabled' => false,
    'teams' => false,
    'team_resolver' => 'Spatie\\Permission\\DefaultTeamResolver',
    'use_passport_client_credentials' => false,
    'display_permission_in_exception' => false,
    'display_role_in_exception' => false,
    'enable_wildcard_permission' => false,
    'cache' => 
    array (
      'expiration_time' => 
      \DateInterval::__set_state(array(
         'from_string' => true,
         'date_string' => '24 hours',
      )),
      'key' => 'spatie.permission.cache',
      'store' => 'default',
    ),
  ),
  'queue' => 
  array (
    'default' => 'database',
    'connections' => 
    array (
      'sync' => 
      array (
        'driver' => 'sync',
      ),
      'database' => 
      array (
        'driver' => 'database',
        'connection' => NULL,
        'table' => 'jobs',
        'queue' => 'default',
        'retry_after' => 90,
        'after_commit' => false,
      ),
      'beanstalkd' => 
      array (
        'driver' => 'beanstalkd',
        'host' => 'localhost',
        'queue' => 'default',
        'retry_after' => 90,
        'block_for' => 0,
        'after_commit' => false,
      ),
      'sqs' => 
      array (
        'driver' => 'sqs',
        'key' => '',
        'secret' => '',
        'prefix' => 'https://sqs.us-east-1.amazonaws.com/your-account-id',
        'queue' => 'default',
        'suffix' => NULL,
        'region' => 'us-east-1',
        'after_commit' => false,
      ),
      'redis' => 
      array (
        'driver' => 'redis',
        'connection' => 'default',
        'queue' => 'default',
        'retry_after' => 90,
        'block_for' => NULL,
        'after_commit' => false,
      ),
      'deferred' => 
      array (
        'driver' => 'deferred',
      ),
      'background' => 
      array (
        'driver' => 'background',
      ),
      'failover' => 
      array (
        'driver' => 'failover',
        'connections' => 
        array (
          0 => 'database',
          1 => 'deferred',
        ),
      ),
    ),
    'batching' => 
    array (
      'database' => 'mysql',
      'table' => 'job_batches',
    ),
    'failed' => 
    array (
      'driver' => 'database-uuids',
      'database' => 'mysql',
      'table' => 'failed_jobs',
    ),
  ),
  'services' => 
  array (
    'postmark' => 
    array (
      'key' => NULL,
    ),
    'resend' => 
    array (
      'key' => NULL,
    ),
    'ses' => 
    array (
      'key' => '',
      'secret' => '',
      'region' => 'us-east-1',
    ),
    'slack' => 
    array (
      'notifications' => 
      array (
        'bot_user_oauth_token' => NULL,
        'channel' => NULL,
      ),
    ),
  ),
  'session' => 
  array (
    'driver' => 'database',
    'lifetime' => 120,
    'expire_on_close' => false,
    'encrypt' => false,
    'files' => 'C:\\laragon\\www\\humas_ptsp\\storage\\framework/sessions',
    'connection' => NULL,
    'table' => 'sessions',
    'store' => NULL,
    'lottery' => 
    array (
      0 => 2,
      1 => 100,
    ),
    'cookie' => 'laravel-session',
    'path' => '/',
    'domain' => NULL,
    'secure' => NULL,
    'http_only' => true,
    'same_site' => 'lax',
    'partitioned' => false,
    'serialization' => 'json',
  ),
  'blade-heroicons' => 
  array (
    'prefix' => 'heroicon',
    'fallback' => '',
    'class' => '',
    'attributes' => 
    array (
    ),
  ),
  'blade-icons' => 
  array (
    'sets' => 
    array (
    ),
    'class' => '',
    'attributes' => 
    array (
    ),
    'fallback' => '',
    'components' => 
    array (
      'disabled' => false,
      'default' => 'icon',
    ),
  ),
  'filament' => 
  array (
    'broadcasting' => 
    array (
    ),
    'default_filesystem_disk' => 'local',
    'temporary_file_url_expiry_minutes' => 30,
    'assets_path' => NULL,
    'cache_store' => NULL,
    'cache_path' => 'C:\\laragon\\www\\humas_ptsp\\bootstrap/cache/filament',
    'livewire_loading_delay' => 'default',
    'file_generation' => 
    array (
      'flags' => 
      array (
      ),
    ),
    'system_route_prefix' => 'filament',
  ),
  'inertia' => 
  array (
    'ssr' => 
    array (
      'enabled' => true,
      'runtime' => 'node',
      'ensure_runtime_exists' => false,
      'url' => 'http://127.0.0.1:13714',
      'hot_url' => NULL,
      'timeout' => NULL,
      'ensure_bundle_exists' => true,
      'throw_on_error' => false,
    ),
    'pages' => 
    array (
      'ensure_pages_exist' => false,
      'paths' => 
      array (
        0 => 'C:\\laragon\\www\\humas_ptsp\\resources\\js/pages',
      ),
      'extensions' => 
      array (
        0 => 'js',
        1 => 'jsx',
        2 => 'svelte',
        3 => 'ts',
        4 => 'tsx',
        5 => 'vue',
      ),
    ),
    'testing' => 
    array (
      'ensure_pages_exist' => true,
    ),
    'expose_shared_prop_keys' => true,
    'store_previous_url' => false,
    'history' => 
    array (
      'encrypt' => false,
    ),
    'devtools' => 
    array (
      'enabled' => NULL,
      'except' => 
      array (
        0 => 'telescope*',
        1 => 'horizon*',
        2 => '_inertia/devtools*',
      ),
      'storage' => 
      array (
        'path' => 'C:\\laragon\\www\\humas_ptsp\\storage\\inertia-devtools',
        'ttl' => 24,
        'prune_interval' => 300,
        'limit' => 100,
      ),
      'middleware' => 
      array (
        0 => 'web',
      ),
      'gate' => NULL,
      'redact' => 
      array (
        'keys' => 
        array (
          0 => 'password',
          1 => 'password_confirmation',
          2 => 'current_password',
          3 => 'token',
          4 => '_token',
          5 => 'access_token',
          6 => 'refresh_token',
          7 => 'secret',
          8 => 'client_secret',
          9 => 'api_key',
        ),
        'headers' => 
        array (
          0 => 'cookie',
          1 => 'set-cookie',
          2 => 'authorization',
          3 => 'proxy-authorization',
          4 => 'x-xsrf-token',
          5 => 'x-csrf-token',
        ),
      ),
    ),
    'preserve_big_integers' => false,
  ),
  'boost' => 
  array (
    'enabled' => true,
    'rules' => 
    array (
      'enabled' => true,
      'scoped_guidelines' => false,
    ),
    'guidelines' => 
    array (
      'exclude' => 
      array (
      ),
    ),
    'skills' => 
    array (
      'exclude' => 
      array (
      ),
    ),
    'executable_paths' => 
    array (
      'php' => NULL,
      'composer' => NULL,
      'npm' => NULL,
      'vendor_bin' => NULL,
      'current_directory' => NULL,
    ),
    'browser_logs_watcher' => true,
    'browser_log_levels' => 
    array (
      0 => 'error',
      1 => 'warning',
      2 => 'info',
      3 => 'debug',
    ),
  ),
  'mcp' => 
  array (
    'redirect_domains' => 
    array (
      0 => '*',
    ),
    'custom_schemes' => 
    array (
    ),
    'authorization_server' => NULL,
    'tool_search' => 
    array (
      'max_tool_calls' => 10,
      'max_output_bytes' => 65536,
    ),
    'clients' => 
    array (
      'github' => 
      array (
        'url' => 'https://api.githubcopilot.com/mcp/',
        'token' => NULL,
        'headers' => 
        array (
          'X-MCP-Readonly' => 'true',
        ),
      ),
      'linear' => 
      array (
        'url' => 'https://mcp.linear.app/mcp',
        'token' => NULL,
      ),
      'playwright' => 
      array (
        'command' => 'npx',
        'args' => 
        array (
          0 => '-y',
          1 => '@playwright/mcp@latest',
          2 => '--headless',
        ),
      ),
    ),
  ),
  'tinker' => 
  array (
    'commands' => 
    array (
    ),
    'alias' => 
    array (
    ),
    'dont_alias' => 
    array (
      0 => 'App\\Nova',
    ),
    'trust_project' => 'always',
  ),
);
