<?php
	session_start();
	session_regenerate_id(true);
	if(isset($_SESSION['member_login'])==false)
	{
		print 'ようこそ'.'<span>ゲスト様</span>';
		print '<div class="login">'.'<a href="member_login.html">会員ログイン</a><br />'.'</div>';
		print '<br />';
	}
	else
	{
		print 'ようこそ';
		print '<span>'.$_SESSION['member_name'].'</span>';
		print '様　';
		print '<div class="logout">'.'<a href="member_logout.php">ログアウト</a><br />'.'</div>';
		print '<br />';
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>でんぱ＠農業組合</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"><!--Bootstrap CSS  CDN読み込み-->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script><!--Google Hosted Libraries  GoogleのBootstrapCDNを使ったJSの読み込み-->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

		<script src="https://use.fontawesome.com/releases/v5.0.8/js/all.js"></script><!--SVG WEBサイトで使うWEBアイコンフォンtを表示する仕組み-->
		<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js'></script><!--無料のCDN、クラウドフレア、インターネットセキュリティ強化&閲覧の高速化-->

		<script type="text/javascript" src="./parallax.min.js"></script>
		<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/li00bs/lity/1.6.6/lity.css' /><!--セキュリティ-->
		<script src='https://cdnjs.cloudflare.com/ajax/libs/lity/1.6.6/lity.js'></script>

		<link href="shop_product.css" rel="stylesheet">
		<link href="https://unpkg.com/sanitize.css" rel="stylesheet"/>
	</head>
	<body>

	<?php

		try
		{

		$pro_code=$_GET['procode'];

		$dsn = 'mysql:dbname=takeshiueno_database1;host=mysql1.php.xdomain.ne.jp';//データベース接続
		$user = 'takeshiueno_0111';
		$password = '5050Rock';//データベースに接続します
		$dbh = new PDO($dsn,$user,$password);
		$dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

		$sql='SELECT name,price,gazou FROM mst_product WHERE code=?';
		$stmt=$dbh->prepare($sql);
		$data[]=$pro_code;
		$stmt->execute($data);

		$rec=$stmt->fetch(PDO::FETCH_ASSOC);
		$pro_name=$rec['name'];
		$pro_price=$rec['price'];
		$pro_gazou_name=$rec['gazou'];

		$dbh=null;

		if($pro_gazou_name=='')
		{
			$disp_gazou='';
		}
		else
		{
			$disp_gazou='<img src="../product/gazou/'.$pro_gazou_name.'">';
		}
		}
		catch(Exception $e)
		{
			print'ただいま障害により大変ご迷惑をお掛けしております。';
			exit();
		}

	?>

	<div class="product_info">商品情報参照<br /></div>
	<br />
	<div class="code">商品コード<br /></div>
	<?php print $pro_code; ?>
	<br />
	<div class="name">商品名<br /></div>
	<?php print $pro_name; ?>
	<br />
	<div class="price">価格<br /></div>
	<?php print $pro_price; ?>円
	<br />
	<?php print $disp_gazou; ?>
	<br />
	<br />
	<? print '<div class="cart">'.'<a href="shop_cartin.php?procode='.$pro_code.'">カートに入れる</a><br /><br />'.'</div>'; ?>
	<form>
		<input type="button" onclick="history.back()" value="戻る">
	</form>

	</body>
</html>