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
    <title>Dashboard - Toprate 247</title>
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
            <nav class="navbar align-items-stretch navbar-light flex-md-nowrap border-bottom p-0">
              <a class="navbar-brand w-100 mr-0" href="dashboard" style="line-height: 25px;">
                <div class="d-table m-auto">
                  <img id="main-logo" class="d-inline-block align-top mr-1" style="max-width: 25px;" src="images/shards-dashboards-logo.svg" alt="Shards Dashboard">
                  <span class="d-none d-md-inline ml-1">Toprate </span>
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
					<a class="nav-link active" href="dashboard">
					  <i class="material-icons">home</i>
					  <span>Dashboard</span>
					</a>
				  </li>
				  <li class="nav-item">
					<a class="nav-link " href="userAccount">
					  <i class="fa fa-user"></i>
					  <span>My Account</span>
					</a>
				  </li>
				  <li class="nav-item">
					<a class="nav-link " href="wallet">
					  <i class="fa fa-money"></i>
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
		  
            <!-- Small Stats Blocks -->
			<?php require "userhead.php";?>
			
            <div class="row">
              <div class="col-lg col-md-6 col-sm-6 mb-4">
                <div class="stats-small stats-small--1 card card-small">
                  <div class="card-body p-0 d-flex">
                    <div class="d-flex flex-column m-auto">
                      <div class="stats-small__data text-center">
                        <span class="stats-small__label text-uppercase">Total Transactions</span>
                        <h6 class="stats-small__value count my-3"><?php echo $action->count_trans_Memb($clientID, "all");?></h6>
                      </div>
                      <div class="stats-small__data">
                        <span class="stats-small__percentage stats-small__percentage--increase">12.4%</span>
                      </div>
                    </div>
                    <canvas height="120" class="blog-overview-stats-small-2"></canvas>
                  </div>
                </div>
              </div>
              <div class="col-lg col-md-4 col-sm-6 mb-4">
                <div class="stats-small stats-small--1 card card-small">
                  <div class="card-body p-0 d-flex">
                    <div class="d-flex flex-column m-auto">
                      <div class="stats-small__data text-center">
                        <span class="stats-small__label text-uppercase">Successful Transactions</span>
                        <h6 class="stats-small__value count my-3"><?php echo $action->count_trans_Memb($clientID, "Approved");?></h6>
                      </div>
                      <div class="stats-small__data"> 
						<!--If successful transaction is more than failed in percentage, we start progress bar--> 
                        <span class="stats-small__percentage stats-small__percentage--decrease"><?php echo round($action->count_trans_Memb($clientID, "Approved")/($action->count_trans_Memb($clientID, "all"))*100, 2);?>%</span>
                      </div>
                    </div>
                    <canvas height="120" class="blog-overview-stats-small-3"></canvas>
                  </div>
                </div>
              </div>
              <div class="col-lg col-md-4 col-sm-6 mb-4">
                <div class="stats-small stats-small--1 card card-small">
                  <div class="card-body p-0 d-flex">
                    <div class="d-flex flex-column m-auto">
                      <div class="stats-small__data text-center">
                        <span class="stats-small__label text-uppercase">Amount Paid</span>
                        <h6 class="stats-small__value count my-3">&#8358;<?php echo number_format($action->apprvTransAmnt($clientID), 2);?></h6>
                      </div>
                      <div class="stats-small__data" align="center">
						View Transactions
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg col-md-4 col-sm-12 mb-4">
                <div class="stats-small stats-small--1 card card-small">
                  <div class="card-body p-0 d-flex">
                    <div class="d-flex flex-column m-auto">
                      <div class="stats-small__data text-center">
                        <span class="stats-small__label text-uppercase">Amount Withdraw</span>
                        <h6 class="stats-small__value count my-3">&#8358;<?php echo number_format($action->apprvWithdraw($clientID), 2);?></h6>
                      </div>
                      <div class="stats-small__data">
                        <span class="stats-small__percentage stats-small__percentage--decrease"></span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
			
			<div class="row" style="margin-bottom: 2%">
				<div class="col-md-12">
					<div class='alert alert-info' align='center'><font size='5px'><b>We deal ruthlessly with FRAUDSTERS</b></font></div>
				</div>
			</div>
			<?php 
			
			if(isset($_REQUEST["chatAdmin"])) { ?>
				<div style="margin-bottom: 10%">
				<?php
				$transID = $_REQUEST["transID"];
				if(isset($_POST["btnAddComment"])) {
					$chatMsg = addslashes($_POST["AddComment"]);
					if(empty($chatMsg) || strlen($chatMsg) < 5) {
						echo $action->error("Chat message is empty or too short");
					} else {
						if ($_SESSION["chatAdded"] == $chatMsg . $transID . $clientID) {
							echo $action->error("Error recreating chat");
						} else {
							if ($action->saveChatReply($chatMsg, $transID, $clientID)) {
								$_SESSION["chatAdded"] = $chatMsg . $transID . $clientID;
								echo $action->success("chat message received, a chat representative will attend to you shortly");
							} else {
								echo $action->error("Error creating chat");
							}
						}
					}
				}
				
				if(isset($_POST["sendChat"])) {
					$chatMsg = addslashes($_POST["chatMsg"]);
					if(empty($chatMsg) || strlen($chatMsg) < 5) {
						echo $action->error("Chat message is empty or too short");
					} else {
						if ($_SESSION["chatAdded"] == $chatMsg . $transID . $clientID) {
							echo $action->error("Error recreating chat");
						} else {
							if ($action->saveChat($chatMsg, $transID, $clientID)) {
								$_SESSION["chatAdded"] = $chatMsg . $transID . $clientID;
								echo $action->success("chat message received, a chat representative will attend to you shortly");
							} else {
								echo $action->error("Error creating chat");
							}
						}
					}
				}
				
				if(empty($transID)) {
					$action->redirect_to("dashboard");
				} else {
					
					$LoadTrans = $action->loadTrans($transID, $clientID);
					$response = json_decode($LoadTrans["response"], true);
					$transType = $LoadTrans["status"];

					$gather = $action->query("select * from transactions where id='$transID' and clientID='$clientID'");
					$gather->execute();

					if($gather->rowCount() == 0) { ?>
						<script>
							alert("Unauthorized Access");
							window.location = "dashboard";
						</script>
					<?php }

					//Is transaction ID opened for a chat already
					$chkTrnsID = $action->query("SELECT * FROM `chat` where transID='$transID' and clientID='$clientID'");
					$chkTrnsID->execute();
					?>
					<div style="font-weight: bolder; border: 1px solid #333; background: #FFCC99; color: #000; padding: 10px; font-size: 18px; margin: 1em auto;">
						&#8358;<?php echo number_format($response["amountNaira"]) . " - " . strtoupper($LoadTrans["type"]); ?>
					</div>
					
					<?php if ($chkTrnsID->rowCount() == 0) { ?>
						<form method="post">
						<textarea class="form-control input-lg" rows="5"
								  placeholder="Drop your chat message here" name="chatMsg" required></textarea> <br/>
							<button class="btn btn-success" type="submit" name="sendChat">
								<b><i class="fa fa-mail-forward"></i> Send Chat</b>
							</button>
						</form>
					<?php }

					$chkTrnsIDInfo = $chkTrnsID->fetch(PDO::FETCH_ASSOC);
					$loadReply = $action->query("SELECT * FROM `chatreply` where transID='$transID' order by id desc");
					$loadReply->execute();
					while ($loadReplyInfo = $loadReply->fetch(PDO::FETCH_ASSOC)) { ?>
						<div class="msg_cell">
							<?php
							if(empty($loadReplyInfo["adminName"])) {
								echo $action->clientAccName($clientID);
							} else {
								echo $loadReplyInfo["adminName"] . " (<font color='red'>Admin</font>)";
							}?> &raquo; <?php echo $loadReplyInfo["content"];?>
							<br/>
							Date Created: <b><?php echo $loadReplyInfo["dateCreated"];?></b>
						</div>
					<?php
					}
					
					
					if($chkTrnsID->rowCount() > 0) { ?>
						<div class="msg_cell">
							<?php echo $action->clientAccName($clientID);?> &raquo; <?php echo $chkTrnsIDInfo["content"];?>
							<br/>
							Date Created: <b><?php echo $chkTrnsIDInfo["dateCreated"];?></b>
						</div>
					<?php if($transType == "Pending") { ?>
					<form method="post">
						<textarea class="form-control input-lg" placeholder="Write A Comment" name="AddComment" required></textarea> <br>
						<button class="btn btn-success" name="btnAddComment" type="submit">
							<b><i class="fa fa-plus"></i> Add Comment</b>
						</button>
					</form>

					<?php } else {
						echo $action->error("Chat ended");
						}
					}
				} ?>
				</div>
			<?php } else { ?>
            <!-- End Small Stats Blocks -->
            <div class="row" id="allTrans" style="margin-bottom: 10%">
				<div class="col-md-12"> 
					<div class="table-responsive">
						<table class="table" id="example" style="margin-top: 10%">
							<thead>
								<tr>
									<td>#</td>
									<td>Date</td>
									<td>Type</td>
									<td>Amount</td>
									<td>Status</td>
								</tr>
							</thead>
								<tr>
								<?php
								$queryRun = $action->query("select * from transactions where clientID='$clientID' order by id desc");
								$queryRun->execute();
								for($i=1; $i<=$queryRun->rowCount(); $i++){ 
									$queryInfo = $queryRun->fetch(PDO::FETCH_ASSOC);
									$response = json_decode($queryInfo["response"], true);
									$amountNaira = $response["amountNaira"]? $response["amountNaira"]:0;
									$txDateCreated = $queryInfo["txDateCreated"];
									$trans_type = $queryInfo["type"];
									$status = $queryInfo["status"];
									$id = $queryInfo["id"]; 
							
									if($status == "Pending" && $trans_type=="withdraw") {
										$btnStatus = "<div class='btn btn-danger btn-sm' id='viewTrans".$id."'><b>Processing</b></div>";
									} else if($status == "Approved" && $trans_type=="withdraw") {
										$btnStatus = "<div class='btn btn-success btn-sm' id='viewTrans".$id."'><b>Payment Completed</b></div>";
									} else if($status == "Pending") {
										$btnStatus = "<div class='btn btn-info btn-sm' id='viewTrans".$id."'><b>In Progress</b></div>";
									} else if($status == "Approved") {
										$btnStatus = "<div class='btn btn-success btn-sm' id='viewTrans".$id."'><b>Approved</b></div>";
									}  else if($status == "Cancelled") {
										$btnStatus = "<div class='btn btn-danger btn-sm' id='viewTrans".$id."'><b>Cancelled</b></div>";
									} ?>
									<td><?php echo $i;?></td>
									<td><?php echo $txDateCreated;?></td>
									<td><?php echo strtoupper($trans_type);?></td>
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
			
			<div id="viewTrans" style="margin-bottom: 10%"></div>
			<?php } ?>
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