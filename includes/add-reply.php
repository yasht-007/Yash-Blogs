<?php

require_once("../admin/includes/connection.php");

$blogPostId=isset($_POST['replyblogPostId']) ? $_POST['blogPostId'] :"";
$commentParentId=isset($_POST['commentParentId']) ? $_POST['commentParentId'] :"";
$commentSenderName = isset($_POST['replycName']) ? $_POST['replycName'] :"";
$commentEmail = isset($_POST['replycEmail']) ? $_POST['replycEmail'] :"";
$comment= isset($_POST['replycMessage']) ? $_POST['replycMessage'] :"";
$date=date("Y-m-d");
$time=date("H:i:s");
$sqlAddReply= "INSERT INTO blog_comments (n_blog_comment_parent_id,n_blog_post_id,v_comment_author,v_comment_author_email,v_comment,d_date_created,d_time_created) VALUES('$commentParentId','$blogPostId','$commentSenderName','$commentEmail','$comment','$date','$time')";
$queryAddReply = mysqli_query($conn,$sqlAddReply);
if(!$queryAddReply){
$result="error";
}else{
$result="success";
}
echo $result;
