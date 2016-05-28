<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Image extends MY_Controller {

	function __construct(){
		parent::__construct();

		$this->load->helper(array('form', 'url'));
	}//end constructor;

	function index() {
		$this->load->view('__cms/include/__upload_form', array('error' => ' ' ));
	}

	##########################################################################
	# Parameter : 1. Directory name (below asset)
	#			  2. Sub directory name 
	#             3. Image name with extension
	#             4. Width
	#             5. Height
	#             6. Return method (optional)
	# Example1 : thumb/images/test/Marie27.gif/40/40 (return image)
	# Example2 : thumb/images/test/Marie27.gif/40/40/pic (return image)
	# Example3 : thumb/images/test/Marie27.gif/40/40/path (return thumb path)
	##########################################################################

	function thumb ($dir, $subdir, $img, $width=200, $height=200, $return='pic') {

		$img_path = $dir.'/'.$subdir.'/'.$img;
		$thumb = image_thumb($img_path, $width, $height);

		if ($return=='pic') {
			echo '<img src="' . $thumb . '" />';
		} else {
			echo $thumb;
		}
	}	

	##########################################################################
	# Parameter : 1. Directory name (below asset)
	#			  2. Sub directory name 
	#             3. Return method (optional)
	# Required : Called from upload form (Example: _cms/include/__upload_form)
	##########################################################################

	function uploadImage ($dir, $return='pic') {

		$this->load->config('setup');
		$this->setup_item = $this->config->item('setup');
		$upload_path = $this->setup_item['project']['upload_path'];

		if (!is_dir($upload_path.'/'.$dir)) {
            $oldumask = umask(0);
            mkdir($upload_path.'/'.$dir, 0777);
            umask($oldumask);
		}

		$config['upload_path'] = $upload_path.'/'.$dir;
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']	= '100';
		$config['max_width']  = '1024';
		$config['max_height']  = '768';

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload())
		{
			$error = array('error' => $this->upload->display_errors());
		}
		else
		{
			$data = array('upload_data' => $this->upload->data());
			//redirect(my_url('image/thumb/'.$dir.'/'.$subdir.'/'.$data['upload_data']['file_name']));
			$img_path = dirname( $_SERVER['SCRIPT_NAME'] ) . '/' .$upload_path.'/'.$dir.'/'.$data['upload_data']['file_name'];
			
			if ($return=='pic') {
				echo '<img src="' . $img_path . '" />';
			} else {
				echo $img_path;
			}
			
		}
	}

}