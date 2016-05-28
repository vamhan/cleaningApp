<?ob_start();?>
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class __sap_connector extends CI_Controller {

	function __construct(){
		parent::__construct();

		date_default_timezone_set('Asia/Bangkok');

		$wsapObj = $this->session->userdata('wsapObj');
		$filename = CFGPATH."cms_config".DS."wsap".DS."object.php";

		$this->sap = $this->setup_item['sap'];
		if (file_exists($filename) && $this->sap['reload'] == 0) {
			$this->load->library('wsap');
			$wsapObj = file_get_contents($filename);
			$this->wsap = unserialize($wsapObj);
		} else {
			if (file_exists($filename)) {
				unlink($filename);
			}
			$obj = $this->login_sap();
        	file_put_contents($filename, serialize($obj));
		}

	}//end constructor;

	function login_sap () {
		echo "Login... <br>";
		$this->load->library('wsap');
		$logindata 	= 	array(
							"ASHOST"=>"192.191.0.16"	// application server
							,"SYSNR"=>"00"				// system number
							,"CLIENT"=>"200"			// client
							,"USER"=>"abap01"			// user
							,"PASSWD"=>"psgsap09"		// password
						);
		$this->wsap->setLoginData($logindata);
		$this->wsap->login();

		return $this->wsap;
	}

	function _padZero ($text, $length) {
		return str_pad($text, $length, '0', STR_PAD_LEFT);
	}

	function _dateFormat ( $date ) {
		return date("d.m.Y", strtotime($date));
	}

	function getUserData(){
		$result = $this->wsap->callFunction("SO_USER_LIST_READ",
								array(	array("IMPORT","USER_GENERIC_NAME","*"),
										array("TABLE","USER_DISPLAY_TAB",array())
								)
		);

		// Call successfull?
		if ($this->wsap->getStatus() == SAPRFC_OK) {
			// Yes, print out the Userlist
			?>
			<table>
				<tr><td>SAP-Name</td><td>User-Nummer</td></tr><?
				
			foreach ($result["USER_DISPLAY_TAB"] as $user) {
				echo "<tr><td>", $user["SAPNAM"],"</td><td>",$user["USRNO"],"</td></tr>";
			}
			
			?></table><?
		} else { 
			$this->wsap->printStatus();
		}
		

	}//end function 	

	function callFunction ($function, $input) {
		$result = $this->wsap->callFunction($function, $input);
		// Call successfull?
		echo $this->wsap->getStatus()."<br>";
		if ($this->wsap->getStatus() == SAPRFC_OK) {
			echo '<pre>';
			//echo json_encode($result);
			print_r($result);
			echo '</pre>';
		} else { 
			$this->wsap->printStatus();
		}
	}

	function getMassTable(){
		$result = $this->wsap->callFunction("ZRFC_MASS_TABLE",
								array(	array("IMPORT","I_MODE","R"),
										array("IMPORT","I_TABLE", "ZTBT_ACTION_PLAN"),
										array("IMPORT","I_DATE", "20141014"),
										array("TABLE","IT_ZTBT_ACTION_PLAN",array())
								)
		);

		// Call successfull?
		echo $this->wsap->getStatus()."<br>";
		if ($this->wsap->getStatus() == SAPRFC_OK) {
			echo '<pre>';
			//echo json_encode($result);
			print_r($result);
			echo '</pre>';
		} else { 
			$this->wsap->printStatus();
		}
		
		//$this->wsap->logoff();
	}//end function 

	function writeMassTable(){

		$items = array();

		$item1 = array(
			"EVENT_CATEGORY_ID" => $this->_padZero("1", 5),
			"ID" 	 => $this->_padZero("1", 10),
			"TITLE" => "MEWMEW TEST"
		);

		array_push($items, $item1);

		$result = $this->wsap->callFunction("ZRFC_MASS_TABLE",
								array(	array("IMPORT","I_MODE","M"),
										array("IMPORT","I_TABLE", "ZTBT_ACTION_PLAN"),
										array("IMPORT","I_DATE", "14.10.2014"),
										array("IMPORT","I_COMMIT", "X"),
										array("TABLE","IT_ZTBT_ACTION_PLAN", $items)
								)
		);

		// Call successfull?
		echo $this->wsap->getStatus()."<br>";
		if ($this->wsap->getStatus() == SAPRFC_OK) {
			echo '<pre>';
			//echo json_encode($result);
			print_r($result);
			echo '</pre>';
			
			/*$result2 = $this->wsap->callFunction("BAPI_TRANSACTION_COMMIT", array());
			if ($this->wsap->getStatus() == SAPRFC_OK) {
				echo "OK2 <br>";
			}*/
		} else { 
			$this->wsap->printStatus();
		}
		
		//$this->wsap->logoff();
	}//end function 

	function getSdBreakdown(){
		$result = $this->wsap->callFunction("ZRFC_SD_GET_BREAKDOWN",
								array(	
										array("IMPORT","I_CONTRACT","1210000118"),
										array("IMPORT","I_FROM", "20141001"),
										array("IMPORT","I_TO", "20141101"),
										array("TABLE","ET_BREAKDOWN",array())
								)
		);


		// Call successfull?
		echo $this->wsap->getStatus()."<br>";
		if ($this->wsap->getStatus() == SAPRFC_OK) {
			echo '<pre>';
			//echo json_encode($result);
			print_r($result);
			echo '</pre>';
		} else { 
			$this->wsap->printStatus();
		}
		
		//$this->wsap->logoff();
	}//end function 

	function createSaleOrderBreakdown () {

		$items = array();

		$item1 = array(
			"ITM_NUMBER" => "000010",
			"MATERIAL" 	 => "000000000000200000",
			"ITEM_CATEG" => "ZTAA",
			"PURCH_NO_C" => "1410000222"
		);

		array_push($items, $item1);

		$partners = array();

		$partner1 = array(
			"PARTN_ROLE" => "AG",
			"PARTN_NUMB" => "0010000029",
			"ITM_NUMBER" => "000000"
		);

		$partner2 = array(
			"PARTN_ROLE" => "WE",
			"PARTN_NUMB" => "0010000029",
			"ITM_NUMBER" => "000000"
		);

		array_push($partners, $partner1);
		array_push($partners, $partner2);

		$order_header_in = array(
			"DOC_TYPE" => "ZORX",
			"SALES_ORG" => "1000",
			"DISTR_CHAN" => "11",
			"DIVISION" => "11",
			"PURCH_NO_C" => "1410000222"

		);

		$result = $this->wsap->callFunction("BAPI_SALESORDER_CREATEFROMDAT2",
								array(	
										array("IMPORT","SALESDOCUMENTIN","1980010121"),
										array("IMPORT","ORDER_HEADER_IN", $order_header_in),
										array("TABLE","ORDER_ITEMS_IN", $items),
										array("TABLE","ORDER_PARTNERS", $partners),
										array("TABLE","RETURN", array())
								)
		);

		// Call successfull?
		if ($this->wsap->getStatus() == SAPRFC_OK) {
			echo "OK <br>";
			echo '<pre>';
			//echo json_encode($result);
			print_r($result['RETURN']);
			echo '</pre>';

			$result2 = $this->wsap->callFunction("BAPI_TRANSACTION_COMMIT", array());
			if ($this->wsap->getStatus() == SAPRFC_OK) {
				echo "OK2 <br>";
			}
		} else { 
			echo "NOT OK <br>";
			$this->wsap->printStatus();
		}
		
		$this->wsap->logoff();
	}
}