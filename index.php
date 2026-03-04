<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>title/description一括取得</title>
<style type="text/css">
body {
    font-family: Arial, sans-serif;
    padding: 20px;
}

form {
    margin-bottom: 20px;
}

textarea {
    width: 100%;
    max-width: 600px;
    font-family: monospace;
}

.table {
    width: auto;
    border-collapse: collapse;
    font-size: 12px;
    max-width: 1200px;
    margin-top: 20px;
}

.table th {
    border: 1px solid #000;
    background-color: #000;
    color: #FFF;
    padding: 8px;
    text-align: left;
}

.table td {
    border: 1px solid #000;
    padding: 8px;
    max-width: 300px;
    word-wrap: break-word;
}

.table a {
    color: #0066cc;
    text-decoration: none;
}

.table a:hover {
    text-decoration: underline;
}

.error {
    color: #d32f2f;
    font-weight: bold;
}

.success {
    color: #388e3c;
    font-weight: bold;
}
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

<h1>title/description/canonical一括取得ツール</h1>

<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'], ENT_QUOTES, 'UTF-8'); ?>" method="post">
    <label for="url">URLを入力（改行区切り）:</label><br>
    <textarea name="url" id="url" rows="10" cols="60" placeholder="https://example1.com&#10;https://example2.com"></textarea>
    <p><input type="submit" value="Check!"></p>
</form>

<?php
require_once 'function.php';

ini_set('display_errors', 'Off');

$lines_array = [];
$result_count = 0;

// POST投稿時の処理
if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['url']) && !empty(trim($_POST['url']))) {
    $urls = $_POST['url'];
    $cr = array("\r\n", "\r");
    $urls = trim($urls);
    $urls = str_replace($cr, "\n", $urls);
    $lines_array = array_filter(explode("\n", $urls), 'trim'); // 空行を除外
    $result_count = count($lines_array);
}
?>

<?php if (!empty($lines_array)): ?>
<p class="success">取得完了: <?php echo $result_count; ?>件</p>

<table class="table">
    <tr>
        <th>URL</th>
        <th>title</th>
        <th>meta description</th>
        <th>canonical</th>
    </tr>
    <tbody>
    <?php
    mb_language('japanese');
    foreach ($lines_array as $url) {
        $url = trim($url);
        if (empty($url)) continue;

        $title = getPageTitle($url);
        $description = getMetaDescription($url);
        $canonical = getCanonical($url);

        // XSS対策: htmlspecialcharsでエスケープ
        $safe_url = htmlspecialchars($url, ENT_QUOTES, 'UTF-8');
        $safe_title = htmlspecialchars($title, ENT_QUOTES, 'UTF-8');
        $safe_description = htmlspecialchars($description, ENT_QUOTES, 'UTF-8');
        $safe_canonical = htmlspecialchars($canonical, ENT_QUOTES, 'UTF-8');

        echo "<tr>";
        echo "<td><a href=\"" . $safe_url . "\" target='_blank'>" . $safe_url . "</a></td>";
        echo "<td>" . $safe_title . "</td>";
        echo "<td>" . $safe_description . "</td>";
        echo "<td>" . $safe_canonical . "</td>";
        echo "</tr>";
    }
    ?>
    </tbody>
</table>
<?php endif; ?>

</body>
</html>
