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
    <title>Administrator - Toprate 247</title>
    <meta name="description" content="A high-quality &amp; free Bootstrap admin dashboard template pack that comes with lots of templates and components.">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link rel="stylesheet" href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" id="main-stylesheet" data-version="1.1.0" href="styles/shards-dashboards.1.1.0.min.css">
    <link rel="stylesheet" href="styles/extras.1.1.0.min.css">
    <link rel="stylesheet" href="styles/styles.css">
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
	<link rel="stylesheet" href="https://use.fontawesome.com/0acf54d04e.css">

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
                  <span class="d-none d-md-inline ml-1">Toprate 247 </span>
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
					<a class="nav-link" href="wallet">
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
						<a class="nav-link active" href="store">
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
            <?php #require "userhead.php";
			 if(isset($_GET["generalSettings"])) {
				if($action->userType($clientID) != 3) {
				?>
					<script>
						alert("Unauthorized Access");
						window.location ="store";
					</script>
				<?php
				die();
				}
				
				if(isset($_REQUEST["modifySettings"])) {
					$newMemberPoint = $_POST["newMemberPoint"];
					$btcWallet = $_POST["btcWallet"];
					$btcPrice = $_POST["btcPrice"];
					$itunesPrice = $_POST["itunesPrice"];
					$single200Value = $_POST["single200Value"];
					$austriaValue = $_POST["austriaValue"];
					$canadaValue = $_POST["canadaValue"];
					$steamPrice = $_POST["steamPrice"];
					$amazonPrice = $_POST["amazonPrice"];
					$ecodePrice = $_POST["ecodePrice"];
					$no_amountItunes = $_POST["no_amountItunes"];
					$amazon_no_rcp = $_POST["amazon_no_rcp"];
					$gplaystore = $_POST["gplaystore"];

					if(empty($newMemberPoint) || empty($btcWallet) || empty($btcPrice) || empty($itunesPrice) || empty($amazonPrice) || empty($ecodePrice) || empty($no_amountItunes) || empty($steamPrice) || empty($gplaystore)) {
						echo $action->error("please fill all field");
					} else {
						if($action->updateAdminSettings($newMemberPoint, $btcWallet, $btcPrice, $itunesPrice, $single200Value, $austriaValue, $canadaValue, $amazonPrice, $ecodePrice, $no_amountItunes, $amazon_no_rcp, $steamPrice, $gplaystore)) {
						?>
							<script>
								alert("Modification successful");
								window.location = "store";
							</script>
						<?php
						} else {
							echo $action->error("Error processing request");
						}
					}
				}
			?>
			
				<div align='center' style="margin-bottom: 2%; margin-top: 3%;">
					<h3 style="font-size: 2.5rem; font-weight: 900">General Settings</h3>
				</div>
				
				<form method="post" id="settingsInfo">
					
					
					<div class="row" style="margin-bottom: 10px; margin-top: 10px">
						<div class="col-lg-4">
							<label>Points for New Member</label>
						</div>
						<div class="col-lg-8">
							<input type="number" class="form-control" name="newMemberPoint" id="newMemberPoint" min="1" value="<?php echo $action->newMemberPoint();?>" required>
						</div>
					</div>
					
					<div class="row" style="margin-bottom: 10px; margin-top: 10px">
						<div class="col-lg-4">
							<label>BitCoin Wallet</label>
						</div>
						<div class="col-lg-8">
							<input type="text" class="form-control" name="btcWallet" id="btcWallet" value="<?php echo $action->btcWallet();?>" required>
						</div>
					</div>
					
					
					<div class="row" style="margin-bottom: 10px; margin-top: 10px">
						<div class="col-lg-4">
							<label>BitCoin Price</label>
						</div>
						<div class="col-lg-8">
							<textarea class="form-control" rows="8" name="btcPrice" id="btcPrice" required><?php echo $action->btcPrice();?></textarea>
						</div>
					</div>
					
					<div class="row" style="margin-bottom: 10px; margin-top: 10px">
						<div class="col-lg-4">
							<label>USA iTunes Price</label>
						</div>
						<div class="col-lg-8">
							<textarea class="form-control" rows="8" name="itunesPrice" id="itunesPrice" required><?php echo $action->itunesPrice();?></textarea>
						</div>
					</div>

					<div class="row" style="margin-bottom: 10px; margin-top: 10px">
						<div class="col-lg-4">
							<label>200 Single Card Price</label>
						</div>
						<div class="col-lg-8">
							<textarea class="form-control" rows="8" name="single200Value" id="single200Value" required><?php echo $action->singlecardPrice();?></textarea>
						</div>
					</div>

					<div class="row" style="margin-bottom: 10px; margin-top: 10px">
						<div class="col-lg-4">
							<label>Australia Card Price</label>
						</div>
						<div class="col-lg-8">
							<textarea class="form-control" rows="8" name="austriaValue" id="austriaValue" required><?php echo $action->australiaPrice();?></textarea>
						</div>
					</div>

					<div class="row" style="margin-bottom: 10px; margin-top: 10px">
						<div class="col-lg-4">
							<label>Canada Card Price</label>
						</div>
						<div class="col-lg-8">
							<textarea class="form-control" rows="8" name="canadaValue" id="canadaValue" required><?php echo $action->canadianPrice();?></textarea>
						</div>
					</div>

					<div class="row" style="margin-bottom: 10px; margin-top: 10px">
						<div class="col-lg-4">
							<label>iTunes Ecode Price</label>
						</div>
						<div class="col-lg-8">
							<textarea class="form-control" rows="8" name="ecodePrice" id="ecodePrice" required><?php echo $action->ecodePrice();?></textarea>
						</div>
					</div>

					<div class="row" style="margin-bottom: 10px; margin-top: 10px">
						<div class="col-lg-4">
							<label>No Amount iTunes Price</label>
						</div>
						<div class="col-lg-8">
							<textarea class="form-control" rows="8" name="no_amountItunes" id="no_amountItunes" required><?php echo $action->no_amountItunes();?></textarea>
						</div>
					</div>

					<div class="row" style="margin-bottom: 10px; margin-top: 10px">
						<div class="col-lg-4">
							<label>Steam Price</label>
						</div>
						<div class="col-lg-8">
							<textarea class="form-control" rows="8" name="steamPrice" id="steamPrice" required><?php echo $action->steamPrice();?></textarea>
						</div>
					</div>
					
					<div class="row" style="margin-bottom: 10px; margin-top: 10px">
						<div class="col-lg-4">
							<label>Amazon Price</label>
						</div>
						<div class="col-lg-8">
							<textarea class="form-control" rows="8" name="amazonPrice" id="amazonPrice" required><?php echo $action->amazonPrice();?></textarea>
						</div>
					</div>

					<div class="row" style="margin-bottom: 10px; margin-top: 10px">
						<div class="col-lg-4">
							<label>Amazon No Receipt Price</label>
						</div>
						<div class="col-lg-8">
							<textarea class="form-control" rows="8" name="amazon_no_rcp" id="amazon_no_rcp" required><?php echo $action->amazonNoReceiptPrice();?></textarea>
						</div>
					</div>

					<div class="row" style="margin-bottom: 10px; margin-top: 10px">
						<div class="col-lg-4">
							<label>Google Playstore Price</label>
						</div>
						<div class="col-lg-8">
							<textarea class="form-control" rows="8" name="gplaystore" id="gplaystore" required><?php echo $action->googlePlayPrice();?></textarea>
						</div>
					</div>
				
					<div class="col-md-12" align="center" style="margin-bottom: 10%; margin-top: 10px">
						<button class="btn btn-success" name="modifySettings" type="submit" id="modifySettings" onclick="return confirm('Proceed with modification')">Save Changes</button>
					</div>
				
				</form>
			<?php
			} else if(isset($_GET["ManageClient"])) { 
				if($action->userType($clientID) != 3) {
				?>
					<script>
						alert("Unauthorized Access");
						window.location ="store";
					</script>
				<?php
				die();
				}
				
				if(isset($_REQUEST["unblockID"])) {
					$uid = $_REQUEST["unblockID"];
					$updateMemb = $action->query("update client set blockTransaction='NO' where id='$uid'");
					if($updateMemb->execute()){
					?>
						<script>
							alert("Member updated");
							window.location = "store?ManageClient";
						</script>
					<?php
					} else{
						echo $action->error("Updating failed");
					}
				}
				if(isset($_REQUEST["editMemb"])) {
					$editMemb = $_REQUEST["editMemb"];
					
					//Update member...
					if(isset($_POST["updateMemb"])) {
						$clientID = $_POST["clientID"];
						$adminType = $_POST["adminType"];
						$blockMember = $_POST["blockMember"];
						$clientPt = $_POST["clientPt"];
						$updateMemb = $action->query("update client set type='$adminType', blockMember='$blockMember', point='$clientPt' where id='$editMemb'");
						if($updateMemb->execute()){
						?>
							<script>
								alert("Member updated");
								window.location = "store?ManageClient";
							</script>
						<?php
						} else{
							echo $action->error("Updating failed");
						}
					}
					?>
					<div align='center' style="margin-bottom: 2%; margin-top: 3%;">
						<h3 style="font-size: 2.5rem; font-weight: 900">Edit Member</h3>
					</div>
				<?php
				
				echo $action->LoadMember($editMemb);
				}  else {
					
				?>
				<div align='center' style="margin-bottom: 2%; margin-top: 3%;">
					<h3 style="font-size: 2.5rem; font-weight: 900">Our Member</h3>
					<small style="text-align: center; font-size: 18px">Total Member: 581</h2>
				</div>
				<?php
				if(isset($_REQUEST["loginID"])) {
					$uid = $_REQUEST["loginID"];
					$_SESSION["username"] = $action->clientEmail($uid);
					$action->redirect_to("dashboard");
				}
				
				if(isset($_REQUEST["gainAccess"])) {
					$uid = $_REQUEST["gainAccess"];
					?>
					<div style="margin-top: 2%; margin-bottom: 2%; ">
					Gain access to <b><?php echo $action->clientEmail($uid);?>'s </b> account <a href="?ManageClient&loginID=<?php echo $uid;?>" class="btn btn-success">Login</a>
					</div>
					<?php
				}
				?>
				<div class="row">
					<div class="col-md-12"> 
						<div class="table-responsive">
							<table class="table" id="example" style="margin-top: 10%">
								<thead>
									<tr>
										<td>#</td>
										<td>Email Address</td>
										<td>Balance</td>
										<td>Action</td>
									</tr>
								</thead>
								<?php
								$queryRun = $action->query("select * from client order by email asc"); $queryRun->execute(); 
								for($i=1; $i<=$queryRun->rowCount(); $i++){ 
									$queryInfo = $queryRun->fetch(PDO::FETCH_ASSOC);
									$point = $queryInfo["point"];
									$clientID = $queryInfo["id"];
									$email = $queryInfo["email"];
									$type = $queryInfo["type"];
									$blockTransaction = $queryInfo["blockTransaction"];
									$wallet = $action->clientBlc($clientID);
									if(empty($wallet)) {
										$wallet = number_format(0,2);
									}else {
										$wallet = number_format($wallet,2);
									}  ?>
									
									
								<tr>
									<td><?php echo $i;?></td>
									<td><?php echo $email;?></td>
									<td>&#8358;<?php echo $wallet;?> <br> <font color="brown"><b>Point: <?php echo $point*10;?></b></font> </td>
									<td>
										<a href="?ManageClient&gainAccess=<?php echo $clientID;?>" onclick="return confirm('Gain Access')" class="btn btn-danger btn-sm">Login</a>
										<a href="?ManageClient&editMemb=<?php echo $clientID;?>" class="btn btn-info btn-sm">View</a>
										<?php if($blockTransaction == "YES") { ?>
											<a href="?ManageClient&unblockID=<?php echo $clientID;?>" class="btn btn-warning btn-sm" onclick="return confirm('Allow member to perform transaction')">Unblock</a>
										<?php } ?>
									</td>
								</tr>
								
								<?php } ?>
							</table>
						</div>
					</div>
				</div>
				
			<?php 
				}
				
			} else if(isset($_GET["pendingTran"])) { ?>

				<div align='center' style="margin-bottom: 2%; margin-top: 3%;">
					<h3 style="font-size: 2.5rem; font-weight: 900">Pending Transaction</h3>
				</div>
				
				<?php
				if(isset($_GET["cancelTrans"])) {
					$clntID=$_GET["clntID"];
					$id=$_GET["id"];
					
					if(isset($_POST["addComment"])) {
						$refusalTerm = addslashes($_POST["reasonCancel"]);
						//Admin Uploads
						$ImgsName = $_FILES["imageUpload"]["name"];
						$ImgsTmp = $_FILES["imageUpload"]["tmp_name"];
						$allowed = array("jpg", "jpeg", "png", "gif", "bmp");
						foreach($ImgsName as $fileName){
							$rand = rand(111, 987);
							$pathinfo = pathinfo($fileName);
							$extension_file = strtolower($pathinfo["extension"]);
							if(!in_array($extension_file , $allowed)) {
								$invalid++;
								// echo $extension_file . "<br>";
							} else {
								$characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ';
								$charactersLength = strlen($characters); 
								$randomString = '';
								for ($i = 0; $i < 1; $i++) {
									$randomString .= strtoupper($characters[rand(0, $charactersLength - 1)]);
								}
								$string = strtolower(str_replace(array("I", "O"), "P", $randomString));
								if(is_numeric(substr(sha1(md5($rand)), 0,1))) {
									$value = $string . substr(sha1(md5($rand)), 1,7).".jpg";
									// echo substr(sha1(md5($rand)), 0,1). " || ". substr(sha1(md5($rand)), 0,7) . " || " . $i++ . " || " . $value . "<br>";
								} else {
									$value = substr(sha1(md5($rand)), 0,7).".jpg";
								}
								$combineFiles[] = $value;
								// echo strlen($value) . "<br>";
							}
						}
						
							foreach($combineFiles as $key=>$val) {
								$joinfile = "../images/market/".$val;
								if(move_uploaded_file($ImgsTmp[$key], $joinfile)){
									$moveFileCount++;
								}
							}
							if($moveFileCount == 0) {
								echo $action->error("You need to upload a proof for declining payment");
							}
							else if($moveFileCount > 0) {
								$response["adminImg"] = implode(",", $combineFiles);
								$jsonResponse = addslashes(json_encode($response));
								$response = $jsonResponse;
								$returnImg = $action->query("select * from transactions where id='$id'");
								$returnImg->execute();
								$returnImg_Info = $returnImg->fetch(PDO::FETCH_ASSOC);
								$return_Image = $returnImg_Info["images"];
								$saveRejected = $action->query("insert into refusedtrans (txID, refusalTerm, images, response) value ('$id', '$refusalTerm', '$return_Image', '$response')");
								if($saveRejected->execute()) {
									if($action->cancelTrans($clntID, $id)) {
									?>
									<script>
										alert("Transaction declined");
										window.location = "store?pendingTran";
									</script>
									<?php
									} else {
										echo $action->error("An error occurred");	
									}
								}
							} 
							else {
								echo $action->error("Error submitting feedback");
							}
					}
					?>
					<form method="post" enctype="multipart/form-data">
					<label for="reasonCancel">Reason for canceling</label><br>
					<textarea class="form-control" rows="5" name="reasonCancel" id="reasonCancel" required></textarea><br>
									
					<div class="msg_cell">
						<div class="col-md-5"><label for="imageUpload"><b>Upload Proof: </b></div> 
						<div class="col-md-7"><input type="file" name="imageUpload[]"  id="imageUpload" multiple required></div><br>
						
					</div>
					<br>
					<center><button name="addComment" class="btn btn-success" type="submit">Save Reason</button></center>
					</form>
					<?php
					
					
				} else if(isset($_GET["approveTrans"])) {
					$clntID=$_GET["clntID"];
					$id=$_GET["id"];
					
					if(isset($_GET["separate"])){
						$_SESSION["recredit"] = 0;
						if(isset($_POST["approveTrans"])){
							
							//Admin Uploads
							$ImgsName = $_FILES["imageUpload"]["name"];
							$ImgsTmp = $_FILES["imageUpload"]["tmp_name"];
							
							//Client card Uploads
							$clnt_ImgsName = $_POST["Imgs"];
							
							//Transaction type...
							$transType = $_POST["transType"];
							
							$amountNaira = $_POST["amountNaira"]; //Amount admin wants to approve..
							$refusalTerm = addslashes($_POST["refusalTerm"]);
							$clientID = $clntID;
							$totalCard = count($clnt_ImgsName); //No. of cards approved
							
							if(!empty($_SESSION['recredit']) && $_SESSION['recredit'] == $clientID * $id){
								$statement = 'An attempt to credit a member twice was blocked.';
								echo $action->error($statement). "<br>";
							}
							else {
								
								
								//How many card was uploaded by the user
								if($totalCard == $action->sumOfCard($id)) { //No refusal card....
									
									//Since there is no card refusal, we need  to ignore admin price and enter the real value to the client wallet...
									$totalAmount = $action->clientBlc($clientID) + $action->amountNaira_card($id);
									
									$_SESSION['recredit'] = $clientID * $id;
									
									//Update transactions as approved...
									$updateTrans = $action->query("update transactions set status='Approved' where clientID='$clientID' and id='$id'");
									$updateBlc = $action->query("update wallet set amount='$totalAmount' where clientID='$clientID'");
									if($updateTrans->execute()) {
										if($updateBlc->execute()) { //Update client balance...
											echo $action->success("Transaction approved, no card was rejected"). "<br>";
											?>
												<script>
													alert("Transaction approved, no card was rejected");
													window.location = "store";
												</script>
											<?php
											$_SESSION["approve"] = "yes";
											
											$referredMe = $clientID;
											$clientNormalpoint = $action->clientPoint($referredMe);
											$newpoint = $clientNormalpoint +1;
											$updtPt = $action->query("update client set point='$newpoint', blockTransaction='NO' where id='$clientID'");
											$updtPt->execute();
											
// set content type header for html email
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
// set additional headers
$headers .= 'From:  noreply@niratrade.com <noreply@niratrade.com>' . "\r\n".'X-Mailer: PHP/' . phpversion();
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
NiraTrade Mgt.
<br><br>
<hr>
<small><i>This is an auto-generated email, do not reply!</i></small>
</div></body></html>";
$clientEmail = $action->clientEmail($clientID);
mail($clientEmail, $subject, $body, $headers);

//Sms parameter
$mobile = $action->GSM($clientID);
$message = $action->clientAccName($clientID).", your Niratrade wallet has been credited with N".$amountNaira.". Wallet balance: N".$newAmnt. ". Thanks for trading with us.";
$senderid = "NIRATRADE";

$file = "http://connectsms.net/components/com_smsreseller/smsapi.php?";
$data = "username=".$sms_username ."&password=".$sms_password ."&sender=".$senderid."&recipient=".$mobile."&message=".$message;
$joinfiledata = $file.$data;
$ch = curl_init($file);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS,$data);
curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
$data = curl_exec($ch);
curl_close($ch);
										} else {
											echo $action->error("Unknown error occurred"). "<br>";
										}
									} else {
										echo $action->error("Unable to approve transactions"). "<br>";
									}
								} else {
									//We need the one that admin mark...
									$user_selectedImage = $clnt_ImgsName;
									$adminImg = explode(",", $_POST["img_arr"]);
									// print_r($adminImg);
									$return_Image = implode(',', (array_diff($adminImg, $user_selectedImage))); //Image to return back to member
									$amount_in_wallet = $action->clientBlc($clientID);
									$newAmnt = $amount_in_wallet+$amountNaira;
									// print_r($ImgsName);
									// die();
							// $response["userRemark"] = $userRemark;
							// $jsonResponse = addslashes(json_encode($response));
																							
										//Declare a variable to hold invalid file number count...
										$invalid = 0; 
										$i = 1;
										$allowed = array("jpg", "jpeg", "png", "gif", "bmp");
										foreach($ImgsName as $fileName){
											$rand = rand(111, 987);
											$pathinfo = pathinfo($fileName);
											$extension_file = strtolower($pathinfo["extension"]);
											if(!in_array($extension_file , $allowed)) {
												$invalid++;
												// echo $extension_file . "<br>";
											} else {
												$characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ';
												$charactersLength = strlen($characters); 
												$randomString = '';
												for ($i = 0; $i < 1; $i++) {
													$randomString .= strtoupper($characters[rand(0, $charactersLength - 1)]);
												}
												$string = strtolower(str_replace(array("I", "O"), "P", $randomString));
												if(is_numeric(substr(sha1(md5($rand)), 0,1))) {
													$value = $string . substr(sha1(md5($rand)), 1,7).".jpg";
													// echo substr(sha1(md5($rand)), 0,1). " || ". substr(sha1(md5($rand)), 0,7) . " || " . $i++ . " || " . $value . "<br>";
												} else {
													$value = substr(sha1(md5($rand)), 0,7).".jpg";
												}
												$combineFiles[] = $value;
												// echo strlen($value) . "<br>";
											}
										}
										
										foreach($combineFiles as $key=>$val) {
											$joinfile = "../images/market/".$val;
											if(move_uploaded_file($ImgsTmp[$key], $joinfile)){
												$moveFileCount++;
											}
										}
										if($moveFileCount == 0) {
											echo $action->error("You need to upload a proof for declining payment");
										}
										else if($moveFileCount > 0) {
											$response["adminImg"] = implode(",", $combineFiles);
											$jsonResponse = addslashes(json_encode($response));
											$response = $jsonResponse;
											
											$responseAppr["txid"] = substr(md5(rand(111, 987)), 0, 10);
											$responseAppr["cardNo"] = count($user_selectedImage);
											$responseAppr["amountNaira"] = $amountNaira;
											$json_Response = addslashes(json_encode($responseAppr));
												
												//save the rejected transaction
											$saveRejected = $action->query("insert into refusedtrans (txID, refusalTerm, images, response) value ('$id', '$refusalTerm', '$return_Image', '$response')");
											if($saveRejected->execute()) {
												// since we have save the failed cards, we need to cancel the transaction and re insert
												$saveRejectedTrans = $action->query("update transactions set status='Cancelled' where id='$id' and clientID='$clientID'");
												if($saveRejectedTrans->execute()) {
													$memberType = "vip".$action->vipLevel($clientID);
													$images = implode(",",$user_selectedImage);
													//We need to re-insert the accepted one manually..
													$saveAccepcted = $action->query("insert into transactions (clientID, memberType, images, amount,  type,  status, response) value ('$clientID', '$memberType', '$images', '$amountNaira',  '$transType',  'Approved', '$json_Response')");
													if($saveAccepcted->execute()){ //We need to update balance...
														$updateWallet = $action->query("update wallet set amount='$newAmnt' where clientID='$clientID'");
														if($updateWallet->execute()) {
															$newpoint = $action->clientPoint($clientID) + 1;
															$updtPt = $action->query("update client set point='$newpoint', blockTransaction='NO' where id='$clientID'");
															$updtPt->execute();
															
																			
// set content type header for html email
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
// set additional headers
$headers .= 'From:  noreply@niratrade.com <noreply@niratrade.com>' . "\r\n".'X-Mailer: PHP/' . phpversion();
$subject = "Transaction Approved";
$body= "<html>
<head>
<title>Transaction Approved</title>
</head>
<body>

<div style='margin-top: 10px; font-family: Helvetica,Verdana,Arial,sans-serif; font-size: 17px; line-height: 21px; padding-left: 19px; padding-right: 30px; color: rebeccapurple;'>
Hi <b>".$clientEmail ."</b> <br>
Partial transaction was approved on your account. You recently make a transaction of ".$action->sumOfCard($id) ." card(s) in which ".$totalCard." card(s) were accepted in your favour and a sum of <b>NGN".number_format($amountNaira,2)." has been added to your account.<br>
Amount: N". $amountNaira ."<br>
New Balance: N".$newAmnt."<br>
Regards<br>
NiraTrade Mgt.
<br><br>
<hr>
<small><i>This is an auto-generated email, do not reply!</i></small>
</div></body></html>";
$clientEmail = $action->clientEmail($clientID);

mail($clientEmail, $subject, $body, $headers);

	
//Sms parameter
$mobile = $action->GSM($clientID);
$message = $action->clientAccName($clientID).", your Niratrade wallet has been credited with N".number_format($amountNaira).". Wallet balance: N".number_format($newAmnt). ". Thanks for trading with us.";
$senderid = "NIRATRADE";

$file = "http://connectsms.net/components/com_smsreseller/smsapi.php?";
$data = "username=".$sms_username ."&password=".$sms_password ."&sender=".$senderid."&recipient=".$mobile."&message=".$message;
$joinfiledata = $file.$data;
$ch = curl_init($file);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS,$data);
curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
$data = curl_exec($ch);
curl_close($ch);



?>
<script>
alert("Transaction approved");
// alert("<?php echo $message;?>");
window.location = "store";
</script>
<?php
														}
													}
												}
											}
											
											
											
										}  else {
												echo $action->error("Error submitting feedback");
											}
										
									
										
						
									
									
								
								}
								// echo $action->error(122) . "<br>";
							}
							
						}
						echo "<br><br><br><br><br>";
						echo $action->separateApproval($id, $clntID);
					}
					else {
						$queryRun = $action->query("select * from transactions where id='$id'");
						$queryRun->execute();
																
						$queryInfo = $queryRun->fetch(PDO::FETCH_ASSOC);
						$images = $queryInfo["images"];
						$clientID = $queryInfo["clientID"];
						$type = $queryInfo["type"];
						$response = json_decode($queryInfo["response"], true);
						$txid = $response["txid"];
						$amountDollar = $response["amountDollar"];
						$amountNaira = $response["amountNaira"];
						$amount_in_wallet = $action->clientBlc($clientID);
						$newAmnt = $amount_in_wallet+$amountNaira;
						if($action->approveTrans($amountNaira, $id, $clntID)) {
							
			
//Sms parameter
$mobile = $action->GSM($clientID);
$message = $action->clientAccName($clientID).", your Niratrade wallet has been credited with N".number_format($amountNaira).". Wallet balance: N".number_format($newAmnt). ". Thanks for trading with us.";
$senderid = "NIRATRADE";

$file = "http://connectsms.net/components/com_smsreseller/smsapi.php?";
$data = "username=".$sms_username ."&password=".$sms_password ."&sender=".$senderid."&recipient=".$mobile."&message=".$message;
$joinfiledata = $file.$data;
$ch = curl_init($file);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS,$data);
curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
$data = curl_exec($ch);
curl_close($ch);
		?>
							<script>
							alert("Transaction approved");
							window.location = "store";
							</script>
						<?php
						} else {
							echo $action->error("An error occurred");
						}
					}
					
				} else {

					$queryRun = $action->query("select * from transactions where type!='bitcoin' and type!='withdraw' and status='Pending' order by memberType desc");
					$queryRun->execute();
					?>
					<div class="row" id="pendingTrans">
						<div class="table-responsive">
							<table class="table" id="example" style="margin-top: 10%">
								<thead>
									<tr>
										<td>#</td>
										<td>Type</td>
										<td>Amount</td>
										<td>Status</td>
									</tr>
								</thead>
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
								<tr>
									<td><?php echo $i;?></td>
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
								<?php } ?>
							</table>
						</div>
					</div>
					
					<div id="pendingResponse" style="margin-bottom: 10%"></div>
				<?php } ?>
				
				
				
			<?php }  else if(isset($_GET["btcTrans"])) { ?>

				<div align='center' style="margin-bottom: 2%; margin-top: 3%;">
					<h3 style="font-size: 2.5rem; font-weight: 900">BitCoin Transaction</h3>
				</div>
				
				<div class="row">
				<?php
				
				if(isset($_GET["cancelTrans"])) {
					$clntID=$_GET["clntID"];
					$id=$_GET["id"];
					
					if(isset($_POST["addComment"])) {
						$refusalTerm = $_POST["reasonCancel"];
						//Admin Uploads
						$ImgsName = $_FILES["imageUpload"]["name"];
						$ImgsTmp = $_FILES["imageUpload"]["tmp_name"];
						$allowed = array("jpg", "jpeg", "png", "gif", "bmp");
						foreach($ImgsName as $fileName){
							$rand = rand(111, 987);
							$pathinfo = pathinfo($fileName);
							$extension_file = strtolower($pathinfo["extension"]);
							if(!in_array($extension_file , $allowed)) {
								$invalid++;
								// echo $extension_file . "<br>";
							} else {
								$characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ';
								$charactersLength = strlen($characters); 
								$randomString = '';
								for ($i = 0; $i < 1; $i++) {
									$randomString .= strtoupper($characters[rand(0, $charactersLength - 1)]);
								}
								$string = strtolower(str_replace(array("I", "O"), "P", $randomString));
								if(is_numeric(substr(sha1(md5($rand)), 0,1))) {
									$value = $string . substr(sha1(md5($rand)), 1,7).".jpg";
									// echo substr(sha1(md5($rand)), 0,1). " || ". substr(sha1(md5($rand)), 0,7) . " || " . $i++ . " || " . $value . "<br>";
								} else {
									$value = substr(sha1(md5($rand)), 0,7).".jpg";
								}
								$combineFiles[] = $value;
								// echo strlen($value) . "<br>";
							}
						}
						
							foreach($combineFiles as $key=>$val) {
								$joinfile = "../images/market/".$val;
								if(move_uploaded_file($ImgsTmp[$key], $joinfile)){
									$moveFileCount++;
								}
							}
							if($moveFileCount == 0) {
								echo $action->error("You need to upload a proof for declining payment");
							}
							else if($moveFileCount > 0) {
								$response["adminImg"] = implode(",", $combineFiles);
								$jsonResponse = addslashes(json_encode($response));
								$response = $jsonResponse;
								$returnImg = $action->query("select * from transactions where id='$id'");
								$returnImg->execute();
								$returnImg_Info = $returnImg->fetch(PDO::FETCH_ASSOC);
								$return_Image = $returnImg_Info["images"];
								$saveRejected = $action->query("insert into refusedtrans (txID, refusalTerm, images, response) value ('$id', '$refusalTerm', '$return_Image', '$response')");
								if($saveRejected->execute()) {
									if($action->cancelTrans($clntID, $id)) {
									?>
									<script>
										alert("Transaction declined");
										window.location = "store?btcTrans";
									</script>
									<?php
									} else {
										echo $action->error("An error occurred");	
									}
								}
							} 
							else {
								echo $action->error("Error submitting feedback");
							}
					}
					?>
					<form method="post" enctype="multipart/form-data">
					<label for="reasonCancel">Reason for canceling</label><br>
					<textarea class="form-control" rows="5" name="reasonCancel" id="reasonCancel" required></textarea><br>
									
					<div class="msg_cell">
						<div class="col-md-5"><label for="imageUpload"><b>Upload Proof: </b></div> 
						<div class="col-md-7"><input type="file" name="imageUpload[]"  id="imageUpload" multiple required></div><br>
						
					</div>
					<br>
					<center><button name="addComment" class="btn btn-success" type="submit">Save Reason</button></center>
					</form>
					<?php
					
					
				} else { ?>
				
					<div class="table-responsive" id="pendingTrans">
						<table class="table" id="example" style="margin-top: 3%">
							<thead>
								<tr>
									<td>#</td>
									<td>Type</td>
									<td>Amount</td>
									<td>Status</td>
								</tr>
							</thead>
							
							
				<?php
					$queryRun = $action->query("select * from transactions where type='bitcoin' and type!='withdraw' and status='Pending' order by memberType desc");
					$queryRun->execute();
					
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
						<tr>
							<td><?php echo $i;?></td>
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
					<?Php } ?>
						</table>
					</div>
					<?Php } ?>
				</div>
				
				<div id="pendingResponse"></div>
				
			<?php } else if(isset($_REQUEST["withdrawRequest"])) { ?>

				<div align='center' style="margin-bottom: 2%; margin-top: 3%;">
					<h3 style="font-size: 2.5rem; font-weight: 900">Withdrawal Request</h3>
				</div>
				<div class="row" id="viewPayment">
				<br>
			<?php 
			
			if(isset($_POST["approveTransBtn"])) {
				$confirmWithdraw = $_POST["confirmWithdraw"];
				$confirmPay = $action->query("update transactions set status='Approved' where id='$confirmWithdraw'");
				if($confirmPay->execute()){
				?>
					<script>
					alert("Payment approved");
					window.location = "store";
					</script>
				<?php
				}else {
				?>
					<script>
					alert("Error occurred");
					window.location = "store";
					</script>
				<?php
				}
			}
			echo $action->withdrawRequest();  ?>
			</div>
			<div id="loadPayment"></div>
			
			<?php } else if(isset($_GET["transHistory"])) { ?>
				<div align='center' style="margin-bottom: 2%; margin-top: 3%;">
					<h3 style="font-size: 2.5rem; font-weight: 900">Transaction History</h3>
				</div>
				<br>
				<div class="col-md-12">
					<div class="bs-component">
					  <ul class="nav nav-tabs">
						<li class="active"><a href="#addGroup" data-toggle="tab"><i class='fa fa-plus'></i> Transactions</a></li>
						<li><a href="#allGroup" data-toggle="tab"><i class="fa fa-server"></i> Withdrawal </a></li>
					  </ul>
					  <div class="tab-content" id="myTabContent">
						<div class="tab-pane fade active in" id="addGroup">
							<div class="col-md-12"><br>
							<?php 
							$href = "store?transHistory";
							echo $action->alltransaction_Request($start_page, $per_page, $page, $href);?>
						</div>
						</div>
						<div class="tab-pane fade" id="allGroup">
							
							<?php 
							$href = "store?transHistory";
							echo $action->allPaid_withdrawRequest($start_page, $per_page, $page, $href);?>
							
						</div>
					  </div>
					  <div style='margin-top: 5%'></div>
					</div>

				</div>
			<?php } else if(isset($_REQUEST["notifyMember"])) { ?>
				
				<div align='center' style="margin-bottom: 2%; margin-top: 3%;">
					<h3 style="font-size: 2.5rem; font-weight: 900">Notify Member</h3>
				</div>
				
				<?php 
				
				if(isset($_REQUEST["saveNotify"])) {
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
							echo $action->error("Please fill all field");
						} else {
							if($action->saveNotify($clientID, $notifyMsg)) { ?>
								<script>
									alert("Notification saved");
									window.location = "store";
								</script>
							<?php } else {
								echo $action->error("error saving notification");
							}
						}
					}
				}
				
				echo $action->loadMember_Select();?>
				<br>
			<?php } else if(isset($_REQUEST["editWallet"])) { ?>
				<div align='center' style="margin-bottom: 2%; margin-top: 3%;">
					<h3 style="font-size: 2.5rem; font-weight: 900">Edit Wallet</h3>
				</div>
				
				<?php
				if(isset($_POST["crdtWallet"])) {
					$uid = $_POST["clientID"];
					$walletBal = $_POST["walletBal"];
					$udptBal = $action->query("update wallet set amount='$walletBal' where clientID='$uid'");
					if($udptBal->execute()) { ?>
						<script>
							alert("Member balance updated");
							window.location = "store";
						</script>
					<?php } else {
						echo $action->error("Error adding fund");
					}
				}
				?>
				<br>
					<form method="post">
						<div class="row">
							<label>Choose Member</label>
							<select class="form-control" name="clientID" id="clientID">
								<option value="">Please select Member</option>
								<?php
								$queryRun = $action->query("select * from client order by email ASC");
								$queryRun->execute();
								for ($i=1; $i<=$queryRun->rowCount(); $i++) {
									$queryInfo = $queryRun->fetch(PDO::FETCH_ASSOC);
									$email = $queryInfo["email"];
									$clientID = $queryInfo["id"];
								 ?>
									<option value="<?php echo $clientID;?>"><?php echo $email . " - NGN".number_format($action->clientBlc($clientID), 2);?></option>
								<?php
								}
								?>
							</select>
						</div>
						<div class="row">
							<label>Amount</label>
							<input class="form-control" type="number" min="1" value="100" name="walletBal" id="walletBal">
						</div>
						<font size="5px" color="red">NOTE: </font> Any amount written will be credited to the user wallet.
						<div align="center" style="margin-bottom: 10%">
							<button class="btn btn-success btn-lg" name="crdtWallet" type="submit"><b>Credit Member</b></button>
						</div>
					</form>
			<?php } else { ?>
			
			<div align='center' style="margin-bottom: 2%; margin-top: 3%;">
				<h3 style="font-size: 2.5rem; font-weight: 900">Administrator Menu</h3>
			</div>
			<br>
			<?php
			$checkChat = $action->query("select * from chat where status='new' and medium='open' order by chatid desc");
			$checkChat->execute();
			if($checkChat->rowCount() > 0) {
				echo $action->success("<i class='fa fa-bullhorn'></i> Hello, You have a chat request. <a href='checkChat'>View Chat</a>");
			}
			?>
            <div class="row" style="margin-top: 5%">
				<div class="col-lg col-md-6 col-sm-6 mb-4">
					<a href="?generalSettings" title="Website Settings" style="text-decoration: none">
						<div class="stats-small stats-small--1 card card-small">
							<div class="card-body p-0 d-flex">
								<div class="d-flex flex-column m-auto">
									<div class="stats-small__data text-center">
										<span class="stats-small__label text-uppercase">
											<i class="fa fa-cog fa-4x"></i>
										</span>
										<h6 class="stats-small__value count my-3">General Settings</h6>
									</div>
								</div>
							</div>
						</div>
					</a>
				</div>
			
				<div class="col-lg col-md-6 col-sm-6 mb-4">
					<a href="?ManageClient" title="Our client" style="text-decoration: none">
						<div class="stats-small stats-small--1 card card-small">
							<div class="card-body p-0 d-flex">
								<div class="d-flex flex-column m-auto">
									<div class="stats-small__data text-center">
										<span class="stats-small__label text-uppercase">
											<i class="fa fa-users fa-4x"></i>
										</span>
										<h6 class="stats-small__value count my-3" style="">Our Client (<?php echo number_format($action->sumClient());?>)</h6>
									</div>
								</div>
							</div>
						</div>
					</a>
				</div>
			
				<div class="col-lg col-md-6 col-sm-6 mb-4">
					<a href="?pendingTran" title="Pending Transaction" style="text-decoration: none">
						<div class="stats-small stats-small--1 card card-small">
							<div class="card-body p-0 d-flex">
								<div class="d-flex flex-column m-auto">
									<div class="stats-small__data text-center">
										<span class="stats-small__label text-uppercase">
											<i class="fa fa-history fa-4x"></i>
										</span>
										<h6 class="stats-small__value count my-3"> Pending Transaction (<?php echo number_format($action->sumOfTrans_Submitted());?>)</h6>
									</div>
								</div>
							</div>
						</div>
					</a>
				</div>
			
				<div class="col-lg col-md-6 col-sm-6 mb-4">
					<a href="?btcTrans" title="BitCoin Transaction" style="text-decoration: none">
						<div class="stats-small stats-small--1 card card-small">
							<div class="card-body p-0 d-flex">
								<div class="d-flex flex-column m-auto">
									<div class="stats-small__data text-center">
										<span class="stats-small__label text-uppercase">
											<i class="fa fa-bitcoin fa-4x"></i>
										</span>
										<h6 class="stats-small__value count my-3">Bitcoin Transaction (<?php echo number_format($action->sumOfBtc_Submitted());?>)</h6>
									</div>
								</div>
							</div>
						</div>
					</a>
				</div>
				
			</div>
			
            <div class="row" style="margin-bottom: 5%">
				<div class="col-lg col-md-6 col-sm-6 mb-4">
					<a href="?withdrawRequest" title="Withdrawal Request" style="text-decoration: none">
						<div class="stats-small stats-small--1 card card-small">
							<div class="card-body p-0 d-flex">
								<div class="d-flex flex-column m-auto">
									<div class="stats-small__data text-center">
										<span class="stats-small__label text-uppercase">
											<i class="fa fa-cog fa-4x"></i>
										</span>
										<h6 class="stats-small__value count my-3">Withdrawal Request (<?php echo number_format($action->sumWithdrawalRequest());?>)</h6>
									</div>
								</div>
							</div>
						</div>
					</a>
				</div>
			
				<div class="col-lg col-md-6 col-sm-6 mb-4">
					<a href="?transHistory" title="Transaction History" style="text-decoration: none">
						<div class="stats-small stats-small--1 card card-small">
							<div class="card-body p-0 d-flex">
								<div class="d-flex flex-column m-auto">
									<div class="stats-small__data text-center">
										<span class="stats-small__label text-uppercase">
											<i class="fa fa-history fa-4x"></i>
										</span>
										<h6 class="stats-small__value count my-3" style="">Transaction History (<small><?php echo number_format($action->allTrans_count());?></small>)</h6>
									</div>
								</div>
							</div>
						</div>
					</a>
				</div>
			
				<div class="col-lg col-md-6 col-sm-6 mb-4">
					<a href="?notifyMember" title="Notify Member" style="text-decoration: none">
						<div class="stats-small stats-small--1 card card-small">
							<div class="card-body p-0 d-flex">
								<div class="d-flex flex-column m-auto">
									<div class="stats-small__data text-center">
										<span class="stats-small__label text-uppercase">
											<i class="fa fa-bullhorn fa-4x"></i>
										</span>
										<h6 class="stats-small__value count my-3"> Notify Member</h6>
									</div>
								</div>
							</div>
						</div>
					</a>
				</div>
			
				<div class="col-lg col-md-6 col-sm-6 mb-4">
					<a href="?editWallet" title="Edit Client Wallet" style="text-decoration: none">
						<div class="stats-small stats-small--1 card card-small">
							<div class="card-body p-0 d-flex">
								<div class="d-flex flex-column m-auto">
									<div class="stats-small__data text-center">
										<span class="stats-small__label text-uppercase">
											<i class="fa fa-pencil fa-4x"></i>
										</span>
										<h6 class="stats-small__value count my-3">Edit Wallet</h6>
									</div>
								</div>
							</div>
						</div>
					</a>
				</div>
				
			</div>
			
		  <?php 
			}
		  require "foot.php";?>
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