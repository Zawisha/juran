<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});
Route::post('/auth/register', 'MyAuth\AuthController@register');
Route::post('auth/login', 'MyAuth\AuthController@login');

Route::group(['middleware' => 'jwt.auth'], function(){
    Route::get('auth/user', 'MyAuth\AuthController@user');
    Route::post('auth/logout', 'MyAuth\AuthController@logout');
    Route::get('is_admin', 'MyAuth\AuthController@is_admin');
    Route::post('save_subject', 'DBController@save_subject');
    Route::post('subject_list_pagination', 'DBController@subject_list_pagination');
    Route::post('subjects_list', 'DBController@subjects_list');
    Route::post('delete_subject', 'DBController@delete_subject');
    Route::post('get_subject', 'DBController@get_subject');
    Route::post('update_subject', 'DBController@update_subject');
    Route::post('render_documents', 'DBController@render_documents');
    Route::post('save_first_text', 'TextController@save_first_text');
    Route::post('user_info', 'DBController@user_info');
    Route::post('store_pic', 'ImageController@store_pic');
    Route::post('store_pic_tooltip', 'ImageController@store_pic_tooltip');
    Route::post('store_pic_proc_list', 'ImageController@store_pic_proc_list');
    Route::post('del_ava', 'ImageController@del_ava');
    Route::post('check_ava', 'ImageController@check_ava');
    Route::post('save_word_doc', 'TextController@save_word_doc');
    Route::post('get_autocomplete', 'DBController@get_autocomplete');
    Route::post('abbreviation_save', 'DBController@abbreviation_save');
    Route::post('get_autocomplete_tooltip', 'DBController@get_autocomplete_tooltip');
    Route::post('save_user_data', 'MyAuth\AuthController@save_user_data');
    Route::post('change_password', 'MyAuth\AuthController@change_password');


});
Route::group(['middleware' => 'jwt.refresh'], function(){
    Route::get('auth/refresh', 'MyAuth\AuthController@refresh');
});
Route::post('confirm', 'MyAuth\AuthController@confirmToken');
Route::post('forget', 'MyAuth\AuthController@forgetPassword');
Route::post('ifexist', 'MyAuth\AuthController@if_exist');


Route::post('add_content', 'DBController@store');
Route::post('delete', 'DBController@destroy');
Route::post('render', 'DBController@render');
Route::post('render_posts', 'DBController@render_posts');
Route::post('post_id', 'DBController@post_id');
Route::post('select_line', 'DBController@select_line');
Route::post('select_name', 'DBController@select_name');
Route::post('add_procedure', 'DBController@add_procedure');
Route::post('render_procedures', 'DBController@render_procedures');
Route::post('render_blocks', 'DBController@render_blocks');
Route::post('render_parents', 'DBController@render_parents');
Route::post('max_block_id', 'DBController@max_block_id');
Route::post('delete_post', 'DBController@delete_post');
Route::post('delete_procedure', 'DBController@delete_procedure');
Route::post('delete_block', 'DBController@delete_block');
Route::post('add_current_post', 'DBController@add_current_post');
Route::post('select_front_current_post', 'DBController@select_front_current_post');
Route::post('change_current_block', 'DBController@change_current_block');
Route::post('select_front_current_block', 'DBController@select_front_current_block');

Route::post('front_render_procedures', 'DBController@front_render_procedures');
Route::post('front_render_start_block', 'DBController@front_render_start_block');
Route::post('front_render_add_block', 'DBController@front_render_add_block');
Route::post('update_post_name', 'DBController@update_post_name');
Route::post('update_procedure_name', 'DBController@update_procedure_name');
Route::post('polute_start_array', 'DBController@polute_start_array');

Route::post('documents_list', 'DBController@documents_list');
Route::post('users_list', 'DBController@users_list');
Route::post('users_list_pagination', 'DBController@users_list_pagination');
Route::post('change_user_banned', 'DBController@change_user_banned');
Route::post('change_user_role', 'DBController@change_user_role');
Route::post('is_log', 'MyAuth\AuthController@is_log');
Route::post('test_hash', 'MyAuth\AuthController@test_hash');
Route::post('tooltip_get_arr', 'DBController@tooltip_get_arr');
Route::post('get_abbr_descr', 'DBController@get_abbr_descr');
Route::post('tooltip_add_text', 'DBController@tooltip_add_text');
Route::post('render_start_tooltip_content', 'DBController@render_start_tooltip_content');
Route::post('edit_tooltip_text', 'DBController@edit_tooltip_text');
Route::post('delete_tooltip_block', 'DBController@delete_tooltip_block');
Route::post('edit_pic_tooltip', 'ImageController@edit_pic_tooltip');
Route::post('get_img_proc_path', 'ImageController@get_img_proc_path');
Route::post('get_content_from_tooltip_db', 'DBController@get_content_from_tooltip_db');
Route::post('get_content_from_tooltip_db_dawn', 'DBController@get_content_from_tooltip_db_dawn');





//Route::post('vk_get_token', 'DBController@vk_get_token');



