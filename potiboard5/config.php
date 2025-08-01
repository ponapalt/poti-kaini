<?php
/*
  * POTI-board EVO v6.77.1 lot.20250530
  * by POTI-board redevelopment team >> https://paintbbs.sakura.ne.jp/poti/
  *
  * POTI-board EVO の設定ファイルです。
  *
*/
/* ---------- 最初に設定する項目 ---------- */
//管理者パスワード
//必ず変更してください。
//$ADMIN_PASS = 'kanripass';

//最大ログ数
//古いログから順番に消えます(最低1000)
define('LOG_MAX', '50000');

//テーマ(テンプレート)のディレクトリ。"/"まで
//テンプレートが入っているディレクトリを指定してください。
//例えば｢MONO｣を使いたい場合は mono/ 、｢BASIC｣を使いたい時は basic/ とします。
//初期値は basic/ です。

// define('SKIN_DIR', 'basic/');

define('SKIN_DIR', 'mono/');

//メール通知のほか、シェアボタンなどで使用
//設置場所のURL。phpのあるディレクトリの'/'まで
define('ROOT_URL', 'https://oekaki.shillest.net/');


//掲示板のタイトルタイトル（<title>とTOP）
define('TITLE', '伺的お絵かき/投稿集会所');

//「ホーム」へのリンク
// 自分のサイトにお絵かき掲示板がある、という慣習からのものです。
// 自分のサイトのURL（絶対パスも可）をどうぞ。
define("HOME", "../");

//画像アップロード機能を 使う:1 使わない:0
define("USE_IMG_UPLOAD","1");
//使わない:0 でも 管理画面で画像アップロードできます。
//使わない:0 でも お絵かき機能は使えます。

//画像のないコメントのみの新規投稿を拒否する する:1 しない:0
define("DENY_COMMENTS_ONLY", "0");
//する:1 でも管理者はコメントのみの投稿ができます。

//PaintBBS NEOを使う 使う:1 使わない:0 
define("USE_PAINTBBS_NEO", "1");
//しぃペインターを使う 使う:1 使わない:0 
define("USE_SHI_PAINTER", "1");
//ChickenPaintを使う 使う:1 使わない:0 
define("USE_CHICKENPAINT", "1");
//Tegakiを使う 使う:1 使わない:0 
define("USE_TEGAKI", "1");
//Axnos Paintを使う 使う:1 使わない:0 
define("USE_AXNOS", "1");
//klecksを使う 使う:1 使わない:0 
define("USE_KLECKS", "1");
//管理者は設定に関わらすべてのアプリを使用できるようにする する:1 しない:0
define('ALLOW_ADMINS_TO_USE_ALL_APPS_REGARDLESS_OF_SETTINGS', '1');
//続きを描く時は設定に関わらずすべてのアプリが使用できるようにする する:1 しない:0
define('ALLOW_ALL_APPS_TO_CONTINUE_DRAWING', '0');

/*----------絶対に設定が必要な項目はここまでです。ここから下は必要に応じて。----------*/

/* ------------- タイムゾーン ------------- */

define("DEFAULT_TIMEZONE","Asia/Tokyo");

/* ---------- SNS連携 ---------- */

//シェアボタンを表示する する:1 しない:0
//対応テンプレートが必要
//設置場所のURL ROOT_URL で設定したurlをもとにリンクを作成
define("SHARE_BUTTON", "1");

/* ---------- スパム対策 ---------- */

//正規表現を使うことができます
//全角半角スペース改行を考慮する必要はありません
//スペースと改行を除去した文字列をチェックします

//設定しないなら 
// array();

//拒絶する文字列
$badstring = array("irc.s16.xrea.com","未承諾広告");

//拒絶するurl
$badurl = array("example.com","www.example.com");

//使用できない名前
$badname = array("ブランド","通販","販売","口コミ");

//初期設定では「"通販"を含む名前」の投稿を拒絶します
//ここで設定したNGワードが有効になるのは「名前」だけです
//本文に「通販で買いました」と書いて投稿する事はできます

//名前以外の項目も設定する場合は
//こことは別の設定項目
//拒絶する文字列で

