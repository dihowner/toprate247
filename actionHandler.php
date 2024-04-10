<?php
session_start();
require "action.php";
require_once "NumberFormat.php";
$action = new Action();
$username = $_SESSION["username"];

//Sms parameter
$sms_username = 'niratrade';
$sms_password = 'pelumi';
$senderid = "NIRATRADE";

date_default_timezone_set("Africa/Lagos");

function Is_email($statement){
    //If the username input string is an e-mail, return true
    if(filter_var($statement, FILTER_VALIDATE_EMAIL)) {
        return true;
    }
    else {
        return false;
    }
}

//Client register...
if(isset($_REQUEST["regClient"])) {
    $email = $_POST["username"];
    $referralcode = $_POST["code"];
    $password = $_POST["password"];
    $gsm = $_POST["gsm"];
    $checkUserInput = Is_email($email);

    $phone = str_replace("+", "", $gsm);
    $nf = new NumberFormat($phone);
    $nf->finalResult();
    $clientNum = $nf->finalResult();
    foreach(explode(",",$clientNum) as $clientNumb){
        if(!empty($clientNumb) && is_numeric($clientNumb) && strlen($clientNumb) > 11){
            $rcv[] = $clientNumb;
        }
    }
    $clientNumb =  implode(',', $rcv);
    $clientNumber = $clientNumb;


    if(empty($referralcode)){
        $referralcode = $action->adminRefCode(); //Admin ID
    } else {
        $referralcode = $action->who_ownsReferal_code($referralcode); //client id
    }

    if(empty($email) || empty($password)) {
        echo "empty_field";
    } else if(empty($clientNumber)){
        echo "empty_number";
    } else if(!$checkUserInput){
        echo "not_email";
    } else if(empty($referralcode) && $action->doesClient_Exist($referralcode) == 0){
        echo "ref_code_error";
    } else if($action->userExist($email) == 1) {
        echo "user_exist";
    } else {
        $password = md5($password);
        if($action->saveUser($email, $password, $referralcode, $clientNumber) == true) {


            //Email Message Aspect

            // set content type header for html email
            $headers  = 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
            // set additional headers
            $headers .= 'From:  noreply@niratrade.com <noreply@niratrade.com>' . "\r\n".'X-Mailer: PHP/' . phpversion();
            $subject = "Profile Created!";
            $body= "<html>
<head>
<title>Profile Created</title>
</head>
<body>

<div style='margin-top: 10px; font-family: Helvetica,Verdana,Arial,sans-serif; font-size: 17px; line-height: 21px; padding-left: 19px; padding-right: 30px; color: rebeccapurple;'>
Hi <b>".$email ."</b> <br>
Your profile has been created. <br> We promise to make your stay a worthwhile.
<br>
Regards<br>
NiraTrade Mgt.
<br><br>
<hr>
<small><i>This is an auto-generated email, do not reply!</i></small>
</div></body></html>";
            mail($email, $subject, $body, $headers);

            echo "saved";
        } else {
            echo "error";
        }
    }
}


//Admin register...
if(isset($_REQUEST["AdminReg"])) {
    $email = $_POST["username"];
    $password = $_POST["password"];
    $gsm = $_POST["gsm"];
    $checkUserInput = Is_email($email);

    $phone = str_replace("+", "", $gsm);
    $nf = new NumberFormat($phone);
    $nf->finalResult();
    $clientNum = $nf->finalResult();
    foreach(explode(",",$clientNum) as $clientNumb){
        if(!empty($clientNumb) && is_numeric($clientNumb) && strlen($clientNumb) > 11){
            $rcv[] = $clientNumb;
        }
    }
    $clientNumb =  implode(',', $rcv);
    $clientNumber = $clientNumb;


    if(empty($email) || empty($password)) {
        echo "empty_field";
    }  else if(empty($clientNumber)){
        echo "empty_number";
    } else if(!$checkUserInput){
        echo "not_email";
    } else if($action->userExist($email) == 1) {
        echo "user_exist";
    } else {
        $password = md5($password);
        if($action->saveAdminUser($email, $password, $clientNumber) == true) {

            echo "saved";
        } else {
            echo "error";
        }
    }

}

//CLient login
if(isset($_REQUEST["clientLogin"])) {
    $email = $_POST["username"];
    $password = $_POST["password"];
    $checkUserInput = Is_email($email);

    if(empty($email) || empty($password)) {
        echo "empty_field";
    } else if(!$checkUserInput){
        echo "not_email";
    } else {
        $password = md5($password);
        if($action->doLogin($email, $password) == "YES") {
            echo "logged";
        } else {
            echo "error";
        }
    }
}

