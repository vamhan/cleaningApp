<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Index extends MY_Controller {

    function __construct() {
        parent::__construct();
    }//end constructor;


    function index() {

        if ($this->db->database != '') {
            redirect( my_url( '__cms_permission/login' ) );
        } else {
            $this->load->config('setup');
            $this->setup_item = $this->config->item('setup');
            $this->language_list = $this->setup_item['language'];

            $p = $this->input->post();

            if (empty($p)) {
                #################################################
                # Display installation form
                #################################################
                $this->display();
            } else {
                #################################################
                # Installation process
                #################################################
                $this->install($p);
            }
        }
    }

    private function display() {
        $this->load->view('__cms/install/index');
    }
    private function install($p) {
        require dirname(__FILE__) . '/phpMyImporter.php';

        #################################################
        # Create database connection
        #################################################
        $connection = @mysql_connect($p['db_hostname'], $p['db_username'], $p['db_password']);
        if($connection) {

            #################################################
            # Create database
            #################################################
            $sql = "DROP DATABASE ".$p['db_name'];
            mysql_query($sql);
            $sql = "CREATE DATABASE ".$p['db_name'];
            mysql_query($sql);

            #################################################
            # Create configuration file
            #################################################
            $this->_configurationFile($p);
            $this->db->database = $p['db_name'];
            $this->db->dbprefix = $p['db_tbprefix'];

            #################################################
            # Import tables
            #################################################
            ob_start();
            $filename = dirname(__FILE__) . DS.'sql'.DS.'cms_category.sql';
            $compress = false;
            $dump = new phpMyImporter($this->db->database, $connection, $filename, $compress);
            $dump->utf8 = true;
            $dump->doImport($this->db->dbprefix);
            ob_get_clean();

            ob_start();
            $filename = dirname(__FILE__) . DS.'sql'.DS.'cms_group_permission.sql';
            $compress = false;
            $dump = new phpMyImporter($this->db->database, $connection, $filename, $compress);
            $dump->utf8 = true;
            $dump->doImport($this->db->dbprefix);
            ob_get_clean();

            ob_start();
            $filename = dirname(__FILE__) . DS.'sql'.DS.'cms_log.sql';
            $compress = false;
            $dump = new phpMyImporter($this->db->database, $connection, $filename, $compress);
            $dump->utf8 = true;
            $dump->doImport($this->db->dbprefix);
            ob_get_clean();
            
            ob_start();
            $filename = dirname(__FILE__) . DS.'sql'.DS.'cms_mobile_api.sql';
            $compress = false;
            $dump = new phpMyImporter($this->db->database, $connection, $filename, $compress);
            $dump->utf8 = true;
            $dump->doImport($this->db->dbprefix);
            ob_get_clean();
            
            ob_start();
            $filename = dirname(__FILE__) . DS.'sql'.DS.'cms_module.sql';
            $compress = false;
            $dump = new phpMyImporter($this->db->database, $connection, $filename, $compress);
            $dump->utf8 = true;
            $dump->doImport($this->db->dbprefix);
            ob_get_clean();
            
            ob_start();
            $filename = dirname(__FILE__) . DS.'sql'.DS.'cms_page.sql';
            $compress = false;
            $dump = new phpMyImporter($this->db->database, $connection, $filename, $compress);
            $dump->utf8 = true;
            $dump->doImport($this->db->dbprefix);
            ob_get_clean();
            
            ob_start();
            $filename = dirname(__FILE__) . DS.'sql'.DS.'cms_page_group.sql';
            $compress = false;
            $dump = new phpMyImporter($this->db->database, $connection, $filename, $compress);
            $dump->utf8 = true;
            $dump->doImport($this->db->dbprefix);
            ob_get_clean();

            ob_start();
            $filename = dirname(__FILE__) . DS.'sql'.DS.'cms_page_struct.sql';
            $compress = false;
            $dump = new phpMyImporter($this->db->database, $connection, $filename, $compress);
            $dump->utf8 = true;
            $dump->doImport($this->db->dbprefix);
            ob_get_clean();

            ob_start();
            $filename = dirname(__FILE__) . DS.'sql'.DS.'cms_user_group.sql';
            $compress = false;
            $dump = new phpMyImporter($this->db->database, $connection, $filename, $compress);
            $dump->utf8 = true;
            $dump->doImport($this->db->dbprefix);
            ob_get_clean();
            
            ob_start();
            $filename = dirname(__FILE__) . DS.'sql'.DS.'cms_user_permission.sql';
            $compress = false;
            $dump = new phpMyImporter($this->db->database, $connection, $filename, $compress);
            $dump->utf8 = true;
            $dump->doImport($this->db->dbprefix);
            ob_get_clean();
            
            ob_start();
            $filename = dirname(__FILE__) . DS.'sql'.DS.'cms_users.sql';
            $compress = false;
            $dump = new phpMyImporter($this->db->database, $connection, $filename, $compress);
            $dump->utf8 = true;
            $dump->doImport($this->db->dbprefix);
            ob_get_clean();
            
            ob_start();
            $filename = dirname(__FILE__) . DS.'sql'.DS.'tb_directory.sql';
            $compress = false;
            $dump = new phpMyImporter($this->db->database, $connection, $filename, $compress);
            $dump->utf8 = true;
            $dump->doImport($this->db->dbprefix);
            ob_get_clean();
            
            ob_start();
            $filename = dirname(__FILE__) . DS.'sql'.DS.'tbt_proto_item.sql';
            $compress = false;
            $dump = new phpMyImporter($this->db->database, $connection, $filename, $compress);
            $dump->utf8 = true;
            $dump->doImport($this->db->dbprefix);
            ob_get_clean();
            
            ob_start();
            $filename = dirname(__FILE__) . DS.'sql'.DS.'tbt_proto_promotion.sql';
            $compress = false;
            $dump = new phpMyImporter($this->db->database, $connection, $filename, $compress);
            $dump->utf8 = true;
            $dump->doImport($this->db->dbprefix);
            ob_get_clean();

            #################################################
            # TODO : Import sample data
            #################################################
            if ($p['sample_data'] == 'on') {

            }

            #################################################
            # Create language file
            #################################################
            $keys = array_keys($p);  
            $multi_lang = preg_grep("/^lang_/", $keys);
            array_push($multi_lang, $p['default_lang']);
            if (!empty($multi_lang)) {
                $this->_createLanguageFile($multi_lang);
            }

            #################################################
            # Create upload folder
            #################################################
            if (!empty($p['upload_path'])) {
                $dir = $p['upload_path'];
                if (!is_dir($dir)) {
                    $oldumask = umask(0);
                    mkdir($dir, 0777);
                    umask($oldumask);
                }
            }

            redirect( my_url( '__cms_permission/login' ) );
        } else {
            echo "Error connecting to database";
        }

    }

    private function _createLanguageFile ($lang_arr) {

        foreach ($lang_arr as $lang) {
            $lang = explode('_', $lang);
            if (sizeof($lang) > 1) {
                $lang = $lang[1];
            } else {
                $lang = $lang[0];
            }

            if ($lang == 'en' || $lang == 'th') {
                $data = file_get_contents(dirname(__FILE__).DS.'setup'.DS.'proto_lang_'.$lang.'.php');

                $oldumask = umask(0);
                file_put_contents( CFGPATH."cms_config".DS."lang".DS.$lang.".php", $data);
                umask($oldumask);
            } else {
                $data = file_get_contents(dirname(__FILE__).DS.'setup'.DS.'proto_lang.php');
                $data = str_replace("__lang__", $lang, $data);

                $oldumask = umask(0);
                file_put_contents( CFGPATH."cms_config".DS."lang".DS.$lang.".php", $data);
                umask($oldumask);
            }
        }
    }

    private function _configurationFile ($p) {

        $db_config = array(
            'hostname' => $p['db_hostname'],
            'username' => $p['db_username'],
            'password' => $p['db_password'],
            'database' => $p['db_name'],
            'dbprefix' => $p['db_tbprefix']
        );

        $data = file_get_contents(CFGPATH.'database.php');
        $file = CFGPATH.'database.php';

        foreach ($db_config as $key => $value)
        {   
            $data = str_replace("db['default']['".$key."'] = ''", "db['default']['".$key."'] = '".$value."'", $data);
        }

        file_put_contents($file, $data);

        //Write setup configuration file
        $setup_config = array(
            'admin_username',
            'admin_password',
            'admin_email',
            'email_protocol',
            'email_host',
            'email_port',
            'email_username',
            'email_password'
        );

        $data = file_get_contents(dirname(__FILE__).DS.'setup'.DS.'proto_setup.php');
        $file = CFGPATH.'setup.php';

        foreach ($p as $key => $value)
        {   
            $data = str_replace('__'.$key.'__', mysql_real_escape_string($value), $data);
        }

        $this->_writefile($file, $data);
    }

    private function _writefile($file, $data) {
        // Open the file to get existing content
        $current = file_get_contents($file);
        // Append a new person to the file
        $current .= "\n\n".$data;
        // Write the contents back to the file
        file_put_contents($file, $current);     
    }
}

