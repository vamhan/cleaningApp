Welcome Home : 
<?php 


// echo lang('msg_welcome');
echo $this->lang->line('msg_welcome');
echo $this->lang->line('emsg_database');

	$this->ds_q->trace($this->session->userdata);

 ?>