//Save Bank account...
if(isset($_REQUEST["saveBankAccount"])) {
    $bank_name = strtoupper(implode(",", $_POST["bank_name"]));
    $accountName = strtoupper($_POST["accountName"]);
    $accountNumber = $_POST["accountNumber"];
    $accType = strtoupper($_POST["accType"]);
    $clientID = $action->clientID($username);
    $clientID = $action->clientID($username);

    if(empty($bank_name) || empty($accountName) || empty($accountNumber) || empty($accType)) {
        echo "empty_field";
    } else if(strlen($accountNumber) < 10 || strlen($accountNumber) > 10){
        echo "invalid_account";
    } else if($action->isUsed_AccountNumber($accountNumber) == 1){
        echo "used_acc_number";
    } else if($action->isWallet_Ready($clientID) == 1){
        echo "wallet_ready";
    } else {
        if($action->saveBankAccount($bank_name, $accountName, $accountNumber, $accType, $clientID)) {


            // set content type header for html email
            $headers  = 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
            // set additional headers
            $headers .= 'From:  noreply@niratrade.com <noreply@niratrade.com>' . "\r\n".'X-Mailer: PHP/' . phpversion();
            $subject = "Banking Account Added!";
            $body= "<html>
<head>
<title>Banking Account Added!</title>
</head>
<body>

<div style='margin-top: 10px; font-family: Helvetica,Verdana,Arial,sans-serif; font-size: 17px; line-height: 21px; padding-left: 19px; padding-right: 30px; color: rebeccapurple;'>
Hi <b>".$email ."</b> <br>
Your bank account has been added to your profile hence, a wallet has been created for your account.

Your Balance is &#8358;".number_format(0, 2)."<br>
Regards<br>
NiraTrade Mgt.
<br><br>
<hr>
<small><i>This is an auto-generated email, do not reply!</i></small>
</div></body></html>";
            mail($username, $subject, $body, $headers);

            echo "saved";
        } else {
            echo "error";
        }
    }
}

//update admin settings...
if(isset($_REQUEST["notifyMemb"])) {
    $notifyMsg = addslashes($_POST["notifyMsg"]);
    $clientID = $_POST["clientID"];
	
	if($clientID == "all_member"){
		$getClnt = $action->query("SELECT * FROM `client`");
		$getClnt->execute();
		for($i=1; $i<=$getClnt->rowCount(); $i++) {
			$getClntInfo = $getClnt->fetch();
			$clientID = $getClntInfo["id"];
			$phone[] = $getClntInfo["phone"];

			if($action->saveNotify($clientID, $notifyMsg)) {
				$msg = "saved";
			} else {
				$msg =  "error";
			}
		}

        $message = "Hello, you have a new notification message. Kindly check your NiraTrade account";
        $file = "http://connectsms.net/components/com_smsreseller/smsapi.php?";
        $data = "username=" . $sms_username . "&password=" . $sms_password . "&sender=" . $senderid . "&recipient=" . implode(",", $phone) . "&message=" . $message;
        $joinfiledata = $file . $data;
        $ch = curl_init($file);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $data = curl_exec($ch);
        curl_close($ch);
		echo $msg;
	} else {
		if(empty($notifyMsg) || empty($clientID)) {
			echo "empty_field";
		} else {
			if($action->saveNotify($clientID, $notifyMsg)) {
				echo "saved";
			} else {
				echo "error";
			}
		}
	}
}

//view transaction...
if(isset($_REQUEST["viewTrans_Pending"]) && isset($_REQUEST["id"])) {
    $id = $_REQUEST["id"];
    echo $action->viewTrans($id);
}