//AとBが両方あったら拒絶。
$badstr_A = array("激安","低価","コピー","品質を?重視","大量入荷");
$badstr_B = array("シャネル","シュプリーム","バレンシアガ","ブランド");

//AとBの単語が2つあったら拒絶します。
//初期設定では「ブランド品のコピー」という投稿を拒絶します。
//1つの単語では拒絶されないので「コピー」のみ「ブランド」のみの投稿はできます。

//一つの単語で拒絶する場合は
//こことは別の設定項目
//拒絶する文字列で

//本文に日本語がなければ拒絶
define("USE_JAPANESEFILTER", "1");

//本文へのURLの書き込みを禁止する する:1 しない:0
//管理者は設定にかかわらず許可
define("DENY_COMMENTS_URL", "0");

//URL入力欄を使用する する:1 しない:0
define("USE_URL_INPUT_FIELD", "1");
//しない:0 で、フォームの入力欄からURL欄が消えます。
//フォームを偽装してもURLの入力ができなくなります。

//指定した日数を過ぎたスレッドのフォームを閉じる
//define("ELAPSED_DAYS","0");
//設定しないなら "0"で。フォームを閉じません。
//define("ELAPSED_DAYS","365");
//	↑ 365日
//で1年以上経過したスレッドに返信できなくなります。
define("ELAPSED_DAYS","365");

//拒絶する画像のハッシュ値
$badfile = array("dummyhash","dummyhash2");

//拒絶するホスト
$badip = array("addr.dummy.com","addr2.dummy.com");

//ホスト名が逆引きできないIPアドレスからの投稿を拒絶する
//する:1 しない:0
define("REJECT_IF_NO_REVERSE_DNS", "0");

// ※逆引きできないIPアドレスの利用者も多いため、"1" にすると一部の正当なユーザーが投稿できなくなる可能性があります。

//禁止ホストからのアクセスがあった時は、SESSIONにキャッシュする
//する:1 しない:0
define("USE_BADHOST_SESSION_CACHE", "0");

// ※禁止ホスト判定をセッションに保存します。
// 禁止ホスト判定されるとブラウザを再起動するまで解除されません。

/* ---------- メール通知設定 ---------- */
// メール通知機能を使う使わないを設定する項目はここにはありません。
//noticemail.inc を potiboard.php と同じディレクトリにアップロードすると
//メール通知機能が自動的にオンになります。

//管理者が投稿したものもメールで通知 しない:1 する:0
define("NOTICE_NOADMIN", "0");

//メール通知先
define("TO_MAIL", "xxx@example.com");

//メール通知に本文を付ける 付ける:1 付けない:0
define("SEND_COM", "1");

/* ---------- メイン設定 ---------- */
//名前の制限文字数。半角で
define("MAX_NAME", "100");

//メールアドレスの制限文字数。半角で
define("MAX_EMAIL", "100");

//題名の制限文字数。半角で
define("MAX_SUB", "100");

//本文の制限文字数。半角で
define("MAX_COM", "1000");

//一ページに表示する記事
define("PAGE_DEF", "10");

// カタログモードの時の1ページに表示する画像
define("CATALOG_PAGE_DEF", "30");

//1スレ内のレス表示件数(0で全件表示)
//レスがこの値より多いと古いレスから省略されます
//返信画面で全件表示されます
define("DSP_RES", "7");

//文字色選択を使用する する:1 しない:0
//要対応テーマ
define("USE_FONTCOLOR", "0");

//投稿容量制限 KB
//PNG形式の画像をJPEGに変換する事でこの制限を回避できる場合はJPEGに変換します
define("MAX_KB", "2048");

//表示する最大サイズ（これ以上はサムネイルまたは縮小表示
define("MAX_W", "600");	//幅
define("MAX_H", "600");	//高さ

//アップロード時の幅と高さの最大サイズ これ以上は縮小
define("MAX_W_PX", "1024"); //幅
define("MAX_H_PX", "1024"); //高さ

//レスで画像貼りを許可する する:1 しない:0
//※お絵かきも連動
define("RES_UPLOAD", "1");

