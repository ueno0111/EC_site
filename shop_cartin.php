<?php
	session_start();
	session_regenerate_id(true);
	if(isset($_SESSION['member_login'])==false)
	{
		print 'ようこそ'.'<span>ゲスト様</span>';
		print '<br />';
		print '<div class="login">'.'<a href="member_login.html">会員ログイン</a><br />'.'</div>';
	}
	else
	{
		print 'ようこそ';
		print '<span>'.$_SESSION['member_name'].'</span>';
		print '様　';
		print '<br />';
		print '<div class="logout">'.'<a href="member_logout.php">ログアウト</a><br />'.'</div>';
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

		<link href="shop_cartlin.css" rel="stylesheet">
		<link href="https://unpkg.com/sanitize.css" rel="stylesheet"/>
	</head>

	<body>

		<?php

		try
		{

		$pro_code=$_GET['procode'];

		if(isset($_SESSION['cart'])==true)
		{
			$cart=$_SESSION['cart'];
			$kazu=$_SESSION['kazu'];
			if(in_array($pro_code,$cart)==true){
				print '<div class="cartin">'.'その商品はすでにカートに入っています。'.'</div>';
				print '<div class="product">'.'<a href="shop_list.php">商品一覧に戻る</a>'.'</div>';
				exit();
			}
		}
		$cart[]=$pro_code;
		$kazu[]=1;
		$_SESSION['cart']=$cart;
		$_SESSION['kazu']=$kazu;

		}
		catch(Exception $e)
		{
			print 'ただいま障害により大変ご迷惑をお掛けしております。';
			exit();
		}

		?>

		<div class="cart">カートに追加しました。<br /></div>
		<br />
		<div class="product"><a href="shop_list.php">商品一覧に戻る</a></div>

	</body>
</html>