//edit price by admin...
if(isset($_REQUEST["editNairaAmount"])) {
  $amount = str_replace(",", "", $_POST["amount"]);
  $id = $_POST["id"];
  
  //Lolzzzzzzz.... it's a json format....
  $srchTrans = $action->query("select * from transactions where id='$id'");
  $srchTrans->execute();
  $srchTrans_Info = $srchTrans->fetch();
  $response = json_decode($srchTrans_Info["response"], true);
  $txid = $response["txid"];
  $amountDollar = $response["amountDollar"];
  $cardNo = $response["cardNo"];
  $amountNaira = $response["amountNaira"]; // current amount
  $userRemark = $response["userRemark"];
  
  //Special json for special market
  $amazonCode = $response["amazonCode"];
  $totalBtc = $response["totalBtc"];
  $itunesEcode = $response["itunesEcode"];
  
  
  //I need to rebuild them back as json...
  $json = array();  
  
  if(!empty($amazonCode)){
	  $json["txid"] = $txid;
	  $json["amountDollar"] = $amountDollar;
	  $json["cardNo"] = $cardNo;
	  $json["amountNaira"] = $amount;
	  $json["userRemark"] = $userRemark;
	  $json["amazonCode"] = $amazonCode;
  }
  else if(!empty($totalBtc)){
	  $json["txid"] = $txid;
	  $json["amountDollar"] = $amountDollar;
	  $json["totalBtc"] = $totalBtc;
	  $json["amountNaira"] = $amount;
	  $json["userRemark"] = $userRemark;
  }
  else if(!empty($itunesEcode)){
	  $json["txid"] = $txid;
	  $json["amountDollar"] = $amountDollar;
	  $json["amountNaira"] = $amount;
	  $json["userRemark"] = $userRemark;
	  $json["itunesEcode"] = $itunesEcode;
  }
  else {
	  $json["txid"] = $txid;
	  $json["amountDollar"] = $amountDollar;
	  $json["cardNo"] = $cardNo;
	  $json["amountNaira"] = $amount;
	  $json["userRemark"] = $userRemark;
  }
  
  // echo  $amountNaira;
 // if($amount < $amountNaira) {
	 // echo "low";
 // } else {
		$response = addslashes(json_encode($json));
		if($action->updatePrice($response, $id)) {
			echo "saved";
		}
	// }
}

//view payment...
if(isset($_REQUEST["convertAccount"])) {
    $conversionType = $_POST["conversionType"];
    $clientID = $action->clientID($username);
    $clientPoint = $action->clientPoint($clientID)*10;
    $vipLevel = $action->vipLevel($clientID);
    // echo $clientPoint;
    // die();
    if(empty($conversionType)){
        echo "empty_field";
    }
    else if($clientPoint < 1000) {
        echo "min_wallet";
    } else if($vipLevel == 5){
        echo "max_vip_level";
    } else{
        if($conversionType == 1) {
            $newPoint = $clientPoint - 1000;
            $newPoint = $newPoint / 10;
            $newVipLevel = $vipLevel + 1;
            $updatePt = $action->query("UPDATE `client` SET `viplevel` = '$newVipLevel', point='$newPoint' WHERE `id` ='$clientID'");
            if($updatePt->execute()) {
                echo "upgraded";
            } else {
                echo "error";
            }
        } else if($conversionType == 2) {
            $newPoint = $clientPoint - 1000;
            $newPoint = $newPoint / 10;
            $clientBlc = $action->clientBlc($clientID) + 1000;
            $updatePt = $action->query("UPDATE `wallet` SET `amount` = '$clientBlc' WHERE `clientID` ='$clientID'");
            $updateClntPt = $action->query("UPDATE `client` SET point='$newPoint' WHERE `id` ='$clientID'");
            if($updatePt->execute() && $updateClntPt->execute()) {
                echo "amount_added";
            } else {
                echo "error";
            }
        }
    }
}

//convert account...
if(isset($_REQUEST["viewPayment"])) {
    $txID = $_REQUEST["txID"];
    echo $action->viewPayment($txID);
}

