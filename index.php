<?php 
$err=0;
$gotvalues=0;
	include('dbconnect.php');
	if(isset($_POST['submit'])){
		$name=$_POST['myname'];
		$pollname=$_POST['pollname'];
		$options=$_POST['options'];
		$gotvalues=1;
		if($options<2){
			$err=1;
			echo ' <script>alert("Options cant be less than 2,you stupid") </script> ';
		}
	
	else if($pollname==""){
		$err=1;
			echo ' <script>alert("Choose poll name") </script> ';
	}
	else{
		$uid=rand(10000,100000);
		$query="INSERT INTO polls(id,uid,name,options) values('NULL','$uid','$name','$options') ";
		$insert=mysqli_query($connect,$query);
		$query2="INSERT INTO options(id,pollid,pollname,opt1per,opt2per,opt3per,opt4per,opt5per,opt6per,opt7per,opt8per,opt9per,opt10per,totalvotes) values('NULL','$uid','$pollname','0','0','0','0','0','0','0','0','0','0','0') ";
		$insert2=mysqli_query($connect,$query2);
	}
}
if(isset($_GET['action'])){

	$totaloptions=$_GET['totaloptions'];
	$pollid=$_GET['pollid'];
	$a=1;

	 while($a<=$totaloptions){ 
	 	$myvalue=$_GET['opt'.$a.''];
	 	
	$query="UPDATE  options SET opt".$a." = '$myvalue' where pollid='$pollid' ";
	$run=mysqli_query($connect,$query);
	$a++;
	}
	if($run){
		header("location:index?pollcreated=yes&pollid=".$pollid);
	}
}
 ?>



<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="style.css">
	<script type="text/javascript" src="script.js"></script>
	<title>Poll System</title>
</head>
<body>
	<div class="header">
		<h1>Poll System</h1>
	</div>
	
	<div class="mybody" id="mybody">
		<h2>Create a poll</h2>
		<form action="index" method="POST">
		<div class="center">
			<input type="text" name="myname" id="myname" class="input" placeholder="Enter your name">
		</div>
		<div class="center">
			<input type="text" name="pollname"  class="input" placeholder="Enter poll question">
		</div>
		<h2  style="text-align: center; margin-top: 4%;">Number of options</h2>
			
		<div class="center">
			<br>
			<select id="options" name="options" class="input">
				<?php 
					$i=2;
					while($i<=10){
				 ?>
				 <option name="options" id="options"><?php echo $i; ?></option>
				 <?php  $i++; } ?>
			</select>
		</div>
		<div class="center">
			<input type="submit" onclick="verify()" name="submit" value="Make poll" class="btn">
		</div>
		</form>
	</div>
	<?php 
	if($gotvalues==1){

		if($err==0){
			?>
			<script type="text/javascript">
				document.getElementById("mybody").style.display="none";
			</script>
				<hr>
			<div class="poll" id="poll">
				<div class="center">
					
					<h2>Make poll</h2>
					
				</div>
				<div class="center">
					<h3 style="color: red;">Poll name : "<?php echo $pollname; ?>" by <?php echo $name; ?></h3>
				</div>

			</div>
			<div class="center">
			<h3 style="font-size: 32px;"> Q. <?php echo "$pollname"; ?> ? </h3>
				</div>

				<?php
				$opt=1; 
				while($opt<=$options){

					?>
					<h2 style="text-align: center; margin-top: 3%; margin-bottom: -2%;">Option - <?php  echo $opt; ?></h2>
					<form action="index">
						<input type="hidden" name="action" value="pollsubmit">
						
					<div class="center">
						
					<input class="myoptions" type="text" name="opt<?php echo $opt; ?>">
				</div>
					<?php
					$opt++;
						}
						$opt--;
				 ?>

				 		<input type="hidden" name="totaloptions" value="<?php echo $opt; ?>">
						<input type="hidden" name="pollid" value="<?php echo $uid; ?>">
				
				 <marquee>Submit options</marquee>
				 <div class="center">
				 	<input style="font-size: 32px;" type="submit" name="optsubmit" value="Submit Options">

				 </div>
				 </form>
				
	<?php		

		}

	}
	 ?>

	 <?php if(isset($_GET['pollcreated'])) { $pollid=$_GET['pollid'];
	 ?>
			<script type="text/javascript">
	 			document.getElementById("mybody").style.display="none";
	 			document.getElementById("poll").style.display="none";
	 		</script>

	 		<div class="pollsuccess">
	 			<div class="center">
	 				<h1 style="color: green;">Poll created successfully !!!!</h1>
	 			</div>
	 			<div class="center">
	 				<h2 style="margin-top:7%;">Your poll id is '<?php  echo $pollid; ?>'</h2>
	 			</div>
	 		</div>

	 		<div class="center">
	 			<h2 style="margin-top: 4%;">Your poll link : <a target="_blank" href="poll?pollid=<?php echo $pollid; ?>">http://localhost/pollsystem/poll?pollid=<?php echo $pollid; ?></a></h2>
	 		</div>
	 		<div class="center">
	 			<a target="_blank" style="margin-top: 4%; font-size: 28px;" href="index">Create a new poll here !!</a>
	 		</div>

	 <?php } ?>
	
	

</body>
</html>