<?php

Route::group([
    'middleware' => ['web'],
    'version' => 'v1',
    'prefix' => Config::get('cms.apiUri')
        ], function () {
    //API for User
    Route::prefix('user')->group(function () {
        Route::post('login', 'Zilliqa\Api\Controllers\User@login');
        Route::post('signup', 'Zilliqa\Api\Controllers\User@signup');
        Route::post('forgotPassword', 'Zilliqa\Api\Controllers\User@forgotPassword');
        Route::post('resetPassword', 'Zilliqa\Api\Controllers\User@resetPassword');
        Route::get('country', 'Zilliqa\Api\Controllers\User@listCountry')->name('user.listCountry');
        Route::post('check-referal', 'Zilliqa\Api\Controllers\User@checkReferal');
        Route::post('confirm-register', 'Zilliqa\Api\Controllers\User@confirmRegister');
    });

    Route::middleware('Zilliqa\Api\Middleware\JwtMiddleware')->prefix('user')->group(function () {
        Route::post('changePassword', 'Zilliqa\Api\Controllers\User@changePassword')->name('user.changePassword');
        Route::get('logout', 'Zilliqa\Api\Controllers\User@logout')->name('user.logOut');
        Route::get('me', 'Zilliqa\Api\Controllers\User@detail')->name('user.detail');
        Route::post('edit', 'Zilliqa\Api\Controllers\User@edit')->name('user.editAccount');
        Route::get('get-list-referal', 'Zilliqa\Api\Controllers\User@getListReferal');
    });
    Route::middleware('Zilliqa\Api\Middleware\JwtMiddleware')->prefix('lending')->group(function () {
        Route::get('/', 'Zilliqa\Api\Controllers\Lending@listAll')->name('lending.list');
        Route::get('/subscription', 'Zilliqa\Api\Controllers\Lending@subscription')->name('lending.subscription');
    });

    Route::middleware('Zilliqa\Api\Middleware\JwtMiddleware')->prefix('history')->group(function () {
        Route::post('/deposit', 'Zilliqa\Api\Controllers\History@historyDeposit')->name('historyDeposit.list');
        Route::post('/with-draw', 'Zilliqa\Api\Controllers\History@historyWithDraw')->name('historyWithDraw.list');
        Route::post('/daily', 'Zilliqa\Api\Controllers\History@historyDaily')->name('historyDaily.list');
        Route::post('/commission', 'Zilliqa\Api\Controllers\History@historyCommission')->name('historyCommission.list');
        Route::post('/store/deposit', 'Zilliqa\Api\Controllers\History@storeDeposit')->name('deposit.store');
        Route::post('/store/with-draw', 'Zilliqa\Api\Controllers\History@storeWithDraw')->name('withdraw.store');
        Route::post('/update/deposit', 'Zilliqa\Api\Controllers\History@updateDeposit')->name('update.deposit');
        Route::post('/update/with-draw', 'Zilliqa\Api\Controllers\History@updateWithDraw')->name('update.withdraw');
    });

    Route::middleware('Zilliqa\Api\Middleware\JwtMiddleware')->prefix('business')->group(function () {
        Route::get('/subscription', 'Zilliqa\Api\Controllers\Lending@subscription')->name('business.subscription');
        Route::get('/price-eth', 'Zilliqa\Api\Controllers\Lending@getPriceETH')->name('business.getPriceETH');
    });


    /* Route::middleware('Zilliqa\Api\Middleware\JwtMiddleware')->prefix('user')->group(function () {
      Route::post('changePassword', 'Zilliqa\Api\Controllers\User@changePassword')->name('user.changePassword');
      Route::get('logout', 'Zilliqa\Api\Controllers\User@logout')->name('user.logOut');
      Route::get('me', 'Zilliqa\Api\Controllers\User@detail')->name('user.detail');
      Route::post('edit', 'Zilliqa\Api\Controllers\User@edit')->name('user.editAccount');
      });
      Route::middleware('Zilliqa\Api\Middleware\JwtMiddleware')->prefix('lending')->group(function () {
      Route::get('/', 'Zilliqa\Api\Controllers\Lending@listAll')->name('lending.list');
      Route::get('/subscription', 'Zilliqa\Api\Controllers\Lending@subscription')->name('lending.subscription');
      });

      Route::middleware('Zilliqa\Api\Middleware\JwtMiddleware')->prefix('history')->group(function () {
      Route::post('/deposit', 'Zilliqa\Api\Controllers\Lending@historyDeposit')->name('historyDeposit.list');
      Route::post('/with-draw', 'Zilliqa\Api\Controllers\Lending@historyWithDraw')->name('historyWithDraw.list');
      });

      Route::middleware('Zilliqa\Api\Middleware\JwtMiddleware')->prefix('business')->group(function () {
      Route::get('/subscription', 'Zilliqa\Api\Controllers\Lending@subscription')->name('business.subscription');
      }); */
});