//member load transaction info...
if(isset($_REQUEST["memberTransInfo"])) {
    $clientID = $action->clientID($username);
    $viewTrans = $_POST["viewTrans"];

    $checkTrans = $action->query("SELECT * FROM `transactions` WHERE `id` ='$viewTrans' and clientID='$clientID'");
    $checkTrans->execute();
    $checkTrans_Info = $checkTrans->fetch(PDO::FETCH_ASSOC);
    $tranStatus = $checkTrans_Info["status"];
    $response = json_decode($checkTrans_Info["response"], true);
    $txID = $response["txid"];
    $amountNaira = $response["amountNaira"];
    $amountDollar = $response["amountDollar"];
    $itunesEcode = $response["itunesEcode"];
    $amazonCode = $response["amazonCode"];
    $allImage_memb = $checkTrans_Info["images"];
    $transType = $checkTrans_Info["type"];
    $txDateCreated = $checkTrans_Info["txDateCreated"];
    $txDateApproved = $checkTrans_Info["txDateApproved"];
    ?>
    <h2 align="center">Transaction ID: <?php echo $txID;?></h2>
    <?php

    if($tranStatus == "Approved") {
        ?>
        <div class="msg_cell"><b>Amount Approved: </b> &#8358;<?php echo number_format($amountNaira);?></div>
        <?php if($transType!="withdraw") { ?>
            <div class="msg_cell"><b>Transaction Type: </b> <?php echo $transType;?></div>
        <?php }
		if(!empty($amazonCode)) {?>
            <div class="msg_cell"><b>Amazon No Receipt Code: </b> <?php echo $amazonCode;?></div>
        <?php } 
		
        if($transType=="withdraw") { ?>
            <div class="msg_cell"><b>Date Approved: </b> <?php echo $txDateApproved;?></div>
        <?php } ?>
        <div class="msg_cell"><b>Status: </b> <font color='red'>Approved</font></div>
        <?php if($transType!="withdraw" && !empty($allImage_memb)) { ?>
            <div class="msg_cell"><b>User Upload: </b>
                <?php
                foreach(explode(',', $allImage_memb) as $allImage_membs){
                    ?>
                    <img src="../images/market/<?php echo $allImage_membs;?>" width="200" height="100" style="margin: 10px">
                    <?php
                }
                ?>
            </div>
            <?php
        } else {?>
            <div class="msg_cell"><b>ITUNES ECODE: </b> <?php echo $itunesEcode;?></div>
        <?php } 
    }
    else if($tranStatus == "Pending" && $transType == "withdraw" ) {
        ?>
        <div class="msg_cell"><b>Amount in Naira: </b> &#8358;<?php echo number_format($amountNaira);?></div>
        <div class="msg_cell"><b>Transaction Type: </b> Expenditure</div>
        <div class="msg_cell"><b>Status: </b> <font color='brown'>In Progress</font></div>
        <div class="msg_cell"><b>Date Created: </b> <?php echo $txDateCreated;?>	</div>
        <?php
    }
    else if($tranStatus == "Pending") {
        ?>
        <div class="msg_cell"><b>Amount in Naira: </b> &#8358;<?php echo number_format($amountNaira);?></div>
        <div class="msg_cell"><b>Amount in Dollar: </b> $<?php echo $amountDollar;?></div>
        <div class="msg_cell"><b>Transaction Type: </b> <?php echo strtoupper($transType);?></div>
        <div class="msg_cell"><b>Status: </b> <font color='brown'>In Progress</font></div>
		<?php 
		if(!empty($amazonCode)) { ?>
            <div class="msg_cell"><b>Amazon No Receipt Code: </b> <?php echo $amazonCode;?></div>
        <?php } 
		  if(!empty($allImage_memb)){ ?>
        <div class="msg_cell"><b>User Upload: </b>
            <?php
            foreach(explode(',', $allImage_memb) as $allImage_membs){
                ?>
                <img src="../images/market/<?php echo $allImage_membs;?>" width="200" height="100" style="margin: 10px">
                <?php
            }
            ?>
        </div>
        <?php
		}  else {?>
            <div class="msg_cell"><b>ITUNES ECODE: </b> <?php echo $itunesEcode;?></div>
        <?php } 
    } else if($tranStatus == "Cancelled") {
        //We need to find rejected ones...
        $check_rejectedTrans = $action->query("SELECT * FROM refusedtrans WHERE `txID` ='$viewTrans'");
        $check_rejectedTrans->execute();
        $check_rejectedTrans_Info = $check_rejectedTrans->fetch(PDO::FETCH_ASSOC);
        $refusalTerm = $check_rejectedTrans_Info["refusalTerm"];
        $rejectedimages = $check_rejectedTrans_Info["images"];
        $adminResponse = json_decode($check_rejectedTrans_Info["response"], true);
        $adminImg = $adminResponse["adminImg"];
        $approvedImage = array_diff(explode(",", $allImage_memb), explode(",", $rejectedimages));

        // echo $allImage_memb;
        //We need to find rejected ones...
        $implodeApprImg = implode(',',$approvedImage);
        $findBaseOnImg = $action->query("SELECT * FROM refusedtrans WHERE `images` ='$implodeApprImg'");
        $findBaseOnImg->execute();
        // echo $implodeApprImg . "<br>";
        // echo $findBaseOnImg->rowCount();
        // die();
        $findBaseOnImg_Info = $findBaseOnImg->fetch(PDO::FETCH_ASSOC);
        $amount_appr = $findBaseOnImg_Info["amount"];

        ?>
        <div class="msg_cell"><b>Amount Rejected: </b> &#8358;<?php echo number_format($amountNaira);?></div>
        <div class="msg_cell"><b>Amount Approved: </b> &#8358;<?php echo number_format($amount_appr);?></div>
        <div class="msg_cell"><b>Transaction Type: </b> <?php echo strtoupper($transType);?></div>
        <div class="msg_cell"><b>Status: </b> <font color='red'>Cancelled</font></div>
		<?php
		if(!empty($amazonCode)) { ?>
            <div class="msg_cell"><b>Amazon No Receipt Code: </b> <?php echo $amazonCode;?></div>
        <?php } 
		if($transType!= "itunes ecode") { ?>
        <div class="msg_cell"><b>Rejected Card:</b>

            <?php
            foreach(explode(",", $rejectedimages) as $rejected_images) {
                ?>
                <img src="../images/market/<?php echo $rejected_images;?>" width="200" height="100" style="margin: 10px">
                <?php
            }
            ?>

        </div>
        <div class="msg_cell"><b>Approved Card: </b>

            <?php
            foreach($approvedImage as $approved_Image) {
                ?>
                <img src="../images/market/<?php echo $approved_Image;?>" width="200" height="100" style="margin: 10px">
                <?php
            }
            ?>

        </div>
		<?php }
			 else {?>
            <div class="msg_cell"><b>ITUNES ECODE: </b> <?php echo $itunesEcode;?></div>
        <?php } 
		?>
        <div class="msg_cell"><b>Refusal Specification: </b> <?php echo $refusalTerm;?></div>
        <div class="msg_cell"><b>Declination Proof: </b>

            <?php
            foreach(explode(',', $adminImg) as $adminImg_approved_Image) {
                ?>
                <img src="../images/market/<?php echo $adminImg_approved_Image;?>" width="200" height="100" style="margin: 10px">
                <?php
            }
            ?>

        </div>
        <?php
    }
    if($tranStatus != "Cancelled" && $tranStatus != "Approved") { ?>
        <div style="color: red; font-size: 28px;">
            <a href="?chatAdmin&transID=<?php echo $viewTrans;?>">
                <b><i class="fa fa-bullhorn fa-2x"></i> Chat With Admin</b>
            </a>
        </div>
    <?php } ?>
    <div align="center" style="margin-bottom: 2%">
        <a href="dashboard" class="mb-2 btn btn-sm btn-outline-dark mr-1">
            <b>CLOSE</b>
        </a>
    </div>
    <?php
}

