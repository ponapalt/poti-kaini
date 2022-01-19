<!DOCTYPE html>
<html lang="ja">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<link rel="stylesheet" href="{{$skindir}}css/mono_main.css">
	<link rel="stylesheet" href="{{$skindir}}css/mono_dark.css" id="css1" disabled>
	<link rel="stylesheet" href="{{$skindir}}css/mono_deep.css" id="css2" disabled>
	<link rel="stylesheet" href="{{$skindir}}css/mono_mayo.css" id="css3" disabled>
	<style>
		.input_disp_none {
			display: none;
		}
	</style>

	<script>
		var colorIdx = GetCookie("colorIdx");
		switch (Number(colorIdx)) {
			case 1:
				document.getElementById("css1").removeAttribute("disabled");
				break;
			case 2:
				document.getElementById("css2").removeAttribute("disabled");
				break;
			case 3:
				document.getElementById("css3").removeAttribute("disabled");
				break;
		}

		function SetCss(obj) {
			var idx = obj.selectedIndex;
			SetCookie("colorIdx", idx);
			window.location.reload();
		}

		function GetCookie(key) {
			var tmp = document.cookie + ";";
			var tmp1 = tmp.indexOf(key, 0);
			if (tmp1 != -1) {
				tmp = tmp.substring(tmp1, tmp.length);
				var start = tmp.indexOf("=", 0) + 1;
				var end = tmp.indexOf(";", start);
				return (decodeURIComponent(tmp.substring(start, end)));
			}
			return ("");
		}

		function SetCookie(key, val) {
			document.cookie = key + "=" + encodeURIComponent(val) + ";max-age=31536000;";
		}
	</script>

	<title>{{$title}}</title>
	@if($notres)
	{{-- I would be happy if you could change this area.
	Please ask google for the detailed meaning. --}}
<meta name="twitter:card" content="summary">
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
	<meta name="twitter:card" content="summary">
	<meta name="twitter:site" content="">
	<meta property="og:site_name" content="">
	<meta property="og:title"
		content="[{{$oya[0][0]['no']}}] {{$oya[0][0]['sub']}} by {{$oya[0][0]['name']}} - {{$title}}">
	<meta property="og:type" content="article">
	<meta property="og:description" content="{{$oya[0][0]['descriptioncom']}}">
	<meta property="og:url" content="{{$rooturl}}{{$self}}?res={{$oya[0][0]['no']}}">
	@if ($oya[0][0]['src'])
	<meta property="og:image" content="{{$rooturl}}{{$oya[0][0]['imgsrc']}}" />
	<meta property="og:description" content="{{$oya[0][0]['descriptioncom']}}" />
	@endif
	@endif
	<style id="for_mobile"></style>
</head>

