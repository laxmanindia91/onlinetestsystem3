<?php
session_start();
error_reporting(0);
include '../db/connect.php';
//error_reporting(0);
$student_id = $_SESSION['id'];
$cat = $_REQUEST['cat'];
$cat = strtoupper($cat);
//echo $cat;
//echo 'student id-' .$student_id . ' ';
$timezone = new DateTimeZone(date_default_timezone_get());
$date = new DateTime('now', $timezone);

$sql = "select * from category where category_name = '$cat'";
$result = mysql_query($sql) or die(mysql_error());
$value = mysql_fetch_object($result);
$cat_id = $value->id;
$cat_name = strtolower($value->category_name);
//echo 'test category id-' . $cat_id;

//calculate test duration
//place this before any script you want to calculate time
$time_start = microtime(true); 

//sample script
//for($i=0; $i<1000; $i++){
 //do anything
//}

//$time_end = microtime(true);

//dividing with 60 will give the execution time in minutes other wise seconds
//$execution_time = ($time_end - $time_start)/60;
/*
$numbers = '1,2,3';

$array =  explode(',', $numbers);

foreach ($array as $item) {
    echo "<li>$item</li>";
}
*/
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title></title>

<style type="text/css">
    .bs-example{
    	margin: 20px;
    }
	#content
{
	width: 900px;
	margin: 0 auto;
	font-family:Arial, Helvetica, sans-serif;
}
.page
{
float: right;
margin: 0;
padding: 0;
}
.page li
{
	list-style: none;
	display:inline-block;
}
.page li a, .current
{
display: block;
padding: 5px;
text-decoration: none;
color: #8A8A8A;
}
.current
{
	font-weight:bold;
	color: #000;
}
.button
{
padding: 5px 15px;
text-decoration: none;
background: #333;
color: #F3F3F3;
font-size: 13PX;
border-radius: 2PX;
margin: 0 4PX;
display: block;
float: left;
}
#refresh-msgId {
    margin-top: 10px;
	margin-right:200px;
	float: right;
   //position: absolute;
}
.alert-warning {
    color: #8a6d3b;
    background-color: #fcf8e3;
    border-color: #faebcc;
}
.alert {
    padding: 15px;
    margin-bottom: 20px;
    border: 1px solid transparent;
    border-radius: 4px;
}
.q_choice
{
	margin-left:5px;
}
</style>
<script>
$(document).ready(function(){
	$('.btntest').hide('fast');
	//$('form').delay(50000).submit();
	$('.submit_test').click(function(){
		//alert('submit test');
		

		<?php 
		$time_end = microtime(true);
		//dividing with 60 will give the execution time in minutes other wise seconds
		$test_duration = ($time_end - $time_start)/60;
		?>
		//var test_duration = $('#time').text();
		var data = $("form").serialize();
			//$.post("../php/submit_test.php?sid=" + <?php echo $student_id; ?> + '&testid=' + <?php echo $cat_id; ?>, data, function() {
				$.post("../php/submit_test.php?sid=" + <?php echo $student_id; ?> + '&testid=' + <?php echo $cat_id; ?> + '&time=' + <?php echo $test_duration; ?>, data, function() {
			$('#response_here').empty();
			//$('form').reset();
			});
	});
	var fiveMinutes = 60 * 30,
        display = $('#time');
    startTimer(fiveMinutes, display);
	
	
	// move div on scroll
	$(window).scroll(function(){
		$(".movescroll").stop().animate({"marginTop": ($(window).scrollTop()) + "px", "marginLeft":($(window).scrollLeft()) + "px"}, "slow" );
});
	
});

function startTimer(duration, display) {
    var timer = duration, minutes, seconds;
    setInterval(function () {
        minutes = parseInt(timer / 60, 10)
        seconds = parseInt(timer % 60, 10);

        minutes = minutes < 10 ? "0" + minutes : minutes;
        seconds = seconds < 10 ? "0" + seconds : seconds;

        display.text(minutes + ":" + seconds);

        if (--timer < 0) {
            timer = duration;
        }
    }, 1000);
	
}
document.onmousedown=disableclick;
status="Right Click Disabled";
function disableclick(event)
{
  if(event.button==2)
   {
     alert(status);
     return false;    
   }
}
</script>
</head>
<body oncontextmenu="return false">
<div class="alert alert-warning" role="alert" id="refresh-msgId" style="top: 70px;"><b>Don't Refresh the Page !! ...</b></div>
<div id="content">
<div class="row">
<div class="col-md-3 col-lg-4 text-center">
<h2>Start Test1</h2>

