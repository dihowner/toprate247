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
    <title>Admin Chat - Toprate 247</title>
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
					<a class="nav-link " href="tables.html">
					  <i class="material-icons">table_chart</i>
					  <span>Tables</span>
					</a>
				  </li>
				  <li class="nav-item">
					<a class="nav-link " href="user-profile-lite.html">
					  <i class="material-icons">person</i>
					  <span>User Profile</span>
					</a>
				  </li>
				  <li class="nav-item">
					<a class="nav-link " href="errors.html">
					  <i class="material-icons">error</i>
					  <span>Errors</span>
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
                    <a class="dropdown-item" href="user-profile-lite.html">
                      <i class="material-icons">&#xE7FD;</i> Referral Link</a>
                    <a class="dropdown-item" href="components-blog-posts.html">
                      <i class="fa fa-user"></i> Edit Profile</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item text-danger" href="#">
                      <i class="material-icons text-danger">&#xE879;</i> Logout </a>
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
			 if(isset($_GET["viewTrans"])) {
				$transID = $_REQUEST["id"];
				
				$chkTrnsID = $action->query("SELECT * FROM `chat` where transID='$transID'");
				$chkTrnsID->execute();
				$chkTrnsIDInfo = $chkTrnsID->fetch(PDO::FETCH_ASSOC);
				$gather = $action->query("select * from transactions where id='$transID'");
				$gather->execute();
				$gatherInfo = $gather->fetch(PDO::FETCH_ASSOC);
				$response = json_decode($gatherInfo["response"], true);
				?>

			 
				<div align='center' style="margin-bottom: 5%; margin-top: 3%;">
					<h3 style="font-size: 2.5rem; font-weight: 900">Chat Transaction</h3>
				</div>
				<div style="font-weight: bolder; border: 1px solid #333; background: #FFCC99; color: #000; padding: 10px; font-size: 18px; margin-bottom: 10px; margin-top: -10px;">
					&#8358;<?php echo number_format($response["amountNaira"]) . " - " . strtoupper($gatherInfo["type"]); ?>
				</div>
				
			 <?php 
			 
				if(isset($_POST["btnAddComment"])) {
					$chatMsg = addslashes($_POST["AddComment"]);
					$adminName = addslashes($_POST["adminName"]);
					if(empty($chatMsg) || strlen($chatMsg) < 5) {
						echo $action->error("Chat message is empty or too short");
					} else {
						if ($_SESSION["chatAdded"] == $chatMsg . $transID . $adminName) {
							echo $action->error("Error recreating chat");
						} else {
							$gather = $action->query("insert into chatreply (adminName, transID, content) values ('$adminName', '$transID', '$chatMsg')");
							if ($gather->execute()) {
								$_SESSION["chatAdded"] = $chatMsg . $transID . $adminName;
								echo $action->success("Response added successfully");
							} else {
								echo $action->error("Error creating chat");
							}
						}
					}
				}
				
				$loadReply = $action->query("SELECT * FROM `chatreply` where transID='$transID' order by id desc");
				$loadReply->execute();
				while ($loadReplyInfo = $loadReply->fetch(PDO::FETCH_ASSOC)) { ?>
					<div class="msg_cell">
						<?php
						if(empty($loadReplyInfo["adminName"])) {
							echo $action->clientAccName($clientID);
						} else {
							echo $loadReplyInfo["adminName"] . " (<font color='red'>Admin</font>)";
						}?> <b>&raquo;</b> <?php echo $loadReplyInfo["content"];?>
						<br/>
						Date Created: <b><?php echo $loadReplyInfo["dateCreated"];?></b>
					</div>
				<?php } ?>
				<div class="msg_cell">
					<?php echo $action->clientAccName($chkTrnsIDInfo["clientID"]);?> <b>&raquo;</b> <?php echo $chkTrnsIDInfo["content"];?>
					<br/>
					Date Created: <b><?php echo $chkTrnsIDInfo["dateCreated"];?></b>
				</div>
			<?php
				if($gatherInfo["status"] == "Pending") { ?>
					<form method="post">
						<textarea class="form-control input-lg" placeholder="Write A Comment" name="AddComment" required></textarea> <br>
						<label for="adminName">Select Admin Name:</label> <br>
						<select name="adminName" id="adminName" class="form-control" required>
							<option value=""> -- Select Admin --</option>
							<option value="Alade Micheal">Alade Micheal</option>
							<option value="Obi Joshua">Obi Joshua</option>
							<option value="Adewuyi Cynthia">Adewuyi Cynthia</option>
							<option value="Kareem Adewale">Kareem Adewale</option>
						</select> <br>
						<button class="btn btn-success" name="btnAddComment" type="submit">
							<b><i class="fa fa-plus"></i> Add Comment</b>
						</button>
					</form>

					<?php
				} else {
					echo $action->error("Chat ended");
				}

			} else { ?>
			 
				<div align='center' style="margin-bottom: 5%; margin-top: 3%;">
					<h3 style="font-size: 2.5rem; font-weight: 900">Chat Transaction</h3>
				</div>
			 <?php
					$checkChat = $action->query("select * from chat where status='new' and medium='open' order by chatid desc");
					$checkChat->execute();
					if ($checkChat->rowCount() == 0) {
						echo $action->error("no chat record found");
					} else {	
						while ($checkChatInfo = $checkChat->fetch(PDO::FETCH_ASSOC)) {
							$transID = $checkChatInfo["transID"];
							$gather = $action->query("select * from transactions where id='$transID'");
							$gather->execute();
							$gatherInfo = $gather->fetch(PDO::FETCH_ASSOC);
							$response = json_decode($gatherInfo["response"], true);

							//Chat Response...
							$checkChatR = $action->query("select * from chatreply where transID='$transID'");
							$checkChatR->execute();
							?>

							<div style="font-weight: bolder; border: 1px solid #333; background: #FFCC99; color: #000; padding: 10px; font-size: 18px; margin-bottom: 20px; margin-top: -15px">
								<a href="?viewTrans&id=<?php echo $transID; ?>">
									&#8358;<?php echo number_format($response["amountNaira"]) . " - " . strtoupper($gatherInfo["type"]) . " <font color='red'><b>(" . $checkChatR->rowCount() . " Response)</b></font>"; ?>
								</a>
							</div>
						<?php }
					}			 ?>
		  <?php }
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