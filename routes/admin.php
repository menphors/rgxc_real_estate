<?php
Route::group(['prefix' => 'property', 'as' => 'property.'], function() {
  Route::get('view-trash', 'PropertyController@viewTrash')->name('view-trash');
  Route::get('restore-trash/{id}', 'PropertyController@restoreTrash')->name('restore-trash'); 
  Route::delete('force-delete/{id}', 'PropertyController@deleteTrash');
});

Route::resource('dashboard', 'DashboardController');
Route::resource('role', 'RoleController');
Route::resource('staff', 'StaffController');
Route::get('property/get-district-province/{id}', 'PropertyController@getDistrictProvince');
Route::get('property/get-commune-district/{id}', 'PropertyController@getCommuneDistrict');
Route::get('property/get-village-commune/{id}', 'PropertyController@getVillageCommune');
Route::get('staff-by-office/{id}', "StaffController@staffbyOffice")->name('staff-by-office');
Route::resource('property', 'PropertyController');
Route::post('logout', "UserController@logout")->name("user-logout");
Route::get('suggestion', "PropertyController@suggestion")->name('suggestion');

Route::get("change-gallery-type", "PropertyController@changeGalleryType")->name("property-change-gallery-type");
Route::prefix('property')->group(function () {
  Route::get("/", "PropertyController@index")->name("property-listing");
  // Route::get("/delete/{id}", "PropertyController@destroy")->name("property-delete");
  Route::get("view/{id}", "PropertyController@show")->name("property-view");
  Route::post("update/{id}", "PropertyController@update")->name("property-update");
  Route::post("store", "PropertyController@store")->name("property-store");
  Route::post("upload/gallery/{id}", "PropertyController@upload")->name("property-upload-gallery");
  Route::post("remove/gallery/{property_id}/{attachment_id}", "PropertyController@removeImage")->name("property-remove-gallery");
  Route::post("send-property-to-office/{property_id}", "PropertyController@sendPropertyToOffice")->name("send-property-to-office");
  Route::post("completed-reviewed/{property_id}", "PropertyController@completedReview")->name("property-completed-reviewed");
  Route::match(['POST', 'GET'], "published/{property_id}", "PropertyController@publishedProperty")->name("property-published");
  Route::post("solved/{property_id}", "PropertyController@solvedProperty")->name("property-solved");

  Route::post("setup-commission", "PropertyController@setupCommission")->name("property-setup-commission");
  Route::post("delete-commission/{id}", "PropertyController@deleteCommission")->name("property-delete-commission");
  Route::post("update-commission/{id}", "PropertyController@updateCommission")->name("property-update-commission");

  Route::post("add-staff/{property_id}", "PropertyController@addStaffToProperty")->name("property-add-staff");
  Route::post("remove-staff/{staff_id}/{property_id}", "PropertyController@removeStaff")->name("property-remove-staff");


  Route::get("generate-link/{property_id}", "PropertyController@generateClientUrl")->name("property-generate-link");
  Route::get("generate-pdf/{property_id}", "PropertyController@generatePDF")->name("property-generate-pdf");

  Route::post("upload-owner-contract/{property_id}", "PropertyController@uploadOwnerContract")->name("property-owner-contract");

  Route::get("change-state/{property_id}/{state?}", "PropertyController@changeState")->name("property-change-state");
  Route::post("save/collector", "PropertyController@createCollector")->name("property-create-collector");

  Route::prefix('ajax')->group(function () {
    Route::get("get-staff-by-role-type/{type}", "PropertyController@getStaffByRoleType")->name("property-get-staff-by-role-type");
  });
});

Route::prefix("contract")->group(function () {
    Route::post("remove/{id}/{property_id}", "PropertyController@removeContract")->name('remove-contract');
});

Route::prefix('user')->group(function (){
    Route::get("/", "UserController@index")->name("user.index");
    Route::post("/", "UserController@store")->name("user.store");
    Route::put("/{id}", "UserController@update")->name("user.update");
    Route::delete("/{id}", "UserController@destroy")->name("user.delete");
    Route::get("create", "UserController@create")->name("user.create");
    Route::get("create", "UserController@create")->name("user.create");
    Route::get("edit/{id}", "UserController@edit")->name("user.edit");
    Route::get("change-password/{id}", "UserController@changePassword")->name("user.change-password");
    Route::post("change-password/{id}", "UserController@storeChangePassword")->name("user.store-change-password");
});

Route::prefix('province')->group(function () {
    Route::get("/", "ProvinceController@index")->name("province-list");
    Route::get("add", "ProvinceController@create")->name("province-add");
    Route::get("edit/{id}", "ProvinceController@edit")->name("province-edit");
    Route::post("store", "ProvinceController@store")->name("province-store");
    Route::post("update/{id}", "ProvinceController@update")->name("province-update");
});


Route::prefix('district')->group(function () {
    Route::get("/", "DistrictController@index")->name("district-list");
    Route::get("add", "DistrictController@create")->name("district-add");
    Route::get("edit/{id}", "DistrictController@edit")->name("district-edit");
    Route::post("store", "DistrictController@store")->name("district-store");
    Route::post("update/{id}", "DistrictController@update")->name("district-update");
});


Route::prefix('commune')->group(function () {
    Route::get("/", "CommuneController@index")->name("commune-list");
    Route::get("add", "CommuneController@create")->name("commune-add");
    Route::get("edit/{id}", "CommuneController@edit")->name("commune-edit");
    Route::post("store", "CommuneController@store")->name("commune-store");
    Route::post("update/{id}", "CommuneController@update")->name("commune-update");
});


