<?php
/**
 * 后台管理
 */


//登录,退出
Route::any('login', 'PublicController@login')->name('login');
Route::any('logout', 'PublicController@logout')->name('logout');
/*Route::any('logout', function () {
    auth()->logout();
    return redirect()->route('login');
})->name('logout');*/


/**
 * 首页，控制台
 */
Route::any('', 'IndexController@index')->name('/');
Route::any('index', 'IndexController@shouye')->name('shouye');

Route::any('flush', 'IndexController@flush')->name('flush');
Route::any('flexible', 'IndexController@flexible')->name('flexible');

/**
 * 个人中心
 */
Route::any('/me', 'AdminController@me')->name('me');

Route::any('/test', 'TestController@index')->name('test');

/**
 * 文件上传
 */
Route::post('/upload/{type}', 'FileController@upload')->name('upload');

/**
 * Rbac权限管理(用户管理)
 */
Route::any('rbac', 'AdminController@index')->name('rbac');
Route::any('rbac/admin', 'AdminController@index')->name('admin-users');
Route::any('rbac/admin/add', 'AdminController@add')->name('add-admin');
Route::any('rbac/admin/edit/{id}', 'AdminController@edit')->name('edit-admin');
Route::any('rbac/admin/assign/{id}', 'AdminController@assign')->name('assign-admin');
Route::get('rbac/admin/delete/{id}', 'AdminController@delete')->name('delete-admin');
Route::post('rbac/admin/status', 'AdminController@status')->name('status-admin');

/**
 * Rbac权限管理(角色管理)
 */
Route::any('rbac/roles', 'RoleController@index')->name('roles');
Route::any('rbac/role/add', 'RoleController@add')->name('add-role');
Route::any('rbac/role/edit/{id}', 'RoleController@edit')->name('edit-role');
Route::any('rbac/role/assign/{id}', 'RoleController@assign')->name('assign-permission');
Route::get('rbac/role/delete/{id}', 'RoleController@delete')->name('delete-role');

/**
 * Rbac权限管理(权限规则管理)
 */
Route::any('rbac/permission', 'PermissionController@index')->name('permission');
Route::any('rbac/permission/add', 'PermissionController@add')->name('add-permission');
Route::any('rbac/permission/edit/{id}', 'PermissionController@edit')->name('edit-permission');
Route::get('rbac/permission/menu/{id}', 'PermissionController@menu')->name('menu-permission');
Route::get('rbac/permission/sort/{id}', 'PermissionController@sort')->name('sort-permission');
Route::get('rbac/permission/delete/{id}', 'PermissionController@delete')->name('delete-permission');

/**
 * 用户管理
 */
Route::match(['get', 'post'], 'users', 'UserController@index')->name('users');

/**
 * 部门管理
 */
Route::any('department', 'DepartmentController@index')->name('department');
Route::any('department/list', 'DepartmentController@index')->name('list-department');
Route::any('department/import', 'DepartmentController@import')->name('import-department');
Route::any('department/add', 'DepartmentController@add')->name('add-department');
Route::any('department/edit/{id}', 'DepartmentController@edit')->name('edit-department');
Route::any('department/delete/{id}', 'DepartmentController@destroy')->name('delete-department');
Route::any('department/govcode', 'DepartmentController@govcode')->name('govcode-department');
Route::any('department/id/{govcode}', 'DepartmentController@getIdByGovcode')->name('id-department');

/**
 * 对象管理
 */
Route::any('object', 'ObjectController@index')->name('object');

/**
 * 企业管理
 */
Route::any('company', 'CompanyController@index')->name('company');
Route::any('company/list', 'CompanyController@Company_list')->name('list-company');
Route::any('company/add', 'CompanyController@add')->name('add-company');
Route::any('company/update/{id}', 'CompanyController@update')->name('update-company');
Route::any('company/show/{id}', 'CompanyController@show')->name('show-company');
Route::any('company/status/{id}', 'CompanyController@status')->name('status-company');
Route::any('company/delete/{id}', 'CompanyController@destroy')->name('delete-company');

/**
 * 品牌管理
 */
