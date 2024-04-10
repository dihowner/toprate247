<?php 
session_start();
require "../action.php"; $action = new Action();
$username = $_SESSION["username"];
$clientID = $action->clientID($username);
if($action->isUser($clientID) == 0) {
    $action->redirect_to("../login");
}
else if($action->bankAccount_row($clientID) == 0) {
    $action->redirect_to("bankAccount");
}
else if($action->isMember_ban($clientID) != 2) {
    ?>
    <script>
        alert("You are banned");
        window.location = "../login";
    </script>
<?php }
?>
<!doctype html>
<html class="no-js h-100" lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Wallet - Toprate 247</title>
    <meta name="description" content="A high-quality &amp; free Bootstrap admin dashboard template pack that comes with lots of templates and components.">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link rel="stylesheet" href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" id="main-stylesheet" data-version="1.1.0" href="styles/shards-dashboards.1.1.0.min.css">
    <link rel="stylesheet" href="styles/extras.1.1.0.min.css">
    <link rel="stylesheet" href="styles/styles.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/0acf54d04e.css">
    <style>
        .progress {
            height: 20px;
            margin-bottom: 20px;
            overflow: hidden;
            background-color: #f5f5f5;
            border-radius: 4px;
            box-shadow: inset 0 1px 2px rgba(0, 0, 0, .1);
        }
        .progress-bar.active {
        	animation: progress-bar-stripes 2s linear infinite;
        }
        .progress-bar {
            font-size: 18px;
            font-weight: bolder;
        	float: left;
            height: 100%;
            line-height: 20px;
            color: #fff;
            text-align: center;
            background-color: #428bca;
            box-shadow: inset 0 -1px 0 rgba(0, 0, 0, .15);
            transition: width .6s ease;
        }
        
        .progress-bar-striped {
        	background-size: 40px 40px;
        	background-image: linear-gradient(45deg, rgba(255, 255, 255, .15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, .15) 50%, rgba(255, 255, 255, .15) 75%, transparent 75%, transparent);
        }
		.list-group-item {
			font-weight: 300;
			font-family: times;
		}

    </style>
	
    <link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css"/>
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

	<script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
	<script src="https://cdn.datatables.net/responsive/2.2.1/js/dataTables.responsive.min.js"></script>
	
	<script>
	$(document).ready(function() {
		$('#example').DataTable();
	} );
	</script>
  </head>
  <body class="h-100">
    <div class="container-fluid">
      <div class="row">
        <!-- Main Sidebar -->
        <aside class="main-sidebar col-12 col-md-3 col-lg-2 px-0">
          <div class="main-navbar">
            <nav class="navbar align-items-stretch navbar-light bg-white flex-md-nowrap border-bottom p-0">
              <a class="navbar-brand w-100 mr-0" href="dashboard" style="line-height: 25px;">
                <div class="d-table m-auto">
                  <img id="main-logo" class="d-inline-block align-top mr-1" style="max-width: 25px;" src="images/shards-dashboards-logo.svg" alt="Shards Dashboard">
                  <span class="d-none d-md-inline ml-1">Toprate 247</span>
                </div>
              </a>
              <a class="toggle-sidebar d-sm-inline d-md-none d-lg-none">
                <i class="material-icons">&#xE5C4;</i>
              </a>
            </nav>
          </div>
		  
			<div class="nav-wrapper"> 
		  
				<ul class="nav flex-column">
				  <li class="nav-item">
					<a class="nav-link" href="dashboard">
					  <i class="material-icons">home</i>
					  <span>Dashboard</span>
					</a>
				  </li>
				  <li class="nav-item">
					<a class="nav-link" href="userAccount">
					  <i class="fa fa-user"></i>
					  <span>My Account</span>
					</a>
				  </li>
				  <li class="nav-item">
					<a class="nav-link active" href="wallet">
					  <i class="material-icons">money</i>
					  <span>My Wallet</span>
					</a>
				  </li>
				  <li class="nav-item">
					<a class="nav-link " href="market">
					  <i class="material-icons">shop</i>
					  <span>Sell Gift Card</span>
					</a>
				  </li>
				  
				  <?php if($action->userType($clientID) == 2 || $action->userType($clientID) == 3) { ?>
					  <li class="nav-item">
						<a class="nav-link " href="store">
						  <i class="fa fa-dashboard"></i>
						  <span>Admin Panel</span>
						</a>
					  </li>
				  <?php } ?>
				  <li class="nav-item">
					<a class="nav-link " href="logout">
					  <i class="fa fa-sign-out"></i>
					  <span>Log Out</span>
					</a>
				  </li>
				</ul>
			</div>
        </aside>
        <!-- End Main Sidebar -->
        <main class="main-content col-lg-10 col-md-9 col-sm-12 p-0 offset-lg-2 offset-md-3" style="background: #fff">
          <div class="main-navbar sticky-top bg-white">
            <!-- Main Navbar -->
            <nav class="navbar align-items-stretch navbar-light flex-md-nowrap p-0">
              <form action="#" class="main-navbar__search w-100 d-none d-md-flex d-lg-flex" style="visibility: hidden">
                <div class="input-group input-group-seamless ml-3">
                  <div class="input-group-prepend">
                    <div class="input-group-text">
                      <i class="fas fa-search"></i>
                    </div>
                  </div>
                  <input class="navbar-search form-control" type="text" placeholder="Search for something..." aria-label="Search"> </div>
              </form>
              <ul class="navbar-nav border-left flex-row ">
                
                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle text-nowrap px-3" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                    <img class="user-avatar rounded-circle mr-2" src="images/avatars/0.jpg" alt="User Avatar">
                    <span class="d-none d-md-inline-block"><?php echo ucfirst($username);?></span>
                  </a>
                  <div class="dropdown-menu dropdown-menu-small">
                    <a class="dropdown-item" href="wallet">
                      <i class="material-icons">&#xE7FD;</i> My Wallet</a>
                    <a class="dropdown-item" href="userAccount">
                      <i class="fa fa-user"></i> Edit Profile</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item text-danger" href="logout">
                      <i class="fa fa-sign-out text-danger"></i> Logout </a>
                  </div>
                </li>
              </ul>
              <nav class="nav">
                <a href="#" class="nav-link nav-link-icon toggle-sidebar d-md-inline d-lg-none text-center border-left" data-toggle="collapse" data-target=".header-navbar" aria-expanded="false" aria-controls="header-navbar">
                  <i class="material-icons">&#xE5D2;</i>
                </a>
              </nav>
            </nav>
          </div>
          <!-- / .main-navbar -->
          <div class="main-content-container container-fluid px-4">
            <?php require "userhead.php";?>
			
            <!-- End Small Stats Blocks -->
            <div class="row">
			
				<div class="col-lg-5">
                <div class="card card-small mb-4">
                  <div class="card-header border-bottom">
                    <h6 class="m-0">Withdraw Money</h6>
                  </div>
                  <ul class="list-group list-group-flush">
                    <li class="list-group-item p-3">
                      <div class="row">
                        <div class="col">
						
							<?php
							if(isset($_POST["compltWithdraw"])) {
								
								$amountWithdraw = str_replace(array(" ", ",", "N"), "", $_POST["amntWithdraw"]);
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
									echo $action->error("Please fill all field");
								} else if($amountWithdraw < 2000){
									echo $action->error("<b>minimum withdrawal is N2,000</b>");
								} else if($amountWithdraw > 100000){
									echo $action->error("<b>minimum withdrawal is N100,000</b>");
								} else {
									if($amnt_with_vat > $clientBlc) { //Wallet balance...
										echo $action->error("insufficient wallet balance");
									} else {
										
										if($TodaysDate == $action->lastWithdrawDate($clientID)) {
											if($action->TotalAmount_WithdrawToday($clientID) >= 100000) {
												echo $action->error("daily withdrawal limit exceeded");
											} else {
												if($action->TotalAmount_WithdrawToday($clientID) > 0){ //Means user has withdraw today... how much left
													$amount_avail = 100000 - $action->TotalAmount_WithdrawToday($clientID);
													if($amountWithdraw > $amount_avail) {
														echo $action->error("<i class='fa fa-remove'></i> You can only withdraw &#8358;".number_format($amount_avail,2)." for today");
													} else {
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
															$headers .= 'From:  noreply@toprate247.com <noreply@toprate247.com>' . "\r\n".'X-Mailer: PHP/' . phpversion();
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
							Toprate247 Mgt.
							<hr>
							<small><i>This is an auto-generated email, do not reply!</i></small>
							</div></body></html>";
															mail($username, $subject, $body, $headers); ?>
															<script>
																alert("Your request has been received");
																window.location = "wallet";
															</script>
														<?php
														} else {
															echo $action->error("Unknown error occurred");
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
												$headers .= 'From:  noreply@toprate247.com <noreply@toprate247.com>' . "\r\n".'X-Mailer: PHP/' . phpversion();
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
							Toprate247 Mgt.
							<hr>
							<small><i>This is an auto-generated email, do not reply!</i></small>
							</div></body></html>";
												mail($username, $subject, $body, $headers);
												?>
												<script>
													alert("Your request has been received");
													window.location = "wallet";
												</script>
											<?php
											} else {
												echo $action->error("Unknown error occurred");
											}
										}
									}
								}
							}
							?>
							
                          <form method="post">
                            <div class="form-row">
                              <div class="form-group col-md-12" style="font-size: 18px">
                                Wallet Balance : &#8358;<?php echo number_format($action->clientBlc($clientID), 2);?>
							  </div>
                            </div>
                            <div class="form-row">
                              <div class="form-group col-md-12">
                                <label for="amntWithdraw"><b>Enter Amount:</b></label>
                                <input class="form-control input-lg" type="number" placeholder="Enter amount to withdraw e.g 50050" min="1000" value="1000" step="10" name="amntWithdraw" id="amntWithdraw" autofocus required> </div>
                            </div>
                            <div class="form-row">
                              <div class="form-group col-md-12">
                                <label for="reNewPass"><b>Account Name:</b></label>
                                <input class="form-control input-lg" value="<?php echo $action->clientAccName($clientID);?>" disabled> 
								</div>
                            </div>
                            <div class="form-row">
                              <div class="form-group col-md-12">
                                <label for="reNewPass"><b>Account No:</b></label>
                                <input class="form-control input-lg" value="<?php echo $action->clientAccNo($clientID);?>" disabled> 
								</div>
                            </div>
                            <div class="form-row">
                              <div class="form-group col-md-12">
                                <label for="reNewPass"><b>Account Name:</b></label>
                                <input class="form-control input-lg" value="<?php echo $action->clientBankName($clientID);?>" disabled> 
								</div>
                            </div>
                            
							<div class="form-row">
								<div class="form-group col-md-12">
									<font color='red'><b>NOTE:</b></font> Minimum withdrawal is N2,000. VAT of N100 is applicable on all withdrawal request<br>
								</div>
							</div>
							
                            <button type="submit" class="btn btn-accent" id="compltWithdraw" name="compltWithdraw" onclick="return confirm('Withdraw money')">
								<b>Withdraw Money</b>
							</button> <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
                          </form>
                        </div>
                      </div>
                    </li>
                  </ul>
                </div>
              </div>
			
				<div class="col-lg-7">
					<div class="card card-small mb-4">
					  <div class="card-header border-bottom">
						<h6 class="m-0">Withdrawal History</h6>
					  </div>
					  
						<div class="row" style="padding: 3%">
							<div class="col-md-12"> 
								<div class="table-responsive">
									<table class="table" id="example" style="margin-top: 10%">
										<thead>
											<tr>
												<td>#</td>
												<td>Date</td>
												<td>Amount</td>
												<td>Status</td>
											</tr>
										</thead>
											<tr>
											<?php
								$queryRun = $action->query("select * from transactions where clientID='$clientID' and type='withdraw' order by id desc limit 10");
								$queryRun->execute();
								for($i=1; $i<=$queryRun->rowCount(); $i++){ 
									$queryInfo = $queryRun->fetch(PDO::FETCH_ASSOC);
									$response = json_decode($queryInfo["response"], true);
									$amountNaira = $response["amountNaira"]? $response["amountNaira"]:0;
									$txDateCreated = $queryInfo["txDateCreated"];
									$status = $queryInfo["status"];
									$id = $queryInfo["id"]; 
							
									if($status == "Pending" && $trans_type=="withdraw") {
										$btnStatus = "<div class='btn btn-danger btn-sm'><b>Processing</b></div>";
									} else if($status == "Approved" && $trans_type=="withdraw") {
										$btnStatus = "<div class='btn btn-success btn-sm'><b>Payment Completed</b></div>";
									} else if($status == "Pending") {
										$btnStatus = "<div class='btn btn-info btn-sm'><b>In Progress</b></div>";
									} else if($status == "Approved") {
										$btnStatus = "<div class='btn btn-success btn-sm'><b>Approved</b></div>";
									}  else if($status == "Cancelled") {
										$btnStatus = "<div class='btn btn-danger btn-sm'><b>Cancelled</b></div>";
									} ?>
									<td><?php echo $i;?></td>
									<td><?php echo $txDateCreated;?></td>
									<td>&#8358;<?php echo number_format($amountNaira, 2);?></td>
									<td><?php echo $btnStatus;?></td>
									
							
									<script>
									$(document).ready(function(){
										$("#viewTrans<?php echo $id;?>").click(function(){
											$("#allTrans").hide();
											$.ajax({
												url: "../actionHandler?memberTransInfo",
												type: "post",
												data: "viewTrans="+<?php echo $id;?>+"",
												beforeSend: function(){
													$("#viewTrans").html("<center><i class='fa fa-refresh fa-5x fa-spin'></i></center>");
												},
												success: function(msg){
													setTimeout(function(){
														$("#viewTrans").html(msg);
													},2000);
												}
											});
											
										});
									});
									</script>
								</tr>
								<?php } ?>
									</table>
								</div>
								
							</div>
						</div>
					</div>
				
				</div>
			
          </div>
		  <?php require "foot.php";?>
        </main>
      </div>
    </div>
	
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js"></script>
    <script src="https://unpkg.com/shards-ui@latest/dist/js/shards.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sharrre/2.0.1/jquery.sharrre.min.js"></script>
    <script src="scripts/extras.1.1.0.min.js"></script>
    <script src="scripts/shards-dashboards.1.1.0.min.js"></script>
    <script src="scripts/app/app-blog-overview.1.1.0.js"></script>
  </body>
</html>