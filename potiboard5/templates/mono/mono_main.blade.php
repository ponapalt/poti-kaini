<!DOCTYPE html>
<html lang="ja">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	@include('parts.style-switcher')
	<link rel="preload" as="style" href="{{$skindir}}icomoon/style.css" onload="this.rel='stylesheet'">
	<link rel="preload" as="script" href="lib/{{$jquery}}">
	<link rel="preload" as="style" href="lib/lightbox/css/lightbox.min.css" onload="this.rel='stylesheet'">
	<link rel="preload" as="script" href="lib/lightbox/js/lightbox.min.js">
	<link rel="preload" as="script" href="loadcookie.js?{{$ver}}">
	<link rel="preload" as="script" href="{{$skindir}}js/mono_common.js?{{$ver}}">
	<style>
		.input_disp_none {
			display: none;
		}
	</style>

	<script src="https://cdn.jsdelivr.net/npm/@nikolat/makibishi@0"></script>
	
	<script type="text/javascript" src="https://s.hatena.ne.jp/js/HatenaStar.js"></script>

	<script type="text/javascript">
		Hatena.Star.Token = 'abcb1594afacbd88eff4a34e00703d16febf6129';
		Hatena.Star.SiteConfig = {
			entryNodes: {
				'div.thread': {
					uri: 'h2 a.permalink',
					title: 'h2',
					container: 'h3 span.hstar'
				} , 
				'div.res': {
					uri: 'h4 span.oyaresno a.permalink_res',
					title: 'h4 span.oyaresno',
					container: 'h4'
				}
			}
		};
	</script>

	<title>{{$title}}</title>
	@if($notres)
	{{-- このあたりは各自変更してもらえると嬉しいです
詳しい意味はgoogle先生に訊いてください。 --}}
	<meta name="twitter:card" content="summary_large_image">
	<meta name="twitter:site" content="">
	<meta property="og:site_name" content="">
	<meta property="og:title" content="{{$title}}">
	<meta property="og:type" content="article">
	<meta property="og:description" content="">
	<meta property="og:image" content="{{$rooturl}}{{$skindir}}img/og.png">
	<meta property="og:image:width" content="1028">
	<meta property="og:image:height" content="1028">
	<meta property="og:url" content="{{$rooturl}}">
	<meta name="description" content="">
	@endif
	@if($resno)
	<meta name="twitter:card" content="summary_large_image">
	<meta name="twitter:site" content="">
	<meta property="og:site_name" content="">
	<meta property="og:title"
		content="[{{$oya[0][0]['no']}}] {{$oya[0][0]['sub']}} by {{$oya[0][0]['name']}} - {{$title}}">
	<meta property="og:type" content="article">
	<meta property="og:description" content="{{$oya[0][0]['descriptioncom']}}">
	<meta property="og:url" content="{{$rooturl}}{{$self}}?res={{$oya[0][0]['no']}}">
	@if ($oya[0][0]['src'])
	<meta property="og:image" content="{{$rooturl}}{{$oya[0][0]['imgsrc']}}">
	<meta property="og:description" content="{{$oya[0][0]['descriptioncom']}}">
	@endif
	@endif
	<style id="for_mobile"></style>
</head>