//レスの時に表示する最大サイズ（これ以上はサムネイルまたは縮小表示
define("MAX_RESW", "400");	//幅
define("MAX_RESH", "400");	//高さ

//IDを表示する する:1 しない:0
define("DISP_ID", "1");

//URLを自動リンクする する:1 しない:0
define("AUTOLINK", "1");
//マークダウン記法でリンクする する:1 しない:0
define("MD_LINK", "0");


//名前を必須にする する:1 しない:0
define("USE_NAME", "0");
define("DEF_NAME", "名無しさん");	//未入力時の名前

//本文を必須にする する:1 しない:0
define("USE_COM", "0");
define("DEF_COM", "本文無し");	//未入力時の本文

//題名を必須にする する:1 しない:0
define("USE_SUB", "0");
define("DEF_SUB", "無題");	//未入力時の題名

//レス時にスレ題名を引用する する:1 しない:0
define("USE_RESUB", "1");

//編集しても投稿日時を変更しないようにする する:1 しない:0 
define("DO_NOT_CHANGE_POSTS_TIME", "0");
//する:1 にすると投稿を編集しても投稿日時は変更されず最初の投稿日時のままになります。
//編集マークも付きません。

//レス画面に前後のスレッドの画像を表示する する:1 しない:0
define("VIEW_OTHER_WORKS", "1");

//管理画面へのリンクを表示する する:1 しない:0
define("USE_ADMIN_LINK", "1");
//しない:0 で、管理画面へのリンクが表示されなくなります。

/* ---------- お絵かき設定 ---------- */

//お絵かき機能を使用する する:1 しない:0
define("USE_PAINT", "1");

//お絵描き最小サイズ（これ以下は強制でこの値
define("PMIN_W", "300");	//幅
define("PMIN_H", "300");	//高さ

//お絵描き最大サイズ（これ以上は強制でこの値
define('PMAX_W', '1000');	//幅
define('PMAX_H', '1000');	//高さ

//お絵描きデフォルトサイズ
define("PDEF_W", "300");	//幅
define("PDEF_H", "300");	//高さ

//描画時間の表示 する:1 しない:0
define("DSP_PAINTTIME", "1");

//パレットデータファイル名
define("PALETTEFILE", "palette.txt");

//パレットデータファイル切り替え機能を使用する する:1 しない:0 
//切り替えるパレットデータファイルが用意できない場合は しない:0。
define("USE_SELECT_PALETTES", "0");
//要対応テーマ

//パレットデータファイル切り替え機能を使用する する:1 の時のパレットデーターファイル名
//初期パレットpalette.txtとやこうさんパレットpalette.datを切り替えて使う時
//↓
$pallets_dat=array(["標準","palette.txt"],["プロ","palette.dat"]);
// ["パレット名","ファイル名"]でひとつ。それをコンマで区切ります。
//パレット名とファイル名は""で囲ってください。
//設定例
//$pallets_dat=array(["パレット1","1.txt"],["パレット2","2.txt"],["パレット3","3.txt"]);

//動画機能を使用する する:1 しない:0
define("USE_ANIME", "1");

//動画記録デフォルトスイッチ ON:1 OFF:0
define("DEF_ANIME", "1");

//動画再生スピード 超高速:-1 高速:0 中速:10 低速:100 超低速:1000
define("PCH_SPEED", "0");

//コンティニューを使用する する:1 しない:0
define("USE_CONTINUE", "1");

//新規投稿でコンティニューする時にも削除キーが必要 必要:1 不要:0
//不要:0 で新規投稿なら誰でも続きを描く事ができるようになります。
define("CONTINUE_PASS", "0");

/* ---------- 詳細設定 ---------- */

// このスクリプト名。変更することをおすすめしません。
define("PHP_SELF", "potiboard.php");

// ログファイル名
define("LOGFILE", "img.log");
define("TREEFILE", "tree.log");

//画像保存ディレクトリ。
define("IMG_DIR", "src/");
//サムネイル保存ディレクトリ
define("THUMB_DIR", "thumb/");
//テンポラリディレクトリ
define("TEMP_DIR", "tmp/");
//動画(PCH)保存ディレクトリ
define("PCH_DIR", "src/");
//入り口ファイル名
define("PHP_SELF2", "index.html");
//1ページ以降の拡張子
define("PHP_EXT", ".html");

