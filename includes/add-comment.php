<?php
require_once("../admin/includes/connection.php");
$blogPostId=isset($_POST['replyblogPostId']) ? $_POST['replyblogPostId'] :"";
$commentSenderName = isset($_POST['cName']) ? $_POST['cName'] :"";
$commentEmail = isset($_POST['cEmail']) ? $_POST['cEmail'] :"";
$comment= isset($_POST['cMessage']) ? $_POST['cMessage'] :"";
$date=date("Y-m-d");
$time=date("H:i:s");
$sqlAddComment= "INSERT INTO blog_comments (n_blog_post_id,v_comment_author,v_comment_author_email,v_comment,d_date_created,d_time_created) VALUES('$blogPostId','$commentSenderName','$commentEmail','$comment','$date','$time')";
$queryAddComment = mysqli_query($conn,$sqlAddComment);
if(!$queryAddComment){
$result="error";
}else{
$result="success";
}
echo $result;