//Show member info 4 admin...
if(isset($_REQUEST["LoadMember"])) {
    $clientID = $_REQUEST["clientID"];
    echo $action->LoadMember($clientID);
}

//send reset code...
if(isset($_REQUEST["sendResetCode"])) {
    $username = $_POST["username"];
    //get the client ID
    $clientID = $action->clientID($username);
    if(empty($clientID)) {
        $clientID = 0;
    }
    if(empty($username)) {
        echo "empty_field";
    }
    else if(!filter_var($username, FILTER_VALIDATE_EMAIL)){
        echo "not_email";
    }
    else {
        if($clientID == 0){
            echo "not_found";
        } else {
            $code = substr(sha1(md5(time() * mt_rand(111, 999))), mt_rand(1, 5), 10);
            if($action->doesUserHas_resetcodebefore($clientID) == 0) {
                $saveCode = $action->query("insert into resetPassword (clientID, code) values ('$clientID','$code')");
                if($saveCode->execute()){

                    // set content type header for html email
                    $headers  = 'MIME-Version: 1.0' . "\r\n";
                    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                    // set additional headers
                    $headers .= 'From:  resetpassword@niratrade.com <resetpassword@niratrade.com>' . "\r\n".'X-Mailer: PHP/' . phpversion();
                    $subject = "Password Recovery!";

                    $body= "<html>
<head>
<title>Withdrawal Request</title>
</head>
<body>

<div style='margin-top: 10px; font-family: Helvetica,Verdana,Arial,sans-serif; font-size: 17px; line-height: 21px; padding-left: 19px; padding-right: 30px; color: rebeccapurple;'>
Dear ". $username.",<br><h2>You requested to change your password</h2><br>

Click <a href='http://niratrade.com/pswdreset?ResetPswd&code=$code' style='color: red'>HERE</a> or copy and paste the link below into your browser to change your password.<br><br>http://niratrade.com/pswdreset?ResetPswd&code=$code<br><br>
<textarea style='width: 100%; height: 100px'>http://niratrade.com/pswdreset?ResetPswd&code=$code</textarea><br><br>
Regards<br>
NiraTrade Mgt.
<hr>
<small><i>This is an auto-generated email, do not reply!</i></small>
</div></body></html>";
                    mail($username, $subject, $body, $headers);

                    echo "code_sent";
                } else {
                    echo "error";
                }
            } else{
                $deleteCode = $action->query("delete from resetPassword where clientID='$clientID'and status='Pending'");
                if($deleteCode->execute()){
                    $saveCode = $action->query("insert into resetPassword (clientID, code) values ('$clientID','$code')");
                    if($saveCode->execute()){

                        // set content type header for html email
                        $headers  = 'MIME-Version: 1.0' . "\r\n";
                        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                        // set additional headers
                        $headers .= 'From:  resetpassword@niratrade.com <resetpassword@niratrade.com>' . "\r\n".'X-Mailer: PHP/' . phpversion();
                        $subject = "Password Recovery!";

                        $body= "<html>
<head>
<title>Withdrawal Request</title>
</head>
<body>

<div style='margin-top: 10px; font-family: Helvetica,Verdana,Arial,sans-serif; font-size: 17px; line-height: 21px; padding-left: 19px; padding-right: 30px; color: rebeccapurple;'>
Dear ". $username.",<br><h2>You requested to change your password</h2><br>

Click <a href='http://niratrade.com/pswdreset?ResetPswd&code=$code' style='color: red'>HERE</a> or copy and paste the link below into your browser to change your password.<br><br>http://niratrade.com/pswdreset?ResetPswd&code=$code<br><br>
<textarea style='width: 100%; height: 100px'>http://niratrade.com/pswdreset?ResetPswd&code=$code</textarea><br><br>
Regards<br>
NiraTrade Mgt.
<hr>
<small><i>This is an auto-generated email, do not reply!</i></small>
</div></body></html>";
                        mail($username, $subject, $body, $headers);
                        echo "code_sent";
                    } else {
                        echo "error";
                    }
                }
            }
        }
    }
}