//サムネイルを作成する する:1 しない:0
define("USE_THUMB", "1");
//サムネイルのJPEG劣化率
define("THUMB_Q", "92");
//クッキー保存日数
define("SAVE_COOKIE", "30");
//連続投稿秒数
define("RENZOKU", "10");
//画像連続投稿秒数
define("RENZOKU2", "20");
//強制sageレス数( 0 ですべてsage)
define("MAX_RES", "20");
//ID生成の種
define("ID_SEED", "IDの種");
//そろそろ消える表示のボーダー。最大ログ数からみたパーセンテージ
define("LOG_LIMIT", "92");

//[新規投稿は管理者のみ]にする する:1 しない:0
//する(1)にした場合、管理者パス以外での新規投稿はできません
define("DIARY", "0");

//アップロードしたPNG画像のファイルサイズが設定値より大きな時はJPEGに変換
//JPEGに変換した画像ともとのPNG画像を比較してファイルサイズが小さなほうを投稿します
//単位kb
define("IMAGE_SIZE", "512");

//ログファイルのファイルサイズの制限値(単位MB)
//大きな値を設定すると動作が不安定になる可能性があります。
define("MAX_LOG_FILESIZE", "15");

//フォーム下の追加お知らせ
//(例)"<li>お知らせデース</li>
//     <li>サーバの規約でアダルト禁止</li>"
//要対応テーマ
$addinfo='<li style="color: red;"><span style="font-weight: bold;">注意：</span>投稿や「お絵かき」時にパスワードダイアログが出ます。ID=sakura / パスワード=unyu を入力してください。</li>';

// 連続・二重投稿対象セキュリティレベル
// ※連続・二重投稿チェック対象を決める条件
// 0:最低　…　チェックしない
// 1:低　　…　ホストが同じログの場合(従来の条件)
// 2:中　　…　低レベルの条件に加え、名前・メールアドレス・URL・題名のいずれかが同じ場合
// 3:高　　…　低レベルの条件に加え、名前・メールアドレス・URL・題名のいずれかが類似率を上回る場合
// 4:最高　…　無条件でチェック。最新ログ20件と連続・二重投稿チェックする事になる
// ※中・高レベルのとき、未入力項目は無視
define("POST_CHECKLEVEL", "2");

// 連続・二重投稿対象セキュリティレベルが 高 のときの類似率(単位％)
define("VALUE_LIMIT", "80");

// 二重投稿セキュリティレベル
//※二重投稿とみなす条件
// 0:最低　…　本文が一致し、画像なしの場合(従来の条件)
// 1:低　　…　本文が一致する場合
// 2:中　　…　本文が類似率(中)を上回る場合
// 3:高　　…　本文が類似率(高)を上回る場合
define("D_POST_CHECKLEVEL", "1");

// 二重投稿セキュリティレベルが 中 のときの類似率(単位％)
define("COMMENT_LIMIT_MIDDLE", "90");

// 二重投稿セキュリティレベルが 高 のときの類似率(単位％)
define("COMMENT_LIMIT_HIGH", "80");

//言語設定
//ファイルのエンコードshift-jisやeucのときのための設定
//utf-8の時は何を設定しても同じ
define("LANG", "Japanese");

/* ---------- SNSシェア機能詳細設定 ---------- */
//シェア機能に、Mastodon、Misskeyの各サーバを含める 1:含める 0:含めない  
define("SWITCH_SNS","1");

// SNS共有の時に一覧で表示するサーバ
//例 	["表示名","https://example.com (SNSのサーバのurl)"],(最後にカンマが必要です)

$servers =
[
		
	["X","https://x.com"],
	["Bluesky","https://bsky.app"],
	["Threads","https://www.threads.net"],
	["mstdn.jp","https://mstdn.jp"],
	["ukadon.shillest.net","https://ukadon.shillest.net"],
	["pawoo.net","https://pawoo.net"],
	["fedibird.com","https://fedibird.com"],
	["misskey.io","https://misskey.io"],
	["xissmie.xfolio.jp","https://xissmie.xfolio.jp"],
	["misskey.design","https://misskey.design"],
	["nijimiss.moe","https://nijimiss.moe"],
	["sushi.ski","https://sushi.ski"],

];

