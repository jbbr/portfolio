<?php

if (config('auth.oauth_login.enabled')) {
    Route::get('oauth/{provider}/login', ['as' => 'oauth.login', 'uses' => 'Auth\OAuthController@login']);
    Route::get('oauth/{provider}/callback', ['as' => 'oauth.callback', 'uses' => 'Auth\OAuthController@callback']);
}

if (config('auth.password_login.enabled')) {
    Auth::routes();
    Route::get('/register/success', ['as' => 'register.success', 'uses' => 'Auth\RegisterController@registersuccess']);
    Route::get('/register/verify/{token}', ['as' => 'register.verify', 'uses' => 'Auth\RegisterController@verify']);
} else {
    // login/logout routes are required for OAuth login
    Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
    Route::post('logout', 'Auth\LoginController@logout')->name('logout');
}

Route::get('/help', ['as' => 'help', 'uses' => 'HelpController@help']);
Route::get('/imprint', ['as' => 'imprint', 'uses' => 'HelpController@imprint']);
Route::get('/privacy', ['as' => 'privacy', 'uses' => 'HelpController@privacy']);

Route::get('/', function () {
    return redirect(route('portfolios.index'));
})->name('index');

Route::group(['prefix' => 'publish'], function () {

    Route::group(['middleware' => 'auth'], function() {
        Route::get('/tree', ['as' => 'publish.profile.tree', 'uses' => 'PublishController@tree']);
        Route::post('/save', ['as' => 'publish.profile.save', 'uses' => 'PublishController@store']);
        Route::delete('/delete/{publish}', ['as' => 'publish.profile.delete', 'uses' => 'PublishController@destroy']);
    });

    Route::get('/{urlkey}', ['as' => 'publish.portfolios.list', 'uses' => 'PublishController@index']);
    Route::get('/{urlkey}/{portfolio}', ['as' => 'publish.entries.list', 'uses' => 'PublishController@entryList']);
    Route::get('/{urlkey}/{portfolio}/{entry}', ['as' => 'publish.entries.show', 'uses' => 'PublishController@entry']);

});
Route::group(['prefix' => 'portfolios', 'middleware' => 'auth'], function () {
    Route::get('/', ['as' => 'portfolios.index', 'uses' => 'PortfolioController@index']);
    Route::get('/arrange', ['as' => 'portfolios.arrange', 'uses' => 'PortfolioController@arrange']);
    Route::post('/edit', ['as' => 'portfolios.multiedit', 'uses' => 'PortfolioController@multiedit']);
    Route::put('/edit', ['as' => 'portfolios.multiupdate', 'uses' => 'PortfolioController@multiupdate']);
    Route::get('/create', ['as' => 'portfolios.create', 'uses' => 'PortfolioController@create']);
    Route::post('/', ['as' => 'portfolios.store', 'uses' => 'PortfolioController@store']);
    Route::get('/code/{code}', ['as' => 'portfolios.code', 'uses' => 'PortfolioController@confirmImport']);
    Route::post('/import', ['as' => 'portfolios.import', 'uses' => 'PortfolioController@import']);
    Route::get('/{portfolio}/help', ['as' => 'portfolios.help', 'uses' => 'PortfolioController@help']);

    Route::group(['prefix' => '/{portfolio}/entries'], function () {
        Route::get('/', ['as' => 'portfolios.entries.index', 'uses' => 'EntryController@index']);
        Route::get('/create', ['as' => 'portfolios.entries.create', 'uses' => 'EntryController@create']);
        Route::get('/{entry}', ['as' => 'portfolios.entries.show', 'uses' => 'EntryController@show']);
        Route::get('/{entry}/edit', ['as' => 'portfolios.entries.edit', 'uses' => 'EntryController@edit']);
        Route::post('/', ['as' => 'portfolios.entries.store', 'uses' => 'EntryController@store']);
        Route::delete('/{entry}', ['as' => 'portfolios.entries.destroy', 'uses' => 'EntryController@destroy']);
        Route::put('/{entry}', ['as' => 'portfolios.entries.update', 'uses' => 'EntryController@update']);
        Route::post('/upload', ['as' => 'portfolios.entries.upload', 'uses' => 'EntryController@upload']);
    });
});

