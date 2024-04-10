<?php

set_time_limit(0);
date_default_timezone_set("Africa/Lagos");
// if(is_file("config.php")){
	require_once "config.php";
	error_reporting(0);
	$config = new Config();

	$per_page = 20;
	if(isset($_GET["currentpage"]))
	{
		$page = $_GET["currentpage"];
	}
	else
	{
		$page = 1;
	}
	$start_page = ($page-1) * $per_page;
	
	// $this->con = $config;
	/**
	 * Created by PhpStorm.
	 * User: PEAKSMS
	 * Date: 4/25/2017
	 * Time: 2:15 AM
	 */


	//Class below

	class Action extends Config
	{
		
		#Admin Functions
		
		//Admin Referral code
		public function adminRefCode() {
			try {
				$queryRun = $this->con->prepare("select * from client where type='3' order by rand() limit 1");
				$queryRun->execute();
				$queryInfo =  $queryRun->fetch(PDO::FETCH_ASSOC);
				$id = $queryInfo["id"];
				return $id;
			}
			catch(PDOException $e)
			{
				echo $e->getMessage();
			}
		}
		
		
		#Admin Functions
		
		
		#Member Functions
		
		//count total transaction user has done
		public function count_trans_Memb($uid, $status) {
			try {
			    switch($status) {
			        case "all":
				    $queryRun = $this->con->prepare("select * from transactions where clientID='$uid' and (status='Cancelled' or status='Approved')");
			        break;
			        case "Approved":
				    $queryRun = $this->con->prepare("select * from transactions where clientID='$uid' and status='$status'");
			        break;
			        case "Cancelled":
				    $queryRun = $this->con->prepare("select * from transactions where clientID='$uid' and status='$status'");
			        break;
			    }
				$queryRun->execute();
				return $queryRun->rowCount();
			} catch(PDOException $e) {
				echo $e->getMessage();
			}
		}
		
		//Does user exist?
		public function userExist($email) {
			try {
				$queryRun = $this->con->prepare("select * from client where email='$email'");
				$queryRun->execute();
				return $queryRun->rowCount();
			}
			catch(PDOException $e)
			{
				echo $e->getMessage();
			}
		}
		
		//Does referral code exist?
		public function doesClient_Exist($referralcode) {
			try {
				$queryRun = $this->con->prepare("select * from client where id='$referralcode'");
				$queryRun->execute();
				return $queryRun->rowCount();
			}
			catch(PDOException $e)
			{
				echo $e->getMessage();
			}
		}
		
		//Who owns referral code... Me , You or ur fada????
		public function who_ownsReferal_code($referralcode) {
			try {
				$queryRun = $this->con->prepare("select * from client where userCode='$referralcode'");
				$queryRun->execute();
				$queryInfo = $queryRun->fetch(PDO::FETCH_ASSOC);
				$realId = $queryInfo["id"];
				return $realId;
			}
			catch(PDOException $e)
			{
				echo $e->getMessage();
			}
		}
		
		//Save Member
		public function saveUser($email, $password, $referralcode, $clientNumber) {
			try {
				//referralcode is the referral Code
				//code is the member Code, which is generated before insertion.
				for($i=1; $i<=1000; $i++) {
					$code = "K".mt_rand(111001,999999);
				}
				
				$point = $this->newMemberPoint();
				$queryRun = $this->con->prepare("insert into client (email, password, userCode, point, phone) values ('$email', '$password', '$code', '$point', '$clientNumber')");
				$queryRun->execute();
				$clientReferred = $this->lastInsertId();
				
				return $queryRun;
			}
			catch(PDOException $e) {
				echo $e->getMessage();
			}
		}
		
		//Save Member
		public function saveAdminUser($email, $password, $clientNumber) {
			try {
				
				//code is the member Code, which is generated before insertion.
				for($i=1; $i<=1000; $i++) {
					$code = "K".mt_rand(111001,999999);
				}
				
				$point = $this->newMemberPoint();
				
				$queryRun = $this->con->prepare("insert into client (email, password, userCode, point, type, phone) values ('$email', '$password', '$code', '$point', '3', '$clientNumber')");
				$queryRun->execute();
				
				return $queryRun;
			}
			catch(PDOException $e) {
				echo $e->getMessage();
			}
		}
			
		//Login Account
		public function doLogin($email, $password)
		{
			try
			{
				$queryRun = $this->con->prepare("select * from client where email='$email' and password='$password'");
				$queryRun->execute();
				if($queryRun->rowCount() == 1) {
					session_start();
					$_SESSION["username"] = $email;
					return "YES";
				} else {
					return "NO";
				}
			}		
			catch(PDOException $e)
			{
				echo $e->getMessage();
			}
		}
		
		//User Row... Is it a client or Not ???
		public function isUser($clientID) {
			try {
				$queryRun = $this->con->prepare("select * from client where id='$clientID'");
				$queryRun->execute();
				return $queryRun->rowCount();
			}		
			catch(PDOException $e) {
				echo $e->getMessage();
			}
		}
		
		//User Row... Is it a client or Not ???
		public function isMember_ban($clientID) {
			try {
				$queryRun = $this->con->prepare("select * from client where id='$clientID'");
				$queryRun->execute();
				$queryInfo = $queryRun->fetch(PDO::FETCH_ASSOC);
				$blockMember = $queryInfo["blockMember"];
				return $blockMember;
			}		
			catch(PDOException $e) {
				echo $e->getMessage();
			}
		}
		
		//Client phone number
		public function GSM($clientID) {
			try {
				$queryRun = $this->con->prepare("select * from client where id='$clientID'");
				$queryRun->execute();
				$queryInfo = $queryRun->fetch(PDO::FETCH_ASSOC);
				$phone = $queryInfo["phone"];
				return $phone;
			}		
			catch(PDOException $e) {
				echo $e->getMessage();
			}
		}
		
		//User type , admin / moderator / normal ??
		public function userType($clientID) {
			try {
				$queryRun = $this->con->prepare("select * from client where id='$clientID'");
				$queryRun->execute();
				$queryInfo = $queryRun->fetch(PDO::FETCH_ASSOC);
				$type = $queryInfo["type"];
				return $type;
			}		
			catch(PDOException $e) {
				echo $e->getMessage();
			}
		}
		
		//Get client password...
		public function clienPass($clientID) {
			try {
				$queryRun = $this->con->prepare("select * from client where id='$clientID'");
				$queryRun->execute();
				$queryInfo = $queryRun->fetch(PDO::FETCH_ASSOC);
				$password = $queryInfo["password"];
				return $password;
			}		
			catch(PDOException $e) {
				echo $e->getMessage();
			}
		}
			
		//update Client account details...
		public function updateClientPass($newPass, $clientID) {
			try {
				$queryRun = $this->con->prepare("update client set password='$newPass' where id='$clientID'");
				$queryRun->execute();
				return $queryRun;
			}
			catch(PDOException $e) {
				echo $e->getMessage();
			}
		}
		
		//User type , admin / moderator / normal ??
		public function vipLevel($clientID) {
			try {
				$queryRun = $this->con->prepare("select * from client where id='$clientID'");
				$queryRun->execute();
				$queryInfo = $queryRun->fetch(PDO::FETCH_ASSOC);
				$viplevel = $queryInfo["viplevel"];
				return $viplevel;
			}		
			catch(PDOException $e) {
				echo $e->getMessage();
			}
		}
		
		//User type , admin / moderator / normal ??
		public function clientEmail($clientID) {
			try {
				$queryRun = $this->con->prepare("select * from client where id='$clientID'");
				$queryRun->execute();
				$queryInfo = $queryRun->fetch(PDO::FETCH_ASSOC);
				$email = $queryInfo["email"];
				return $email;
			}		
			catch(PDOException $e) {
				echo $e->getMessage();
			}
		}
				
		//Get Client Id
		public function clientID($username) {
			try {
				$queryRun = $this->con->prepare("select * from client where email='$username'");
				$queryRun->execute();
				$queryInfo = $queryRun->fetch(PDO::FETCH_ASSOC);
				$clientID = $queryInfo["id"];
				return $clientID;
			}
			catch(PDOException $e) {
				echo $e->getMessage();
			}
		}
				
		//does user has reset code in db before
		public function doesUserHas_resetcodebefore($clientID) {
			try {
				$queryRun = $this->con->prepare("select * from resetPassword where clientID='$clientID'and status='Pending'");
				$queryRun->execute();
				return $queryRun->rowCount();
			}
			catch(PDOException $e) {
				echo $e->getMessage();
			}
		}
			
		//Has Client update his or her bank account
		public function bankAccount_row($clientID) {
			try {
				$queryRun = $this->con->prepare("select * from bankaccount where clientID='$clientID'");
				$queryRun->execute();
				return $queryRun->rowCount();
			}
			catch(PDOException $e) {
				echo $e->getMessage();
			}
		}
			
		//Account number is in use ?
		public function isUsed_AccountNumber($accountNumber) {
			try {
				$queryRun = $this->con->prepare("select * from bankaccount where merchantNo='$accountNumber'");
				$queryRun->execute();
				return $queryRun->rowCount();
			}
			catch(PDOException $e) {
				echo $e->getMessage();
			}
		}
		
		//Account number is in use ?
		public function isWallet_Ready($clientID) {
			try {
				$queryRun = $this->con->prepare("select * from wallet where clientID='$clientID'");
				$queryRun->execute();
				return $queryRun->rowCount();
			}
			catch(PDOException $e) {
				echo $e->getMessage();
			}
		}
		
		//client point 
		public function clientPoint($referredMe) {
			try {
				$queryRun = $this->con->prepare("select * from client where id='$referredMe'");
				$queryRun->execute();
				$queryInfo = $queryRun->fetch(PDO::FETCH_ASSOC);
				$point = $queryInfo["point"];
				return $point;
			}
			catch(PDOException $e) {
				echo $e->getMessage();
			}
		}
		
		//block update for bank account number
		public function blockAccNumb4update($clientID) {
			try {
				$queryRun = $this->con->prepare("select * from bankaccount where clientID='$clientID'");
				$queryRun->execute();
				$queryInfo = $queryRun->fetch(PDO::FETCH_ASSOC);
				$blockUpdate = $queryInfo["blockUpdate"];
				return $blockUpdate;
			}
			catch(PDOException $e) {
				echo $e->getMessage();
			}
		}
			
		//Client referral code...
		public function userCode($clientID) {
			try {
				$queryRun = $this->con->prepare("select * from client where id='$clientID'");
				$queryRun->execute();
				$queryInfo = $queryRun->fetch(PDO::FETCH_ASSOC);
				$userCode = $queryInfo["userCode"];
				return $userCode;
			}
			catch(PDOException $e) {
				echo $e->getMessage();
			}
		}
			
		//save Client account details...
		public function saveBankAccount($bank_name, $accountName, $accountNumber, $accType, $clientID) {
			try {
				$nextUpdate = date('d.m.Y h:i A', strtotime("+15 days"));
				$queryRun = $this->con->prepare("insert into bankaccount (clientID, bankName, merchantName, merchantNo, accountType, nextUpdate) values ('$clientID', '$bank_name', '$accountName', '$accountNumber', '$accType', '$nextUpdate')");
				if($queryRun->execute()) { // we need to create a wallet for the user
					$saveAccount = $this->con->prepare("insert into wallet (clientID, amount) values ('$clientID', '0.00')");
					$saveAccount->execute();
				}
				return $queryRun;
			}
			catch(PDOException $e) {
				echo $e->getMessage();
			}
		}
			
		//update Client account details...
		public function updateBankAccount($bank_name, $accountName, $accountNumber, $accType, $clientID) {
			try {
				$nextUpdate = date('d.m.Y h:i A', strtotime("+15 days"));
				$queryRun = $this->con->prepare("update bankaccount set bankName='$bank_name', merchantName='$accountName', merchantNo='$accountNumber', accountType='$accType', blockUpdate='YES', nextUpdate='$nextUpdate' where clientID='$clientID'");
				$queryRun->execute();
				return $queryRun;
			}
			catch(PDOException $e) {
				echo $e->getMessage();
			}
		}
			
		//Client account name...
		public function clientAccName($clientID) {
			try {
				$queryRun = $this->con->prepare("select * from bankaccount where clientID='$clientID'");
				$queryRun->execute();
				$queryInfo = $queryRun->fetch(PDO::FETCH_ASSOC);
				$merchantName = $queryInfo["merchantName"];
				return $merchantName;
			}
			catch(PDOException $e) {
				echo $e->getMessage();
			}
		}
			
		//Client account name...
		public function clientAccNo($clientID) {
			try {
				$queryRun = $this->con->prepare("select * from bankaccount where clientID='$clientID'");
				$queryRun->execute();
				$queryInfo = $queryRun->fetch(PDO::FETCH_ASSOC);
				$merchantNo = $queryInfo["merchantNo"];
				return $merchantNo;
			}
			catch(PDOException $e) {
				echo $e->getMessage();
			}
		}
			
		//Client account type...
		public function clientAccType($clientID) {
			try {
				$queryRun = $this->con->prepare("select * from bankaccount where clientID='$clientID'");
				$queryRun->execute();
				$queryInfo = $queryRun->fetch(PDO::FETCH_ASSOC);
				$merchantNo = $queryInfo["accountType"];
				return $merchantNo;
			}
			catch(PDOException $e) {
				echo $e->getMessage();
			}
		}
			
		//Client bank name...
		public function clientBankName($clientID) {
			try {
				$queryRun = $this->con->prepare("select * from bankaccount where clientID='$clientID'");
				$queryRun->execute();
				$queryInfo = $queryRun->fetch(PDO::FETCH_ASSOC);
				$merchantNo = $queryInfo["bankName"];
				return $merchantNo;
			}
			catch(PDOException $e) {
				echo $e->getMessage();
			}
		}
		
		//Client balance in wallet...
		public function clientMobile($clientID) {
			try {
				$queryRun = $this->con->prepare("select * from client where id='$clientID'");
				$queryRun->execute();
				$queryInfo = $queryRun->fetch(PDO::FETCH_ASSOC);
				$phone = $queryInfo["phone"];
				return $phone;
			}
			catch(PDOException $e) {
				echo $e->getMessage();
			}
		}
		
		//Client balance in wallet...
		public function clientBlc($clientID) {
			try {
				$queryRun = $this->con->prepare("select * from wallet where clientID='$clientID'");
				$queryRun->execute();
				$queryInfo = $queryRun->fetch(PDO::FETCH_ASSOC);
				$amount = $queryInfo["amount"];
				return $amount;
			}
			catch(PDOException $e) {
				echo $e->getMessage();
			}
		}
			
		//save Client account details...
		public function saveCardUpload($clientID, $images, $cardAmount, $type, $response) {
			try {
				$memberType = "vip".$this->vipLevel($clientID);
				$queryRun = $this->con->prepare("insert into transactions (clientID, memberType, images, amount, type, response) values ('$clientID', '$memberType', '$images', '$cardAmount', '$type', '$response')");
				if($queryRun->execute()) { // we need to create a wallet for the user
					$updtUsr = $this->con->prepare("update client set blockTransaction='YES' where id='$clientID'");
					$updtUsr->execute();
				}
				return $queryRun;
			}
			catch(PDOException $e) {
				echo $e->getMessage();
			}
		}
		
		//User Row... Is it a client or Not ???
		public function isClient_Blocked4Trans($clientID) {
			try {
				$queryRun = $this->con->prepare("select * from client where id='$clientID' and blockTransaction='YES'");
				$queryRun->execute();
				return $queryRun->rowCount();
			}		
			catch(PDOException $e) {
				echo $e->getMessage();
			}
		}
		
		
		//Get bitcoin address for admin
		public function btcWallet() {
			try {
				$queryRun = $this->con->prepare("select * from settings where setName='btcWallet'");
				$queryRun->execute();
				$queryInfo = $queryRun->fetch(PDO::FETCH_ASSOC);
				$setValue = $queryInfo["setValue"];
				return $setValue;				
			}		
			catch(PDOException $e) {
				echo $e->getMessage();
			}
		}
				
		//Who referred Me , I need id of who referred you
		private function clientReffered($clientID) {
			try {
				$queryRun = $this->con->prepare("select * from referral where clientReferred='$clientID'");
				$queryRun->execute();
				$queryInfo = $queryRun->fetch(PDO::FETCH_ASSOC);
				$who_InvitedMe = $queryInfo["clientID"];
				return $who_InvitedMe;
			}		
			catch(PDOException $e) {
				echo $e->getMessage();
			}
		}
		
		//Has invitee receive point for inviting me? 
		private function invitee_pointStatus($clientID) {
			try {
				$queryRun = $this->con->prepare("select * from referral where clientReferred='$clientID'");
				$queryRun->execute();
				$queryInfo = $queryRun->fetch(PDO::FETCH_ASSOC);
				$pointRcv = $queryInfo["pointRcv"];
				return $pointRcv;
			}		
			catch(PDOException $e) {
				echo $e->getMessage();
			}
		}
		
		#Member Functions
		
		#Admin Functions
		
		//Get google playstore price for admin
		public function googlePlayPrice() {
			try {
				$queryRun = $this->con->prepare("select * from settings where setName='googlePlayPrice'");
				$queryRun->execute();
				$queryInfo = $queryRun->fetch(PDO::FETCH_ASSOC);
				$setValue = $queryInfo["setValue"];
				return str_replace(" ", "", $setValue);				
			}		
			catch(PDOException $e) {
				echo $e->getMessage();
			}
		}
		
		//Get bitcoin price for admin
		public function btcPrice() {
			try {
				$queryRun = $this->con->prepare("select * from settings where setName='btcPrice'");
				$queryRun->execute();
				$queryInfo = $queryRun->fetch(PDO::FETCH_ASSOC);
				$setValue = $queryInfo["setValue"];
				return str_replace(" ", "", $setValue);				
			}		
			catch(PDOException $e) {
				echo $e->getMessage();
			}
		}
		
		//Get itunes price for admin
		public function itunesPrice() {
			try {
				$queryRun = $this->con->prepare("select * from settings where setName='itunesPrice'");
				$queryRun->execute();
				$queryInfo = $queryRun->fetch(PDO::FETCH_ASSOC);
				$setValue = $queryInfo["setValue"];
				return str_replace(" ", "", $setValue);				
			}		
			catch(PDOException $e) {
				echo $e->getMessage();
			}
		}

		//Get 200 single price for admin
		public function singlecardPrice() {
			try {
				$queryRun = $this->con->prepare("select * from settings where setName='singlecardPrice'");
				$queryRun->execute();
				$queryInfo = $queryRun->fetch(PDO::FETCH_ASSOC);
				$setValue = $queryInfo["setValue"];
				return str_replace(" ", "", $setValue);
			}
			catch(PDOException $e) {
				echo $e->getMessage();
			}
		}

		//Get 200 single price for admin
		public function australiaPrice() {
			try {
				$queryRun = $this->con->prepare("select * from settings where setName='australiaPrice'");
				$queryRun->execute();
				$queryInfo = $queryRun->fetch(PDO::FETCH_ASSOC);
				$setValue = $queryInfo["setValue"];
				return str_replace(" ", "", $setValue);
			}
			catch(PDOException $e) {
				echo $e->getMessage();
			}
		}

		//Get 200 single price for admin
		public function canadianPrice() {
			try {
				$queryRun = $this->con->prepare("select * from settings where setName='canadianPrice'");
				$queryRun->execute();
				$queryInfo = $queryRun->fetch(PDO::FETCH_ASSOC);
				$setValue = $queryInfo["setValue"];
				return str_replace(" ", "", $setValue);
			}
			catch(PDOException $e) {
				echo $e->getMessage();
			}
		}
		
		//Get amazon price for admin
		public function amazonPrice() {
			try {
				$queryRun = $this->con->prepare("select * from settings where setName='amazonPrice'");
				$queryRun->execute();
				$queryInfo = $queryRun->fetch(PDO::FETCH_ASSOC);
				$setValue = $queryInfo["setValue"];
				return $setValue;				
			}		
			catch(PDOException $e) {
				echo $e->getMessage();
			}
		}
        
        public function apprvWithdraw($uid) {
			try {
				$queryRun = $this->con->prepare("select sum(amount) as totalAmnt from transactions where clientID='$uid' and status='Approved' and type='withdraw'");
				$queryRun->execute();
				$queryInfo = $queryRun->fetch(PDO::FETCH_ASSOC);
				$totalAmnt = $queryInfo["totalAmnt"];
				return $totalAmnt ? $totalAmnt:0;				
			} catch(PDOException $e) {
				echo $e->getMessage();
			}
        }
        
        public function apprvTransAmnt($uid) {
			try {
				$queryRun = $this->con->prepare("select response from transactions where clientID='$uid' and status='Approved' and type!='withdraw'");
				$queryRun->execute();
				$totalAmnt = 0;
				while($queryRunInfo = $queryRun->fetch(PDO::FETCH_ASSOC)) {
				    $response = json_decode($queryRunInfo["response"], true);
				    $totalAmnt += $response["amountNaira"];
				}
				return $totalAmnt ? $totalAmnt:0;				
			} catch(PDOException $e) {
				echo $e->getMessage();
			}
        }
        
		//Get amazon price for admin
		public function amazonNoReceiptPrice() {
			try {
				$queryRun = $this->con->prepare("select * from settings where setName='amazonNoReceiptPrice'");
				$queryRun->execute();
				$queryInfo = $queryRun->fetch(PDO::FETCH_ASSOC);
				$setValue = $queryInfo["setValue"];
				return $setValue;
			}
			catch(PDOException $e) {
				echo $e->getMessage();
			}
		}
		
		//Get ecode price for admin
		public function ecodePrice() {
			try {
				$queryRun = $this->con->prepare("select * from settings where setName='ecodePrice'");
				$queryRun->execute();
				$queryInfo = $queryRun->fetch(PDO::FETCH_ASSOC);
				$setValue = $queryInfo["setValue"];
				return $setValue;				
			}		
			catch(PDOException $e) {
				echo $e->getMessage();
			}
		}

		//Get ecode price for admin
		public function no_amountItunes() {
			try {
				$queryRun = $this->con->prepare("select * from settings where setName='noAmountItunes'");
				$queryRun->execute();
				$queryInfo = $queryRun->fetch(PDO::FETCH_ASSOC);
				$setValue = $queryInfo["setValue"];
				return $setValue;
			}
			catch(PDOException $e) {
				echo $e->getMessage();
			}
		}

		//Get ecode price for admin
		public function steamPrice() {
			try {
				$queryRun = $this->con->prepare("select * from settings where setName='steamPrice'");
				$queryRun->execute();
				$queryInfo = $queryRun->fetch(PDO::FETCH_ASSOC);
				$setValue = $queryInfo["setValue"];
				return $setValue;
			}
			catch(PDOException $e) {
				echo $e->getMessage();
			}
		}
		
		//Total Member 
		public function sumClient() {
			try {
				$queryRun = $this->con->prepare("select * from client");
				$queryRun->execute();
				return $queryRun->rowCount();				
			}		
			catch(PDOException $e) {
				echo $e->getMessage();
			}
		}
		
		//Total withdrawal request... 
		public function sumWithdrawalRequest() {
			try {
				$queryRun = $this->con->prepare("select * from transactions where status='Pending' and type='withdraw'");
				$queryRun->execute();
				return $queryRun->rowCount();				
			}		
			catch(PDOException $e) {
				echo $e->getMessage();
			}
		}
		
		//Total withdrawal request... 
		public function allTrans_count() {
			try {
				$queryRun = $this->con->prepare("select * from transactions");
				$queryRun->execute();
				return $queryRun->rowCount();				
			}		
			catch(PDOException $e) {
				echo $e->getMessage();
			}
		}
		
		//Total bitcoin submit... 
		public function sumOfTrans_Submitted() {
			try {
				$queryRun = $this->con->prepare("select * from transactions where status='Pending' and type!='bitcoin' and type!='withdraw'");
				$queryRun->execute();
				return $queryRun->rowCount();				
			}		
			catch(PDOException $e) {
				echo $e->getMessage();
			}
		}
		
		//Total bitcoin submit... 
		public function sumOfBtc_Submitted() {
			try {
				$queryRun = $this->con->prepare("select * from transactions where status='Pending' and type='bitcoin'");
				$queryRun->execute();
				return $queryRun->rowCount();				
			}		
			catch(PDOException $e) {
				echo $e->getMessage();
			}
		}
		
		//Total Transaction 
		public function sumTrans() {
			try {
				$queryRun = $this->con->prepare("select * from client");
				$queryRun->execute();
				return $queryRun->rowCount();				
			}		
			catch(PDOException $e) {
				echo $e->getMessage();
			}
		}
		
		//Point 4 newly registered member
		public function newMemberPoint() {
			try {
				$queryRun = $this->con->prepare("select * from settings where setName='newMemberPoint'");
				$queryRun->execute();
				$queryInfo = $queryRun->fetch(PDO::FETCH_ASSOC);
				$setValue = $queryInfo["setValue"];
				return $setValue;			
			}		
			catch(PDOException $e) {
				echo $e->getMessage();
			}
		}
			
		//update settings admin......
		public function updateAdminSettings($newMemberPoint, $btcWallet, $btcPrice, $itunesPrice, $single200Value, $austriaValue, $canadaValue, $amazonPrice, $ecodePrice, $no_amountItunes, $amazon_no_rcp, $steamPrice, $gplaystore) {
			try {
				$queryRun[] = "update settings set setValue='$btcWallet' where setName='btcWallet'";
				$queryRun[] = "update settings set setValue='$newMemberPoint' where setName='newMemberPoint'";
				$queryRun[] = "update settings set setValue='$btcPrice' where setName='btcPrice'";
				$queryRun[] = "update settings set setValue='$itunesPrice' where setName='itunesPrice'";
				$queryRun[] = "update settings set setValue='$single200Value' where setName='singlecardPrice'";
				$queryRun[] = "update settings set setValue='$austriaValue' where setName='australiaPrice'";
				$queryRun[] = "update settings set setValue='$canadaValue' where setName='canadianPrice'";
				$queryRun[] = "update settings set setValue='$amazonPrice' where setName='amazonPrice'";
				$queryRun[] = "update settings set setValue='$ecodePrice' where setName='ecodePrice'";
				$queryRun[] = "update settings set setValue='$no_amountItunes' where setName='noAmountItunes'";
				$queryRun[] = "update settings set setValue='$amazon_no_rcp' where setName='amazonNoReceiptPrice'";
				$queryRun[] = "update settings set setValue='$steamPrice' where setName='steamPrice'";
				$queryRun[] = "update settings set setValue='$gplaystore' where setName='googlePlayPrice'";

				foreach($queryRun as $saveChanges) {
					$saveChange = $this->con->prepare($saveChanges);
					if($saveChange->execute()) {
						$statement = true;
					} else {
						$statement = false;
					} 
				}
				
				return $statement;
			}
			catch(PDOException $e) {
				echo $e->getMessage();
			}
		}

		//update settings admin......
		public function loadMember_Select() {
			try {
                $queryRun = $this->con->prepare("select * from client order by email ASC");
                $queryRun->execute();
                if($queryRun->rowCount() == 0) {
                    return $this->error("No registered member yet");
                } else {
                    ?>

                    <form method="post" id="notifyMsgInfo">
						<div class="row">
							<label>Choose Member</label>
							<select class="form-control input-lg" name="clientID" id="clientID">
								<option value="">Please select Member</option>
								<option value="all_member">All Member</option>
							<?php
							for ($i=1; $i<=$queryRun->rowCount(); $i++) {
								$queryInfo = $queryRun->fetch(PDO::FETCH_ASSOC);
								$email = $queryInfo["email"];
								$clientID = $queryInfo["id"];
							 ?>
								<option value="<?php echo $clientID;?>"><?php echo $email;?></option>
							<?php
							}
							?>
							</select>
						</div>
                        <br>
						<div class="row">
							<label>Notification Message</label>
							<textarea class="form-control" rows="8" name="notifyMsg" id="notifyMsg" required></textarea>
						</div>
                        <br>
                        <center>
                            <button name="saveNotify" id="saveNotify" type="submit" class="btn btn-primary">Notify Client</button>
                        </center>
                    </form>
                    <?php
                }
			}
			catch(PDOException $e) {
				echo $e->getMessage();
			}
		}

		//save notification message......
		public function saveNotify($clientID, $notifyMsg) {
			try {
                $queryRun = $this->con->prepare("insert into notification (clientID, message) values ('$clientID', '$notifyMsg')");
                $queryRun->execute();
                return $queryRun;
			}
			catch(PDOException $e) {
				echo $e->getMessage();
			}
		}

		//unread notification 4 client......
		public function hasNotification_unread($clientID) {
			try {
                $queryRun = $this->con->prepare("select * from notification where clientID='$clientID' and status='new'");
                $queryRun->execute();
                return $queryRun->rowCount();
			}
			catch(PDOException $e) {
				echo $e->getMessage();
			}
		}


        //unread notification 4 client......
        public function notificationMsg($clientID) {
            try {
                $queryRun = $this->con->prepare("select * from notification where clientID='$clientID' order by id desc limit 1");
                $queryRun->execute();
                if($queryRun->rowCount() == 0) {
                    return $this->error("You do not have any notification message");
                } else {
                    $queryRunUpdt = $this->con->prepare("update notification set status='read' where clientID='$clientID'");
                    $queryRunUpdt->execute();
                    for($i=1; $i<=$queryRun->rowCount(); $i++) {
                        $queryRunInfo = $queryRun->fetch(PDO::FETCH_ASSOC);
                        $message = $queryRunInfo["message"];
                        ?>
                        <div style="margin-bottom: 10px; background:#fff; border: 1px solid #ccc; padding: 0px 10px; border-radius: 3px; word-wrap: break-word">
                            <?php echo $message;?>
                        </div>
                        <?php
                    }
                }

            }
            catch(PDOException $e) {
                echo $e->getMessage();
            }
        }
		
		//all pending transactions 4 admin
		public function btcpendingTrans() {
			try {
				$queryRun = $this->con->prepare("select * from transactions where type='bitcoin' and type!='withdraw' and status='Pending' order by memberType desc");
				$queryRun->execute();
				
				if($queryRun->rowCount() == 0) {
				return $this->error("No transactions at the moment");
				} else {?>
					<table class="table table-responsive table-striped table-hover table-bordered" id="pendingTrans">
						<tr style="color: #000; font-weight: 700">
							<!--<td>Client Info</td> -->
							<td>Type</td>
							<td>Amount</td>
							<td>Status</td>
						</tr>
						<tr>
				<?php
					for($i=1; $i<=$queryRun->rowCount(); $i++) {
						
						$queryInfo = $queryRun->fetch(PDO::FETCH_ASSOC);
						$response = json_decode($queryInfo["response"], true);
						$amountDollar = $response["amountDollar"];
						$amountNaira = $response["amountNaira"];
						$txDateCreated = $queryInfo["txDateCreated"];
						$trans_type = $queryInfo["type"];
						$status = $queryInfo["status"];
						$clientID = $queryInfo["clientID"];
						$id = $queryInfo["id"];
					?>	
							<!--<td><?php echo $this->clientEmail($clientID) . " (vip".$this->vipLevel($clientID).")";?></td> -->
							<td><?php echo strtoupper($trans_type);?></td>
							<td>$<?php echo $amountDollar;?> for &#8358;<?php echo number_format($amountNaira);?></td>
							<td>
								<button class="btn btn-info" id="viewTrans<?php echo $id;?>"><b>View</b></button>
							</td>
						</tr>
						<script>
						$(document).ready(function(){
							$("#viewTrans<?php echo $id;?>").click(function(){
								var data = "id="+<?php echo $id;?>+"";
								var pendingResponse = $("#pendingResponse");
								$.ajax({
									url: "../actionHandler?viewTrans_Pending&id=<?php echo $id;?>",
									type: "post",
									data: data,
									beforeSend: function(){
										$("#pendingTrans").hide();
										pendingResponse.html("<center><i class='fa fa-refresh fa-spin fa-4x'></i></center>");
									},
									success: function(msg){
										setTimeout(function(){
											// $("#showTrans").show();
											pendingResponse.html(msg);
										}, 2000);
									}
								});
							});
						});
						</script>
					<?Php				

					}				
				}	
				?>
				</table>
				<?php
			}		
			catch(PDOException $e) {
				echo $e->getMessage();
			}
		}
		
		//all pending transactions 4 admin
		public function updatePrice($response, $id) {
			try {
				$queryRun = $this->con->prepare("update transactions set response='$response' where id='$id'");
				$queryRun->execute();
				return $queryRun;
				
			} catch(PDOException $e){
				echo $e->getMessage();
			}
		}
		
		//all pending transactions 4 admin
		public function viewTrans($id) {
			try {
				
				$queryRun = $this->con->prepare("select * from transactions where id='$id'");
				$queryRun->execute();
				
				if($queryRun->rowCount() == 0) {
					return $this->error("No transactions at the moment");
				} else {
					
					$queryInfo = $queryRun->fetch(PDO::FETCH_ASSOC);
					$images = $queryInfo["images"];
					$clientID = $queryInfo["clientID"];
					$type = $queryInfo["type"];
					$response = json_decode($queryInfo["response"], true);
					$txid = $response["txid"];
					$amountDollar = $response["amountDollar"];
					$amountNaira = $response["amountNaira"];
					$userRemark = $response["userRemark"];
					$itunesEcode = $response["itunesEcode"];
					$amazonCode = $response["amazonCode"];
					
					//Convert the images into an array.
					$ImgArr = explode(",", $images);
					$ImgCounter = count($ImgArr);
					$clientEmail = $this->clientEmail($clientID);
					$vipLevel = $this->vipLevel($clientID);


                    if($type == "amazon") {
                        $valAmazon = "disabled";
                    } else  if($type == "amazon no receipt") {
                        $valNo = "disabled";
                    } else  if($type == "itunes") {
                        $valUs = "disabled";
                    } else  if($type == "200 SINGLE CARD") {
                        $valsingle = "disabled";
                    } else  if($type == "AUSTRALIA ITUNES CARD") {
                        $valAus = "disabled";
                    } else  if($type == "CANADIAN ITUNES CARD") {
                        $valCan = "disabled";
                    }  else  if($type == "steam") {
                        $valsteam = "disabled";
                    }   else  if($type == "no amount itunes") {
                        $valNoAmnt = "disabled";
                    }   else  if($type == "google playstore") {
                        $valGoogle = "disabled";
                    } else{
                        $val = "";
                    }

					?>
					<div id="showTrans">
						<h2 align="center" style="color: #000">Transaction Details: <?php echo $txid;?></h2>
						<div class="row msg_cell"><b>Client Email: </b><?php echo $clientEmail. " (vip".$this->vipLevel($clientID).")";?></div> 
						<div class="row msg_cell"><b>Client Balance:  </b> &#8358;<?php echo number_format($this->clientBlc($clientID), 2);?> </div> 
						<div class="row msg_cell"><b>Amount in usd: </b>$<?php echo $amountDollar;?></div> 
						<div class="row msg_cell">
							<div class="col-sm-6">
								<b>Amount in naira: </b>&#8358;<?php echo number_format($amountNaira,2);?>
								<button id="edit" class="btn btn-default btn-sm"><b><i class="fa fa-pencil"></i> Edit</b></button>
							</div>
							<div class="col-md-6" id="showEdit" style="display: none">
								<form method="post" class="form-inline" id="priceForm<?php echo $id;?>">
									<input type="number" name="amount" id="amount" value="<?php echo $amountNaira;?>" min="<?php echo $amountNaira;?>" class="form-control input-sm">
									<input type="hidden" name="id" id="id" value="<?php echo $id;?>">
									<button type="submit" name="editAmnt<?php echo $id;?>" id="editAmnt<?php echo $id;?>" class="btn btn-success btn-sm">Update</button>
								</form>
							</div> 
						</div> 
						
						<script>
						$("#edit").click(function(e){
							e.preventDefault();
							$("#showEdit").slideToggle();
						});
						
						$("#editAmnt<?php echo $id;?>").click(function(e){
							e.preventDefault();
							
							var data = $("#priceForm<?php echo $id;?>").serialize();
							// alert(data);
							$.ajax({
								url: "../actionHandler?editNairaAmount",
								type: "post",
								data: data,
								beforeSend: function(){
									$("#editAmnt<?php echo $id;?>").html("<i class='fa fa-spinner fa-spin'></i>").prop("disabled", true);
									$("#amount").prop("disabled", true);
								},
								success: function(msg){
									setTimeout(function(){
										$("#editAmnt<?php echo $id;?>").html("Update").prop("disabled", false);
										$("#amount").prop("disabled", false);
										if(msg == "low") {
											alert("New amount is too low than current amount");
										} else if(msg == "saved") {
											alert("Amount updated");
											window.location = "store?pendingTran";
										}  else if(msg == "error") {
											alert("Please try again");
										} else {
											alert(msg);
										}
									}, 2000);
								}
							});
						});
						
						</script>
						
						<div class="row msg_cell">
                            <div class="col-md-6">
                                <b>Transaction Type: </b><?php echo strtoupper($type);?>
                                <button id="switchTrans" class="btn btn-default btn-sm"><b><i class="fa fa-exchange"></i> Switch</b></button>
                            </div>
                            <div class="col-md-6" id="show_Trans" style="display: none">
                                <form method="post" class="form-inline" id="transForm<?php echo $id;?>">
                                    <select name="transType" id="transType" class="form-control input-sm">
                                        <option value="">Please select card type</option>
                                        <option value="amazon" <?php echo $valAmazon;?>>Amazon</option>
                                        <option value="amazon no receipt" <?php echo $valNo;?>>Amazon No Receipt</option>
                                        <option value="itunes" <?php echo $valUs;?>>USA ITUNES</option>
                                        <option value="no amount itunes" <?php echo $valNoAmnt;?>>NO AMOUNT ITUNES</option>
                                        <option value="200 SINGLE CARD" <?php echo $valsingle;?>>200 SINGLE CARD</option>
                                        <option value="AUSTRALIA ITUNES CARD" <?php echo $valAus;?>>AUSTRALIA ITUNES CARD</option>
                                        <option value="CANADIAN ITUNES CARD" <?php echo $valCan;?>>CANADIAN ITUNES CARD</option>
                                        <option value="steam" <?php echo $valsteam;?>>STEAM CARD</option>
                                        <option value="google playstore" <?php echo $valsteam;?>>Google Playstore CARD</option>
                                    </select>

                                    <input type="hidden" name="id" id="id" value="<?php echo $id;?>">
                                    <button type="submit" name="editTranstype<?php echo $id;?>" id="editTranstype<?php echo $id;?>" class="btn btn-success btn-sm">Update</button>
                                </form>
                            </div>
                        </div>

                        <script>
                            $("#switchTrans").click(function(e){
                                e.preventDefault();
                                $("#show_Trans").slideToggle();

                                $("#editTranstype<?php echo $id;?>").click(function(e){
                                    e.preventDefault();

                                    if($("#transType").val() == "") {
                                        alert("Please select transaction type");
                                    } else {
                                        var data = $("#transForm<?php echo $id;?>").serialize();
                                        //alert(data);
                                        $.ajax({
                                            url: "../actionHandler?changeTrans",
                                            type: "post",
                                            data: data,
                                            beforeSend: function () {
                                                $("#editTranstype<?php echo $id;?>").html("<i class='fa fa-spinner fa-spin'></i>").prop("disabled", true);
                                                $("#transType").prop("disabled", true);
                                            },
                                            success: function (msg) {
                                                setTimeout(function () {
                                                    $("#editTranstype<?php echo $id;?>").html("Update").prop("disabled", false);
                                                    $("#transType").prop("disabled", false);

                                                    if (msg == "saved") {
                                                        alert("Transaction type  updated");
                                                        window.location = "store?pendingTran";
                                                    } else if (msg == "error") {
                                                        alert("Please try again");
                                                    } else {
                                                        alert(msg);
                                                    }
                                                }, 2000);
                                            }
                                        });
                                    }
                                });
                            });

                        </script>


						<?php if(!empty($amazonCode)) { ?>
						<div class="row msg_cell"><b>Amazon Code: </b><?php echo strtoupper($amazonCode);?></div> 
						<?php } ?>
						<div class="row msg_cell"><b>User Remark: </b><?php echo $userRemark;?></div> 
						<?php 
						if(!empty($images)) { ?>
						<div class="row msg_cell">
							<?php foreach($ImgArr as $eachImg) { ?>
								<img src="../images/market/<?php echo $eachImg;?>" width="200" height="100" style="margin: 10px">
							<?php } ?>
						</div> 
						<?php }else {
						?>
						<div class="row msg_cell"><b>Itunes Ecode: </b><?php echo $itunesEcode;?></div> 
						<?php
						} ?>
						<center>
						<?php
						
						if($ImgCounter == 1) {
							?>
								<a href="store?pendingTran&approveTrans&clntID=<?php echo $clientID;?>&id=<?php echo $id;?>" class="btn btn-success btn-lg" style="margin-bottom: 5px" onclick="return confirm('Mark all card as valid ? \n Action is irreversible')">Approve</a>
								<a class="btn btn-danger btn-lg" style="margin-bottom: 5px" href="store?pendingTran&cancelTrans&clntID=<?php echo $clientID;?>&id=<?php echo $id;?>" onclick="return confirm('Cancel Transaction ? \n Action is irreversible')"><b>Decline</b></a>
								<a href class="btn btn-info btn-lg" style="margin-bottom: 5px" href="store?pendingTran">Close</a>
							<?php
						} else if($ImgCounter > 1) {
							?>
								<a href="store?pendingTran&approveTrans&clntID=<?php echo $clientID;?>&id=<?php echo $id;?>" class="btn btn-success btn-lg" style="margin-bottom: 5px" onclick="return confirm('Mark all card as valid ? \n Action is irreversible')">Approve</a>
								<a href="store?pendingTran&approveTrans&clntID=<?php echo $clientID;?>&id=<?php echo $id;?>&separate" class="btn btn-primary btn-lg" style="margin-bottom: 5px" onclick="return confirm('Approve Transaction in batch due to an invalid card ? \n Action is irreversible')">Approve Separately</a>
								<a class="btn btn-danger btn-lg" style="margin-bottom: 5px" href="store?pendingTran&cancelTrans&clntID=<?php echo $clientID;?>&id=<?php echo $id;?>" onclick="return confirm('Cancel Transaction ? \n Action is irreversible')"><b>Decline</b></a>
								<a href class="btn btn-info btn-lg" style="margin-bottom: 5px" href="store?pendingTran">Close</a>
							<?php
						}
						?>				 
						</center>
					</div>
				<?php
				}	
			}		
			catch(PDOException $e) {
				echo $e->getMessage();
			}
		}
		
		//Load Member base on id 4 admin
		public function LoadMember($clientID) {
			try {
				
				$queryRun = $this->con->prepare("select * from client where id='$clientID'");
				$queryRun->execute();
					
				$queryInfo = $queryRun->fetch(PDO::FETCH_ASSOC);
					if($this->userType($clientID) == 1) {
						$rank = "Client";
					} else if($this->userType($clientID) == 2) {
						$rank = "Moderator";
					} else if($this->userType($clientID) == 3) {
						$rank = "Super Admin";
					}
					
					
					$bankRun = $this->con->prepare("select * from bankaccount where clientID='$clientID'");
					$bankRun->execute();
					$bankRunInfo = $bankRun->fetch(PDO::FETCH_ASSOC);
					$bankName = $bankRunInfo["bankName"];
					$merchantName = $bankRunInfo["merchantName"];
					$merchantNo = $bankRunInfo["merchantNo"];
					
					?>
					<div class="col-md-12" style="margin-bottom: 10%">
					
					<form method="post">
						<h2 align="center" style="color: #000; margin-top: 3%">Client Name: <?php echo $this->clientAccName($clientID);?></h2>
						<div class="msg_cell"><b>Client Email: </b><?php echo $this->clientEmail($clientID). " (vip".$this->vipLevel($clientID).")";?></div> 
						<div class="msg_cell"><b>Wallet: </b>&#8358;<?php echo number_format($this->clientBlc($clientID),2);?></div> 
						<div class="msg_cell"><b>Mobile No: </b><?php echo $this->clientMobile($clientID);?></div> 
						<div class="msg_cell"><b>Site Rank: </b><?php echo $rank;?></div> 
						<?php if($bankRun->rowCount() ==0){
							echo $this->error("No banking details added yet");
						} else { ?>
						<label>Banking Information</label>
						<div class="msg_cell"><b>Bank Name: </b><?php echo $bankName;?></div> 
						<div class="msg_cell"><b>Account Name: </b><?php echo $merchantName;?></div> 
						<div class="msg_cell"><b>Account No.: </b><?php echo $merchantNo;?></div> 
						
						<label>Client Point:</label>
						<input type="number" class="form-control input-lg" id="clientPt" name="clientPt" value="<?php echo $this->clientPoint($clientID);?>"><br>
						
						<label>Admin Functions</label>
						<select class="form-control input-lg" id="adminType" name="adminType">
							<option value="">Select admin role</option>
							<option value="1">Normal Client</option>
							<option value="2">Moderator</option>
							<option value="3">Global Admin</option>
						</select><br>
						
						<label>Block Member</label>
						<select class="form-control input-lg" id="blockMember" name="blockMember">
							<option value="">Please choose</option>
							<option value="1">Yes</option>
							<option value="2">No</option>
						</select><br>
						
						<center>
							<input name="clientID" type="hidden" value="<?php echo $clientID;?>">
							<button type="submit" name="updateMemb" class="btn btn-success" onclick="return confirm('Update Member')">Update Member</button>
							<a href="store?ManageClient" class="btn btn-default">Close</a>
						</center>
					</form>
						<?php } ?>
					</div>
				<?php
			}		
			catch(PDOException $e) {
				echo $e->getMessage();
			}
		}
		
		//all pending transactions 4 admin
		public function viewPayment($txID) {
			try {
				// return $txID; 
				// die();
				$queryRun = $this->con->prepare("select * from transactions where id='$txID' and type='withdraw' and status='Pending' order by memberType desc");
				$queryRun->execute();
				
				if($queryRun->rowCount() == 0) {
					return $this->error("Transaction not found or payment has been approved");
				} else {
					
					$queryInfo = $queryRun->fetch(PDO::FETCH_ASSOC);
					$amountNaira = $queryInfo["amount"];
					$clientID = $queryInfo["clientID"];
					$txDateCreated = $queryInfo["txDateCreated"];
					$response = json_decode($queryInfo["response"], true);
					$txid = $response["txid"];
					
					$bankRun = $this->con->prepare("select * from bankaccount where clientID='$clientID'");
					$bankRun->execute();
					$bankRunInfo = $bankRun->fetch(PDO::FETCH_ASSOC);
					$bankName = $bankRunInfo["bankName"];
					$merchantName = $bankRunInfo["merchantName"];
					$merchantNo = $bankRunInfo["merchantNo"];
					
					?>
					<div id="showTrans" class="col-md-12">
						<h2 align="center" style="color: #000">Transaction Details: <?php echo $txid;?></h2>
						<div class="msg_cell"><b>Client Email: </b><?php echo $this->clientEmail($clientID). " (vip".$this->vipLevel($clientID).")";?></div> 
						<div class="msg_cell"><b>Amount in naira: </b>&#8358;<?php echo number_format($amountNaira,2);?></div> 
						<div class="msg_cell"><b>Bank Name: </b><?php echo strtoupper($bankName);?></div> 
						<div class="msg_cell"><b>Account Name: </b><?php echo strtoupper($merchantName);?></div> 
						<div class="msg_cell"><b>Account No.: </b><?php echo $merchantNo;?></div> 
						
						<center>
							<form method="post">
							<input type="hidden" name="confirmWithdraw" value="<?php echo $txID;?>">
							<button type="submit" name="approveTransBtn" onclick="return confirm('Approve payment')" class="btn btn-lg btn-success">Approve</button>
							</form>
						</center>
					</div>
				<?php
				}	
			}		
			catch(PDOException $e) {
				echo $e->getMessage();
			}
		}
		
		//cancel transactions 4 admin
		public function cancelTrans($clntID, $id) {
			try {
				$clientID = $clntID;
				$clientEmail = $this->clientEmail($clientID);
					$queryRun = $this->con->prepare("update transactions set status='Cancelled' where id='$id' and clientID='$clientID'");
					if($queryRun->execute()){
						
						//We need to unblock the client so that he can check the market again...
						$unblockClnt = $this->con->prepare("update client set blockTransaction='NO' where id='$clientID'");
						$unblockClnt->execute();
						
							
							
		// set content type header for html email
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		// set additional headers
		$headers .= 'From:  noreply@connecttunes.com <noreply@connecttunes.com>' . "\r\n".'X-Mailer: PHP/' . phpversion();
		$subject = "Transaction Declined";
		$body= "<html>
<head>
<title>Transaction Declined</title>
</head>
<body>

<div style='margin-top: 10px; font-family: Helvetica,Verdana,Arial,sans-serif; font-size: 17px; line-height: 21px; padding-left: 19px; padding-right: 30px; color: rebeccapurple;'>
Hi <b>".$clientEmail ."</b> <br>
Your transaction was declined due to an invalid card or invalid transaction. We urge you to check your account for more details why the order was canceled.
Regards<br>
ConnectTunes Mgt.
<br><br>
<hr>
<small><i>This is an auto-generated email, do not reply!</i></small>
</div></body></html>";
	mail($clientEmail, $subject, $body, $headers);
			return true;
					} else {
						return false;
					}
				
			}		
			catch(PDOException $e) {
				echo $e->getMessage();
			}
		}
		
		//approve transactions 4 admin
		public function approveTrans($amountNaira, $id, $clntID) {
			try {
					$clientID = $clntID;
					$clientEmail = $this->clientEmail($clientID);
					$clientBlc = $this->clientBlc($clientID);
					$referredMe = $this->clientReffered($clientID);
					$newAmnt = $this->clientBlc($clientID) + $amountNaira;
					
					$newreferralPoint = $this->clientPoint($referredMe) + 5; //its just like 50 for referral..
					// die();
					$queryRun = $this->con->prepare("update transactions set status='Approved' where id='$id' and clientID='$clientID'");
					if($queryRun->execute()){
												
						//Has invitee receive point for inviting a client.. just once...
						if(!empty($referredMe) && $this->invitee_pointStatus($clientID) == "NO") {
							
							$updtPt = $this->con->prepare("update client set point='$newreferralPoint' where id='$referredMe'");
							$updtPt->execute();
							
							$updtPt_status = $this->con->prepare("update referral set pointRcv='YES' where clientReferred='$clientID'");
							$updtPt_status->execute();
							
							//Invitee...
							$referEmail = $this->clientEmail($referredMe);
							
							// set content type header for html email
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		// set additional headers
		$headers .= 'From:  noreply@connecttunes.com <noreply@connecttunes.com>' . "\r\n".'X-Mailer: PHP/' . phpversion();
		$subject = "Point Added";
		$body= "<html>
<head>
<title>Point Added</title>
</head>
<body>

<div style='margin-top: 10px; font-family: Helvetica,Verdana,Arial,sans-serif; font-size: 17px; line-height: 21px; padding-left: 19px; padding-right: 30px; color: rebeccapurple;'>
Hi <b>".$referEmail ."</b> <br>
You just earn 50point. Your referral just complete a transaction successfully.<br>
ConnectTunes Mgt.
<br><br>
<hr>
<small><i>This is an auto-generated email, do not reply!</i></small>
</div></body></html>";
	mail($referEmail, $subject, $body, $headers);
							
						} 
							$updtPt_status = $this->con->prepare("update referral set pointRcv='YES' where clientReferred='$clientID'");
							$updtPt_status->execute();
						} 
						
						//We need to unblock the client so that he can check the market again...
						$unblockClnt = $this->con->prepare("update client set blockTransaction='NO' where id='$clientID'");
						$unblockClnt->execute();
						
						//We need to add the money to the client wallet ...
						$addMoney = $this->con->prepare("update wallet set amount='$newAmnt' where clientID='$clientID'");
						if($addMoney->execute()){
		// set content type header for html email
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		// set additional headers
		$headers .= 'From:  noreply@connecttunes.com <noreply@connecttunes.com>' . "\r\n".'X-Mailer: PHP/' . phpversion();
		$subject = "Transaction Approved";
		$body= "<html>
<head>
<title>Transaction Approved</title>
</head>
<body>

<div style='margin-top: 10px; font-family: Helvetica,Verdana,Arial,sans-serif; font-size: 17px; line-height: 21px; padding-left: 19px; padding-right: 30px; color: rebeccapurple;'>
Hi <b>".$clientEmail ."</b> <br>
Your transaction was approved successfully. You just earned 10points for a success transaction<br>
Amount: N". $amountNaira ."<br>
New Balance: N".$newAmnt."<br>
Regards<br>
ConnectTunes Mgt.
<br><br>
<hr>
<small><i>This is an auto-generated email, do not reply!</i></small>
</div></body></html>";
	mail($clientEmail, $subject, $body, $headers);
	
	
	$referredMe = $clientID;
	$newClntPoint = $this->clientPoint($referredMe) + 1; //its just like 10 for client who made the transaction..
	
	$updtPt4Client = $this->con->prepare("update client set point='$newClntPoint' where id='$clientID'");
	$updtPt4Client->execute();
	
	return true;
						
						
					} else {
						return false;
					}
				
			}		
			catch(PDOException $e) {
				echo $e->getMessage();
			}
		}
				
		//total card no uploaded
		public function sumOfCard($id) {
			$queryRun = $this->con->prepare("select * from transactions where id='$id'");
			$queryRun->execute();
			$queryInfo = $queryRun->fetch(PDO::FETCH_ASSOC);
			$images = explode(",", $queryInfo["images"]);
			return count($images);
		}
		
		//total card no uploaded
		public function amountNaira_card($id) {
			$queryRun = $this->con->prepare("select * from transactions where id='$id'");
			$queryRun->execute();
			$queryInfo = $queryRun->fetch(PDO::FETCH_ASSOC);
			$response = json_decode($queryInfo["response"], true);
			return $response["amountNaira"];
		}
		
		//total card no uploaded
		public function cardImages($id) {
			$queryRun = $this->con->prepare("select * from transactions where id='$id'");
			$queryRun->execute();
			$queryInfo = $queryRun->fetch(PDO::FETCH_ASSOC);
			return explode(",", $queryInfo["images"]);
		}
		
		//Separate transaction approval
		public function separateApproval($id, $clntID) {
			try {
					$queryRun = $this->con->prepare("select * from transactions where id='$id'");
					$queryRun->execute();
					$queryInfo = $queryRun->fetch(PDO::FETCH_ASSOC);
					$images = $queryInfo["images"];
					$type = $queryInfo["type"];
					$clientID = $queryInfo["clientID"];
					$clientEmail = $this->clientEmail($clientID);
					$vipLevel = $this->vipLevel($clientID);
					$response = json_decode($queryInfo["response"], true);
					$txid = $response["txid"];
					$amountDollar = $response["amountDollar"];
					$amountNaira = $response["amountNaira"];
					
					$img_arr = explode(",", $images);
					?>
					<h2 align="center" style="color: #000; margin-top: -3%">Transaction Details: <?php echo $txid;?></h2>
					<form method="post" autocomplete="off" enctype="multipart/form-data">
						<div class="msg_cell"><b>Client Email: </b><?php echo $clientEmail. " (vip".$this->vipLevel($clientID).")";?></div> 
						<div class="msg_cell"><b>Client Balance:  </b> &#8358;<?php echo number_format($this->clientBlc($clientID), 2);?> </div> 
						<div class="msg_cell"><b>Amount in usd: </b>$<?php echo $amountDollar;?></div> 
						<div class="msg_cell"><b>Amount in naira: </b>&#8358;<?php echo number_format($amountNaira,2);?></div> 
						<div class="msg_cell"><b>Transaction Type: </b><?php echo strtoupper($type);?></div>
						<label><font size="4px">Uncheck Invalid Card</label><br/>
						
					<?php
					foreach($img_arr as $image) {
						?>
							<div style="margin: 10px">
								<label>
									<input type="checkbox" value="<?php echo $image;?>" name="Imgs[]" checked>
									<img src="../images/market/<?php echo $image;?>" width="200"/> </div><br/>
								</label>
						<?php
					}
					?>
					<div class="msg_cell">
						<div class="row">
							<div class="col-md-5"><b>Enter Amount in Naira: </b></div> 
							<div class="col-md-7">
								<input class="form-control" name="amountNaira" placeholder="Amount to add to user wallet" required>
							</div>
						</div>
					</div>
					<div class="msg_cell">
						<div class="col-md-5"><b>Upload Proof: (<i>Optional</i>) </b></div> 
						<div class="col-md-7"><input type="file" name="imageUpload[]" multiple required></div><br>
						
					</div>
					<div class="msg_cell">
						<div class="col-md-5"><b>Comment or Remark: </b></div> 
						<input name="img_arr" value="<?php echo $images;?>" type="hidden"><!--For passing images name-->
						<input name="transType" value="<?php echo $type;?>" type="hidden"><!--For passing images name-->
						<div class="col-md-7"><textarea name="refusalTerm" placeholder="Give a short note for card rejection " class="form-control" rows="5"></textarea></div><br>
						<br><br><br><br>
					</div>
					<div align="center">
						<button class="btn btn-success" type="submit" name="approveTrans"><b>Submit</b></button>
					</div>
					</form>
					<?php
			}		
			catch(PDOException $e) {
				echo $e->getMessage();
			}
		}
		
		//amount left to withdraw for today...
		public function totalWithdraw($clientID) {
			$queryRun = $this->con->prepare("select * from transactions where id='$id'");
			$queryRun->execute();
			$queryInfo = $queryRun->fetch(PDO::FETCH_ASSOC);
			return explode(",", $queryInfo["images"]);
		}
		
		//Last withdraw date...
		public function lastWithdrawDate($clientID) {
			$queryRun = $this->con->prepare("select * from transactions where clientID='$clientID' and type='withdraw' and status='Pending'");
			$queryRun->execute();
			$queryInfo = $queryRun->fetch(PDO::FETCH_ASSOC);
			return $queryInfo["dateWithdraw"];
		}
		
		//Last withdraw date...
		public function TotalAmount_WithdrawToday($clientID) {
			$TodaysDate = date("Y-m-d");
			$queryRun = $this->con->prepare("select sum(amount) as totalAmount from transactions where clientID='$clientID' and type='withdraw' and dateWithdraw='$TodaysDate'");
			$queryRun->execute();
			$queryInfo = $queryRun->fetch(PDO::FETCH_ASSOC);
			return $queryInfo["totalAmount"];
		}
		
		//All withdraw request...
		public function withdrawRequest() {
			$queryRun = $this->con->prepare("select * from transactions where status='Pending' and type='withdraw'");
			$queryRun->execute();
			if($queryRun->rowCount() == 0) {
				return "<div style='margin-top: -13%'>".$this->error("no withdrawal request at the moment")."</div>";
			} else {
				while($queryInfo = $queryRun->fetch(PDO::FETCH_ASSOC)) {
					$response = json_decode($queryInfo["response"], true);
					$txid = $response["txid"];
					$amountNaira = $response["amountNaira"];
					$id = $queryInfo["id"];
					?>
					
						<div class="col-md-4">
							<div style="margin-bottom: 10px; text-align:center; background:#fff; border: 1px solid #ccc; padding: 0px 10px; border-radius: 3px;box-shadow:0px 1px 0px 1px silver">
								<a href="#" style="cursor: pointer; color: #EB5424; text-transform: none" title="Transaction History" id="txID<?php echo $id;?>">
									<div style=" padding:10px; font-size:28px">
										Tx Id: <?php echo $txid;?>
										<br>
											<font size="5px">&#8358;<?php echo number_format($amountNaira,2);?></font>
									</div>
								</a>
							</div>
						</div>
						<script>
						$(document).ready(function(){
							$("#txID<?php echo $id;?>").click(function(){
								$("#viewPayment").hide();
								var status = $("#loadPayment");
								$.ajax({
									url: "../actionHandler?viewPayment",
									type: "post",
									data: "txID="+<?php echo $id;?>+"",
									beforeSend: function(){
										status.html("<center><i class='fa fa-refresh fa-spin fa-5x'></i></center>");
									},
									success: function(msg){
										status.html(msg);
									}
								});
							});
						});
						</script>
					<?php
				}
			}
		}
		
		//All withdraw request...
		public function allPaid_withdrawRequest($start_page, $per_page, $page, $href) {
			$queryRun = $this->con->prepare("select * from transactions where status!='Pending' and type='withdraw' order by id desc LIMIT $start_page, $per_page");
			$queryRun->execute();
			if($queryRun->rowCount() == 0) {
				return "<div style='margin-top: 5%'>".$this->error("no withdrawal history yet")."</div>";
			} else {
					$sql = "select * from transactions where status!='Pending' and type='withdraw'";
					echo "<br><br><br>".$this->pagination($sql, $href);
				?>
					<table class="table table-bordered table-striped table-hover">
						<tr>
							<td>Client Name</td>
							<td>Amount</td>
							<td>Date Withdraw</td>
							<td>Date Approved</td>
							<td>Status</td>
						</tr>
						<tr>
					
				<?php
				while($queryInfo = $queryRun->fetch(PDO::FETCH_ASSOC)) {
					$response = json_decode($queryInfo["response"], true);
					$clientID = $queryInfo["clientID"];
					$amount = $queryInfo["amount"];
					$txDateCreated = $queryInfo["txDateCreated"];
					$txDateApproved = $queryInfo["txDateApproved"];
                    $status = $queryInfo["status"];
                    if($status == "Approved") {
                        $status = "<font color='green'><b>Approved</b></font>";
                    } else if($status == "Cancelled") {
                        $status = "<font color='red'><b>Cancelled</b></font>";
                    }
					?>
						<td><?php echo $this->clientAccName($clientID);?></td>
                        <td><b>&#8358;<?php echo number_format($amount);?></b></td>
						<td><?php echo $txDateCreated;?></td>
						<td><?php echo $txDateApproved;?></td>
						<td><?php echo $status;?></td>
						</tr>
					<?php
				} ?>
				</table>
				<?php
			}
		}
		
		//All transaction request...
		public function alltransaction_Request($start_page, $per_page, $page, $href) {
			$queryRun = $this->con->prepare("select * from transactions where status!='Pending' and type!='withdraw' order by id desc LIMIT $start_page, $per_page");
			$queryRun->execute();
			if($queryRun->rowCount() == 0) {
				return "<div style='margin-top: '>".$this->error("no withdrawal history yet")."</div>";
			} else {
					$sql = "select * from transactions where status!='Pending' and type='withdraw'";
					echo "<br><br><br>".$this->pagination($sql, $href);
				?>
					<table class="table table-bordered table-striped table-hover">
						<tr>
							<td>Client Name</td>
							<td>Type</td>
							<td>Amount</td>
							<td>Date Submitted</td>
							<td>Status</td>
						</tr>
						<tr>
					
				<?php
				while($queryInfo = $queryRun->fetch(PDO::FETCH_ASSOC)) {
					$response = json_decode($queryInfo["response"], true);
					$txid = $response["txid"];
					$amountNaira = $response["amountNaira"];
					$id = $queryInfo["id"];
					$clientID = $queryInfo["clientID"];
					$type = $queryInfo["type"];
					$txDateCreated = $queryInfo["txDateCreated"];
					$status = $queryInfo["status"];
					if($status == "Approved") {
					    $status = "<font color='green'><b>Approved</b></font>";
                    } else if($status == "Cancelled") {
					    $status = "<font color='red'><b>Cancelled</b></font>";
                    }
					?>
						<td><?php echo $this->clientAccName($clientID);?></td>
						<td><?php echo $type;?></td>
						<td>&#8358;<?php echo number_format($amountNaira);?></td>
						<td><?php echo $txDateCreated;?></td>
						<td><?php echo $status;?></td>
						</tr>
					<?php
				}
				?>
				</table>
				<?php
			}
		}

		public function loadTrans($id, $clientID) {
		    try {
                $gather = $this->con->prepare("select * from transactions where id='$id' and clientID='$clientID'");
                $gather->execute();
                $gatherInfo = $gather->fetch(PDO::FETCH_ASSOC);
                return $gatherInfo;
            } catch (PDOException $e) {
		        echo $e->getMessage();
            }
        }

		public function saveChat($chatMsg, $transID, $clientID) {
		    try {
                $gather = $this->con->prepare("insert into chat (clientID, transID, content) values ('$clientID', '$transID', '$chatMsg')");
                $gather->execute();
                return $gather;
            } catch (PDOException $e) {
		        echo $e->getMessage();
            }
        }

		public function saveChatReply($chatMsg, $transID, $clientID) {
		    try {
                $gather = $this->con->prepare("insert into chatreply (clientID, transID, content) values ('$clientID', '$transID', '$chatMsg')");
                $gather->execute();
                return $gather;
            } catch (PDOException $e) {
		        echo $e->getMessage();
            }
        }

		//get all admin Number...
		public function adminGSM() {
			$gather = $this->con->prepare("select * from client where type='3'");
			$gather->execute();
			for($i=1; $i<=$gather->rowCount(); $i++) {
				$gatherInfo = $gather->fetch(PDO::FETCH_ASSOC);
				$phone[] = $gatherInfo["phone"];
			}
			return implode(",", $phone);
		}
		
		#Admin Functions
		
		//Functions
		public function lastInsertId() {
			$lastInsertId = $this->con->lastInsertId();
			return $lastInsertId;
		}
		
		
		public function redirect_to($link)
		{
			$redirect = header("Location:".$link);
			return $redirect;
		}

		
		public function is_loggedIN()
		{

			if(isset($_SESSION["username"]))
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		
		
		public function query($query)
		{
			$query = $this->con->prepare($query);
			return $query;
		}
		
		
		public function rows($query)
		{
			$q = $this->con->prepare($query);
			$r = $q->execute();
			$count = $q->rowCount();
			return $count;
		}
		
		
		public function success($statement) {
			$success=  '<div class="alert alert-success alert-dismissable" style="font-size: 16px; text-transform: uppercase;">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<b>'. $statement .'</b>
				</div>';
						
			return $success;
		}
		
		
		public function error($statement) {
			$error=  '<div class="alert alert-danger alert-dismissable" style="margin-right: 15px; font-size: 18px; text-transform: uppercase;">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<b>'. $statement .'</b>
				</div>';
						
			return $error;
		}	
	
		public function getURL_path() 
		{
			$pageURL = 'http';
			if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
			$pageURL .= "://";
			if ($_SERVER["SERVER_PORT"] != "80") 
			{
				$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
			} 
			else 
			{
				$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
			}
			return substr($pageURL, 0 ,-23);
		}	
		
		
		//My Paginator function
	private $PERPAGE_LIMIT = 20;
	private function getFAQ($sql) {

		// getting parameters required for pagination
		$currentPage = 1;
		if(isset($_GET['currentpage'])){
		$currentPage = $_GET['currentpage'];
		}
		$startPage = ($currentPage-1)*$this->PERPAGE_LIMIT;
		if($startPage < 0) $startPage = 0;
		$href = "?";
		// echo $this->PERPAGE_LIMIT;
		//adding limits to select query
		$result =  $this->con->prepare($sql . " limit " . $startPage . "," . $this->PERPAGE_LIMIT); 
		$result->execute();
		// print_r($result);
		while($row = $result->fetch(PDO::FETCH_ASSOC)) {
			$questions[] = $row;
		}

		if(is_array($questions)){
			$questions["msgID"] = $this->paginateResults($sql);
			return $questions;
		}
	}
	
	
	//function creates page links
	public function pagination($sql, $href) {
		$result =  $this->con->prepare($sql);
		$result->execute();
		$count = $result->rowCount();
		$output = '';
		// $href = "?";
		if(!isset($_REQUEST["currentpage"])){
			$_REQUEST["currentpage"] = 1;
			$page = $_REQUEST["currentpage"];
		}
		else
		{
			$page = $_REQUEST["currentpage"];
		}
		if($this->PERPAGE_LIMIT != 0)
		$pages  = ceil($count/$this->PERPAGE_LIMIT);
		//if pages exists after loop's lower limit
		if($pages>1)
		{
			if(($_REQUEST["currentpage"]-3)>0) {
			$output = $output . '<a href="' . $href . '&currentpage=1" class="btn btn-primary btn-sm">1</a>';
			}
			if(($_REQUEST["currentpage"]-3)>1) {
			$output = $output . ' ... ';
			}
			// Page: 1 - 20 out of 364 
			//Loop for provides links for 2 pages before and after current page
			for($i=($_REQUEST["currentpage"]-2); $i<=($_REQUEST["currentpage"]+2); $i++)	{
			if($i<1) continue;
			if($i>$pages) break;
			if($_REQUEST["currentpage"] == $i)
			$output = $output . '<span id='.$i.' class="btn btn-primary btn-sm">'.$i.'</span>';
			else				
			$output = $output . '<a href="' . $href . "&currentpage=".$i . '" class="btn btn-primary btn-sm" style="margin-left: 5px; margin-right: 5px">'.$i.'</a>';
			}

			//if pages exists after loop's upper limit
			if(($pages-($_REQUEST["currentpage"]+2))>1) {
			$output = $output . ' ... ';
			}
			if(($pages-($_REQUEST["currentpage"]+2))>0) {
			if($_REQUEST["currentpage"] == $pages)
			$output = $output . '<span id=' . ($pages) .' class="btn btn-primary btn-sm">' . ($pages) .'</span>';
			else				
			$output =  $output . '<a href="' . $href .  "&currentpage=" .($pages) .'" class="btn btn-primary btn-sm">' . ($pages) .'</a>';
			}

		}
		?><?php  echo "Page:   $page  - ";  if($this->PERPAGE_LIMIT * $page > $count) { echo $count; } else { echo $this->PERPAGE_LIMIT * $page; } ?> <?php echo ' out of '. $count  . ' ' . $output;
		// return $jxy;
	}
	
		
	//function calculate total records count and trigger pagination function	
	private function paginateResults($sql) {
		$result =  $this->con->prepare($sql); 
		$result->execute();
		$count   = $result->rowCount();
		$page_links = pagination($count);
		return $page_links;
	}
		
		
		
		
		
	}
	$obj = new Action();
// }
	
?>
