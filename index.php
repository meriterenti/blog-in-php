<html>
 <head>
 </head>
 <body>
 <h1>Last news of Fall ...</h1>
</body>
</html>


<?php
require_once 'db.php';

$sql = "SELECT * FROM article";
$result = $conn->query($sql);
if($result->num_rows > 0) {
	while($row = $result->fetch_assoc()) {
		$title = urlencode($row['post_title']);
		echo "<a href ='post_page.php?t=$title' target='_blank'>".$row['post_title']."</a>" ;
		echo "<br />".$row['post_date'];
		echo "<br />".$row['post_short_description']."<br />";
	}
}
?>