Route::group(['middleware' => 'auth'], function () {
    Route::get("media/dialog", "MediaController@dialog");
    Route::resource("media", "MediaController", ['except' => 'create']);
    Route::get("media/{medium}/download", ['as' => 'media.download', 'uses' => 'MediaController@download']);
});

Route::group(['prefix' => 'tags', 'middleware' => 'auth'], function () {
    Route::get('/', ['as' => 'tags.index', 'uses' => 'TagsController@index']);
    //Route::get('/create', ['as' => 'tags.create', 'uses' => 'TagsController@create']);
    Route::get('/{tag}', ['as' => 'tags.show', 'uses' => 'TagsController@show']);
    Route::get('/{tag}/edit', ['as' => 'tags.edit', 'uses' => 'TagsController@edit']);
    Route::post('/', ['as' => 'tags.store', 'uses' => 'TagsController@store']);
    Route::delete('/{tag}', ['as' => 'tags.destroy', 'uses' => 'TagsController@destroy']);
    Route::put('/{tag}', ['as' => 'tags.update', 'uses' => 'TagsController@update']);
});

Route::group(['prefix' => 'profile', 'middleware' => 'auth'], function () {
    Route::get('/', ['as' => 'profile.index', 'uses' => 'ProfileController@index']);
    Route::get('/edit', ['as' => 'profile.edit', 'uses' => 'ProfileController@edit']);
    Route::put('/', ['as' => 'profile.update', 'uses' => 'ProfileController@update']);

    Route::group(['prefix' => 'password', 'middleware' => 'auth'], function () {
        Route::get('/edit', ['as' => 'password.edit', 'uses' => 'PasswordController@edit']);
        Route::put('/edit', ['as' => 'password.update', 'uses' => 'PasswordController@update']);
    });

});

Route::group(['prefix' => 'export', 'middleware' => 'auth'], function () {
    $exportType = env('EXPORT_TYPE', '');
    Route::get('/', ['as' => 'export.index', 'uses' => $exportType.'ExportController@index']);
    Route::post('/', ['as' => 'export.index', 'uses' => $exportType.'ExportController@index']);
    Route::post('generate', ['as' => 'export.generate', 'uses' => $exportType.'ExportController@generate']);
    Route::post('send', ['as' => 'export.send', 'uses' => $exportType.'ExportController@send']);
    Route::post('filter', ['as' => 'export.filter', 'uses' => $exportType.'ExportController@filterList']);
});

Route::group(['prefix' => 'locations', 'middleware' => 'auth'], function () {

    Route::get('/', ['as' => 'locations.index', 'uses' => 'LocationController@index']);
    Route::get('/create', ['as' => 'locations.create', 'uses' => 'LocationController@create']);
    Route::get('/{location}', ['as' => 'locations.show', 'uses' => 'LocationController@show']);
    Route::get('/{location}/edit', ['as' => 'locations.edit', 'uses' => 'LocationController@edit']);
    Route::post('/', ['as' => 'locations.store', 'uses' => 'LocationController@store']);
    Route::delete('/{location}', ['as' => 'locations.destroy', 'uses' => 'LocationController@destroy']);
    Route::put('/{location}', ['as' => 'locations.update', 'uses' => 'LocationController@update']);

});

/** Admin - Routes */
Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'admin']], function () {

    Route::group(['prefix' => 'users', 'middleware' => ['auth', 'admin']], function () {
        Route::get('/', ['as' => 'admin.users.index', 'uses' => 'AdminController@users']);
        Route::post('/', ['as' => 'admin.user.store', 'uses' => 'AdminController@userStore']);
        Route::get('/create', ['as' => 'admin.user.create', 'uses' => 'AdminController@userCreate']);
        Route::put('/{user}', ['as' => 'admin.user.update', 'uses' => 'AdminController@userUpdate']);
        Route::delete('/{user}', ['as' => 'admin.user.destroy', 'uses' => 'AdminController@userDestroy']);
        Route::get('/{user}/edit', ['as' => 'admin.user.edit', 'uses' => 'AdminController@userEdit']);
    });

    Route::group(['prefix' => 'config', 'middleware' => ['auth', 'admin']], function () {
        Route::get('/', ['as' => 'admin.config.index', 'uses' => 'AdminController@config']);
        Route::post('/', ['as' => 'admin.config.store', 'uses' => 'AdminController@saveConfig']);
    });
});