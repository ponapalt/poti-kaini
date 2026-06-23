<?php
// POTI-board EVO  投稿ログ RSS 出力スクリプト
// potirss.php

// ---- フィードに出す最大件数 ----
const POTIRSS_MAX_ITEMS = 30;

// ---- 設定ファイル読み込み（ROOT_URL / TITLE / LOGFILE 等を流用） ----
if (!is_file(__DIR__ . '/config.php')) {
	header('Content-Type: text/plain; charset=UTF-8');
	die('config.php not found.');
}
require_once(__DIR__ . '/config.php');

// ---- タイムゾーン ----
defined('DEFAULT_TIMEZONE') or define('DEFAULT_TIMEZONE', 'Asia/Tokyo');
date_default_timezone_set(DEFAULT_TIMEZONE);

// ---- 各種URLの組み立て ----
$root     = rtrim(ROOT_URL, '/') . '/';   // 設置場所URL（末尾スラッシュ保証）
$self_url = $root . PHP_SELF;             // 掲示板本体URL
$feed_url = $root . basename(__FILE__);   // このフィード自身のURL

/**
 * 拡張子から MIME タイプを返す
 */
function potirss_mime(string $ext): string {
	switch (strtolower($ext)) {
		case '.jpg':
		case '.jpeg': return 'image/jpeg';
		case '.png':  return 'image/png';
		case '.gif':  return 'image/gif';
		case '.webp': return 'image/webp';
		default:      return '';
	}
}

/**
 * ログ格納文字列をプレーンテキストに戻す
 *   &#44; → カンマ、<br> → 改行、タグ除去、HTMLエンティティ復号
 */
function potirss_plain(?string $s): string {
	$s = (string)$s;
	$s = str_replace('&#44;', ',', $s);
	$s = preg_replace('#<br\s*/?>#i', "\n", $s);
	$s = strip_tags($s);
	return html_entity_decode($s, ENT_QUOTES, 'UTF-8');
}

/**
 * XML（要素値・属性値）用エスケープ
 */
function potirss_xe(?string $s): string {
	return htmlspecialchars((string)$s, ENT_QUOTES | ENT_XML1, 'UTF-8');
}

/**
 * UNIXタイムを取り出す（potiboard.php の microtime2time 相当）
 */
function potirss_unixtime(string $microtime, string $logver): int {
	if ($logver === '6') {
		$t = substr($microtime, 0, -3);
	} else {
		$t = (strlen($microtime) > 12) ? substr($microtime, -13, -3) : $microtime;
	}
	return ctype_digit($t) ? (int)$t : 0;
}

