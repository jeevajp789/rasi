<?php


        session_start();
        // dBase file
        include "dbConfig.php";
  
	$DB = new DBConfig();
	$DB -> config();
	$dbhandle =$DB -> conn();

	
	$q = "SELECT * FROM `meanings` "
		."WHERE `wordid`='".$_GET["wordid"]."' ";

	$qLlanguages="SELECT * FROM languages where status='A' ";
	//execute the SQL query and return records
	$resultLanguages = mysql_query($qLlanguages);

	//execute the SQL query and return records

 
	if(isset($_GET["Save"]))
	{
		if($_GET["Save"]!="")
		{
		  $q = "INSERT INTO `temp_meanings` (`meaning`,`languageid`,`word_id`) "
			."VALUES ('".$_POST["txtMeaning"]."', "
			."'".$_POST["cmbLanguage"]."', "
			."'".$_POST["hidWordId"]."')";
	  	//  Run query
		  $r = mysql_query($q);

		$q = "SELECT * FROM `meanings` "
		."WHERE `wordid`='".$_POST["hidWordId"]."' ";

		}
	}

	$result = mysql_query($q);


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<!--
Design by Free CSS Templates
http://www.freecsstemplates.org
Released for free under a Creative Commons Attribution 2.5 License

Name       : Modelling 
Description: A two-column, fixed-width design with dark color scheme.
Version    : 1.0
Released   : 20120617

-->
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="keywords" content="" />
<meta name="description" content="" />
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>rasi</title>
<link href="http://fonts.googleapis.com/css?family=Abel" rel="stylesheet" type="text/css" />
<link href="style.css" rel="stylesheet" type="text/css" media="screen" />
<script type="text/javascript">
	function fnAddNew()
	{

		document.getElementById("td1").style.display="";
		document.getElementById("td2").style.display="";
                document.getElementById("td2a").style.display="";
                document.getElementById("td2b").style.display="";
		document.getElementById("td3").style.display="";
		document.getElementById("td4").style.display="";
	}
	function fnCancel()
	{
		document.getElementById("td1").style.display="none";
		document.getElementById("td2").style.display="none";
		document.getElementById("td3").style.display="none";
		document.getElementById("td4").style.display="none";
	}

	function fnSave()
	{
		frmMeanings.action="?Save=Yes&wordid="+document.getElementById("hidWordId").value;
		frmMeanings.method="post";
		frmMeanings.submit();
	}

</script>

</head>
<body >
<form action="" method="POST" id="frmMeanings"">
	<div id="wrapper">
		<div id="wrapper2">
			<!-- end #header -->

			<div id="page">
				<div id="content">
					<div class="post">
						<h2 class="title"><a href="#">Available word meaning(s)</a></h2>
					
						</div>
					</div>
				</div>
				<!-- end #content -->
				<div style="clear: both;">&nbsp;</div>
			</div>
			<!-- end #page --> 
		</div>
	</div>
	<div id="footer-content-wrapper">
		<div id="footer-content">
			<div id="column1">
				<h2><?php if(isset($_GET["word"])) echo $_GET["word"] ?></h2>
				<ul>
				
					<?php while ($row = mysql_fetch_array($result, MYSQL_ASSOC)){
					echo "<li>".$row['meaning']."</li>";
					}
					?>

				</ul>
			</div>
		</div>
	</div>

	<div id="footerlink">
		<ul>
				<?php
				  echo "<table border=\"0\"/><tr>";
				  echo "<td><a href=\"#\" onclick=\"fnAddNew();\">Add New</a></td>";
				  echo "<td style=\"display:none\" id=\"td1\"><input type=\"text\" name=\"txtMeaning\" size=\"15\" placeholder=\"Meaning\"></td>";
				  echo "<td style=\"display:none\" id=\"td2\"><select id=\"cmbLanguage\"";
				  echo "name=\"cmbLanguage\">";
                                  
				?>
					<?php while ($row = mysql_fetch_array($resultLanguages, MYSQL_ASSOC)){
					echo "<option value=".$row['id'].">".$row['language']."</option>";
					}
					?>
				<?php
 				  echo "</select></td>";
                                  echo "<td style=\"display:none\" id=\"td2a\"><input type=\"text\" name=\"txtComment\" size=\"15\" placeholder=\"Comment\"></td>";
                                  echo "<td style=\"display:none\" id=\"td2b\"><input type=\"text\" name=\"txtReference\" size=\"15\" placeholder=\"Reference\"></td>";
				  echo "<td style=\"display:none\" id=\"td3\"><a href=\"#\" onclick=\"fnSave();\">Save</a></td>";
				  echo "<td style=\"display:none\" id=\"td4\"><a href=\"#\" id=\"action\" onclick=\"fnCancel();\">Cancel</a></td>";
				  echo "</tr>";
				  echo "</table>";


				?>

		</ul>
	</div>	
	<!-- end #footer -->

	<input type="hidden" value="<?php echo $_GET['wordid'] ?>" id="hidWordId" name="hidWordId">
	<input type="hidden" value="<?php echo $_GET['word'] ?>" id="hidWord" name="hidWord">
</form>
</body>
</html>

<?php
	mysql_free_result($result);
?>