Route::any('brand', 'BrandController@index')->name('brand');
Route::any('brand/add', 'BrandController@add')->name('add-brand');
Route::any('brand/update/{id}', 'BrandController@update')->name('update-brand');
Route::any('brand/show/{id}', 'BrandController@show')->name('show-brand');
Route::any('brand/status/{id}', 'BrandController@status')->name('status-brand');
Route::any('brand/delete/{id}', 'BrandController@destroy')->name('delete-brand');

/**
 * 转运中心管理
 */
Route::any('transportation', 'TransportationController@index')->name('transportation');
Route::any('transportation/list', 'TransportationController@TransportationList')->name('list-transportation');
Route::any('transportation/list/user', 'TransportationController@TransportationListByUser')->name('listuser-transportation');
Route::any('transportation/add', 'TransportationController@add')->name('add-transportation');
Route::any('transportation/update/{id}', 'TransportationController@update')->name('update-transportation');
Route::any('transportation/show/{id}', 'TransportationController@show')->name('show-transportation');
Route::any('transportation/status/{id}', 'TransportationController@status')->name('status-transportation');
Route::any('transportation/delete/{id}', 'TransportationController@destroy')->name('delete-transportation');
Route::any('transportation/device/{id}', 'TransportationController@device')->name('device-transportation');


Route::any('transportation/play', 'TransportationController@play')->name('play-transportation');
/**
 * 网点管理
 */
Route::any('dot', 'DotController@index')->name('dot');
Route::any('dot/list', 'DotController@DotList')->name('list-dot');
Route::any('dot/add', 'DotController@add')->name('add-dot');
Route::any('dot/update/{id}', 'DotController@update')->name('update-dot');
Route::any('dot/show/{id}', 'DotController@show')->name('show-dot');
Route::any('dot/status/{id}', 'DotController@status')->name('status-dot');
Route::any('dot/delete/{id}', 'DotController@destroy')->name('delete-dot');
Route::any('dot/device/{id}', 'DotController@device')->name('device-dot');

/**
 * 重点对象管理
 */
Route::any('point/object', 'PObjectController@index')->name('pobject');
Route::any('point/object/add', 'PObjectController@add')->name('add-pobject');
Route::post('point/object/query', 'PObjectController@objectQuery')->name('query-pobject');
Route::any('point/object/list', 'PObjectController@objectList')->name('list-pobject');
Route::any('point/object/show/{id}', 'PObjectController@show')->name('show-pobject');
Route::any('point/object/delete/{id}', 'PObjectController@destroy')->name('delete-pobject');
Route::post('point/object/batchdelete','PObjectController@batchDestroy')->name('batch-delete-pobject');
Route::post('point/object/device', 'PObjectController@device')->name('device-pobject');
Route::post('point/object/device/list/{id}', 'PObjectController@deviceList')->name('devicelist-pobject');

/**
 * 轮播设备列表
 */
Route::any('point/device', 'PDeviceController@index')->name('pdevice');
Route::any('point/device/add', 'PDeviceController@add')->name('add-pdevice');
Route::any('point/device/delete/{id}', 'PDeviceController@destroy')->name('delete-pdevice');
Route::post('point/device/batchdelete','PDeviceController@batchDestroy')->name('batch-delete-pdevice');

/**
 * 视频巡检
 */
Route::any('ievent', 'IeventController@index')->name('ievent');
Route::any('ievent/object', 'IeventController@object')->name('ievent-object');
Route::any('ievent/show/{id}', 'IeventController@show')->name('ievent-show');
Route::any('ievent/report', 'IeventController@report')->name('ievent-report');
Route::any('ievent/region', 'IeventController@region')->name('ievent-region');

/**
 * 智能分析事件(作业违规监管)
 */
Route::any('aevent', 'AeventController@index')->name('aevent');
Route::any('aevent/show/{id}', 'AeventController@show')->name('aevent-show');
Route::any('aevent/report', 'AeventController@report')->name('aevent-report');
Route::any('aevent/region', 'AeventController@region')->name('aevent-region');
Route::any('aevent/add', 'AeventController@add')->name('aevent-add');

/**
 * 告警事件
 */
Route::any('alarm', 'AlarmController@index')->name('alarm');
Route::any('alarm/show', 'AlarmController@show')->name('alarm-show');
Route::any('alarm/report', 'AlarmController@report')->name('alarm-report');
Route::any('alarm/region', 'AlarmController@region')->name('alarm-region');