// ---- tree.log から「レスNo → 親スレNo」マップを作成 ----
$parent_of = [];
if (is_file(TREEFILE)) {
	$tree_lines = file(TREEFILE, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
	foreach ($tree_lines as $tline) {
		$nos = explode(',', trim($tline));
		$oya = $nos[0];
		foreach ($nos as $n) {
			if ($n !== '') {
				$parent_of[$n] = $oya;
			}
		}
	}
}

// ---- img.log を新しい順に読み込み、上位 POTIRSS_MAX_ITEMS 件を採用 ----
$items = [];
if (is_file(LOGFILE) && ($fp = fopen(LOGFILE, 'r'))) {
	while (($line = fgets($fp)) !== false) {
		if (!trim($line)) {
			continue;
		}
		// 20フィールド固定。不足分は空文字で補完
		$f = array_pad(explode(',', rtrim($line, "\r\n")), 20, '');
		list($no, $date, $name, $email, $sub, $com, $url, $host, $pass,
			$ext, $w, $h, $time, $chk, $ptime, $fcolor, $pchext, $thumbnail, $tool, $logver) = $f;

		// 記事Noが数字でない行（破損行）はスキップ
		if (!ctype_digit((string)$no)) {
			continue;
		}
		// 削除済み（中身が空）の行はスキップ
		if ($name === '' && $email === '' && $url === '' && $com === '' && $ext === '') {
			continue;
		}

		// スレッド親Noを引いてリンクを組む（レスは ?res=親#No）
		$oya  = $parent_of[$no] ?? $no;
		$link = $self_url . '?res=' . rawurlencode($oya) . '#' . rawurlencode($no);

		// 投稿日時
		$utime = potirss_unixtime((string)$time, (string)$logver);

		// 画像（サムネイルがあればそれを表示用に、enclosure は本画像）
		$img_url   = '';   // 本画像URL
		$disp_url  = '';   // 表示用（サムネ優先）URL
		$enc_type  = '';   // enclosure MIME
		$enc_len   = 0;    // enclosure ファイルサイズ
		if ($ext !== '') {
			$img_path = __DIR__ . '/' . IMG_DIR . $time . $ext;
			if (is_file($img_path)) {
				$img_url  = $root . IMG_DIR . $time . $ext;
				$enc_type = potirss_mime($ext);
				$enc_len  = (int)filesize($img_path);

				// サムネイル判定（logver 6 は thumbnail フラグ、旧版は実ファイル存在）
				$has_thumb = ($logver === '6')
					? ($thumbnail === 'thumbnail')
					: is_file(THUMB_DIR . $time . 's.jpg');
				$disp_url = ($has_thumb && is_file(__DIR__ . '/' . THUMB_DIR . $time . 's.jpg'))
					? $root . THUMB_DIR . $time . 's.jpg'
					: $img_url;
			}
		}

		// タイトル（題名 ＋ 投稿者名）
		$plain_sub  = potirss_plain($sub);
		$plain_name = potirss_plain($name);
		if ($plain_sub === '') {
			$plain_sub = '無題';
		}
		$title = 'No.' . $no . ' ' . $plain_sub;
		if ($plain_name !== '') {
			$title .= ' / ' . $plain_name;
		}

		// 説明（サムネイル＋本文HTML。CDATAで包む）
		$desc = '';
		if ($disp_url !== '') {
			$desc .= '<a href="' . $link . '"><img src="' . $disp_url . '" alt="" border="0" /></a><br />';
		}
		// com はログ内で既にエスケープ済み＝安全なHTML（<br />のみ実タグ）
		$desc .= str_replace('&#44;', ',', (string)$com);
		// CDATA 終端記号の混入を無害化
		$desc = str_replace(']]>', ']]&gt;', $desc);

		$items[] = [
			'no'       => $no,
			'title'    => $title,
			'link'     => $link,
			'desc'     => $desc,
			'utime'    => $utime,
			'img_url'  => $img_url,
			'enc_type' => $enc_type,
			'enc_len'  => $enc_len,
		];

		if (count($items) >= POTIRSS_MAX_ITEMS) {
			break;
		}
	}
	fclose($fp);
}

// ---- チャンネルの更新日時（最新記事 or 現在時刻） ----
$last_time = !empty($items) ? $items[0]['utime'] : time();
if (!$last_time) {
	$last_time = time();
}

// ---- RSS 2.0 出力 ----
header('Content-Type: application/rss+xml; charset=UTF-8');

echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
?>
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
<channel>
	<title><?php echo potirss_xe(TITLE); ?></title>
	<link><?php echo potirss_xe($self_url); ?></link>
	<atom:link href="<?php echo potirss_xe($feed_url); ?>" rel="self" type="application/rss+xml" />
	<description><?php echo potirss_xe(TITLE . ' の投稿ログ'); ?></description>
	<language>ja</language>
	<lastBuildDate><?php echo date(DATE_RSS, $last_time); ?></lastBuildDate>
	<pubDate><?php echo date(DATE_RSS, $last_time); ?></pubDate>
	<generator>POTI-board EVO potirss.php</generator>
<?php foreach ($items as $it): ?>
	<item>
		<title><?php echo potirss_xe($it['title']); ?></title>
		<link><?php echo potirss_xe($it['link']); ?></link>
		<guid isPermaLink="true"><?php echo potirss_xe($it['link']); ?></guid>
<?php if ($it['utime']): ?>
		<pubDate><?php echo date(DATE_RSS, $it['utime']); ?></pubDate>
<?php endif; ?>
<?php if ($it['img_url'] !== '' && $it['enc_type'] !== ''): ?>
		<enclosure url="<?php echo potirss_xe($it['img_url']); ?>" type="<?php echo potirss_xe($it['enc_type']); ?>" length="<?php echo $it['enc_len']; ?>" />
<?php endif; ?>
		<description><![CDATA[<?php echo $it['desc']; ?>]]></description>
	</item>
<?php endforeach; ?>
</channel>
</rss>
