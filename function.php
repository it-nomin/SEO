<?php
// title取得
function getPageTitle( $url ) {
    $html = @file_get_contents($url, false, stream_context_create(['http' => ['timeout' => 5]]));
    if ($html === false) {
        return '[取得失敗]';
    }
    $html = mb_convert_encoding($html, "UTF-8", "auto");
    if (preg_match("/<title>(.*?)<\/title>/i", $html, $matches)) {
        return trim($matches[1]);
    }
    return '[title未検出]';
}

// meta description取得（エラー対応）
function getMetaDescription( $url ) {
    $tags = @get_meta_tags($url);
    if ($tags === false || !isset($tags['description'])) {
        return '[未検出]';
    }
    return mb_convert_encoding($tags['description'], "UTF-8", "auto");
}

// canonical取得
function getCanonical( $url ) {
    $html = @file_get_contents($url, false, stream_context_create(['http' => ['timeout' => 5]]));
    if ($html === false) {
        return '[取得失敗]';
    }
    $html = mb_convert_encoding($html, "UTF-8", "auto");
    if (preg_match("/<link[^>]*rel=['\"]canonical['\"][^>]*href=['\"]([^'\"]+)['\"][^>]*>/i", $html, $matches) ||
        preg_match("/<link[^>]*href=['\"]([^'\"]+)['\"][^>]*rel=['\"]canonical['\"][^>]*>/i", $html, $matches)) {
        return trim($matches[1]);
    }
    return '[検出されず]';
}
?>
