<?php

// Minimal .env loader: parses KEY=VALUE pairs into $_ENV / getenv() and
// exposes a tiny env() helper. Kirby 5 doesn't auto-load .env files, but
// they're gitignored at the project root so this is the canonical place
// to keep secrets out of version control.
$envFile = dirname(__DIR__, 2) . '/.env';
if (is_file($envFile) && is_readable($envFile)) {
  foreach (file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
    $line = trim($line);
    if ($line === '' || $line[0] === '#') continue;
    if (!str_contains($line, '=')) continue;
    [$key, $value] = explode('=', $line, 2);
    $key = trim($key);
    $value = trim($value, " \t\"'");
    $_ENV[$key] = $value;
    $_SERVER[$key] = $value;
    putenv("$key=$value");
  }
}

if (!function_exists('env')) {
  function env(string $key, mixed $default = null): mixed
  {
    if (array_key_exists($key, $_ENV)) return $_ENV[$key];
    if (array_key_exists($key, $_SERVER)) return $_SERVER[$key];
    $value = getenv($key);
    return $value === false ? $default : $value;
  }
}

// Dev-only: the `.dev` file is present only while the Vite dev server runs
// (written/removed by vite-plugin-kirby). When it exists we tell the browser
// never to cache page responses, so a stale/broken page from a dropped Vite
// connection can always be fixed with a plain reload — no manual cache-clear.
$isDev = is_file(dirname(__DIR__, 2) . '/.dev');

return [
  'debug' => true,

  'hooks' => [
    'route:after' => function () use ($isDev) {
      if ($isDev && headers_sent() === false) {
        header('Cache-Control: no-store, no-cache, must-revalidate');
      }
    },
  ],

  // Environment-specific settings
  // On Fortrabbit, set KIRBY_LICENSE env var instead of using .license file
  'panel' => [
    'install' => false  // Set to true only for initial remote setup
  ],

  // In development (Vite running) the pages cache is OFF, so template,
  // snippet and content edits show up on the next reload instead of serving
  // stale rendered HTML — this is what makes live-reload reliable. In
  // production the pages cache is ON for speed; the home page is excluded
  // because kirby-uniform needs a fresh CSRF token per request.
  'cache' => [
    'pages' => $isDev ? false : [
      'home' => false,
    ],
  ],

  'zapier' => [
    'webhook' => env('PROGRAMME_SIGNUP_WEBHOOK', ''),
  ],

  // Responsive image recipe, defined once and reused everywhere via the
  // `image` snippet. One shared width ladder; three presets so a single
  // high-res upload auto-generates AVIF (smallest) → WebP → original-format
  // fallback. Keys are `w`-descriptors that pair with the `sizes` attribute.
  // Kirby never upscales past the source, so smaller originals simply top out.
  'thumbs' => [
    'srcsets' => [
      'default' => [
        '480w'  => ['width' => 480,  'quality' => 80],
        '768w'  => ['width' => 768,  'quality' => 80],
        '1024w' => ['width' => 1024, 'quality' => 80],
        '1440w' => ['width' => 1440, 'quality' => 78],
        '1920w' => ['width' => 1920, 'quality' => 75],
        '2400w' => ['width' => 2400, 'quality' => 72],
      ],
      'webp' => [
        '480w'  => ['width' => 480,  'format' => 'webp', 'quality' => 76],
        '768w'  => ['width' => 768,  'format' => 'webp', 'quality' => 76],
        '1024w' => ['width' => 1024, 'format' => 'webp', 'quality' => 75],
        '1440w' => ['width' => 1440, 'format' => 'webp', 'quality' => 73],
        '1920w' => ['width' => 1920, 'format' => 'webp', 'quality' => 70],
        '2400w' => ['width' => 2400, 'format' => 'webp', 'quality' => 68],
      ],
      'avif' => [
        '480w'  => ['width' => 480,  'format' => 'avif', 'quality' => 55],
        '768w'  => ['width' => 768,  'format' => 'avif', 'quality' => 55],
        '1024w' => ['width' => 1024, 'format' => 'avif', 'quality' => 52],
        '1440w' => ['width' => 1440, 'format' => 'avif', 'quality' => 50],
        '1920w' => ['width' => 1920, 'format' => 'avif', 'quality' => 48],
        '2400w' => ['width' => 2400, 'format' => 'avif', 'quality' => 46],
      ],
    ],
  ]
];