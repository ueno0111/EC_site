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

		<link href="shop_cartlook.css" rel="stylesheet">
		<link href="https://unpkg.com/sanitize.css" rel="stylesheet"/>
	</head>

	<body>

		<?php

		try
		{

		if(isset($_SESSION['cart'])==true)
		{
			$cart=$_SESSION['cart'];
			$kazu=$_SESSION['kazu'];
			$max=count($cart);
		}
		else
		{
			$max=0;
		}

		if($max==0)
		{
			print '<div class="nocart">'.'カートに商品が入っていません。<br />'.'</div>';
			print '<br />';
			print '<div class="product">'.'<a href="shop_list.php">商品一覧へ戻る</a>'.'</div>';
			exit();
		}

		$dsn = 'mysql:dbname=takeshiueno_database1;host=mysql1.php.xdomain.ne.jp';//データベース接続
		$user = 'takeshiueno_0111';
		$password = '5050Rock';//データベースに接続します
		$dbh = new PDO($dsn,$user,$password);
		$dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

		foreach($cart as $key=>$val)
		{
			$sql='SELECT code,name,price,gazou FROM mst_product WHERE code=?';
			$stmt=$dbh->prepare($sql);
			$data[0]=$val;
			$stmt->execute($data);

			$rec=$stmt->fetch(PDO::FETCH_ASSOC);

			$pro_name[]=$rec['name'];
			$pro_price[]=$rec['price'];
			if($rec['gazou']=='')
			{
				$pro_gazou[]='';
			}
			else
			{
				$pro_gazou[]='<img src="../product/gazou/'.$rec['gazou'].'">';
			}
		}
		$dbh=null;

		}
		catch(Exception $e)
		{
			print'ただいま障害により大変ご迷惑をお掛けしております。';
			exit();
		}

		?>

		<div class="cart_product">カートの中身<br /></div>
		<br />
		<form method="post" action="kazu_change.php">
		<table border="1">
		<tr>
		<td>商品</td>
		<td>商品画像</td>
		<td>価格</td>
		<td>数量</td>
		<td>小計</td>
		<td>削除</td>
		</tr>
		<?php for($i=0;$i<$max;$i++)
			{
		?>
		<tr>
			<td><?php print $pro_name[$i]; ?></td>
			<td><?php print $pro_gazou[$i]; ?></td>
			<td><?php print $pro_price[$i]; ?>円</td>
			<td><input type="text" name="kazu<?php print $i; ?>" value="<?php print $kazu[$i]; ?>"></td>
			<td><?php print $pro_price[$i]*$kazu[$i]; ?>円</td>
			<td><input type="checkbox" name="sakujo<?php print $i; ?>"></td>
		</tr>
		<?php
			}
		?>
		</table>
		<input type="hidden" name="max" value="<?php print $max; ?>">
		<div class="kazu"><input type="submit" value="数量変更"><br /></div>
		<div class="back"><input type="button" onclick="history.back()" value="戻る"></div>
		</form>
		<br />
		<div class="buy"><a href="shop_form.html">ご購入手続きへ進む</a><br /></div>
		<?php
			if(isset($_SESSION["member_login"])==true){
				print '<div class="order">'.'<a href="shop_kantan_check.php">会員かんたん注文へ進む</a><br/>'.'</div>';
			}
		?>
	</body>
</html>