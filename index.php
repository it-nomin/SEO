<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>title/description一括取得</title>
<style type="text/css">
<!--

.table {
width: auto;
border-collapse: collapse;
font-size: 12px;
width: 950px;
}

.table th {
border-width: 1px;
border-color: #000000;
border-style: solid;
background-color: #000000;
color: #FFFFFF;

}

.table td {
border-width: 1px;
border-color: #000000;
border-style: solid;
padding: 2px;
height: 45px;
width: 200px;
}

-->
</style>
</head>

<body>
<!-- Google Tag Manager -->
<noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-WRN2FZ"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-WRN2FZ');</script>
<!-- End Google Tag Manager -->

<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
	<textarea name="url" rows="10" cols="40"></textarea>
	<p><input type="submit" value="Check!"></p>
</form>


<?php
require_once 'function.php';

ini_set('display_errors', 'Off');	//Warning非表示処理
//もしもpost投稿があったら
if($_SERVER['REQUEST_METHOD'] == "POST"){
	$urls = $_POST['url'];      // テキストエリアの値を取得
	$cr = array("\r\n", "\r");   // 改行コード置換用配列を作成しておく
	$urls = trim($urls);         // 文頭文末の空白を削除

	// 改行コードを統一
	//str_replace ("検索文字列", "置換え文字列", "対象文字列");
	$urls = str_replace($cr, "\n", $urls);

	//改行コードで分割（結果は配列に入る）
	$lines_array = explode("\n", $urls);
}
?>


<table class="table">
		<tr>
			<th>URL</th>
			<th>title</th>
			<th>meta description</th>
		</tr>
<tbody>

 <?php

	foreach ($lines_array as $urls => $value) {
 	mb_language('japanese'); //言語を設定
 	$value = get_meta_tags($value);
 	$value = mb_convert_encoding($value['description'], "UTF-8","auto"); //description取得
	echo "<tr><td><a href=".$lines_array[$urls]." target='_blank' >".$lines_array[$urls]."</a></td>";//URL抽出してリンク設置
	echo "<td>".getPageTitle( $lines_array[$urls] )."</td>";
	echo "<td>".$value."</td></tr>";

	}
?>



</tbody>
</table>




</div>

</body>

</html>
