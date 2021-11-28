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

		<link href="shop_form_check.css" rel="stylesheet">
		<link href="https://unpkg.com/sanitize.css" rel="stylesheet"/>
	</head>

	<body>

		<?php

		require_once('../common/common.php');

		$post=sanitize($_POST);

		$onamae=$_POST['onamae'];
		$email=$_POST['email'];
		$postal1=$_POST['postal1'];
		$postal2=$_POST['postal2'];
		$address=$_POST['address'];
		$tel=$_POST['tel'];
		$chumon=$_POST['chumon'];
		$pass=$_POST['pass'];
		$pass2=$_POST['pass2'];
		$danjo=$_POST['danjo'];
		$birth=$_POST['birth'];

		$okflg=true;

		if($onamae=='')
		{
			print '<div class="item2">'.'お名前が入力されていません。'.'</div>';
			$okflg=false;
		}
		else
		{
			print '<div class="item">'.'お名前<br />'.'</div>';
			print $onamae;
			print '<br /><br />';
		}

		if(preg_match('/\A[\w\-\.]+\@[\w\-\.]+\.([a-z]+)\z/',$email)==0)
		{
			print '<div class="item2">'.'メールアドレスを正確に入力してください。'.'</div>';
			$okflg=false;
		}
		else
		{
			print '<div class="item">'.'メールアドレス<br />'.'</div>';
			print $email;
			print '<br /><br />';
		}

		if(preg_match('/\A[0-9]+\z/',$postal1)==0)
		{
			print '<div class="item2">'.'郵便番号は半角数字で入力してください。'.'</div>';
			$okflg=false;
		}
		else
		{
			print '<div class="item">'.'郵便番号<br />'.'</div>';
			print $postal1;
			print '-';
			print $postal2;
			print '<br /><br />';
		}

		if(preg_match('/\A[0-9]+\z/',$postal2)==0)
		{
			print '<div class="item2">'.'郵便番号は半角数字で入力してください。'.'</div>';
			$okflg=false;
		}

		if($address=='')
		{
			print '<div class="item2">'.'住所が入力されていません。'.'</div>';
			$okflg=false;
		}
		else
		{
			print '<div class="item">'.'住所<br />'.'</div>';
			print $address;
			print '<br /><br />';
		}

		if(preg_match('/\A\d{2,5}-?\d{2,5}-?\d{4,5}\z/',$tel)==0)
		{
			print '<div class="item2">'.'電話番号を正確に入力してください。'.'</div>';
			$okflg=false;
		}
		else
		{
			print '<div class="item">'.'電話番号<br />'.'</div>';
			print $tel;
			print '<br /><br />';
		}

		if($chumon=='chumontouroku')
		{
			if($pass=='')
			{
				print '<div class="item2">'.'パスワードが入力されていません。'.'</div>';
				$okflg=false;
			}

			if($pass!=$pass2)
			{
				print '<div class="item2">'.'パスワードが一致しません。'.'</div>';
				$okflg=false;
			}

			print '<div class="item">'.'性別<br />'.'</div>';
			if($danjo=='dan')
			{
				print '男性';
			}
			else
			{
				print '女性';
			}
			print '<br /><br />';

			print '<div class="item">'.'生年月日<br />'.'</div>';
			print $birth;
			print '年代';
			print '<br /><br />';

		}

		if($okflg==true)
		{
			print '<form method="post" action="shop_form_done.php">';
			print '<input type="hidden" name="onamae" value="'.$onamae.'">';
			print '<input type="hidden" name="email" value="'.$email.'">';
			print '<input type="hidden" name="postal1" value="'.$postal1.'">';
			print '<input type="hidden" name="postal2" value="'.$postal2.'">';
			print '<input type="hidden" name="address" value="'.$address.'">';
			print '<input type="hidden" name="tel" value="'.$tel.'">';
			print '<input type="hidden" name="chumon" value="'.$chumon.'">';
			print '<input type="hidden" name="pass" value="'.$pass.'">';
			print '<input type="hidden" name="danjo" value="'.$danjo.'">';
			print '<input type="hidden" name="birth" value="'.$birth.'">';
			print '<input type="button" onclick="history.back()" value="戻る">';
			print '<input type="submit" value="ＯＫ"><br />';
			print '</form>';
		}
		else
		{
			print '<form>';
			print '<input type="button" onclick="history.back()" value="戻る">';
			print '</form>';
		}

		?>

	</body>
</html>