//send reset code...
if(isset($_REQUEST["resetPassword"])) {
    $clientID = $_POST["clientID"];
    $code = $_POST["code"];
    $newPass = $_POST["newPass"];
    $re_NewPass = $_POST["re_NewPass"];
    if(empty($newPass) || empty($re_NewPass)) {
        echo "empty_field";
    } else if($newPass != $re_NewPass) {
        echo "not_match";
    } else {
        $newPass = md5($newPass);
        if($action->updateClientPass($newPass, $clientID)) {
            $updateCode = $action->query("update resetPassword set status='used' where clientID='$clientID'and code='$code'");
            $updateCode->execute();
            echo "updated";
        } else {
            echo "error";
        }
    }
}

//view transaction...
if(isset($_REQUEST["withdrawRequest"])) {
    $amountWithdraw = str_replace(array(" ", ",", "N"), "", $_POST["amountWithdraw"]);
    $clientID = $action->clientID($username);
    $TodaysDate = date("Y-m-d");
    $vipLevel = "vip".$action->vipLevel($clientID);
    $response["txid"] = substr(md5(rand(111, 987)), 0, 10);
    $response["amountNaira"] = $amountWithdraw;
    $response["dateWithdraw"] = $TodaysDate;
    $jsonResponse = addslashes(json_encode($response));
    $clientBlc = $action->clientBlc($clientID);
    $amnt_with_vat = $amountWithdraw + 100;
    $newBlc = $clientBlc - $amnt_with_vat;
    if(empty($amountWithdraw)){
        echo "empty_field";
    } else if($amountWithdraw < 2000){
        echo "min_amnt";
    } else if($amountWithdraw > 100000){
        echo "max_amnt";
    } else {
        if($amnt_with_vat > $clientBlc) { //Wallet balance...
            echo "wallet_small";
        } else {
            if($TodaysDate == $action->lastWithdrawDate($clientID)) {
                if($action->TotalAmount_WithdrawToday($clientID) >= 100000) {
                    echo "limit_exceed";
                } else {
                    if($action->TotalAmount_WithdrawToday($clientID) > 0){ //Means user has withdraw today... how much left
                        $amount_avail = 100000 - $action->TotalAmount_WithdrawToday($clientID);
                        if($amountWithdraw > $amount_avail) {
                            echo $action->error("<i class='fa fa-remove'></i> You can only withdraw &#8358;".number_format($amount_avail,2)." for today");
                        } else {
                            // die();
                            //Save the transaction....
                            $saveTrans = $action->query("insert into transactions (clientID, memberType, amount, type, response, dateWithdraw) values ('$clientID', '$vipLevel', '$amountWithdraw', 'withdraw', '$jsonResponse','$TodaysDate')");
                            if($saveTrans->execute()) {
                                //Update the balance
                                $updateBlc = $action->query("update wallet set amount='$newBlc' where clientID='$clientID'");
                                $updateBlc->execute();

                                // set content type header for html email
                                $headers  = 'MIME-Version: 1.0' . "\r\n";
                                $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                                // set additional headers
                                $headers .= 'From:  noreply@niratrade.com <noreply@niratrade.com>' . "\r\n".'X-Mailer: PHP/' . phpversion();
                                $subject = "Withdrawal Request!";
                                $body= "<html>
<head>
<title>Withdrawal Request</title>
</head>
<body>

<div style='margin-top: 10px; font-family: Helvetica,Verdana,Arial,sans-serif; font-size: 17px; line-height: 21px; padding-left: 19px; padding-right: 30px; color: rebeccapurple;'>
You recently make a withdrawal request of NGN".$amountWithdraw."<br>
Your request has been received and will be processed soon<br>
Regards<br>
NiraTrade Mgt.
<hr>
<small><i>This is an auto-generated email, do not reply!</i></small>
</div></body></html>";
                                mail($username, $subject, $body, $headers);
                                echo "successful";
                            } else {
                                echo "error";
                            }
                        }
                    }
                }
            } else {
                $saveTrans = $action->query("insert into transactions (clientID, memberType, amount, type, response, dateWithdraw) values ('$clientID', '$vipLevel', '$amountWithdraw', 'withdraw', '$jsonResponse','$TodaysDate')");
                if($saveTrans->execute()) {
                    //Update the balance
                    $updateBlc = $action->query("update wallet set amount='$newBlc' where clientID='$clientID'");
                    $updateBlc->execute();

                    // set content type header for html email
                    $headers  = 'MIME-Version: 1.0' . "\r\n";
                    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                    // set additional headers
                    $headers .= 'From:  noreply@niratrade.com <noreply@niratrade.com>' . "\r\n".'X-Mailer: PHP/' . phpversion();
                    $subject = "Withdrawal Request!";
                    $body= "<html>
<head>
<title>Withdrawal Request</title>
</head>
<body>

<div style='margin-top: 10px; font-family: Helvetica,Verdana,Arial,sans-serif; font-size: 17px; line-height: 21px; padding-left: 19px; padding-right: 30px; color: rebeccapurple;'>
You recently make a withdrawal request of NGN".$amountWithdraw."<br>
Your request has been received and will be processed soon<br>
Regards<br>
NiraTrade Mgt.
<hr>
<small><i>This is an auto-generated email, do not reply!</i></small>
</div></body></html>";
                    mail($username, $subject, $body, $headers);
                    echo "successful";
                } else {
                    echo "error";
                }
            }
        }
    }
}


