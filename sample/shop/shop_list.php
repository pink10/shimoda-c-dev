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
	print ' 様　';
	print '<a href="member_logout.php">ログアウト</a><br />';
	print '<br />';
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>ろくまる農園</title>
</head>
<body>

<?php



try
{

$dsn='mysql:dbname=shop;host=localhost;charset=utf8';
$user='root';
$password='';
$dbh=new PDO($dsn,$user,$password);
$dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

$sql='SELECT code,name,price,type,size FROM mst_product WHERE 1';
$stmt=$dbh->prepare($sql);
$stmt->execute();

$dbh=null;    

print '商品一覧<br /><br />';



require_once('../common/common.php');
?>
<form method="post" action="">
キーワード<br />
<input type="text" name="keyword" ><br />
<br />
<input type="submit" value="検索">
</form>
<br />
    
    
キーワードを選んでください．<br />
<from method="post"action="">
種類
<?php pulldown_type();?>
サイズ
<?php pulldown_size();?>
<br />
<input type="submit" value="絞り込み">
</form>
<br />


<?php

//フリーキーワード
$keyword='';
if (isset($_POST['keyword'])){
     $keyword=$_POST['keyword'];
}
if($keyword!==''){
    print $keyword.'が含まれる商品';
    print '<br />';
}
//固定キーワード
$type='';
$siza='';
if(isset($_POST['type'])){
    $type=$_POST['type'];
    $size=$_POST['size'];         
}
if($type!==''){
    print $type.','.$size.',に一致する商品';
    print '<br />';        
}



while(true)
{
    $rec=$stmt->fetch(PDO::FETCH_ASSOC);
        $type2=$rec['type'];
        $size2=$rec['size'];
    if($rec==false)
    {
        break;
    }
        $disp=0;
    //キーワードが空,または，キーワードが含まれるとき表示
    if(($keyword==='')&&($type==='')){
        $disp=1;
    }
    else if (($keyword==='')&&(strpos($rec['name'],$keyword)!==false)){
        $disp=1;
    }
    else if(($keyword==='')&&((strpos($type2,$type)!==false)&&(strpos($size2,$size)!==false))){
         $disp=1;
    }
    
    if($disp===1){
        print '<a href="shop_product.php?procode='.$rec['code'].'">';
        print $rec['name'].'---';
        print $rec['price'].'円';
        print '</a>';
        print '<br />';
    }
}
?>

<?php

$key='';
if(isset($_POST['keyword'])){
 $key=$_POST['keyword'];
}
if($key!==''){
 print $key.'が含まれる商品';
}


while(true)
{
	$rec=$stmt->fetch(PDO::FETCH_ASSOC);
	if($rec==false)
	{
		break;
	}
	print '<a href="shop_product.php?procode='.$rec['code'].'">';
	print $rec['name'].'---';
	print $rec['price'].'円';
	print '</a>';
	print '<br />';
}

print '<br />';
print '<a href="shop_cartlook.php">カートを見る</a><br />';

}
catch (Exception $e)
{
	 print 'ただいま障害により大変ご迷惑をお掛けしております。';
	 exit();
}

?>

</body>
</html>