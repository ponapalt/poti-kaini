<?php
// redirect.php

// リクエストURIを取得
$request_uri = $_SERVER['REQUEST_URI'];

// /res/で始まるパスのパターンマッチング
if (preg_match('#^/res/(\d+)(?:-(\d+))?$#', $request_uri, $matches)) {
    $base_res = $matches[1];
    
    // XXX-YYYパターンの場合
    if (isset($matches[2])) {
        $target_res = $matches[2];
        $redirect_url = "https://oekaki.shillest.net/potiboard.php?res={$base_res}#{$base_res}-{$target_res}";
    } 
    // 単一レス番号の場合
    else {
        $redirect_url = "https://oekaki.shillest.net/potiboard.php?res={$base_res}";
    }
    
    // リダイレクト実行
    header("HTTP/1.1 301 Moved Permanently");
    header("Location: {$redirect_url}");
    exit();
}

// マッチしない場合は404を返す
header("HTTP/1.1 404 Not Found");
echo "404 Not Found";
?>