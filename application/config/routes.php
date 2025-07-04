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
$route['default_controller'] = 'inquiry';
// $route['CustomerCare'] = 'customercare';
$route['customercare'] = 'CustomerCareController/index';

#ltrs
$route['ltrs'] = 'LtrsController/index';
$route['ltrs/psgc'] = 'LtrsController/get_psgc_select';
$route['ltrs/store'] = 'LtrsController/store';

#job application
$route['careers'] = 'JobApplication/index';
$route['jobapplication/apply'] = 'JobApplication/apply';
$route['jobapplication/loan/find_psgc'] = 'JobApplication/find_psgc';
$route['careers/view/(:num)'] = 'JobApplication/view/$1';
$route['jobapplication/getJobsData'] = 'JobApplication/getJobsData';
$route['jobapplication/sms_sending'] = 'JobApplication/sms_sending';
$route['jobapplication/submit'] = 'JobApplication/submit';
$route['jobapplication/getCourse'] = 'JobApplication/getCourse';
$route['jobapplication/getDesiredPosition'] ='JobApplication/getDesiredPosition';

#feedback
$route['fb'] = 'feedback';
$route['Feedback'] = 'feedback';

#bigbike
$route['big-bike'] = 'BigBikeReservationController/redirect';#redirect old link
$route['bigbike'] = 'BigBikeReservationController/index';
$route['big-bike/store'] = 'BigBikeReservationController/store';
$route['big-bike/psgc'] = 'BigBikeReservationController/get_psgc_select';
$route['raffle'] = 'RaffleController/index';
$route['draw-raffle'] = 'RaffleController/drawRaffle';
$route['login/(:any)'] = 'RaffleController/login/$1';

#testride
$route['test-ride'] ='TestRideController/redirect';#redirect old link
$route['testride'] = 'TestRideController/index';
$route['api/test-ride/store'] = 'TestRideController/store';
$route['api/test-ride/psgc'] = 'TestRideController/getPsgcSelect';
$route['getSchedule'] = 'TestRideController/getSchedule';

#Clerance
$route['clearance'] = 'ClearanceController/index';
$route['login'] = 'ClearanceController/logIn';
$route['logout'] = 'ClearanceController/logOut';
$route['mainview'] = 'ClearanceController/mainView';
$route['get-clearance'] = 'ClearanceController/getAllClearance';
$route['get-comment'] = 'ClearanceController/getComment';
$route['store-comment'] = 'ClearanceController/storeComment';
$route['edit-email'] = 'ClearanceController/editEmail';
$route['change-status'] = 'ClearanceController/changeStatus';
$route['exit-interview'] = 'ClearanceController/exitInterview';
$route['store-interview'] = 'ClearanceController/storeInterview';
$route['check-interview'] = 'ClearanceController/checkInterview';
$route['download-coe']   = 'ClearanceController/downloadCoe';
$route['download-action'] = 'ClearanceController/DownloadAction';
$route['get-lastpay'] = 'ClearanceController/getLastPay';
$route['lastpay-comment'] = 'ClearanceController/lastPayComment';
$route['agree-action'] = 'ClearanceController/agreeAction';

$route['otp/send'] = 'CustomerCareController/sms_sending';
$route['otp/validate']='CustomerCareController/validateStore';
#Parts generator
$route['parts-checker'] = 'PartsGenaratorController';
$route['get-parts-list'] = 'PartsGenaratorController/getPartsList';
#Admin Panel
$route['data_session'] = 'ClearanceController/session_data';


#attachment checker 
$route['attachment-checker/(:any)'] = 'AttachmentCheckerController/index/$1';
$route['attachment-checker'] = 'AttachmentCheckerController/index';