<body>
	<header id="header">
		<h1><a href="{{$self2}}">{{$title}}</a></h1>
		<div>
			<a href="{{$home}}" target="_top">[ホーム]</a>
			@if($use_admin_link)<a href="{{$self}}?mode=admin">[管理モード]</a>@endif
		</div>
			<hr>
		<div>
			<p style="font-size: small;">うか・てき [伺的] 《形動》 伺かのように見える何か。「伺か」のキャラクターであってもなくてもよい。つまり割となんでも良い。【初出】勉強会</p>
			
			<p style="font-size: small; margin-top: 8px;">「お絵かき」でその場で描画可能。「投稿」で直接ファイル投稿可。ツール選択ができます。懐かしいUIならPaintBBS NEOかしぃペインター、本格的なやつならKlecksかChickenPaintで。なんでもお待ちしております。<br>
			何かありましたら管理者まで。 <a href="https://ukadon.shillest.net/@ponapalt">Mastodon:ponapalt</a> / <a href="https://twitter.com/ponapalt">twitter:ponapalt</a></p>
			
			<p style="font-size: small; margin-top: 8px;"><span style="color: #009900; font-weight: bold; ">おすすめ：</span>投稿やレスのタイトル右の★ボタンで★マークをつけることができます。拍手的な使い方でなんとなくぽちっとしてみるといいと思います。<br>
			左が<a href="https://nikolat.github.io/makibishi/">MAKIBISHI(登録不要、nostr参加者はアイコンがつく)</a>で、右が<a href="https://s.hatena.ne.jp/">はてなスター(はてな登録必須)</a>になります<br>
			<span style="color: #009900;">星が増えるときっとやる気も増える。ちなみに黄色の★なら何度でも押せるぞ。</span></p>
		</div>
		<hr>
		<div>
			<nav class="menu">
				<a href="{{$self2}}">[トップ]</a>
				@if($for_new_post)
				<a href="{{$self}}?mode=newpost">[投稿]</a>
				@endif
				<a href="{{$self}}?mode=catalog">[カタログ]</a>
				[通常モード]
				<a href="{{$self}}?mode=piccom">[投稿途中の絵]</a>
				<a href="#footer" title="一番下へ">[↓]</a>
			</nav>
			<hr>
			@if($resno)
			@if($form)
			<p class="resm">
				レス送信モード
				@if($resname)
				<script>
					function add_to_com() {
						var textField = document.getElementById("p_input_com");
						var postername = "{!! htmlspecialchars($resname,ENT_QUOTES,'utf-8') !!}{{$_san}}";
						// テキストフィールドの現在のカーソル位置を取得
						var startPos = textField.selectionStart;
						var endPos = textField.selectionEnd;
						// カーソル位置に指定した文字列を挿入
						textField.value = textField.value.substring(0, startPos) + postername + textField.value.substring(endPos);
						// カーソル位置を更新
						var newCursorPosition = startPos + postername.length;
						textField.setSelectionRange(newCursorPosition, newCursorPosition);						// テキストフィールドにフォーカスを設定
						textField.focus();
					}
				</script>
				{{-- コピーボタン  --}}
				<button class="copy_button" onclick="add_to_com()">投稿者名をコピー</button>
				@endif
			</p>
			<hr>
			@endif
			@endif
		@if($paintform)
		@if($resno or !$diary)

			@if($resno)
			<p class="resm">お絵かきレス</p>
			<hr>
			@endif
			<div class="epost">

			{{-- ペイントフォーム --}}
			@include('parts.mono_paint_form')
			</div>
		@endif
			<div class="epost">
			@if ($notres and (!$diary or $addinfo))
				<ul>
					@if ($paint2 and !$diary)
					<li>お絵かきできる画像のサイズは幅 {{$pminw}}px～{{$pmaxw}}px、高さ {{$pminh}}px～{{$pmaxh}}pxの範囲内です。</li>
					<li>幅 {{$maxw}}px、高さ {{$maxh}}pxを超える画像はサムネイルで表示されます。</li>
					@endif
					{!!$addinfo!!}
				</ul>
			@endif	
			</div>
			@endif
			@if($form)
			<div>
				<form action="{{$self}}" method="post" enctype="multipart/form-data" id="comment_form">
					<input type="hidden" name="token" value="@if($token){{$token}}@endif">
					<input type="hidden" name="mode" value="regist">
					@if($resno)<input type="hidden" name="resto" value="{{$resno}}">@endif
					<input type="hidden" name="MAX_FILE_SIZE" value="{{$maxbyte}}">
					<table>
						<tr>
							<td>名前 @if($usename){{$usename}}@endif</td>
							<td><input class="form" type="text" name="name" size="28" value="" autocomplete="username">
							</td>
						</tr>
						<tr>
							<td>メール</td>
							<td><input class="form" type="text" name="email" size="28" value="" autocomplete="email">
							</td>
						</tr>
						@if($use_url_input)
						<tr>
							<td>URL</td>
							<td><input class="form" type="text" name="url" size="28" autocomplete="url"></td>
						</tr>
						@endif
						<tr>
							<td>題名 @if($usesub){{$usesub}}@endif</td>
							<td>
								<input class="form" type="text" name="sub" size="20" value="@if($resub){{$resub}}@endif"
									autocomplete="section-sub">
								<input class="button" type="submit" value="送信する">
							</td>
						</tr>
						<tr>
							<td>本文 @if($usecom){{$usecom}}@endif</td>
							<td><textarea class="form" name="com" cols="28" rows="4" wrap="soft"
									id="p_input_com"></textarea></td>
						</tr>
						@if($upfile)
						<tr>
							<td>ファイル</td>
							<td>
								<input class="form" type="file" name="upfile" accept="image/*">
								<span class="preview"></span>
							</td>
						</tr>
						@endif
						<tr>
							<td>削除編集パスワード</td>
							<td><input class="form" type="password" name="pwd" value=""
									autocomplete="current-password"><small>(記事の編集削除用)</small></td>
						</tr>
					</table>
					<ul>
						@if($upfile)
						<li>添付可能なファイル形式はGIF、JPG、PNG、およびWEBPです。</li>
						<li>幅 {{$maxw_px}}px、高さ {{$maxh_px}}pxを超える添付画像は縮小されます。</li>
						@endif
						@if($paintform or $upfile)
						<li>幅 {{$maxw}}px、高さ {{$maxh}}pxを超える画像はサムネイルで表示されます。</li>
						<li>最大投稿データ量は {{$maxkb}} KB までです。sage機能付き。</li>
						@endif
						{!!$addinfo!!}
					</ul>
				</form>
			</div>
			@endif
		</div>
	</header>

	<main>
		<section>
			{{-- スレッドのループ --}}
			@foreach ($oya as $i=>$ress)
			<div class="thread">

				@if(isset($ress) and !@empty($ress))
				@foreach ($ress as $res)
				{{-- 記事表示 --}}
				@if ($loop->first)
				{{-- 最初のループ --}}
				{{-- レスモードの時 --}}
				@if($resno)
				<h2><a href="{{$self}}?res={{$res['no']}}" class="permalink"><span class="oyano">[{{$res['no']}}]</span> {{$res['sub']}}</a></h2>
				@else
				<h2><a href="{{$self}}?res={{$res['no']}}" class="permalink"><span class="oyano">[{{$res['no']}}]</span>
						{{$res['sub']}}</a></h2>
				@endif
				{{-- 親記事のヘッダ --}}
				<h3>
				@if(!isset($res['not_deleted'])||$res['not_deleted'])
					<span class="name"><a
							href="{{$self}}?mode=search&page=1&amp;imgsearch=on&amp;query={{$res['encoded_name']}}&amp;radio=2"
							target="_blank" rel="noopener">{{$res['name']}}</a></span><span
						class="trip">{{$res['trip']}}</span> :
					{{$res['now']}}@if($res['id']) ID : {{$res['id']}}@endif @if($res['url']) <span class="url">[<a
							href="{{$res['url']}}" target="_blank" rel="nofollow noopener noreferrer">URL</a>]</span>
					@endif @if($res['updatemark']){{$res['updatemark']}}@endif
				@endif
				<span class="makibishi" data-url="https://oekaki.shillest.net/res/{{$res['no']}}" data-allow-anonymous-reaction="true"></span>
				<span class="hstar"></span>
				</h3>
				<hr>
				@else
				<hr>
				{{-- 子レス --}}
				<div class="res">
					{{-- 子レスヘッダ --}}
					<h4>
					<span class="oyaresno" id="{{$res['no']}}">[<a href="{{$self}}?res={{$ress[0]['no']}}#{{$ress[0]['no']}}-{{$res['no']}}" class="permalink_res">{{$res['no']}}</a>]</span>
					@if(!isset($res['not_deleted'])||$res['not_deleted'])
						<span class="rsub">{{$res['sub']}}</span> :
						<span class="name"><a
								href="{{$self}}?mode=search&page=1&amp;imgsearch=on&amp;query={{$res['encoded_name']}}&amp;radio=2"
								target="_blank" rel="noopener">{{$res['name']}}</a></span><span
							class="trip">{{$res['trip']}}</span> : {{$res['now']}}@if($res['id']) ID :
						{{$res['id']}}@endif @if($res['url']) <span class="url">[<a href="{{$res['url']}}"
								target="_blank" rel="nofollow noopener noreferrer">URL</a>]</span>@endif
						@if($res['updatemark']) {{$res['updatemark']}}@endif
					@endif
					<span class="makibishi" data-url="https://oekaki.shillest.net/res/{{$ress[0]['no']}}-{{$res['no']}}" data-allow-anonymous-reaction="true"></span>
					</h4>
				{{-- 子レスヘッダここまで --}}
				@endif
					{{-- 親子共通 --}}
					@if($res['src'])
					<div class="img_info_wrap">
						<a href="{{$res['src']}}" target="_blank" rel="noopener" data-lightbox="filename_{{$res['no']}}">{{$res['srcname']}}</a>
						({{$res['size_kb']}} KB)
						@if($res['thumb']) - サムネイル表示中 - @endif @if($res['painttime']) PaintTime :
						{{$res['painttime']}}@endif
						@if($res['tool'])<span class="article_info_desc">Tool :
						{{$res['tool']}}</span>@endif
						<br>
						@if($res['continue']) ●<a
							href="{{$self}}?mode=continue&amp;no={{$res['continue']}}&amp;resno={{$ress[0]['no']}}">続きを描く</a>@endif
						@if($res['spch'])<span class="for_pc">@endif @if($res['pch']) ●<a
								href="{{$self}}?mode=openpch&amp;pch={{$res['pch']}}&amp;resno={{$ress[0]['no']}}&amp;no={{$res['no']}}" target="_blank">動画</a>@endif
							@if($res['spch'])</span>@endif
					</div>
					<figure @if($res['w']>=750) style="float:none;margin-right:0"@endif>
						<a href="{{$res['src']}}" target="_blank" rel="noopener" data-lightbox="{{$ress[0]['no']}}">
						<img src="{{$res['imgsrc']}}" alt="{{$res['sub']}} by {{$res['name']}}"
								title="{{$res['sub']}} by {{$res['name']}}" width="{{$res['w']}}"
								height="{{$res['h']}}" @if($i>4)loading="lazy"@endif>
						</a>
					</figure>
					@endif
					<div class="comment_wrap">
					<p>{!!$res['com']!!}
							@if(isset($res['not_deleted'])&&!$res['not_deleted'])
							この記事はありません。
							@endif
					</p>
						{{-- コメント部分 --}}
					</div>
					{{-- 最初のループならレス省略件数を表示 --}}
					@if ($loop->first)
					@if ($res['skipres'])
					<hr>
					<div class="article_skipres">レス{{$res['skipres']}}件省略中。</div>
					@endif
					@endif
			{{-- 子レス閉じタグ --}}
			@if (!$loop->first)
			</div>
			@endif
			@endforeach
			@endif
			<div class="thfoot">
				<hr>
				@if($sharebutton)
				{{-- シェアボタン --}}
				<span class="share_button">
					@if($switch_sns)
					<a href="{{$self}}?mode=set_share_server&encoded_t={{$ress[0]['encoded_t']}}&amp;encoded_u={{$ress[0]['encoded_u']}}" onclick="open_sns_server_window(event,{{$sns_window_width}},{{$sns_window_height}})"><span
						class="button"><img src="{{$skindir}}img/share-from-square-solid.svg" alt=""> SNSで共有する</span></a>
					@else
					<a target="_blank"
						href="https://twitter.com/intent/tweet?text={{$ress[0]['encoded_t']}}&url={{$ress[0]['encoded_u']}}"><span
							class="button"><img src="{{$skindir}}img/twitter.svg" alt=""> Tweet</span></a>
					<a target="_blank" class="fb btn"
						href="http://www.facebook.com/share.php?u={{$ress[0]['encoded_u']}}"><span
							class="button"><img src="{{$skindir}}img/facebook.svg" alt="">
							Share</span></a>
					@endif

				</span>
				@endif
				@if($notres)<span class="button"><a href="{{$self}}?res={{$ress[0]['no']}}"><img
							src="{{$skindir}}img/rep.svg" alt="">@if($ress[0]['disp_resbutton']) 返信 @else
						 表示 @endif</a></span>@endif
				<a href="#header" title="上へ">[&uarr;]</a>
			</div>
			</div>
			@endforeach
			{{-- スレッドループここまで --}}
		</section>
	</main>


	<footer id="footer">
		<div>

			<nav>
				@if($resno)
				<div class="pcdisp page">

					@if($res_prev)<a href="{{$self}}?res={{$res_prev['no']}}">≪{{$res_prev['substr_sub']}}</a>@endif
					| <a href="{{$self2}}">Top</a> |
					@if($res_next)<a href="{{$self}}?res={{$res_next['no']}}">
						{{$res_next['substr_sub']}}≫</a>@endif
				</div>

				<div class="mobiledisp">
					@if($res_prev)
					Prev: <a href="{{$self}}?res={{$res_prev['no']}}">{{$res_prev['sub']}}</a>
					<br>
					@endif
					@if($res_next)
					Next: <a href="{{$self}}?res={{$res_next['no']}}">{{$res_next['sub']}}</a>
					<br>
					@endif
				</div>

				@if($view_other_works)
				<div class="view_other_works">
					@foreach($view_other_works as $view_other_work)<div><a
							href="{{$self}}?res={{$view_other_work['no']}}"><img src="{{$view_other_work['imgsrc']}}" alt="{{$view_other_work['sub']}} by {{$view_other_work['name']}}" title="{{$view_other_work['sub']}} by {{$view_other_work['name']}}" width="{{$view_other_work['w']}}" height="{{$view_other_work['h']}}" loading="lazy"></a></div>@endforeach
				</div>
				@endif

				@endif

				@if($notres)

				{{-- 前、次のナビゲーション --}}
				@include('parts.mono_prev_next')

				@endif
			</nav>
			{{-- <!-- メンテナンスフォーム欄 --> --}}
			@include('parts.mono_mainte_form')

		</div>
		{{-- <!-- 著作権表示 削除しないでください --> --}}
		@include('parts.mono_copyright')
	</footer>
	<div id="page_top"><a class="icon-angles-up-solid"></a></div>
	<script src="loadcookie.js?{{$ver}}"></script>
	<script>
	document.addEventListener('DOMContentLoaded',l,false);
	</script>
	<script src="lib/{{$jquery}}"></script>
	<script src="lib/lightbox/js/lightbox.min.js"></script>
	<script src="{{$skindir}}js/mono_common.js?{{$ver}}"></script>
</body>

</html>