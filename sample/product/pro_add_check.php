<?php
session_start();
session_regenerate_id(true);
if(isset($_SESSION['login'])==false)
{
	print 'ログインされていません。<br />';
	print '<a href="../staff_login/staff_login.html">ログイン画面へ</a>';
	exit();
}
else
{
	print $_SESSION['staff_name'];
	print 'さんログイン中<br />';
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

require_once('../common/common.php');

$post=sanitize($_POST);
$pro_name=$post['name'];
$pro_price=$post['price'];
$pro_info=$post['info'];
$pro_gazou=$_FILES['gazou'];
$pro_type=$post['type'];
$pro_size=$post['size'];

if($pro_name=='')
{
	print '商品名が入力されていません。<br />';
}
else
{
	print '商品名:';
	print $pro_name;
	print '<br />';
}

if(preg_match('/^[0-9]+$/',$pro_price)==0)
{
	print '価格をきちんと入力してください。<br />';
}
else
{
	print '価格:';
	print $pro_price;
	print '円<br />';
}

if($pro_info=='')
{
	print '商品説明が入力されていません。<br />';
}
else
{
	print '商品説明:';
	print $pro_info;
	print '<br />';
}

if($pro_gazou['size']>0)
{
	if($pro_gazou['size']>1000000)
	{
		print '画像が大き過ぎます';
	}
	else
	{
		move_uploaded_file($pro_gazou['tmp_name'],'./gazou/'.$pro_gazou['name']);
		print '<img src="./gazou/'.$pro_gazou['name'].'">';
		print '<br />';
	}
}

if($pro_type=='')
{
	print 'タイプが入力されていません。<br />';
}
else
{
	print 'タイプ:';
	print $pro_type;
	print '<br />';
}
if($pro_size=='')
{
	print 'サイズが入力されていません。<br />';
}
else
{
	print 'サイズ:';
	print $pro_size;
	print '<br />';
}

if($pro_name=='' || preg_match('/^[0-9]+$/',$pro_price)==0 || $pro_info=='' || $pro_gazou['size']>1000000 ||$pro_type==''||$pro_size=='')
{
	print '<form>';
	print '<input type="button" onclick="history.back()" value="戻る">';
	print '</form>';
}
else
{
	print '上記の商品を追加します。<br />';
	print '<form method="post" action="pro_add_done.php">';
	print '<input type="hidden" name="name" value="'.$pro_name.'">';
	print '<input type="hidden" name="price" value="'.$pro_price.'">';
        print '<input type="hidden" name="info" value="'.$pro_info.'">';
	print '<input type="hidden" name="gazou_name" value="'.$pro_gazou['name'] .'">';
	print '<input type="hidden" name="type" value="'.$pro_type.'">';
	print '<input type="hidden" name="size" value="'.$pro_size.'">';
        print '<br />';
	print '<input type="button" onclick="history.back()" value="戻る">';
	print '<input type="submit" value="ＯＫ">';
	print '</form>';
}

?>
</body>
</html>