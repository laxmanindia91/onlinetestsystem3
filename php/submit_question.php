<?php
include '../db/connect.php';
$level = $_POST['level'];
$cat = $_POST['category'];
$quest = $_POST['question'];
$qtype = $_POST['optradio'];
$ans = $_POST['answer'];
$topics = $_POST['testtopics'];
$choice_values = $_POST['choice_name'];

$level = $_POST['level'];

foreach ($topics as $value) {
    //echo "Key: $key; Value: $value\n";
	//echo $value;
	$tmp[]=$value;
}

$jointopics = implode("^",$tmp);

$query1 = "INSERT INTO questions(question,category_id,level,topics,question_type,isACtive) VALUES ('$quest','$cat','$level','$jointopics','$qtype','1')";
$result = mysql_query($query1) or die(mysql_error());
//get id of question that submitted
$question_id = mysql_insert_id();

foreach ($choice_values as $value) {
	$tmp2[]=$value;
}
$choicevalues = implode("^",$tmp2);
$query2 = "INSERT INTO question_choices (question_id , is_Correct_Choice, answer_choices) VALUES ('$question_id','$ans','$choicevalues')";
$result2 = mysql_query($query2) or die(mysql_error());
mysql_close();
?>