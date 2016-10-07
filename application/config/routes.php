<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'tour';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['edit-request/(:any)'] = "approvals/edit_request/(:any)";
$route['view-request/(:any)'] = "approvals/view_request/(:any)";
$route['edit-request-modal/(:any)'] = "approvals/edit_request_modal/$1";

$route['approvals/approvals-menu/(:any)'] = "approvals/approvals_menu/$1";
$route['approvals/approvals-today/(:any)'] = "approvals/approvals_today/$1";
$route['approvals/approvals-week/(:any)'] = "approvals/approvals_week/$1";
$route['approvals/approvals-month/(:any)'] = "approvals/approvals_month/$1";
$route['approvals/approvals-outlet/(:any)'] = "approvals/approvals_outlet/$1";
$route['approvals/get_outlet_approvals'] = "approvals/get_outlet_approvals";

$route['approvals/save_edit_request'] = "approvals/save_edit_request";
$route['approvals/save_reply'] = "approvals/save_reply";
$route['approvals/delete_suggest_edit'] = "approvals/delete_suggest_edit";

$route['approvals/change_comment_status'] = "approvals/change_comment_status";
$route['approvals/get_approvals_by_date'] = "approvals/get_approvals_by_date";
$route['approvals/edit-approval-phase'] = "approvals/edit_approval_phase";
$route['approvals/phase-user-list/(:any)'] = "approvals/phase_user_list/$1";
$route['approvals/edit-approval-phase/(:any)/(:any)'] = "approvals/edit_approval_phase/$1/$2";
$route['approvals/edit-approval-phase/(:any)/(:any)/(:any)'] = "approvals/edit_approval_phase/$1/$2/$3";



$route['approvals/(:any)/(:any)'] = "approvals/index/$1/$2";
$route['reminders/(:any)'] = "reminders/index/$1";

$route['brands/add-existing-user/(:num)'] = "brand_users/add_existing_user/$1";
$route['brands/save-existing-user'] = "brand_users/save_existing_user";

$route['drafts/(:any)'] = "drafts/index/$1";

$route['send_mail_pending_approvers'] = "approvals/send_mail_pending_approvers";
$route['approvals/(:any)'] = "approvals/index/$1";
$route['archives/export_post/(:any)'] = "archives/export_post/$1";
$route['archives/(:any)'] = "archives/index/$1";



$route['set-password/(:any)'] = "tour/set_password/$1";
$route['join-co-create/(:any)/(:any)'] = "tour/join_co_create/$1/$2";

// $route['register_user/(:any)/(:any)'] = "tour/register_sub_user/$1/$2";
$route['user_preferences/change-plan'] = "user_preferences/change_plan";
$route['user_preferences/save_payment'] = "user_preferences/save_payment";

$route['user_preferences/add_user'] = "user_preferences/add_user";
$route['user_preferences/edit_user_info'] = "user_preferences/edit_user_info";
$route['user_preferences/(:any)'] = "user_preferences/index/$1";
$route['user_preferences/edit_user_info'] = "user_preferences/edit_user_info";
$route['terms-of-use'] = "footer/terms_of_use";
$route['privacy-policy'] = "footer/privacy_policy";


