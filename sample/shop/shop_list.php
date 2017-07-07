<?php
session_start();
session_regenerate_id(true);
if(isset($_SESSION['member_login'])==false)
{
print 'ようこそゲスト様';
print '<a href="member_login.html">会員ログイン</a><br />';
print '<br />';
}
else
{
 print 'ようこそ';
 print $_SESSION['member_name'];
 print ' 様';
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



//商品データ
$sql='SELECT code,name,price,gazou FROM mst_product WHERE 1';
$stmt1=$dbh->prepare($sql);
$stmt1->execute();
$p_code=array();
$p_name=array();
$p_price=array();
$p_gazou=array();
$p_sum=array();
while(true)
{
 $rec=$stmt1->fetch(PDO::FETCH_ASSOC);
 if($rec==false)
 {
    break;
 }
 $p_code[]=$rec['code'];
 $p_name[]=$rec['name'];
 $p_price[]=$rec['price'];
 $p_sum[]=0;
 $p_gazou[]=$rec['gazou'];
}
$pro_num=count($p_code);

//注文データ
$sql='SELECT code,code_product,quantity FROM dat_sales_product WHERE 1';
$stmt2=$dbh->prepare($sql);
$stmt2->execute();
$s_code=array();
$s_pro_code=array();
$s_quantity=array();
while(true)
{
 $rec=$stmt2->fetch(PDO::FETCH_ASSOC);
 if($rec==false)
 {
 break;
 }
 $s_code[]=$rec['code'];
 $s_pro_code[]=$rec['code_product'];
 $s_quantity[]=$rec['quantity'];
}
$sales_num=count($s_code);

//DB切断
$dbh=null;

//集計
for ($i = 0; $i < $sales_num; $i++){
 for ($j = 0; $j < $pro_num; $j++){
    if($s_pro_code[$i]===$p_code[$j]){
    $p_sum[$j]=$p_sum[$j]+$s_quantity[$i];
    break;
  }
 }
}
=======
$sql='SELECT code,name,price,type,size FROM mst_product WHERE 1';
$stmt=$dbh->prepare($sql);
$stmt->execute();

$dbh=null;    

//売上1位
$key=key($p_sum);
print '注文数1位';
print '<a href="shop_product.php?procode='.$p_code[$key].'">';
print '<br />';

if($p_gazou[$key]=='')
{
	$disp_gazou='';
}
else
{
	$disp_gazou='<img src="../product/gazou/'.$p_gazou[$key].'">';
}
        print $disp_gazou;
        print '</a>';
        print '<br />';
print $p_name[$key].'---';
print $p_price[$key].'円';
print ' 注文数'.$p_sum[$key].'個';
print '<br /><br />';

//売上2位
next($p_sum);
$key=key($p_sum);
print '注文数2位';
print '<a href="shop_product.php?procode='.$p_code[$key].'">';
print '<br />';

if($p_gazou[$key]=='')
{
	$disp_gazou='';
}
else
{
	$disp_gazou='<img src="../product/gazou/'.$p_gazou[$key].'">';
}
        print $disp_gazou;
        print '</a>';
        print '<br />';
print $p_name[$key].'---';
print $p_price[$key].'円';
print ' 注文数'.$p_sum[$key].'個';
print '<br /><br />';
//売上3位
next($p_sum);
$key=key($p_sum);
print '注文数3位';
print '<a href="shop_product.php?procode='.$p_code[$key].'">';
print '<br />';

if($p_gazou[$key]=='')
{
	$disp_gazou='';
}
else
{
	$disp_gazou='<img src="../product/gazou/'.$p_gazou[$key].'">';
}
        print $disp_gazou;
        print '</a>';
        print '<br />';
print $p_name[$key].'---';
print $p_price[$key].'円';
print ' 注文数'.$p_sum[$key].'個';
print '<br /><br />';



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
<form method="post"action="">
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





?>



<form method="post" action="">
キーワード<br />
<input type="text" name="keyword" ><br />
<br />
<input type="submit" value="検索">
</form>




<?php

$key='';
if(isset($_POST['keyword'])){
  $key=$_POST['keyword'];
}
if($key!==''){
  print $key.'が含まれる商品';
  print'<br/>';
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
    else if (($type==='')&&(strpos($rec['name'],$keyword)!==false)){
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