//Contact us ....
if(isset($_REQUEST["contactUs"])) {
    $name = $_POST["your_name"];
    $email = $_POST["your_emailAddr"];
    $subject = $_POST["subject"];
    $message = $_POST["your_msg"];
    if(empty($name) || empty($email) || empty($subject) || empty($message)) {
        echo "empty_field";
    } else if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "not_email";
    } else {
        $receiver_email = "odeniyipelumi@gmail.com";
        // set content type header for html email
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        // set additional headers
        $headers .= 'From: NiraTrade <noreply@niratrade.com>' . "\r\n".'X-Mailer: PHP/' . phpversion();
        $subject = $subject;
        $body= "<html>
    <head>
        <title>". $subject ."</title>
    </head>
    <body>
<div style='font-family:arial;border:2px solid #c0c0c0;padding:15px;border-radius:5px;'>
	This is an enquiry email via <a href='http://niratrade.com/contact_us' target='_blank'>http://niratrade.com/contact_us</a> from: $name < <a href='mailto:$email'>$email</a> >
	<br><br>
	$message
</div></div></body>";
        if(mail($receiver_email, $subject, $body, $headers)) {
            echo "mail_sent";
        } else {
            echo "error";
        }
    }
}

//Fetch card type...
if(isset($_REQUEST["fetchCardType"])) {
   $fetchVal = $_POST["fetchVal"];
   if($fetchVal == "itunes") {
    ?>
	<div class="row">
       <div class="col-lg-5"><br>
       <label for="itunesValue">Enter amount <font size="3px">(Separate multiple card amount value with comma):</font></label><br>
           <input type="text" placeholder="Card Value" name="cardAmount" id="itunesValue" onKeyUp="getitunesCost();" class="form-control input-lg" required>
           <input id="ituneNaira" name="ituneNaira" type="hidden">
       </div>
	   
       <div class="col-lg-7"><br><br>
           <div id="itunesSum" style="font-size: 26px"></div>
       </div>
   </div>

    <?php
   } else if($fetchVal == "200 SINGLE CARD") {
       ?>
	<div class="row">
       <div class="col-md-5"> <br>
			<label for="itunesValue">Enter amount <font size="3px">(Separate multiple card amount value with comma):</font></label><br>
           <input type="text" placeholder="Card Value" name="cardAmount" id="single200Value" onKeyUp="get200Cost();" class="form-control input-lg" required>
           <input id="ituneNaira" name="ituneNaira" type="hidden">
       </div>
       <div class="col-md-7"><br><br>
           <div id="itunesSum" style="font-size: 26px"></div>
       </div>
	</div>

       <?php
   } else if($fetchVal == "AUSTRALIA ITUNES CARD") {
       ?>
		<div class="row">
		   <div class="col-md-5"><br>
		   <label for="itunesValue">Enter amount <font size="3px">(Separate multiple card amount value with comma):</font></label><br>
			   <input type="text" placeholder="Card Value" name="cardAmount" id="austriaValue" onKeyUp="getAustraliaCost();" class="form-control input-lg" required>
			   <input id="ituneNaira" name="ituneNaira" type="hidden">
		   </div>
		   <div class="col-md-7"><br><br>
			   <div id="itunesSum" style="font-size: 26px"></div>
		   </div>
		</div>

       <?php
   } else if($fetchVal == "CANADIAN ITUNES CARD") {

       ?>
		<div class="row">
		   <div class="col-md-5"><br>
		   <label for="itunesValue">Enter amount <font size="3px">(Separate multiple card amount value with comma):</font></label><br>
			   <input type="text" placeholder="Card Value" name="cardAmount" id="canadaValue" onKeyUp="getCanadaCost();" class="form-control input-lg" required>
			   <input id="ituneNaira" name="ituneNaira" type="hidden">
		   </div>
		   <div class="col-md-7"><br><br>
			   <div id="itunesSum" style="font-size: 26px"></div>
		   </div>
	   </div>

       <?php
   }
}

