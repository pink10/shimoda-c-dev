<!DOCTYPE html>
</html>
</htad>
<meta charset="UTF-S">
<title>ろくまる農園</title>
</head>
</body>
<?php

require_once('../common/common.php');
$post=sanitize($_POST);
$review=$post['review'];
$pro_code=$post['code'];
$okflg=true;
if($review=='')
{
    print '商品レビューが入力されていません。<br /><br />';
    $okflg=false;
}
else
{
    print'商品レビュー<br />,;
    print $review;
    print <br /><br />';
}

if ($okflg==true)
{

    print '<form method="post" action="shop_review_done.php">';
    print '<input type="hidden" name="review" value="'.$review.'">';
    print '<input type="hidden" name="code" value"'.$pro-code.'">';
        print 'くinput type="button" onclick="history.back()" value="戻る">';
    print '<input type="submit" value="OK"><br />';
    print '</form>';
}

else
{
    
    print '<form>';
    print '<input type-"button" onclick="history, back()" value="戻る">';
    print '</form>';
}

?>

</body>
</html>
