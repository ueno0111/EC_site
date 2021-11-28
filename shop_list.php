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
		print ' 様　';
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

		<link href="shop_list.css" rel="stylesheet">
		<link href="https://unpkg.com/sanitize.css" rel="stylesheet"/>
	</head>

	<body>

		<?php

		try
			{

			$dsn = 'mysql:dbname=takeshiueno_database1;host=mysql1.php.xdomain.ne.jp';//データベース接続
			$user = 'takeshiueno_0111';
			$password = '5050Rock';//データベースに接続します
			$dbh = new PDO($dsn,$user,$password);
			$dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

			$sql='SELECT code,name,price,gazou FROM mst_product WHERE 1';
			$stmt=$dbh->prepare($sql);
			$stmt->execute();

			$dbh=null;

			print '<div class="product">商品一覧</div>';

			
			while(true)
			{
				$rec=$stmt->fetch(PDO::FETCH_ASSOC);
				$pro_gazou=$rec['gazou'];
				if($rec==false)
				{
					break;
				}
				if($pro_gazou==""){//もしも画像のファイルがあれば表示のタグを準備
					$disp_gazou='';//空なら何も表示されない
				}else{
					$disp_gazou='<img src="./gazou/'.$pro_gazou.'">';
				}
	
				print '<a href="shop_product.php?procode='.$rec['code'].'">';
				print $rec['name'].'---';
				print $rec['price'].'円';
				print '<div class="gazou">'.$disp_gazou.'</div>';
				print '</a>';
				print '<br />';
			}

				print '<br />';
				print '<div class="cart">'.'<a href="shop_cartlook.php">カートを見る</a><br />'.'</div>';

			}
			catch (Exception $e)
			{
				print 'ただいま障害により大変ご迷惑をお掛けしております。';
				exit();
			}

		?>

	</body>
</html>