if(isset($_REQUEST["cardPrice"])) {
    $fetchVal = $_POST["fetchVal"];
    if($fetchVal == "itunes") {
        $price = $action->itunesPrice();
    } else if($fetchVal == "200 SINGLE CARD") {
        $price = $action->singlecardPrice();
    } else if($fetchVal == "AUSTRALIA ITUNES CARD") {
        $price = $action->australiaPrice();
    } else if($fetchVal == "CANADIAN ITUNES CARD") {
        $price = $action->canadianPrice();
    }
    ?>

    <table class="table table-responsive table-striped table-bordered" style="margin-bottom:5%">
        <tr id="head">
            <th>Total Amount</th>
            <th>Price (per 100$)</th>
            <th></th>
        </tr>
        <tr>

            <?php
            $replace = str_replace(array('\r\n','\n',"\n","\r\n"), "<br>", $price);
            $cost2 = explode("<br>", $replace);
            for($i=0; $i<count($cost2); $i++){
                $x=explode("=",$cost2[$i]);
                $y= implode(",", explode("=",$x[1]));
                $price_perVal[] = $y;
                $lowMin[] = $x[0];
            }
            //Array Combine...
            $arrPush = array_combine($lowMin, $price_perVal);

            foreach($arrPush as $amount=>$pricePerDollar){
            ?>
            <td>≥ $<?php echo $amount;?></td>
            <td>&#8358;<?php echo number_format($pricePerDollar*100);?></td>
            <td>$<?php echo $amount;?> = &#8358;<?php echo number_format($pricePerDollar*$amount);?></td>
        </tr>
        <?php
        }
        ?>
    </table>

    <?php
}

//Change transaction...
if(isset($_REQUEST["changeTrans"])) {
    $transType = $_POST["transType"];
    $id = $_POST["id"];
    $updtTran = $action->query("update transactions set type='$transType' where id='$id'");
    if($updtTran->execute()) {
        echo "saved";
    } else {
        echo "error";
    }
}