/**
 * 作业配置
 */
Route::any('supervise/model', 'SuperviseController@analysisModel')->name('supervise-analysisModel');
Route::any('supervise/model/update/{id}', 'SuperviseController@updateModel')->name('supervise-updateModel');
Route::any('supervise/model/delete/{id}', 'SuperviseController@deleteModel')->name('supervise-deleteModel');
Route::any('supervise/time', 'SuperviseController@analysisTime')->name('supervise-analysisTime');
Route::any('supervise/time/add', 'SuperviseController@addTime')->name('supervise-addTime');
Route::any('supervise/time/sync', 'SuperviseController@syncTime')->name('supervise-syncTime');
Route::any('supervise/time/delete/{id}', 'SuperviseController@destroy')->name('supervise-destroy');
Route::any('supervise/transportation/list', 'SuperviseController@TransportationList')->name('supervise-TransportationList');
Route::any('supervise/transportation', 'SuperviseController@transportation')->name('supervise-transportation');
Route::any('supervise/dot/list', 'SuperviseController@dotList')->name('supervise-dotList');
Route::any('supervise/dot', 'SuperviseController@dot')->name('supervise-dot');
Route::any('supervise/dot/update/{id}', 'SuperviseController@updateDot')->name('supervise-updateDot');
Route::any('supervise/device', 'SuperviseController@device')->name('supervise-device');
Route::any('supervise/device/show/{id}', 'SuperviseController@show')->name('supervise-show');
Route::any('supervise/device/update/{id}', 'SuperviseController@updateDevice')->name('supervise-updateDevice');
Route::any('supervise/region', 'SuperviseController@region')->name('supervise-region');


/**
 * 重点企业管理
 */
Route::any('point/company', 'PCompanyController@index')->name('pcompany');
Route::any('point/company/add', 'PCompanyController@add')->name('add-pcompany');
Route::any('point/company/share', 'PCompanyController@share')->name('share-pcompany');
Route::any('point/company/show/{id}', 'PCompanyController@show')->name('show-pcompany');
Route::any('point/company/delete/{id}', 'PCompanyController@destroy')->name('delete-pcompany');

/**
 * 重点转运中心管理
 */
Route::any('point/transportation', 'PTransportationController@index')->name('ptransportation');
Route::any('point/transportation/add', 'PTransportationController@add')->name('add-ptransportation');
Route::any('point/transportation/share', 'PTransportationController@share')->name('share-ptransportation');
Route::any('point/transportation/show/{id}', 'PTransportationController@show')->name('show-ptransportation');
Route::any('point/transportation/delete/{id}', 'PTransportationController@destroy')->name('delete-ptransportation');
Route::any('point/transportation/device/{id}', 'PTransportationController@device')->name('device-ptransportation');

/**
 * 重点网点管理
 */
Route::any('point/dot', 'PDotController@index')->name('pdot');
Route::any('point/dot/add', 'PDotController@add')->name('add-pdot');
Route::any('point/dot/share', 'PDotController@share')->name('share-pdot');
Route::any('point/dot/show/{id}', 'PDotController@show')->name('show-pdot');
Route::any('point/dot/delete/{id}', 'PDotController@destroy')->name('delete-pdot');
Route::any('point/dot/device/{id}', 'PDotController@device')->name('device-pdot');

/**
 * 重点品牌管理
 */
Route::any('point/brand', 'PBrandController@index')->name('pbrand');
Route::any('point/brand/add', 'PBrandController@add')->name('add-pbrand');
Route::any('point/brand/share', 'PBrandController@share')->name('share-pbrand');
Route::any('point/brand/show/{id}', 'PBrandController@show')->name('show-pbrand');
Route::any('point/brand/delete/{id}', 'PBrandController@destroy')->name('delete-pbrand');



/**
 * 日志管理
 */
