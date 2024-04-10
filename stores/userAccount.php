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
    <title>My Account - Toprate 247</title>
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
    </style>
	
    <link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css"/>
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>

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
					<a class="nav-link active" href="userAccount">
					  <i class="fa fa-user"></i>
					  <span>My Account</span>
					</a>
				  </li>
				  <li class="nav-item">
					<a class="nav-link " href="wallet">
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
			
				<div class="col-lg-6">
                <div class="card card-small mb-4">
                  <div class="card-header border-bottom">
                    <h6 class="m-0">Edit Profile</h6>
                  </div>
                  <ul class="list-group list-group-flush">
                    <li class="list-group-item p-3">
                      <div class="row">
                        <div class="col">
						
							<?php
							if(isset($_POST["updatePass"])) {
								
								$currPass = $_POST["currPass"];
								$newPass = $_POST["newPass"];
								$reNewPass = $_POST["reNewPass"];
								$clientID = $action->clientID($username);

								if(empty($currPass) || empty($newPass) || empty($reNewPass)) { ?>
										<div class="alert alert-danger" style="font-size: 18px; color: #fff; text-transform: uppercase; font-weight: bold">Please fill all field</div>
								<?php } else {
									$currPass = md5($currPass);
									$newPass = md5($newPass);
									$reNewPass = md5($reNewPass);
									if($currPass != $action->clienPass($clientID)) { ?>
										<div class="alert alert-danger" style="font-size: 18px; color: #fff; text-transform: uppercase; font-weight: bold">Incorrect current password</div>
									<?php } else if($newPass != $reNewPass) {?>
										<div class="alert alert-danger" style="font-size: 18px; color: #fff; text-transform: uppercase; font-weight: bold"><b>Password do no match</div>
									<?php } else if($newPass = $currPass) {?>
										<div class="alert alert-danger" style="font-size: 18px; color: #fff; text-transform: uppercase; font-weight: bold"><b>Your new password can't be same with current password</div>
									<?php } else {
										if($action->updateClientPass($newPass, $clientID)) { ?>
											<script>
												alert("Password modified successfully");
												window.location = "userAccount";
											</script>
										<?php 
											session_destroy($username);
										} else { ?>
											<div class="alert alert-danger" style="font-size: 18px; color: #fff; text-transform: uppercase; font-weight: bold"><b>Error updating password</div>
										<?php }
									}
								}
							}
							?>
							
							
                          <form method="post">
                            <div class="form-row">
                              <div class="form-group col-md-12">
                                <label for="feFirstName">Email Address</label>
                                <input type="text" class="form-control" value="<?php echo $action->clientEmail($clientID);?>" disabled>
							  </div>
                            </div>
                            <div class="form-row">
                              <div class="form-group col-md-6">
                                <label>Invite Code</label>
                                <input class="form-control" value="<?php echo $action->userCode($clientID);?>" disabled> </div>
                              <div class="form-group col-md-6">
                                <label>Level</label>
                                <input class="form-control" value="VIP <?php echo $action->vipLevel($clientID);?>" disabled> </div>
                            </div>
                            <div class="form-row">
                              <div class="form-group col-md-12">
                                <label for="currPass"><b>Current Password:</b></label>
                                <input class="form-control input-lg" type="password" placeholder="Enter current password" name="currPass" id="currPass" required> </div>
								
                            </div>
                            <div class="form-row">
                              <div class="form-group col-md-6">
                                <label for="newPass"><b>New Password:</b></label>
                                <input class="form-control input-lg" type="password" placeholder="Enter your desired password" name="newPass" id="newPass" required> 
								</div>
                              <div class="form-group col-md-6">
                                <label for="reNewPass"><b>Re-type New Password:</b></label>
                                <input class="form-control input-lg" type="password" name="reNewPass" placeholder="Re-enter your password" id="reNewPass" required> 
								</div>
								
                            </div>
                            
                            <button type="submit" class="btn btn-accent" id="updatePass" name="updatePass">
								<b>Update Account</b>
							</button> <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
                          </form>
                        </div>
                      </div>
                    </li>
                  </ul>
                </div>
              </div>
			
				<div class="col-lg-6">
                <div class="card card-small mb-4">
                  <div class="card-header border-bottom">
                    <h6 class="m-0">Banking Details</h6>
                  </div>
                  <ul class="list-group list-group-flush">
                    <li class="list-group-item p-3">
                      <div class="row">
                        <div class="col">
						
							<?php 
							if(isset($_POST["upatebankAccount"])) {
								$bank_name = strtoupper(implode(",", $_POST["bank_name"]));
								$accountName = strtoupper($_POST["accountName"]);
								$accountNumber = $_POST["accountNumber"];
								$accType = strtoupper($_POST["accType"]);
								$clientID = $action->clientID($username);

								if(empty($bank_name) || empty($accountName) || empty($accountNumber) || empty($accType)) { ?>
									<div class="alert alert-danger" style="font-size: 18px; color: #fff; text-transform: uppercase; font-weight: bold">please fill all field</div>
								<?php } else if(strlen($accountNumber) < 10 || strlen($accountNumber) > 10){ ?>
									<div class="alert alert-danger" style="font-size: 18px; color: #fff; text-transform: uppercase; font-weight: bold">Invalid account number provided</div>
								<?php } else if($action->clientAccNo($clientID) != $accountNumber && $action->isUsed_AccountNumber($accountNumber) == 1){ //Old Account is diff then check if it exists ?>
									<div class="alert alert-danger" style="font-size: 18px; color: #fff; text-transform: uppercase; font-weight: bold">Account number (<?php echo $accountNumber;?>) has already been used by another client</div>
								<?php } else {
									if($action->updateBankAccount($bank_name, $accountName, $accountNumber, $accType, $clientID)) { ?>
										<script>
											alert("Account modified successfully");
											window.location = "userAccount";
										</script>
									<?php } else { ?>
										<div class="alert alert-danger" style="font-size: 18px; color: #fff; text-transform: uppercase; font-weight: bold">Error modifying account</div>
									<?php }
								}
							}
							
							?>							
						
                          <form method="post">
                            <div class="form-row">
								<div class="form-group col-md-12">
									<label for="accountName">Account Name</label>
									<input type="text" class="form-control" placeholder="Enter your account name" name="accountName" id="accountName" value="<?php echo $action->clientAccName($clientID);?>" required> 
								</div>
                            </div>
                            <div class="form-row">
								<div class="form-group col-md-12">
									<label for="accountNumber">Account Number</label>
									<input type="text" maxlength="10" value="<?php echo $action->clientAccNo($clientID);?>" name="accountNumber" id="accountNumber"  placeholder="Enter your account number" class="form-control" required>
								</div>
                            </div>
                            <div class="form-row">
								<div class="form-group col-md-12">
									<label for="bank_name"><b>Select Bank:</b></label>
									<select name="bank_name[]" id="bank_name" class="form-control input-lg" required>
										<option value="">Select Your Bank</option>
										<option value="Access Bank"<?php echo ($action->clientBankName($clientID)== "ACCESS BANK") ? ' selected="selected"': '';?>>Access Bank</option>
										<option value="Citi Bank"<?php echo ($action->clientBankName($clientID)== "CITI BANK") ? ' selected="selected"': '';?>>Citi Bank</option>
										<option value="Diamond Bank"<?php echo ($action->clientBankName($clientID)== "DIAMOND BANK") ? ' selected="selected"': '';?>>Diamond Bank</option>
										<option value="Dinamic Standard Bank"<?php echo ($action->clientBankName($clientID)== "DINAMIC STANDARD BANK") ? ' selected="selected"': '';?>>Dinamic Standard Bank</option>
										<option value="Eco Bank"<?php echo ($action->clientBankName($clientID)== "ECO BANK") ? ' selected="selected"': '';?>>Eco Bank</option>
										<option value="FCMB"<?php echo ($action->clientBankName($clientID)== "FCMB") ? ' selected="selected"': '';?>>FCMB</option>
										<option value="Fidelity Bank"<?php echo ($action->clientBankName($clientID)== "FIDELITY BANK") ? ' selected="selected"': '';?>>Fidelity Bank</option>
										<option value="Fin Bank"<?php echo ($action->clientBankName($clientID)== "FIN BANK") ? ' selected="selected"': '';?>>Fin Bank</option>
										<option value="First Bank"<?php echo ($action->clientBankName($clientID)== "FIRST BANK") ? ' selected="selected"': '';?>>First Bank</option>
										<option value="GTB"<?php echo ($action->clientBankName($clientID)== "GTB") ? ' selected="selected"': '';?>>GTB</option>
										<option value="Keystone Bank"<?php echo ($action->clientBankName($clientID)== "KEYSTONE BANK") ? ' selected="selected"': '';?>>Keystone Bank</option>
										<option value="Heritage Bank"<?php echo ($action->clientBankName($clientID)== "HERITAGE BANK") ? ' selected="selected"': '';?>>Heritage Bank</option>
										<option value="Providus Bank"<?php echo ($action->clientBankName($clientID)== "PROVIDUS BANK") ? ' selected="selected"': '';?>>Providus Bank</option>
										<option value="Skye Bank"<?php echo ($action->clientBankName($clientID)== "SKYE BANK") ? ' selected="selected"': '';?>>Skye Bank</option>
										<option value="Stanbic IBTC Bank"<?php echo ($action->clientBankName($clientID)== "STANBIC IBTC BANK") ? ' selected="selected"': '';?>>Stanbic IBTC Bank</option>
										<option value="Standard Chartered Bank"<?php echo ($action->clientBankName($clientID)== "STANDARD CHARTERED BANK") ? ' selected="selected"': '';?>>Standard Chartered Bank</option>
										<option value="Staline Bank"<?php echo ($action->clientBankName($clientID)== "STALINE BANK") ? ' selected="selected"': '';?>>Staline Bank</option>
										<option value="Suntrust Bank"<?php echo ($action->clientBankName($clientID)== "SUNTRUST BANK") ? ' selected="selected"': '';?>>Suntrust Bank</option>
										<option value="UBA"<?php echo ($action->clientBankName($clientID)== "UBA") ? ' selected="selected"': '';?>>UBA</option>
										<option value="Union Bank"<?php echo ($action->clientBankName($clientID)== "UNION BANK") ? ' selected="selected"': '';?>>Union Bank</option>
										<option value="Unity Bank"<?php echo ($action->clientBankName($clientID)== "UNITY BANK") ? ' selected="selected"': '';?>>Unity Bank</option>
										<option value="Wema Bank"<?php echo ($action->clientBankName($clientID)== "WEMA BANK") ? ' selected="selected"': '';?>>Wema Bank</option>
										<option value="Zenith Bank"<?php echo ($action->clientBankName($clientID)== "ZENITH BANK") ? ' selected="selected"': '';?>>Zenith Bank</option>
									</select>
								</div>
                            </div>
                            <div class="form-row">
								<div class="form-group col-md-12">
									<label for="accType"><b>Account Type:</b></label>
									<select name="accType" id="accType" class="form-control input-lg" required>
										<option value="">Select account type</option>
										<option value="savings"<?php echo ($action->clientAccType($clientID)== "SAVINGS") ? ' selected="selected"': '';?>>Savings</option>
										<option value="fixed"<?php echo ($action->clientAccType($clientID)== "FIXED") ? ' selected="selected"': '';?>>Fixed</option>
										<option value="current"<?php echo ($action->clientAccType($clientID)== "CURRENT") ? ' selected="selected"': '';?>>Current</option>
									</select>
								</div>
                            </div>
							
							<?php if($action->blockAccNumb4update($clientID) == "YES") {
								// echo $action->error("Your account has been suspended for update. Check back later");
								echo $action->error("You can't update your banking details at the moment, kindly check back");
							} else if($action->bankAccount_row($clientID) == 0){ ?>
								<font color="red"><b>NOTE:</b></font> You can only edit your banking details after 15days of submission<br><br>
							<button class="btn btn-success btn-lg" id="savebankAccount" name="savebankAccount" type="submit"><b>Save Account</button>
							<?php 
							}  else if($action->blockAccNumb4update($clientID) == "NO"){ ?><font color="red"><b>NOTE:</b></font> You can only edit your banking details after 15days of submission<br><br>							
								<button type="submit" class="btn btn-accent"id="upatebankAccount" name="upatebankAccount">Modify Account</button>
							<?php } ?>
						  </form>
                        </div>
                      </div>
                    </li>
                  </ul>
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