<body>
	<header id="header">
		<h1><a href="{{$self2}}">{{$title}}</a></h1>
		<div>
			<a href="{{$home}}" target="_top">[Home]</a>
			<a href="{{$self}}?mode=admin">[Admin mode]</a>
		</div>
		<hr>
		<div>
			<nav class="menu">
				<a href="{{$self2}}">[Top]</a>
				@if($for_new_post)
				<a href="{{$self}}?mode=newpost">[Post]</a>
				@endif
				<a href="{{$self}}?mode=catalog">[Catalog]</a>
				[Normal mode]
				<a href="{{$self}}?mode=piccom">[Recover Images]</a>
				<a href="#footer" title="to bottom">[↓]</a>
			</nav>
			<hr>
			@if($resno)
			@if($form)
			<p class="resm">
				Reply mode
				@if($resname)
				<script>
					function add_to_com() {
						document.getElementById("p_input_com").value +=
							"{!! htmlspecialchars($resname,ENT_QUOTES,'utf-8') !!} @if($_san){{$_san}}) @else -san @endif";
					}
				</script>
				{{-- コピーボタン  --}}
				<button class="copy_button" onclick="add_to_com()">Copy the poster name</button>
				@endif
			</p>
			<hr>
			@endif
			@endif
			@if($paintform)
			@if($paint)
			<script>
				function is_mobile() {
					if (navigator.maxTouchPoints && (window.matchMedia && window.matchMedia('(max-width: 768px)').matches))
					return true;
					return false;
				}
				if (is_mobile()) {
					document.getElementById("for_mobile").textContent = ".for_pc{display: none;}";
				}
			</script>

			@if($resno)
			<p class="resm">Reply with oekaki</p>
			<hr>
			@endif
			<div class="epost">

				{{-- ペイントボタン --}}
				<form action="{{$self}}" method="post" enctype="multipart/form-data">
					<p>
						Width :<input name="picw" type="number" title="幅" class="form" value="{{$pdefw}}" min="300"
							max="{{$pmaxw}}">
						Height :<input name="pich" type="number" title="高さ" class="form" value="{{$pdefh}}" min="300"
							max="{{$pmaxh}}">
						@if($select_app)
						Tool:
						<select name="shi">
							<option value="neo">PaintBBS NEO</option>
							@if($use_shi_painter)<option value="1" class="for_pc">Shi-Painter</option>@endif
							@if($use_chickenpaint)<option value="chicken">ChickenPaint</option>@endif
						</select>
						@else
						{{-- <!-- 選択メニューを出さない時に起動するアプリ --> --}}
						<input type="hidden" name="shi" value="neo">
						@endif

						@if($use_select_palettes)
						Palettes: <select name="selected_palette_no" title="Palette"
							class="form">{!!$palette_select_tags!!}</select>
						@endif
						@if($resno)
						<input type="hidden" name="resto" value="{{$resno}}">
						@endif
						@if($anime)<label><input type="checkbox" value="true" name="anime" title="Save Playback"
								@if($animechk){{$animechk}}@endif>Save Playback</label>@endif
						<input type="hidden" name="mode" value="paint">
						<input class="button" type="submit" value="Paint">
					</p>
				</form>
				@if($paint2)
				<ul>
					<li>Canvas size is width 300px to {{$pmaxw}}px, height 300px to {{$pmaxh}}px.</li>
					<li>Images larger than width {{$maxw}}px height {{$maxh}}px will be displayed in reduced size.</li>
					@if($addinfo){{$addinfo}}@endif
				</ul>
				@endif
			</div>
			@endif
			@endif
			@if($form)
			<div>
				<form action="{{$self}}" method="post" enctype="multipart/form-data">
					<input type="hidden" name="token" value="@if($token){{$token}}@endif">
					<input type="hidden" name="mode" value="regist">
					@if($resno)<input type="hidden" name="resto" value="{{$resno}}">@endif
					<input type="hidden" name="MAX_FILE_SIZE" value="{{$maxbyte}}">
					<table>
						<tr>
							<td>Name @if($usename){{$usename}}@endif</td>
							<td><input class="form" type="text" name="name" size="28" value="" autocomplete="username">
							</td>
						</tr>
						<tr>
							<td>Mail</td>
							<td><input class="form" type="text" name="email" size="28" value="" autocomplete="email">
							</td>
						</tr>
						<tr>
							<td>URL</td>
							<td><input class="form" type="text" name="url" size="28" autocomplete="url"></td>
						</tr>
						<tr>
							<td>Sub @if($usesub){{$usesub}}@endif</td>
							<td>
								<input class="form" type="text" name="sub" size="20" value="@if($resub){{$resub}}@endif"
									autocomplete="section-sub">
								<input class="button" type="submit" value="Post">
							</td>
						</tr>
						<tr>
							<td>Com @if($usecom){{$usecom}}@endif</td>
							<td><textarea class="form" name="com" cols="28" rows="4" wrap="soft"
									id="p_input_com"></textarea></td>
						</tr>
						@if($upfile)
						<tr>
							<td>UpFile</td>
							<td>
								<input class="form" type="file" name="upfile" accept="image/*">
								<span class="preview"></span>
							</td>
						</tr>
						@endif
						<tr>
							<td>Pass</td>
							<td><input class="form" type="password" name="pwd" value=""
									autocomplete="current-password"><small>(For editing and deleting)</small></td>
						</tr>
					</table>
					<ul>
						@if($upfile)
						<li>Attachable files type: GIF, JPG, PNG and WEBP. </li>
						<li>Images larger than width {{$maxw}}px height {{$maxh}}pxpx will be displayed in reduced size.</li>
						@endif
						<li>The maximum amount of posted data is {{$maxkb}}KB. With sage function.</li>
						@if($addinfo){{$addinfo}}@endif
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
				{{-- <!--記事表示--> --}}
				@if ($loop->first)
				{{-- 最初のループ --}}
				{{-- レスモードの時 --}}
				@if($resno)
				<h2><span class="oyano">[{{$res['no']}}]</span> {{$res['sub']}}</h2>
				@else
				<h2><a href="{{$self}}?res={{$res['no']}}"><span class="oyano">[{{$res['no']}}]</span>
						{{$res['sub']}}</a></h2>
				@endif
				{{-- 親記事のヘッダ --}}
				<h3>
					<span class="name"><a
							href="search_en.php?page=1&amp;imgsearch=on&amp;query={{$res['encoded_name']}}&amp;radio=2"
							target="_blank" rel="noopener">{{$res['name']}}</a></span><span
						class="trip">{{$res['trip']}}</span> :
					{{$res['now']}}@if($res['id']) ID : {{$res['id']}}@endif @if($res['url']) <span class="url">[<a
							href="{{$res['url']}}" target="_blank" rel="nofollow noopener noreferrer">URL</a>]</span>
					@endif @if($res['updatemark']){{$res['updatemark']}}@endif
				</h3>
				<hr>
				@else
				<hr>
				{{-- 子レス --}}
				<div class="res">
					<div class="res_wrap">
						{{-- 子レスヘッダ --}}
						<h4>
							<span class="oyaresno">[{{$res['no']}}]</span>
							<span class="rsub">{{$res['sub']}}</span> :
							<span class="name"><a
									href="search_en.php?page=1&amp;imgsearch=on&amp;query={{$res['encoded_name']}}&amp;radio=2"
									target="_blank" rel="noopener">{{$res['name']}}</a></span><span
								class="trip">{{$res['trip']}}</span> : {{$res['now']}}@if($res['id']) ID :
							{{$res['id']}}@endif @if($res['url']) <span class="url">[<a href="{{$res['url']}}"
									target="_blank" rel="nofollow noopener noreferrer">URL</a>]</span>@endif
							@if($res['updatemark']) {{$res['updatemark']}}@endif
						</h4>
						{{-- 子レスヘッダここまで --}}
						@endif
						{{-- 親子共通 --}}
						@if($res['src'])
						<div class="img_info_wrap">
							<a href="{{$res['src']}}" title="{{$res['sub']}}" target="_blank">{{$res['srcname']}}</a>
							({{$res['size']}} B)
							@if($res['thumb']) - Showing thumbnail - @endif @if($res['painttime']) PaintTime :
							{{$res['painttime']}}@endif
							<br>
							@if($res['continue']) <a
								href="{{$self}}?mode=continue&amp;no={{$res['continue']}}">*Continue</a>@endif
							@if($res['spch'])<span class="for_pc">@endif @if($res['pch']) <a
									href="{{$self}}?mode=openpch&amp;pch={{$res['pch']}}" target="_blank">*Replay</a>@endif
								@if($res['spch'])</span>@endif
						</div>
						<figure @if($res['w']>=750) style="float:none;margin-right:0"@endif>
							@if($res['thumb'])
							<a href="{{$res['src']}}" target="_blank" rel="noopener">
								@endif
								<img src="{{$res['imgsrc']}}" alt="{{$res['sub']}} by {{$res['name']}}"
									title="{{$res['sub']}} by {{$res['name']}}" width="{{$res['w']}}"
									height="{{$res['h']}}" loading="lazy">
								@if($res['thumb'])
							</a>
							@endif
						</figure>
						@endif
						<div class="comment_wrap">
							<p>{!!$res['com']!!}</p>
							{{-- 親のコメント部分 --}}
							@if ($loop->first)
							@if ($res['skipres'])
							<hr>
							<div class="article_skipres">
								{{$res['skipres']}}posts Omitted.
							</div>
							@endif
						</div>
						@endif
						{{-- 子レスなら --}}
						@if (!$loop->first)
					</div>
				</div>
			</div>
			@endif
			@endforeach
			@endif
			<div class="thfoot">
				<hr>
				@if($sharebutton)
				{{-- シェアボタン --}}
				<span class="share_button">
					<a target="_blank"
						href="https://twitter.com/intent/tweet?&text=%5B{{$ress[0]['encoded_no']}}%5D%20{{$ress[0]['share_sub']}}%20by%20{{$ress[0]['share_name']}}%20-%20{{$encoded_title}}&url={{$encoded_rooturl}}{{$encoded_self}}?res={{$ress[0]['encoded_no']}}"><span
							class="icon-twitter button"><img src="{{$skindir}}img/twitter.svg" alt=""> tweet</span></a>
					<a target="_blank" class="fb btn"
						href="http://www.facebook.com/share.php?u={{$encoded_rooturl}}{{$encoded_self}}?res={{$ress[0]['encoded_no']}}"><span
							class="icon-facebook2 button"><img src="{{$skindir}}img/facebook.svg" alt="">
							share</span></a>
				</span>
				@endif
				@if($notres)<span class="button"><a href="{{$self}}?res={{$ress[0]['no']}}"><img
							src="{{$skindir}}img/rep.svg" alt=""> @if($ress[0]['disp_resbutton'])Reply @else
							View @endif</a></span>@endif
				<a href="#header" title="to top">[&uarr;]</a>
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
							href="{{$self}}?res={{$view_other_work['no']}}"><img src="{{$view_other_work['imgsrc']}}" alt="{{$view_other_work['sub']}} by {{$view_other_work['name']}}" title="{{$view_other_work['sub']}} by {{$view_other_work['name']}} width="{{$view_other_work['w']}}" height="{{$view_other_work['h']}}" loading="lazy"></a></div>@endforeach
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

			<script src="loadcookie.js"></script>
			<script>
				l(); //LoadCookie
			</script>
		</div>
		{{-- <!-- 著作権表示 削除しないでください --> --}}
		@include('parts.mono_copyright')
	</footer>
	<script src="{{$skindir}}jquery-3.5.1.min.js"></script>
	<script>
		colorIdx = GetCookie('colorIdx');
		document.getElementById("mystyle").selectedIndex = colorIdx;

		window.onpageshow = function () {
			var $btn = $('[type="submit"]');
			//disbledを解除
			$btn.prop('disabled', false);
			$btn.click(function () { //送信ボタン2度押し対策
				$(this).prop('disabled', true);
				$(this).closest('form').submit();
			});
		}
	</script>
</body>

</html>