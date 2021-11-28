<?php
	session_start();
	session_regenerate_id(true);
	if(isset($_SESSION['member_login'])==false){
		print 'ログインできませんでした。<br/>';
		print '<a href="shop_list.php">商品一覧へ</a>';
		exit();
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

		<link href="shop_kantan_check.css" rel="stylesheet">
		<link href="https://unpkg.com/sanitize.css" rel="stylesheet"/>
	</head>

	<body>

		<?php

		$code=$_SESSION['member_code'];//会員登録した人のデータをとる

		$dsn = 'mysql:dbname=takeshiueno_database1;host=mysql1.php.xdomain.ne.jp';//データベース接続
		$user = 'takeshiueno_0111';
		$password = '5050Rock';//データベースに接続します
		$dbh = new PDO($dsn,$user,$password);
		$dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

		$sql='SELECT name,email,postal1,postal2,address,tel FROM dat_member WHERE code=?';
		$stmt=$dbh->prepare($sql);
		$data[]=$code;
		$stmt->execute($data);
		$rec=$stmt->fetch(PDO::FETCH_ASSOC);

		$dbh=null;

		$onamae=$rec['name'];
		$email=$rec['email'];
		$postal1=$rec['postal1'];
		$postal2=$rec['postal2'];
		$address=$rec['address'];
		$tel=$rec['tel'];

		print '<div class="item">'.'お名前<br/>'.'</div>';
		print $onamae;
		print '<br/><br/>';

		print '<div class="item">'.'メールアドレス<br/>'.'</div>';
		print $email;
		print '<br/><br/>';

		print '<div class="item">'.'郵便版号<br/>'.'</div>';
		print $postal1;
		print '-';
		print $postal2;
		print '<br/><br/>';

		print '<div class="item">'.'住所<br/>'.'</div>';
		print $address;
		print '<br/><br/>';

		print '<div class="item">'.'電話番号<br/>'.'</div>';
		print $tel;
		print '<br/><br/>';

			print '<form method="post" action="shop_kantan_done.php">';
			print '<input type="hidden" name="onamae" value="'.$onamae.'">';
			print '<input type="hidden" name="email" value="'.$email.'">';
			print '<input type="hidden" name="postal1" value="'.$postal1.'">';
			print '<input type="hidden" name="postal2" value="'.$postal2.'">';
			print '<input type="hidden" name="address" value="'.$address.'">';
			print '<input type="hidden" name="tel" value="'.$tel.'">';
			print '<input type="hidden" name="chumon" value="'.$chumon.'">';
			print '<input type="button" onclick="history.back()" value="戻る">';
			print '<input type="submit" value="ＯＫ"><br />';
			print '</form>';
		?>

	</body>
</html>