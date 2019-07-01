<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'before' => 'LaravelLocalizationRedirectFilter',
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'middleware' => 'web' ],
        'namespace' => 'Index',
    ],
    function()
    {
        Route::get('/', 'IndexController@index');
        Route::get('/login', 'IndexController@login');
        Route::get('/lost-password', 'IndexController@lostPassword');
        Route::post('/reset-password', 'IndexController@sendLostPasswordLink');
        Route::get('/reset-pass/{reset_token}', 'IndexController@resetPass');
        Route::post('/set-new-pass', 'IndexController@setNewPass');
    }
);

Route::group([
    'middleware' => 'web',
    'namespace' => 'Index',
], function() {
    Route::post('/login', 'IndexController@login');
});


Route::group([
    'prefix' => 'admin',
    'namespace' => 'Admin',
], function() {
    Route::post('reset-password', 'AdminController@resetPasswordEdit');
    Route::get('cron-update-user-task-status','AdminController@cronUpdateUserTaskStatus');
    Route::get('cron-update-deal-bill-num','AdminController@cronUpdateDealBillNum');
});

Route::group([
    'prefix' => 'admin',
    'namespace' => 'Admin',
    'middleware' => 'web',
], function() {
    Route::post('login', 'AdminController@login');

    Route::get('index', 'AdminController@index');
    Route::get('dashboard', 'AdminController@dashboard');

    Route::get('user-list', 'AdminController@userList');
    Route::get('user-edit/{user_id}', 'AdminController@userEdit');
    Route::post('user-edit/{user_id}', 'AdminController@saveUser');
    Route::get('delete-user', 'AdminController@deleteUser');

    Route::get('region-list', 'AdminController@regionList');
    Route::get('region-edit/{region_id}', 'AdminController@regionEdit');
    Route::post('region-edit/{region_id}', 'AdminController@saveRegion');
    Route::get('delete-region', 'AdminController@deleteRegion');

    Route::get('bank-list', 'AdminController@bankList');
    Route::get('bank-edit/{bank_id}', 'AdminController@bankEdit');
    Route::post('bank-edit/{bank_id}', 'AdminController@saveBank');
    Route::get('delete-bank', 'AdminController@deleteBank');

    Route::get('payment-list', 'AdminController@paymentList');
    Route::get('payment-edit/{payment_id}', 'AdminController@paymentEdit');
    Route::post('payment-edit/{payment_id}', 'AdminController@savePayment');
    Route::get('delete-payment', 'AdminController@deletePayment');

    Route::get('delivery-list', 'AdminController@deliveryList');
    Route::get('delivery-edit/{delivery_id}', 'AdminController@deliveryEdit');
    Route::post('delivery-edit/{delivery_id}', 'AdminController@saveDelivery');
    Route::get('delete-delivery', 'AdminController@deleteDelivery');

    Route::get('brand-list', 'AdminController@brandList');
    Route::get('brand-edit/{brand_id}', 'AdminController@brandEdit');
    Route::post('brand-edit/{brand_id}', 'AdminController@saveBrand');
    Route::get('delete-brand', 'AdminController@deleteBrand');

    Route::get('mark-list', 'AdminController@markList');
    Route::get('mark-edit/{mark_id}', 'AdminController@markEdit');
    Route::post('mark-edit/{mark_id}', 'AdminController@saveMark');
    Route::get('delete-mark', 'AdminController@deleteMark');

    Route::get('fraction-list', 'AdminController@fractionList');
    Route::get('fraction-edit/{fraction_id}', 'AdminController@fractionEdit');
    Route::post('fraction-edit/{fraction_id}', 'AdminController@saveFraction');
    Route::get('delete-fraction', 'AdminController@deleteFraction');

    Route::get('percent-list', 'AdminController@percentList');
    Route::get('percent-edit/{percent_id}', 'AdminController@percentEdit');
    Route::post('percent-edit/{percent_id}', 'AdminController@savePercent');
    Route::get('delete-percent', 'AdminController@deletePercent');

    Route::get('status-list', 'AdminController@statusList');
    Route::get('status-edit/{status_id}', 'AdminController@statusEdit');
    Route::post('status-edit/{status_id}', 'AdminController@saveStatus');
    Route::get('delete-status', 'AdminController@deleteStatus');

    Route::get('timezone-list', 'AdminController@timezoneList');
    Route::get('timezone-edit/{timezone_id}', 'AdminController@timezoneEdit');
    Route::post('timezone-edit/{timezone_id}', 'AdminController@saveTimezone');
    Route::get('delete-timezone', 'AdminController@deleteTimezone');

    Route::get('station-list', 'AdminController@stationList');
    Route::get('station-edit/{station_id}', 'AdminController@stationEdit');
    Route::post('station-edit/{station_id}', 'AdminController@saveStation');
    Route::get('delete-station', 'AdminController@deleteStation');

    Route::get('client-list', 'AdminController@clientList');
    Route::get('client-edit/{client_id}', 'AdminController@clientEdit');
    Route::post('client-edit', 'AdminController@saveClient');
    Route::post('client-edit/{client_id}', 'AdminController@saveClient');
    Route::get('delete-client', 'AdminController@deleteClient');

    Route::get('company-list', 'AdminController@companyList');
    Route::get('company-edit/{company_id}', 'AdminController@companyEdit');
    Route::post('company-edit', 'AdminController@saveCompany');
    Route::post('company-edit/{company_id}', 'AdminController@saveCompany');
    Route::get('delete-company', 'AdminController@deleteCompany');

    Route::get('auto-task-list', 'AdminController@autoTaskList');
    Route::get('auto-task-edit/{auto_task_id}', 'AdminController@autoTaskEdit');
    Route::post('auto-task-edit', 'AdminController@saveAutoTask');
    Route::post('auto-task-edit/{auto_task_id}', 'AdminController@saveAutoTask');
    Route::get('delete-auto-task', 'AdminController@deleteAutoTask');

    Route::get('system-info-list', 'AdminController@systemInfoList');
    Route::get('system-info-edit/{system_info_id}', 'AdminController@systemInfoEdit');
    Route::post('system-info-edit/{system_info_id}', 'AdminController@saveSystemInfo');

    Route::get('change-password-edit', 'AdminController@changePasswordEdit');
    Route::post('change-password-edit', 'AdminController@changePassword');

    Route::get('deal-list', 'AdminController@dealList');
    Route::get('deal-edit/{deal_id}', 'AdminController@dealEdit');
    Route::get('delete-deal', 'AdminController@deleteDeal');
    Route::post('save-deal-info', 'AdminController@saveDealInfo');

    Route::get('profile', 'AdminController@profile');
    Route::post('update-profile-info', 'AdminController@updateProfileInfo');
    Route::get('get-region-list', 'AdminController@getRegionList');
    Route::get('get-station-list', 'AdminController@getStationList');
    Route::get('get-client-list', 'AdminController@getClientList');
    Route::get('get-station', 'AdminController@getStation');
    Route::get('get-company-list', 'AdminController@getCompanyList');
    Route::post('upload-deal-file', 'AdminController@uploadDealFile');

    Route::post('save-new-user-task', 'AdminController@saveNewUserTask');
    Route::get('load-deal-task/{deal_id}', 'AdminController@loadDealTask');

    Route::post('save-client-answer', 'AdminController@saveClientAnswer');
    Route::get('delete-client-answer', 'AdminController@deleteClientAnswer');

    Route::get('load-client-answers/{deal_id}', 'AdminController@loadClientAnswers');
    Route::post('complete-user-task', 'AdminController@completeUserTask');

    Route::get('load-shipping-comment/{deal_id}', 'AdminController@loadShippingComment');
    Route::post('save-shipping-comment', 'AdminController@saveShippingComment');
    Route::get('delete-shipping-comment', 'AdminController@deleteShippingComment');

    Route::get('load-delivery-comment/{deal_id}', 'AdminController@loadDeliveryComment');
    Route::post('save-delivery-comment', 'AdminController@saveDeliveryComment');
    Route::get('delete-delivery-comment', 'AdminController@deleteDeliveryComment');

    Route::get('load-deal-history/{deal_id}', 'AdminController@loadDealHistory');

    Route::post('calculate-deal-kp-sum', 'AdminController@calculateDealKpSum');
    Route::post('formulate-deal-kp', 'AdminController@formulateDealKpSum');

    Route::get('user-task-list', 'AdminController@userTaskList');
    Route::post('drag-deal-file', 'AdminController@uploadDealOtherFile');

    Route::get('deal-template-file-list', 'AdminController@dealTemplateFileList');
    Route::get('deal-template-file-edit/{deal_template_file_id}', 'AdminController@dealTemplateFileEdit');
    Route::post('deal-template-file-edit/{deal_template_file_id}', 'AdminController@saveDealTemplateFile');
    Route::get('delete-deal-template-file', 'AdminController@deleteDealTemplateFile');

    Route::post('upload-deal-dogovor-file', 'AdminController@uploadDealDogovorFile');
    Route::get('load-deal-kp-file/{deal_id}', 'AdminController@loadDealKpFile');
    Route::get('download-deal-kp', 'AdminController@downloadDealKp');
    Route::get('send-kp-mail', 'AdminController@sendKpMail');

    Route::post('create-deal-bill-file', 'AdminController@createDealBillFile');
    Route::get('load-deal-bill-file/{deal_id}', 'AdminController@loadDealBillFile');
    Route::get('send-bill-mail', 'AdminController@sendBillMail');
    Route::get('send-bill-mail-close', 'AdminController@sendBillMailClose');
    Route::get('delete-deal-file', 'AdminController@deleteDealFile');
    Route::get('delete-deal-kp-file', 'AdminController@deleteDealKpFile');

    Route::get('load-deal-close-file/{deal_id}', 'AdminController@loadDealCloseFile');
    Route::post('create-deal-close-file', 'AdminController@createDealCloseFile');

    Route::get('load-shipping-client-comment/{deal_id}', 'AdminController@loadShippingClientComment');
    Route::post('save-shipping-client-comment', 'AdminController@saveShippingClientComment');
    Route::get('delete-shipping-client-comment', 'AdminController@deleteShippingClientComment');

    Route::get('load-delivery-client-comment/{deal_id}', 'AdminController@loadDeliveryClientComment');
    Route::post('save-delivery-client-comment', 'AdminController@saveDeliveryClientComment');
    Route::get('delete-delivery-client-comment', 'AdminController@deleteDeliveryClientComment');

    Route::get('send-delivery-client-comment-email', 'AdminController@sendDeliveryClientCommentEmail');
    Route::get('send-shipping-client-comment-email', 'AdminController@sendShippingClientCommentEmail');
    Route::get('calculate-deal-rest-volume-sum', 'AdminController@calculateDealRestVolumeSum');

    Route::get('get-station-by-region', 'AdminController@getStationByRegion');
    Route::get('get-fraction-by-brand', 'AdminController@getFractionByBrand');
    Route::get('get-mark-by-brand', 'AdminController@getMarkByBrand');
    Route::get('get-region-by-brand', 'AdminController@getRegionByBrand');

    Route::get('load-notifications', 'AdminController@loadNotifications');
    Route::get('export-station-list', 'AdminController@exportStationList');
    Route::post('import-station-list', 'AdminController@importStationList');

    Route::post('send-deal-refuse-form','AdminController@sendDealRefuseForm');

    Route::get('import-export-station-list','AdminController@importExportStationList');

    Route::get('download-dogovor','AdminController@downloadDogovor');
    Route::get('send-dogovor','AdminController@sendDogovor');

    Route::get('test-doc','AdminController@testDoc');

    //fff
         Route::get('logout', function(){
        Auth::logout();
        return redirect('/');
    });

});

Route::get('/admin', function()
{
    return redirect('/admin/index');
});