// SNS共有の時に開くWindowsの幅と高さ

//windowの幅 初期値 600
define("SNS_WINDOW_WIDTH","600");

//windowの高さ 初期値 600
define("SNS_WINDOW_HEIGHT","600");

/* ---------- お絵かき詳細設定 ---------- */

//テンポラリ内のファイル有効期限(日数)
define("TEMP_LIMIT", "3");

//初期レイヤー数［しぃペインターのみ］
define("LAYER_COUNT", "3");

//アンドゥの回数(デフォルト)
define("UNDO", "90");

//アンドゥを幾つにまとめて保存しておくか(デフォルト)
define("UNDO_IN_MG", "45");

//PNGの減色率とJPEGの圧縮率
//要対応テーマ
define("COMPRESS_LEVEL", "15");

//キャンバスクオリティの選択肢［しぃペインターのみ］
//※最初の値がデフォルトになります(要対応テーマ)
$qualitys = array("1","2","3","4");

//セキュリティ関連－URLとクリック数かタイマーのどちらかが設定されていれば有効
//※十分テストした上で設定して下さい
//セキュリティクリック数。設定しないなら""で
define("SECURITY_CLICK", "");
//セキュリティタイマー(単位:秒)。設定しないなら""で
define("SECURITY_TIMER", "");

//ペイント画面のパスワードの暗号鍵
//あまり頻繁に変更しない事
//define('CRYPT_PASS','fbgtK4pj9t8Auek');
//↑ 暗号化と解読のためのパスワード。
//phpの内部で処理するので覚えておく必要はありません。
//管理パスとは別なものです。
//適当な英数字を入れてください。

//CheerpJ の旧バージョンを使用する する:1 しない:0
//最新バージョンで問題がでる場合は、する:1
define("USE_CHEERPJ_OLD_VERSION","0");

/* ------------- トラブルシューティング ------------- */

//問題なく動作している時は変更しない。

//urlパラメータを追加する する:1 しない:0
//ブラウザのキャッシュが表示されて投稿しても反映されない時は1。
define('URL_PARAMETER', '1');

//画像やHTMLファイルのパーミッション。
define("PERMISSION_FOR_DEST", 0606);//初期値 0606
//ブラウザから直接呼び出さないログファイルのパーミッション
define("PERMISSION_FOR_LOG", 0600);//初期値 0600
//画像や動画ファイルを保存するディレクトリのパーミッション
define("PERMISSION_FOR_DIR", 0707);//初期値 0707

//GD2のImageCopyResampledでサムネイルの画質向上 させる:1 させない:0
//不具合がある場合のみ 0
define("RE_SAMPLED", "1");

/*セキュリティ*/

//iframe内での表示を 拒否する:1 許可する:0
//セキュリティリスクを回避するため "拒否する:1" を強く推奨。

define("X_FRAME_OPTIONS_DENY", "1");

// 管理者パスワードを5回連続して間違えた時は拒絶する
// する: 1 しない: 0
// する: 1 にするとセキュリティは高まりますが、ログインページがロックされた時の解除に手間がかかります。

define("CHECK_PASSWORD_INPUT_ERROR_COUNT", "1");

//ftp等でアクセスして、
// `templates/errorlog/error.log`
// を削除すると、再度ログインできるようになります。
// このファイルには、間違った管理者パスワードを入力したクライアントのIPアドレスが保存されています。
// 上記ファイルは手動で削除しなくても、ロック発生から3日経過すると自動的に削除され、ロックが解除されます。
// また、 しない: 0 に設定しなおせば上記ファイルは削除され、ロックが解除されます。

//JavaScriptを経由していない投稿を拒絶
// する: 1 しない: 0
// する: 1 にすると、JavaScriptを無効にしているクライアントからの投稿は拒絶されます。
// また、common.js が対応バージョンでない場合も拒絶されます。
define("REJECT_WITHOUT_JAVASCRIPT", "0"); 

include './config_ext.php';

