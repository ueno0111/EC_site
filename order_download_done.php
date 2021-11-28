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
		print '<span class="staff_name">'. $_SESSION['staff_name'].'</span>';
		print 'さんログイン中<br />';
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

		<link href="order_download_done.css" rel="stylesheet">
		<link href="https://unpkg.com/sanitize.css" rel="stylesheet"/>
	</head>

	<body>

		<?php

		try
		{

			$year=$_POST['year'];
			$month=$_POST['month'];
			$day=$POST['day'];

			$dsn = 'mysql:dbname=takeshiueno_database1;host=mysql1.php.xdomain.ne.jp';
			$user = 'takeshiueno_0111';
			$password = '5050Rock';//データベースに接続します
			$dbh = new PDO($dsn,$user,$password);
			$dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

			$sql='
			SELECT
				dat_sales.code,
				dat_sales.date,
				dat_sales.code_member,
				dat_sales.name AS dat_sales_name,
				dat_sales.email,
				dat_sales.postal1,
				dat_sales.postal2,
				dat_sales.address,
				dat_sales.tel,
				dat_sales_product.code_product,
				mst_product.name AS mst_product_name,
				dat_sales_product.price,
				dat_sales_product.quantity
			FROM
				dat_sales,dat_sales_product,mst_product
			WHERE
				dat_sales.code=dat_sales_product.code_sales
				AND dat_sales_product.code_product=mst_product.code
				AND substr(dat_sales.date,1,4)="2021"
				AND substr(dat_sales.date,6,2)="11"
				AND substr(dat_sales.date,9,2)="02"
			';
			$stmt=$dbh->prepare($sql);
			$data[]=$year;
			$data[]=$month;
			$data[]=$day;
			$stmt->execute($data);

			$dbh=null;

			$csv='注文コード、注文日時、会員番号、お名前、メール、郵便番号、住所、TEL、商品コード、商品名、価格、数量';
			$csv.="\n";
			while(true)
			{
				$rec=$stmt->fetch(PDO::FETCH_ASSOC);
				if($rec==false)
				{
					break;
				}
				$csv.=$rec['code'];
				$csv.=',';
				$csv.=$rec['date'];
				$csv.=',';
				$csv.=$rec['code_member'];
				$csv.=',';
				$csv.=$rec['dat_sales_name'];
				$csv.=',';
				$csv.=$rec['email'];
				$csv.=',';
				$csv.=$rec['postal1'].'-'.$rec['postal2'];
				$csv.=',';
				$csv.=$rec['address'];
				$csv.=',';
				$csv.=$rec['tel'];
				$csv.=',';
				$csv.=$rec['code_product'];
				$csv.=',';
				$csv.=$rec['mst_product_name'];
				$csv.=',';
				$csv.=$rec['price'];
				$csv.=',';
				$csv.=$rec['quantity'];
				$csv.="\n";
			}
			//print nl2br($csv);
			$file = fopen('./chumon.csv','w');//同じフォルダ内に書き込みモードで開く
			$csv = mb_convert_encoding($csv,'SJIS','UTF-8');//文字コードをShift→JISに変換。
			fputs($file,$csv);//ファイルを書き込み
			fclose($file);//ファイルを閉じる

			}
			catch (Exception $e)
			{
				print 'ただいま障害により大変ご迷惑をお掛けしております。';
				exit();
			}

		?>

		<div class="download">注文データダウンロード</div><br />
		<br />
		<a href="chumon.csv">ダウンロード</a><br />
		<br/>
		<a href="order_download.php">日付選択へ</a><br/>
		<br/>
		<div class="top"><a href="../staff_login/staff_top.php">トップメニューへ</a><br/></div>

	</body>
</html>