#applicat online exam
$route['jobapp-exam']           = 'JobApplicationExamController';
$route['auth/login-exam']       = 'JobApplicationExamController/checkApplicant';
$route['exam-view']             = 'JobApplicationExamController/Questionaire';
$route['jobapp-cached-remove']  = 'JobApplicationExamController/deleteCachedData';
$route['store-exam-answer']     = 'JobApplicationExamController/storeAnswer';
$route['jobapp/admin']          = 'JobApplicationExamController/adminLogin';
$route['auth/admin-login']      = 'JobApplicationExamController/authAdmin';
$route['exam-admin-view']       = 'JobApplicationExamController/examAdminView';
$route['getExamResult/(:any)']  = 'JobApplicationExamController/getExamResult/$1';
$route['transferAdmin/(:any)']  = 'JobApplicationExamController/transferAdmin/$1';
$route['getExamResultAll']      = 'JobApplicationExamController/getExamResultAll';
$route['manual-transfer']       = 'JobApplicationExamController/manualTransfer';
$route['exam-logout/(:any)']    = 'JobApplicationExamController/logout/$1';    
$route['getAllApplicantAPI']    = 'JobApplicationExamController/getAllApplicant';
$route['sendEmailInvite']       = 'JobApplicationExamController/sendEmailInvite';
$route['exam_maintenance']      = 'JobApplicationExamController/examMaintenance';
$route['retakeApplicant']       = 'JobApplicationExamController/retakeApplicant';
$route['get-otp-logs']          = 'JobApplicationExamController/getOtpLogs';
$route['send-otp-email']       = 'JobApplicationExamController/sendEmailIOtp';

$route['monitor-otp']       = 'JobApplicationExamController/monitorOtp';


# barcode generator
$route['warehouse']     = 'WarehouseController/index';
$route['warehouse-main-view']     = 'WarehouseController/mainView';
$route['upload-engine'] = 'WarehouseController/uploadEngine';
$route['warehouse-filter-data'] = 'WarehouseController/filterData';
$route['check-engine-number']    = 'WarehouseController/checkEngineNumberData';
$route['getBrandList']      = 'WarehouseController/getallBrandList';
$route['add_pick_list']      = 'WarehouseController/addPickList';
$route['check-Branch']      = 'WarehouseController/checkBranch';
$route['warehouse-login']      = 'WarehouseController/authWarehouse';
$route['warehouse-logout']      = 'WarehouseController/logout';
$route['material-check']      = 'WarehouseController/materialCheck';
$route['material-count']      = 'WarehouseController/materialCount';
$route['get-inventory']      = 'WarehouseController/getInventory';
$route['save-engines']       = 'WarehouseController/saveEngines';
$route['order-change-status']      = 'WarehouseController/changeStatus';
$route['get-check-order']         = 'WarehouseController/getCheckOrder';
$route['add-new-material']           = 'WarehouseController/addNewMaterial';
$route['remove-engine']           = 'WarehouseController/removeEngine';
$route['remove-order-material'] =    'WarehouseController/removeOrderMaterial';
$route['warehouse-users'] = 'WarehouseController/warehouseUsers';
$route['change-access']     =    'WarehouseController/changeAccess';
$route['change-supplying-access']     =    'WarehouseController/changeSupplyingAccess';
$route['change-tab-access']     =    'WarehouseController/tabAccess';

$route['qr-mobile']         =    'WarehouseController/mobileQr';
$route['redirect']          =    'WarehouseController/redirect';



# case NTE 
$route['case-nte'] = 'CaseNTEController';
$route['casente-login'] = 'CaseNTEController/authCaseNTE';
$route['casente-mainview'] = 'CaseNTEController/mainView';
$route['case-seen']     =   'CaseNTEController/caseSeen';

#delete-cached-data
$route['cached-remove/(:any)']  = 'JobApplicationExamController/deleteCachedData/$1';
$route['sample-email']      = 'PhpMailController/send';


$route['cmc-xmas']         = 'CmcChristmasController/index';
$route['cmc-xmas-login']   = 'CmcChristmasController/authLogin';
$route['cmcxmas-mainview'] = 'CmcChristmasController/mainView';
$route['getGeoLocation']   = 'CmcChristmasController/getGeoLocation';
$route['xmas-scan']        = 'CmcChristmasController/xmasScan';
$route['attendance-xmas']   = 'CmcChristmasController/attendance';
$route['xmas-fetch-data']   = 'CmcChristmasController/fetchData';

#maintenanace redirect
$route['maintenance'] = 'MaintenanceController/index';


$route['magic-view'] = 'MagicController/index';
$route['magic-now'] = 'MagicController/now';
$route['magic-reset'] = 'MagicController/reset';
$route['magic-test'] = 'MagicController/test';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
