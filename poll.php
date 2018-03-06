<?php 

	include('dbconnect.php');

	if(!isset($_GET['pollid']) || strlen($_GET['pollid'])==0){
		echo '<script> alert("Create a poll first ");</script> ';
		header("location:http://localhost/pollsystem/index");
		
	}
	else{
		$pollid=$_GET['pollid'];
		$query="SELECT * from options where pollid='$pollid'";
		$run=mysqli_query($connect,$query);
		if(mysqli_num_rows($run)==0){
			header("location:http://localhost/pollsystem/index");
		
		}
		$fetch=mysqli_fetch_assoc($run);
		$pollname=$fetch['pollname']."??";

		$query="SELECT * from polls where uid='$pollid'";
		$run=mysqli_query($connect,$query);
		$fetch=mysqli_fetch_assoc($run);
		$totaloptions=$fetch['options'];
	}
	if(isset($_GET['submit'])){
		if(!isset($_GET['opt'])){
			echo '<script> alert("Choose an option"); </script>';
		}
		else{
		$option=$_GET['opt'];
		$query="SELECT * from options where pollid='$pollid'";
		$run=mysqli_query($connect,$query);
		$fetch=mysqli_fetch_assoc($run);
		$votedoption="opt".$option."per";

		$val=(int)$fetch[$votedoption];
		$val++;
		$totalvotes=(int)$fetch['totalvotes'];
		$totalvotes++;
		$query2="UPDATE options SET  ".$votedoption." = '$val'"." ,  totalvotes='$totalvotes' "."where pollid='$pollid'";
		$run2=mysqli_query($connect,$query2);
		
		}
	
		
	}
	
 ?>
 <!DOCTYPE html>
 <html>
 <head>
 	<script type="text/javascript" src="script.js"></script>
 	<link rel="stylesheet" type="text/css" href="style.css">
 	<title>Poll System</title>
 </head>
 <body>
 	<h1 style="text-align: center;">Poll System</h1>
 	<div class="center">
 	<h1 style="margin-top: 4%; margin-bottom: 8%;">Poll name : <span style="color: red;"><?php echo $pollname; ?></span></h1>
 	</div>
 	<?php 
 	$i=1;
 	$query2="SELECT * from options where pollid='$pollid'";
	
		$run2=mysqli_query($connect,$query2);
		$fetch2=mysqli_fetch_assoc($run2);
 	?>
 	<form action="poll">
 	 <?php
 	while($i<=$totaloptions){
 		$currentoption="opt"."$i";

 	$myoption=$fetch2[$currentoption];
			
 	 ?><div class="center">
 	 
 	 <input id="<?php echo $i; ?>" type="radio" name="opt" value="<?php echo $i; ?>">
 	 <h2  class="radiobtn"><?php echo "$myoption"; ?></h2>
 	 
 	 </div>
 	 <?php $i++; }?>
 	 
 	 <input type="hidden" name="pollid" value="<?php echo $pollid; ?>">
 	 <div class="center">
 	 	<input type="submit" name="submit" style="margin-top: 4%;" value="Vote now" >
 	 </div>
 	</form>
 	<div style="margin-top: 4%;"	 class="center">
 		
 		<button id="showbtn" onclick="showbtn()">Show data</button>
 	</div>

<?php 
	$query3="SELECT * from options where pollid='$pollid'";
	$run3=mysqli_query($connect,$query3);
	$fetch3=mysqli_fetch_assoc($run3);
	
 ?>
 	<div id="databox">
 		<?php 
 		$p=1;
 		while($p<=$totaloptions){
 		
 		 ?>
 		 <div class="center">
 		 <h1>
 		 	<?php 
 		 	$myval="opt".$p."per"; 
 		 	$totalvotes=$fetch3['totalvotes'];
 		 	if($fetch3[$myval]!=0)
 		 	$fetch3[$myval]=(float)$fetch3[$myval]*100/$totalvotes;
 		 	$myvalname="opt".$p;
 		 echo $fetch3[$myvalname]." - ".$fetch3[$myval]." %"; ?>
 		 	
 		 </h1> </div>
 		 <?php $p++; } ?>

 		

 	</div>
 	<div class="center">
	 			<a target="_blank" style="margin-top: 4%; font-size: 28px;" href="index">Create a new poll here !!</a>
	 		</div>
 </body>
 </html>