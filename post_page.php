<?php
require_once 'db.php';

if(isset($_GET['t']) && !empty($_GET['t'])){
	$title = mysqli_real_escape_string($conn, $_GET['t']);
	$id = showPost($title, $conn);
	if($id !== 0){
		showComments($id, $conn);		
		if(!empty($_POST['name']) && !empty($_POST['comment'])){
			addComments($id,$_POST['name'], $_POST['comment'], $conn);
		}
	}
}



function showPost($title, $conn){
	$sql = "SELECT * FROM article WHERE post_title='$title'";
	$result = $conn->query($sql);
	if($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			echo "<h3 style='color:green'>".$row['post_title']."</h3><br />";
			echo $row['post_description']."<br />";
			echo "<img width='200px' class='post_image' src='src/images/".$row['post_image']."'> <br />";
			return $row['id'];
		}
	}
	return 0;
}

function showComments($id, $conn){
	$sql = "SELECT * FROM comment WHERE title_id = $id";
	$result = $conn->query($sql);
	if($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			echo "<h5>".$row['name']."</h5> <br />";
			echo $row['comm']."<br />";
		}
	}
}

function addComments ($id, $name, $comment, $conn){
	$comment = htmlspecialchars($comment);
	$sql = "INSERT INTO comment (title_id, name, comm) VALUES ($id, ?, ?)";
	$stmt = $conn->prepare($sql);
	$stmt->bind_param('ss', $name, $comment);
	$stmt->execute();
	header('Location:'.$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING']);
	die;
}
?>

<html>
<body>

<h4>Leave your comment here</h4>
<form action="" method="POST">
Your name: <input type="text" name="name"><br>
Comment: <textarea name="comment"></textarea><br>
<input type="submit">
</form>

</body>
</html>
