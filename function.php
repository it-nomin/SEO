<?php
//title取得
function getPageTitle( $url ) {
    $html = file_get_contents($url); //file_get_contents関数で指定されたURLからHTML文字列を取得
    $html = mb_convert_encoding($html,"UTF-8","auto"); //mb_convert_encoding関数で内部エンコーディングに指定している文字コードに変換
    if ( preg_match( "/<title>(.*?)<\/title>/i", $html, $matches) ) { //preg_match関数で正規表現を使ってtitleタグを抜き出す
        return $matches[1];
    } else {
        return false;
    }
}


//canonical取得





?>
