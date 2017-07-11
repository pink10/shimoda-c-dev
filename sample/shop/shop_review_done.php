<?php
	session_start();
	session_regenerate_id(true);
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>スズキヤ</title>
</head>
<body>

<?php

try
{

require_once('../common/common.php');

$post=sanitize($_POST);

$review=$post['review'];
$pro_code=$post['code'];

if (DEBUG) {
$dsn='mysql:dbname=shop;host=localhost;charset=utf8';
$user='root';
$password='';
$dbh=new PDO($dsn,$user,$password);
$dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
}
else{
$dbServer = '127.0.0.1';
$dbUser = $_SERVER['MYSQL_USER'];
$dbPass = $_SERVER['MYSQL_PASSWORD'];
$dbName = $_SERVER['MYSQL_DB'];
$dsn = "mysql:host={$dbServer};dbname={$dbName};charset=utf8";
$dbh = new PDO($dsn, $dbUser, $dbPass);
}

$sql='INSERT INTO dat_review(code_product,review) VALUES (?,?)';
$stmt=$dbh->prepare($sql);
$data[]=$pro_code;
$data[]=$review;
$stmt->execute($data);

print '商品レビューを追加しました。<br />';

}
catch (Exception $e)
{
	print 'ただいま障害により大変ご迷惑をお掛けしております。';
	exit();
}

print '<br />';
print '<a href="shop_product.php?procode='.$pro_code.'">戻る</a>';

?>

</body>
</html>