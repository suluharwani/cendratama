<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (is_file(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
//home
//alt_login
$routes->get('/altlogin', 'Login::altlogin');

// alt login
$routes->get('/', 'Home::index');
$routes->get('/contact', 'Contact::index');
$routes->get('/blog', 'Blog::index');
$routes->get('/blog/(:any)', 'Blog::content/$1');
$routes->get('/informations', 'Informations::index');
$routes->get('/informations/(:any)', 'Informations::info/$1');
$routes->get('/pages', 'Pages::index');
//product
$routes->get('/admin/product', 'Product::index');
$routes->post('/admin/product/tambah_group', 'Product::tambah_group');
$routes->post('/admin/product/select_group', 'Product::select_group');
$routes->post('/admin/product/deleted_group', 'Product::deleted_group');
$routes->post('/admin/product/purge_group', 'Product::purge_group');
$routes->post('/admin/product/upload', 'Product::upload');
$routes->post('/admin/product/update_cat', 'Product::update_cat');
$routes->post('/admin/product/hapus_cat', 'Product::hapus_cat');
$routes->post('/admin/product/restore_cat', 'Product::restore_cat');
$routes->post('/admin/product/create', 'Product::create');


//admin
$routes->get('/admin', 'Admin::index' , ['as' => 'admin']);
$routes->get('/admin/manage/pages', 'Pages::manage');
$routes->get('/admin/manage/static_pages', 'StaticPages::manage');
$routes->get('/admin/login', 'Login::index');
$routes->post('/admin/login', 'Login::index');
$routes->get('/admin/register', 'Login::register');
$routes->get('/logout', 'Login::logout');
$routes->get('/admin/user/(:any)', 'User::user/$1');
//datatables post product

$routes->post('/product/listdataProduct', 'Product::listdataProduct');

//datatables post user admin
$routes->post('/admin/listdata_user', 'User::listdata_user');
$routes->post('/admin/user/tambah_admin', 'User::tambah_admin');
$routes->post('/admin/user/hapus_user', 'User::hapus_user');
$routes->post('/admin/user/reset_password', 'User::reset_password');
$routes->post('/admin/user/ubah_status_user', 'User::ubah_status_user');
$routes->post('/admin/user/ubah_level_user', 'User::ubah_level_user');
//datatables post client
$routes->post('/admin/listdata_client', 'User::listdata_client');
$routes->post('/admin/user/tambah_client', 'User::tambah_client');
$routes->post('/admin/user/hapus_client', 'User::hapus_client');
$routes->post('/admin/user/reset_password_client', 'User::reset_password_client');
$routes->post('/admin/user/ubah_status_client', 'User::ubah_status_client');
//datatables post user pages
$routes->post('/pages/listdata_pages', 'Pages::listdata_pages');
$routes->post('/admin/page/tambah_page', 'Pages::tambah_page');
$routes->post('/admin/page/hapus_page', 'Pages::hapus_page');
$routes->post('/admin/page/detail', 'Pages::detail');
$routes->post('/admin/page/deleted_page', 'Pages::deleted_page');
$routes->post('/admin/page/restore_page', 'Pages::restore_page');
$routes->post('/admin/page/update_page', 'Pages::update_page');
$routes->post('/admin/page/cat_list', 'Pages::cat_list');
$routes->post('/admin/page/subcat_list', 'Pages::subcat_list');
//cat sub cat
$routes->post('/admin/page/tambah_cat', 'Pages::tambah_cat');
$routes->post('/admin/page/update_cat', 'Pages::update_cat');
$routes->post('/admin/page/update_subcat', 'Pages::update_subcat');
$routes->post('/admin/page/hapus_cat', 'Pages::hapus_cat');
$routes->post('/admin/page/hapus_subcat', 'Pages::hapus_subcat');
$routes->post('/admin/page/tambah_subcat', 'Pages::tambah_subcat');

$routes->get('/admin/test/(:any)', 'Admin::test/$1');
//menu
$routes->post('/home/menu', 'Home::menu');
$routes->post('/home/menu_cat', 'Home::menu_cat');
$routes->post('/home/menu_sub_cat', 'Home::menu_sub_cat');

//page
$routes->get('/page/(:any)/(:any)/(:any)(:any)', 'Home::page/$1/$2/$3/$4');
$routes->get('/page/(:any)/(:any)/(:any)', 'Home::page/$1/$2/$3');
$routes->get('/page/(:any)/(:any)', 'Home::page/$1/$2');
$routes->get('/page/(:any)', 'Home::page/$1');
$routes->get('/page', 'Home::page');

$routes->post('/home/get_menu_array', 'Home::get_menu_array');

//static pages
$routes->get('/admin/static_page', 'StaticPages::crud');
$routes->get('/admin/manage/static_pages/(:any)', 'StaticPages::manage_static_page/$1');
$routes->post('/admin/static_page/(:any)', 'StaticPages::crud/$1');
$routes->post('/admin/static/ubah_status', 'StaticPages::ubah_status');
//tinymce
$routes->post('/admin/upload/tinymce', 'StaticPages::tinymceUpload');
$routes->get('/admin/static_page/listGambar', 'StaticPages::listGambar');
$routes->post('/admin/static/deleteGambar', 'StaticPages::deleteGambar');
$routes->post('/admin/static/select_client', 'StaticPages::select_client');
$routes->post('/admin/static/select_produk', 'StaticPages::select_produk');


// client area
$routes->get('/client', 'Client::index');
$routes->post('/client', 'Client::index');
$routes->get('/client/sendmail', 'Client::sendEmail');
$routes->get('/clientlogout', 'Client::clientlogout');
$routes->get('/client/verify/(:any)', 'Client::verify/$1');
$routes->get('/client/verifikasi/(:any)', 'Client::verifikasi/$1');

//homepage
$routes->post('/home/getContactUs', 'Home::getContactUs');
$routes->post('/home/getSlider', 'Home::getSlider');
$routes->post('/home/getService', 'Home::getService');
$routes->post('/home/getPortfolio', 'Home::getPortfolio');
$routes->post('/home/getTestimonial', 'Home::getTestimonial');
$routes->post('/home/getPartner', 'Home::getPartner');
$routes->post('/home/getOffer', 'Home::getOffer');
$routes->post('/home/getGroupProduct', 'Home::getGroupProduct');


/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
