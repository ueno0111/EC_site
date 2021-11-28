<?php
	session_start();
	session_regenerate_id(true);
	if(isset($_SESSION['member_login'])==false){
		print 'ログインされていません。';
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

		<link href="shop_kantan_done.css" rel="stylesheet">
		<link href="https://unpkg.com/sanitize.css" rel="stylesheet"/>
	</head>

	<body>

		<?php

		try
		{

		require_once('../common/common.php');

		$post=sanitize($_POST);

		$onamae=$post['onamae'];
		$email=$post['email'];
		$postal1=$post['postal1'];
		$postal2=$post['postal2'];
		$address=$post['address'];
		$tel=$post['tel'];

		print '<div class="name">'.'<span>'.$onamae.'</span>'.'様<br />'.'</div>';
		print '<div class="order">'.'ご注文ありがとうござました。<br />'.'</div>';
		print '<div class="email">'.'<span>'.$email.'</span>'.'にメールを送りました。'.'<br/>'.'ご確認ください。<br />'.'</div>';
		print '<div class="product">'.'以下の住所に発送いたします。<br />'.'</div>';
		print $postal1.'-'.$postal2.'<br />';
		print $address.'<br />';

		$honbun='';
		$honbun.=$onamae."様\n\nこのたびはご注文ありがとうございました。\n";
		$honbun.="\n";
		$honbun.="ご注文商品\n";
		$honbun.="--------------------\n";

		$cart=$_SESSION['cart'];
		$kazu=$_SESSION['kazu'];
		$max=count($cart);

		$dsn = 'mysql:dbname=takeshiueno_database1;host=mysql1.php.xdomain.ne.jp';//データベース接続
		$user = 'takeshiueno_0111';
		$password = '5050Rock';//データベースに接続します
		$dbh = new PDO($dsn,$user,$password);
		$dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

		for($i=0;$i<$max;$i++)
		{
			$sql='SELECT name,price FROM mst_product WHERE code=?';
			$stmt=$dbh->prepare($sql);
			$data[0]=$cart[$i];
			$stmt->execute($data);

			$rec=$stmt->fetch(PDO::FETCH_ASSOC);

			$name=$rec['name'];
			$price=$rec['price'];
			$kakaku[]=$price;
			$suryo=$kazu[$i];
			$shokei=$price*$suryo;

			$honbun.=$name.' ';
			$honbun.=$price.'円 x ';
			$honbun.=$suryo.'個 = ';
			$honbun.=$shokei."円\n";
		}

		$sql='LOCK TABLES dat_sales WRITE,dat_sales_product WRITE,dat_member WRITE';
		$stmt=$dbh->prepare($sql);
		$stmt->execute();


		//会員登録せずに注文
		$lastmembercode=$_SESSION['member_code'];
		if($chumon=='chumontouroku')
		{
			$sql='INSERT INTO dat_member (password,name,email,postal1,postal2,address,tel,danjo,born) VALUES (?,?,?,?,?,?,?,?,?)';
			$stmt=$dbh->prepare($sql);
			$data=array();
			$data[]=md5($pass);
			$data[]=$onamae;
			$data[]=$email;
			$data[]=$postal1;
			$data[]=$postal2;
			$data[]=$address;
			$data[]=$tel;
			if($danjo=='dan')
			{
				$data[]=1;
			}
			else
			{
				$data[]=2;
			}
			$data[]=$birth;
			$stmt->execute($data);

			$sql='SELECT LAST_INSERT_ID()';
			$stmt=$dbh->prepare($sql);
			$stmt->execute();
			$rec=$stmt->fetch(PDO::FETCH_ASSOC);
			$lastmembercode=$rec['LAST_INSERT_ID()'];
		}


		//会員登録して注文
		$sql='INSERT INTO dat_sales (code_member,name,email,postal1,postal2,address,tel) VALUES (?,?,?,?,?,?,?)';
		$stmt=$dbh->prepare($sql);
		$data=array();
		$data[]=$lastmembercode;
		$data[]=$onamae;
		$data[]=$email;
		$data[]=$postal1;
		$data[]=$postal2;
		$data[]=$address;
		$data[]=$tel;
		$stmt->execute($data);

		$sql='SELECT LAST_INSERT_ID()';
		$stmt=$dbh->prepare($sql);
		$stmt->execute();
		$rec=$stmt->fetch(PDO::FETCH_ASSOC);
		$lastcode=$rec['LAST_INSERT_ID()'];

		for($i=0;$i<$max;$i++)
		{
			$sql='INSERT INTO dat_sales_product (code_sales,code_product,price,quantity) VALUES (?,?,?,?)';
			$stmt=$dbh->prepare($sql);
			$data=array();
			$data[]=$lastcode;
			$data[]=$cart[$i];
			$data[]=$kakaku[$i];
			$data[]=$kazu[$i];
			$stmt->execute($data);
		}

		$sql='UNLOCK TABLES';
		$stmt=$dbh->prepare($sql);
		$stmt->execute();

		$dbh=null;
		if($chumon=='chumontouroku'){
			print '会員登録が完了致しました。';
			print '次回からメールアドレスとパスワードでログインしてくだい<br/>';
			print 'ご注文が簡単にできるようになります。<br/>';
			print '<br/>';
		}

		$honbun.="送料は無料です。\n";
		$honbun.="--------------------\n";
		$honbun.="\n";
		$honbun.="代金は以下の口座にお振込ください。\n";
		$honbun.="ろくまる銀行 やさい支店 普通口座 １２３４５６７\n";
		$honbun.="入金確認が取れ次第、梱包、発送させていただきます。\n";
		$honbun.="\n";

		if($chumon=='chumontouroku'){
			$honbun.="会員登録が完了いたしました。\n";
			$honbun.="次回からメールアドレスとパスワードでログインしてください。\n";
			$honbun.="ご注文が簡単にできるようになります。\n";
			$honbun.="\n";
		}

		$honbun.="□□□□□□□□□□□□□□\n";
		$honbun.="　～安心野菜のろくまる農園～\n";
		$honbun.="\n";
		$honbun.="○○県六丸郡六丸村123-4\n";
		$honbun.="電話 090-6060-xxxx\n";
		$honbun.="メール info@rokumarunouen.co.jp\n";
		$honbun.="□□□□□□□□□□□□□□\n";

		//print '<br/>';
		//print nl2br($honbun);


		//メールフォーム送信
		$title='ご注文ありがとうございます。';
		$header='From:info@rokumarunouen.co.jp';
		$honbun=html_entity_decode($honbun,ENT_QUOTES,'UTF-8');
		mb_language('Japanese');
		mb_internal_encoding('UTF-8');
		mb_send_mail($email,$title,$honbun,$header);

		$title='お客様からご注文がありました。';
		$header='From:'.$email;
		$honbun=html_entity_decode($honbun,ENT_QUOTES,'UTF-8');
		mb_language('Japanese');
		mb_internal_encoding('UTF-8');
		mb_send_mail('info@rokumarunouen.co.jp',$title,$honbun,$header);

		}
		catch (Exception $e)
		{
			print 'ただいま障害により大変ご迷惑をお掛けしております。';
			exit();
		}

		?>

		<br />
		<div class="back"><a href="shop_list.php">商品画面へ</a></div>

	</body>
</html>