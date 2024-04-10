
<div class="row" style="margin-top: 4%">
	<div class="col-sm-6 mb-4" style="margin-top: 0.8%; margin-bottom: 10px; color: #000; font-size: 18px; font-weight: bold">
		<b>Account Name : </b> <?php echo $action->clientAccName($clientID);?>
	</div>
	<div class="col-sm-6 mb-4" style="margin-top: 0.8%; margin-bottom: 10px; color: #000; font-size: 18px; font-weight: bold">
		<b>Wallet : </b> &#8358;<?php echo number_format($action->clientBlc($clientID), 2);?> <a href="wallet">Withdraw</a>
	</div>
	<div class="col-sm-6 mb-4" style="margin-bottom: 10px; color: #000; font-size: 18px; font-weight: bold">
		<b>Referral Code : </b> <?php echo $action->userCode($clientID);?>
	</div>
	<div class="col-sm-6 mb-4" style="margin-bottom: 10px; color: #000; font-size: 18px; font-weight: bold">
		<b>Level Type : </b> Vip <?php echo $action->vipLevel($clientID);?> 
		<!--<a href="upgradeAccount">Upgrade Account</a>-->
	</div>
</div>	

<div class="row">
	<div class="col-md-12 mb-4">
		<div class="progress" style="margin-right: 15px">
			<div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="<?php echo $action->clientPoint($clientID);?>" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $action->clientPoint($clientID);?>%">
				<?php echo $action->clientPoint($clientID) * 10;?>/1000
			  </div>
		</div>
	</div>
</div>