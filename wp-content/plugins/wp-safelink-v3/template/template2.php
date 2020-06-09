<!DOCTYPE html>
<html lang="en">
<head>
<title><?php the_title()?></title>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<meta charset="utf-8">
<meta name='viewport' content='width=device-width, initial-scale=1.0'> 
<link rel='stylesheet' type='text/css' href='//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css'/>
<link rel='stylesheet' type='text/css' href='//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css'/>
<meta name="robots" content="noindex,nofollow">
<script type='text/javascript' src='https://code.jquery.com/jquery-1.11.2.min.js'></script>
<style> 
.adb{display:none;position:fixed;width:100%;height:100%;left:0;top:0;bottom:0;background:rgba(51,51,51,0.9);z-index:10000;text-align:centerx;color:#111;}
.adbs{margin:0 auto;width:auto;min-width:400px;position:fixed;z-index:99999;left:50%;top:50%;transform:translate(-50%, -50%);padding:20px 30px 30px;background:rgba(255,255,255,0.9);-webkit-border-radius:12px;-moz-border-radius:12px;border-radius:12px;}
</style>
</head>
<body> 
<section id="content-wrapper" style='margin-top:80px'>
<div class='container'> 
	<div class='row'>
		<div class='col-md-12'>
			<div class='panel panel-default'> 
				<div class='panel-body'> 
					<div class="wpsafe-top text-center"> 
						<div style="color:red;margin-bottom:20px;">Human Verification</div>
						<form action="<?php the_permalink()?>" method="post">
							<input type="hidden" name="newwpsafelink" value="<?php echo $_GET['code']?>">
							<input class="btn btn-primary" type="submit" value="Submit">
						</form> 
					</div> 		
				</div> 
			</div>
		</div>
	</div>
</div>
</section>
<?php if($_GET['adb']=='1'):?>
<div class="adb" id="adb">
	<div class="adbs">
		<h3><?php echo $_GET['adb1'];?></h3>
		<p><?php echo $_GET['adb2'];?></p>
	</div>
</div> 
<?php endif;?>
<script src="<?php echo WPSAF_URL;?>/assets/fuckadblock.js"></script>
<script type="text/javascript"> 
	var count= <?php echo $_GET['delay'];?>;
	function adBlockDetected() { 
		document.getElementById("adb").setAttribute("style", "display:block");
	} 
	function adBlockNotDetected() { 
	} 
	if(typeof fuckAdBlock === 'undefined') {
		adBlockDetected();
	} else {
		fuckAdBlock.setOption({ debug: true });
		fuckAdBlock.onDetected(adBlockDetected).onNotDetected(adBlockNotDetected);
	} 
</script>
</body>
</html>