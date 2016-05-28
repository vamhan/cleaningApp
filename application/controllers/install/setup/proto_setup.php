$config['setup']['project'] = array(
	'name' 						=> '__project_name__',
	'abbv' 						=> '__project_abbv__',
	'admin_email'   			=> '__admin_email__',
	'default_lang' 				=> '__default_lang__',
	'backend' 					=> '__backend__',
	'frontend' 					=> '__frontend__',
	'mobile_api' 				=> '__mobile_api__',
	'upload' 					=> '__upload__',
	'upload_path' 				=> '__upload_path__',
	'upload_size' 				=> '__upload_size__',
	'folder_upload_size' 		=> '__folder_upload_size__',
	'wysiwyg' 					=> '__wysiwyg__',
	'sample_data' 				=> '__sample_data__',
	'password_recovery_method' 	=> '__password_recovery_method__',
	'authentication_type' 		=> '__authentication_type__',
	'enable_cookie' 			=> '__enable_cookie__',
	'system_log'				=> '__system_log__'
);

$config['setup']['super_admin'] = array(
	'username'		=> '__admin_username__',
	'password'		=> '__admin_password__',
	'email'   		=> '__admin_email__'
);

$config['setup']['email'] = array(
	"protocol" 	=> '__email_protocol__',
	"smtp_host" => '__email_host__',
	"smtp_port" => '__email_port__',
	"smtp_user" => '__email_username__',
	"smtp_pass" => '__email_password__',
	"crlf"		=> "\r\n",
	"mailtype"	=> 'html',
	"charset" 	=> 'utf-8',
	"newline" 	=> "\r\n",
	"wordwrap" 	=> TRUE
);