</div>
</div>
<div class="bs-example">
<div class="row">
<div class="col-md-3 col-lg-4">
<div class="panel panel-default movescroll">
                    <div class="panel-heading pull-center">Test Time</div>
                    <div class="panel-body">
                        <?php //echo $date;  ?> <div><font color="red">Test closes in <span id="time">20:00</span> minutes!</font></div> 
                    </div>
                    
                </div>
</div>
    <div class="col-md-8 col-lg-8">
	<!--form action="submit_test.php" method="post" id="onlinetest"-->
	<form>
<?php
//pagination 
/*$start=0;
$limit=1;

if(isset($_GET['id']))
{
	$id=$_GET['id'];
	$start=($id-1)*$limit;
}*/
//pagination end
//$sql1 = "select * from questions order by RAND() LIMIT 30";

$query = "select * from test_students where testcategory = '$cat_name'";
$rs = mysql_query($query) or die(mysql_error());
$rec = mysql_fetch_object($rs);
$test_level = $rec->testlevel;
$test_topics = $rec->testtopics;

$topic_array =  explode(',', $test_topics);
print_r($test_topics);
echo '<br>';
foreach($topic_array as $ta)
{
echo '<b>' . $ta . '</b>';
//$sql1 = "SELECT t1.id,t1.question FROM questions t1 JOIN category t2 ON t2.id = t1.category_id WHERE t1.category_id = '$cat_id' order by RAND() LIMIT 10 ";
$sql1 = "SELECT t1.id,t1.question,t1.topics FROM questions t1 JOIN category t2 ON t2.id = t1.category_id WHERE t1.category_id = '$cat_id' && t1.topics = '$ta' order by RAND() LIMIT 50 ";
$result = mysql_query($sql1) or die(mysql_error());
//echo 'total ' . mysql_num_rows($result);
while($row = mysql_fetch_array($result))
{
$id = $row[0];
$quest = $row[1];
$topic = $row[4];	
?>	<div id="question_option" style="border:1px;">
	<div id="quest"><h4><?php echo $quest . '-' . $id . '-Topic: ' . $topic; ?></h4></div>
	<div><input type="hidden" name="question[<?php echo $id ?>][]" value="<?php echo $id; ?>"></div>
    <div class="q_choice">
	<ul class="list-unstyled">
	<?php $sql2 = "select * from question_choices where question_id = '$id' ";
	
			$result2 = mysql_query($sql2) or die(mysql_error());
			while($row = mysql_fetch_object($result2))
			{
	?>
        <!--li><div><input type="radio" name="optradio" value="A"> <?php //echo $row->choice1; ?></div>
		<div><input type="radio" name="optradio" value="B"> <?php //echo $row->choice2; ?></div>
		<div><input type="radio" name="optradio" value="C"> <?php //echo $row->choice3; ?></div>
		<div><input type="radio" name="optradio" value="D"> <?php //echo $row->choice4; ?></div></li-->

        <li><div><input type="radio" name="question[<?php echo $id ?>]" value="A"> <?php echo $row->choice1; ?></div>
		<div><input type="radio" name="question[<?php echo $id ?>]" value="B"> <?php echo $row->choice2; ?></div>
		<div><input type="radio" name="question[<?php echo $id ?>]" value="C"> <?php echo $row->choice3; ?></div>
		<div><input type="radio" name="question[<?php echo $id ?>]" value="D"> <?php echo $row->choice4; ?></div></li>
        
	<?php } ?>
        
    </ul>
	</div>
	</div>
	<?php
	} // while loop
} // foreach loop	
//pagination
	/*$rows=mysql_num_rows(mysql_query("select * from questions"));
$total=ceil($rows/$limit);

if($id)
{
	echo "<a href='?id=".($id-1)."' class='button'>PREVIOUS</a>";
}
if($id!=$total)
{
	echo "<a href='?id=".($id+1)."' class='button'>NEXT</a>";
}*/
//pagination end
	mysql_close($con);
	?>
	<button type="button" class="btn btn-danger submit_test">Submit</button>
	<hr>
	<p><b>Note:</b> Don't click/press back button during test.</p>
	</form>
    </div>
	</div>
 
</div>
</div>
</body>
</html>                                		