Route::any('log', 'LogController@index')->name('log');
Route::any('log/department', 'LogController@department')->name('department-log');
Route::any('log/type', 'LogController@logType')->name('type-log');
Route::post('log/user', 'LogController@logUser')->name('user-log');
Route::any('log/operation', 'LogController@operation')->name('operation-log');
Route::any('log/operation/content', 'LogController@operationContent')->name('operation-content-log');
Route::any('log/export', 'LogController@export')->name('export-log');
Route::any('log/file/list', 'LogController@fileList')->name('file_list-log');
Route::any('log/file', 'LogController@file')->name('file-log');
Route::any('log/activation/{id}', 'LogController@activation')->name('activation-log');
Route::any('log/activation/content', 'LogController@content')->name('activation-log');
Route::any('log/activation/delete/{id}', 'LogController@delete')->name('delete-log');


/**
 * 数据管理
 */
Route::any('data', 'DataController@index')->name('data');
Route::any('data/backup', 'DataController@backup')->name('backup-data');
Route::any('data/recovery/{id}', 'DataController@recovery')->name('recovery-data');
Route::post('data/recovery/img', 'DataController@recoveryImg')->name('recovery-img');
Route::any('data/show/{id}', 'DataController@show')->name('show-data');
Route::any('data/delete/{id}', 'DataController@destroy')->name('delete-data');

/*
 * 平台配置
 */
Route::any('config/index','ConfigController@index')->name('config-index');
/*
 * 智能分析配置
 */
Route::any('analysisconfig/index','AnalysisConfigController@index')->name('analysis-config');
Route::any('notice/list', 'NoticeController@list')->name('notice-list');
Route::any('notice/add', 'NoticeController@add')->name('notice-add');

/*
 * 统计分析模块
 */
Route::any('task/index','TasksController@index')->name('task-index');
Route::any('task/detail/{id}','TasksController@detail')->name('task-detail');
//获取部门列表
Route::any('task/department','TasksController@department')->name('task-department');
//获取企业转运中心网点列表
Route::any('task/object','TasksController@object')->name('task-object');
Route::any('task/add','TasksController@add')->name('task-add');
Route::any('task/export/{id}','TasksController@export')->name('task-export');
Route::any('task/report','TasksController@report')->name('task-report');
Route::any('task/report/show/{id}','TasksController@show')->name('task-show');
Route::any('task/report/export/{id}','TasksController@reportExport')->name('task-report-export');

/*
 * 绑定手机号，邮箱
 */
Route::any('me/bd/mobile', 'AdminController@bdMobile')->name('bd-mobile');
Route::any('me/bd/email', 'AdminController@bdEmail')->name('bd-email');

/*
 *人工巡检
 */
Route::any('manuals', 'ManualController@index')->name('manuals');
Route::any('manual/company', 'ManualController@company')->name('manual-company');
Route::any('manual/dot', 'ManualController@dot')->name('manual-dot');
Route::any('manual/transportation', 'ManualController@transportation')->name('manual-transportation');
Route::any('manual/map', 'ManualController@map')->name('manual-map');
Route::any('manual/device/{type}/{id}', 'ManualController@device')->name('manual-device');
/*
 * 查询设备实时流地址
 */
Route::any('device/url','AnalysisConfigController@hls')->name('device-url');

/*
 * 节点管理
 */
Route::any('node/list','NodeController@index')->name('node-list');
Route::any('node/upgrade','NodeController@upgrade')->name('node-upgrade');
Route::any('node/history','NodeController@history')->name('node-history');
Route::any('node/roleBack','NodeController@roleBack')->name('node-roleBack');
Route::post('node/use/{id}','NodeController@useResources')->name('node-useResources');
Route::get('node/version','NodeController@versionInfo')->name('node-version');
Route::get('node/stopUp','NodeController@stopUpgrade')->name('node-stopUp');
Route::post('node/sshcmd','NodeController@nodeSsh')->name('node-sshcmd');


/*
 * 项目进度
 */
Route::any('project','ProjectController@index')->name('project');
Route::any('project/show/{id}','ProjectController@show')->name('project-show');

/*
 * 海康插件播放相关
 */
Route::post('device/encoding','IndexController@getDeviceEncoding')->name('device-encoding');
Route::post('device/vdconfig','IndexController@getHkServerConfig')->name('device-hkconfig');

/*
 * 数据统计
 */
//根据转运中心返回智能分析最新5个事件
Route::post('aevent/top', 'AeventController@top')->name('aevent-top');
//查看转运中心或网点下没有视频质检的点位列表
Route::post('aevent/device', 'AeventController@device')->name('aevent-device');
