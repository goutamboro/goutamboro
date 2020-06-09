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
<style>img{max-width:100%;}
.wpsafe-top{width:auto;text-align:center;margin-bottom:20px;}.img-logo{max-height:30px;}
.navbar-brand{padding:10px;}
.wpsafe-bottom{width:auto;text-align:center;margin-top:0px;padding-top:60px;}
#wpsafe-generate{display:none;}#wpsafe-wait2{display:none;}#wpsafe-link{display:none;}
.adb{display:none;position:fixed;width:100%;height:100%;left:0;top:0;bottom:0;background:rgba(51,51,51,0.9);z-index:10000;text-align:centerx;color:#111;}
.adbs{margin:0 auto;width:auto;min-width:400px;position:fixed;z-index:99999;left:50%;top:50%;transform:translate(-50%, -50%);padding:20px 30px 30px;background:rgba(255,255,255,0.9);-webkit-border-radius:12px;-moz-border-radius:12px;border-radius:12px;}
</style>
</head>
<body>
<div class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <a href="" class="navbar-brand"><img src="<?php echo $_GET['logo']?>" class="img-logo"/></a>
          <button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#navbar-main">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
        </div>
        <div class="navbar-collapse collapse" id="navbar-main">
			<div class="pull-left"> </div> 
		</div>
      </div>
    </div>
<section id="content-wrapper" style='margin-top:80px'>
<div class='container'> 
	<div class='row'>
		<div class='col-md-12'>
			<div class='panel panel-default'> 
				<div class='panel-body'> 
		<div class="wpsafe-top text-center">
			<div><?php echo $_GET['ads1'];?></div>
			<div id="wpsafe-wait1"><?php echo $_GET['delaytext']?></div>
			<div id="wpsafe-generate"><a href="#wpsafegenerate" onclick="wpsafegenerate()"><img src="<?php echo $_GET['image1'];?>"/></a></div>
		</div>
				<hr style="margin-top:10px;"> 
				<h1><?php the_title()?></h1>
				<hr><?php the_content()?>	
		<div class="wpsafe-bottom text-center" id="wpsafegenerate">
			<div id="wpsafe-wait2"><img src="<?php echo $_GET['image2'];?>"/></div>
			<div id="wpsafe-link"><a href="<?php echo $_GET['linkr'];?>" target="_blank" rel="nofollow">
			<img src="<?php echo $_GET['image3'];?>"/></a></div>
			<div><?php echo $_GET['ads2'];?></div>
		</div> 			
				</div>
				<div style="margin-bottom:20px;" id='iklan728x90'>
				<center> 
				</center>
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
<?php if($_GET['adb']=='1'):?>
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
		var count= <?php echo $_GET['delay'];?>;
	}
<?php else:?>
	var count= <?php echo $_GET['delay'];?>;
<?php endif;?>
	var counter=setInterval(timer, 1000);
	function timer(){
		count=count-1;
		if (count <= 0){ 
			document.getElementById('wpsafe-wait1').style.display = 'none';
			document.getElementById('wpsafe-generate').style.display = 'block';
			clearInterval(counter);
			return;
		}
		document.getElementById("wpsafe-time").innerHTML=count;
	} 
	function wpsafegenerate(){ 
		document.getElementById('wpsafegenerate').focus();
		document.getElementById('wpsafe-link').style.display = 'none';
		document.getElementById('wpsafe-wait2').style.display = 'block';
		var timer=setInterval(function(){document.getElementById('wpsafe-wait2').style.display='none';},2000); 
		var timer=setInterval(function(){document.getElementById('wpsafe-link').style.display='block';},2000);
	}
</script>
</body>
</html>