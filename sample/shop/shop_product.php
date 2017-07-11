<?php
session_start();
session_regenerate_id(true);
if(isset($_SESSION['member_login'])==false)
{
	print 'ようこそゲスト様　';
	print '<a href="member_login.html">会員ログイン</a><br />';
	print '<br />';
}
else
{
	print 'ようこそ';
	print $_SESSION['member_name'];
	print '様　';
	print '<a href="member_logout.php">ログアウト</a><br />';
	print '<br />';
}
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

$pro_code=$_GET['procode'];

require_once('../common/common.php');
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


$sql='SELECT name,price,info,gazou FROM mst_product WHERE code=?';
$stmt=$dbh->prepare($sql);
$data[]=$pro_code;
$stmt->execute($data);

$rec=$stmt->fetch(PDO::FETCH_ASSOC);
$pro_name=$rec['name'];
$pro_price=$rec['price'];
$pro_info=$rec['info'];
$pro_gazou_name=$rec['gazou'];

//商品レビュー
$sql='SELECT review FROM dat_review WHERE code_product=?';
$stmt3=$dbh->prepare($sql);
$data3[]=$pro_code;
$stmt3->execute($data3);

$dbh=null;

if($pro_gazou_name=='')
{
	$disp_gazou='';
}
else
{
	$disp_gazou='<img src="../product/gazou/'.$pro_gazou_name.'">';
}
print '<a href="shop_cartin.php?procode='.$pro_code.'">カートに入れる</a><br /><br />';

}
catch(Exception $e)
{
	print'ただいま障害により大変ご迷惑をお掛けしております。';
	exit();
}

?>

商品情報参照<br />
<br />
商品コード<br />
<?php print $pro_code; ?>
<br />
商品名<br />
<?php print $pro_name; ?>
<br />
価格<br />
<?php print $pro_price; ?>円
<br />
商品説明<br />
<?php print $pro_info; ?>
<br />
<?php print $disp_gazou; ?>
<br />
<br />

<!--
<form>
<input type="button" onclick="history.back()" value="戻る">
</form>
-->
<form action="shop_list.php">
<input type="submit" value="戻る">
</form>

<br />
商品レビュー--------------------<br />
<form method="post" action="shop_review_check.php">
<br />
商品レビューを入力してください。<br />
<input type="text" name="review" style="width:500px"><br />
<input type="hidden" name="code" value="<?php echo $pro_code;?>">
<input type="submit" value="OK">
</form>
<?php
while (true)
{
    $rec=$stmt3->fetch(PDO::FETCH_ASSOC);
    if($rec==false)
    {
        break;
    }
    print $rec['review'];
        print '<br />';
}        
?>    
</body>
</html>