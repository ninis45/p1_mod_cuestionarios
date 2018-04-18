<?php defined('BASEPATH') or exit('No direct script access allowed');
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
| 	www.your-site.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://www.codeigniter.com/user_guide/general/routing.html
*/
$route['cuestionarios/admin/pregunta/(:num)']		= 'admin_pregunta/load/$1';
$route['cuestionarios/admin/pregunta(:any)?'] = 'admin_pregunta$1';
$route['cuestionarios/admin/diagnostico(:any)?'] = 'admin_diagnosticos$1';
$route['cuestionario/(:num)'] = "cuestionario/load/$1";
// front-end
?>