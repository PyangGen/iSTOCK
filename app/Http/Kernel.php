'web' => [

    \App\Http\Middleware\EncryptCookies::class,
    \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
    \Illuminate\Session\Middleware\StartSession::class,

    \App\Http\Middleware\SetLocale::class,

    \Illuminate\View\Middleware\ShareErrorsFromSession::class,
],