Route::prefix('village')->group(function () {
    Route::get("/", "VillageController@index")->name("village-list");
    Route::get("add", "VillageController@create")->name("village-add");
    Route::get("edit/{id}", "VillageController@edit")->name("village-edit");
    Route::post("store", "VillageController@store")->name("village-store");
    Route::post("update/{id}", "VillageController@update")->name("village-update");
});

Route::prefix('property-type')->group(function () {
    Route::get("/", "PropertyTypeController@index")->name("property-type-listing");
    Route::get("add", "PropertyTypeController@create")->name("property-type-add");
    Route::post("store", "PropertyTypeController@store")->name("property-type-store");
    Route::get("edit/{id}", "PropertyTypeController@edit")->name("property-type-edit");
    Route::post("update/{id}", "PropertyTypeController@update")->name("property-type-update");
    Route::post("delete/{id}", "PropertyTypeController@destroy")->name("property-type-delete");
});

Route::prefix("property-owner")->group(function (){
    Route::get("/", "OwnerController@index")->name("property-owner-listing");
    Route::get("add", "OwnerController@create")->name("property-owner-add");
    Route::post("store", "OwnerController@store")->name("property-owner-store");
    Route::get("edit/{id}", "OwnerController@edit")->name("property-owner-edit");
    Route::post("update/{id}", "OwnerController@update")->name("property-owner-update");
    Route::post("destroy/{id}", "OwnerController@destroy")->name("property-owner-destroy");
});


Route::prefix('office')->group(function () {
    Route::get("/", "OfficeController@index")->name("office-listing");
    Route::get("add", "OfficeController@create")->name("office-add");
    Route::post("store", "OfficeController@store")->name("office-store");
    Route::get("edit/{id}", "OfficeController@edit")->name("office-edit");
    Route::post("update/{id}", "OfficeController@update")->name("office-update");
    Route::post("delete/{id}", "OfficeController@destroy")->name("office-destroy");
});

Route::prefix('config')->group(function () {
    Route::get("/", "ConfigController@index")->name("config-index");
    Route::post("store", "ConfigController@store")->name("config-store");
});

Route::prefix('cms')->group(function () {
    Route::get("/", "CMSController@index")->name("cms-index");
    Route::get("add", "CMSController@create")->name("cms-create");
    Route::post("store", "CMSController@store")->name("cms-store");
    Route::get("cms-edit/{id}", "CMSController@edit")->name("cms-edit");
    Route::post("destroy/{id}", "CMSController@destroy")->name("cms-destroy");
});

Route::prefix("customer")->group(function (){
    Route::get("/", "CustomerController@index")->name("customer-listing");
    Route::get("add", "CustomerController@create")->name("customer-add");
    Route::post("store", "CustomerController@store")->name("customer-store");
    Route::get("edit/{id}", "CustomerController@edit")->name("customer-edit");
    Route::post("delete/{id}", "CustomerController@destroy")->name("customer-destroy");
});

Route::prefix("sale")->group(function (){
    Route::get("/", "SaleController@index")->name("sale-listing");
    Route::get("detail/{id}", "SaleController@show")->name("sale-detail");
    Route::get("add", "SaleController@create")->name("sale-add");
    Route::get("get-property-data/{property_id}", "SaleController@getPropertyData")->name("sale-get-property-data");
    Route::post("store", "SaleController@store")->name("store-sale");
    Route::post("store-staff-payment/{sale_id}", "SaleController@storeStaffPayment")->name("store-staff-payment");
    Route::get("get-staff-by-type/{type}/{sale_id}", "SaleController@getStaffByType")->name("store-staff-by-type");
    Route::get('suggestion', 'SaleController@suggestion')->name('suggestion');
    Route::delete("/{id}", "SaleController@destroy")->name("sale.delete");
});

Route::prefix("payment")->group(function (){
    Route::post("save/{property_id}", "SaleController@storePayment")->name("store-payment");
});

Route::prefix("project")->group(function (){
   Route::get("/", "ProjectController@index")->name("project-listing");
   Route::get("add", "ProjectController@create")->name("project-add");
   Route::post("store", "ProjectController@store")->name("project-store");
   Route::get("project-edit/{project_id}", "ProjectController@edit")->name("project-edit");
   Route::get("show/{project_id}", "ProjectController@show")->name("project-show");
   Route::post("project-update/{project_id}", "ProjectController@update")->name("project-update");
   Route::post("project-destroy/{project_id}", "ProjectController@destroy")->name("project-destroy");
});

Route::prefix('transfer')->group(function () {
    Route::get("province", "TransferController@province")->name("transfer-province");
    Route::get("district", "TransferController@district")->name("transfer-district");
    Route::get("commune", "TransferController@commune")->name("transfer-commune");
    Route::get("village", "TransferController@village")->name("transfer-village");
});

Route::prefix('report')->group(function() {
  Route::get('commission', "ReportController@commission")->name("commission");
  Route::get('sale', "ReportController@sale")->name("sale");
  Route::get('properties', "ReportController@properties")->name('properties');
});

Route::prefix('tag')->group(function () {
  Route::get("/", "TagController@index")->name("tag-listing");
  Route::get("add", "TagController@create")->name("tag-add");
  Route::post("store", "TagController@store")->name("tag-store");
  Route::get("edit/{id}", "TagController@edit")->name("tag-edit");
  Route::post("update/{id}", "TagController@update")->name("tag-update");
  Route::post("delete/{id}", "TagController@destroy")->name("tag-delete");

  Route::get('search', "TagController@search")->name('serach');
});
