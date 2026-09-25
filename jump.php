<?php
$URL = strip_tags(urldecode($_SERVER['QUERY_STRING']));
if (!preg_match('/^[a-zA-Z]+:\/\//i', $URL))  {
	die("Invalid URL");
}

$trustedarray = [
];

$untrustedarray = [
];

$forceredirects = [
];

foreach ($forceredirects as $keyword => $target) {
	if (stripos($URL, $keyword) !== false) {
		header("Location: " . $target);
		exit;
	}
}

foreach ($trustedarray as $domain) {
	if (preg_match('/^[a-zA-Z]+:\/\/([a-zA-Z0-9-]+\.)*' . preg_quote($domain, '/') . '/i', $URL)) {
		header("Location: " . $URL);
		exit;
	}
}

$untrusted = false;
foreach ($untrustedarray as $domain) {
	if (preg_match('/^[a-zA-Z]+:\/\/([a-zA-Z0-9-]+\.)*' . preg_quote($domain, '/') . '/i', $URL)) {
		$untrusted = true;
		break;
	}
}

$REDIRECT_DELAY = 5;
$URL_HTML = htmlspecialchars($URL, ENT_QUOTES, 'UTF-8');
$URL_JS   = json_encode($URL);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<?php if (!$untrusted) { ?>
	<meta http-equiv="refresh" content="<?= $REDIRECT_DELAY ?>;url=<?= $URL_HTML ?>">
	<?php } ?>
	<title>★Jump★ | Kolyma Network</title>
	<meta name="robots" content="nofollow,noarchive" />
	<?php if (!$untrusted) { ?>
	<script>
		var redirectURL = <?= $URL_JS ?>;
                
                if (window.location.hash) {
		        redirectURL += window.location.hash;
	        }
                
		var seconds = <?= $REDIRECT_DELAY ?>;
		function countdown() {
			var el = document.getElementById("countdown");
			if (el) {
				el.textContent = seconds;
			}
			if (seconds <= 0) {
				window.location.href = redirectURL;
				return;
			}
			seconds--;
			setTimeout(countdown, 1000);
		}
		function l() {
			var link = document.getElementById("linkto");
		if (link) {
			link.href = redirectURL;
			link.textContent = redirectURL;
			link.focus();
		}
			countdown();
		}
	</script>
	<?php } ?>
        <style>
        body {
        font-family: MS PGothic, Mona;
        }
        </style>
</head>
<body <?php if (!$untrusted) { ?>onload="l();"<?php } ?> link="#0000ee" vlink="#0000EE" text="#000" bgcolor="#EEEEEE" alink="#FF0000">
        <h1>★Jump@<font color="red">K</font>olymaNET★</h1>
	<b><a id="linkto" href="<?php echo $URL_HTML; ?>"><?php echo $URL_HTML; ?></a></b><br>
	<?php if ($untrusted) { ?>
	<i>Jumping to URL... Click the link to continue.</i>
	<?php } else { ?>
	<i>Jumping to URL in <span id="countdown"><?php echo $REDIRECT_DELAY; ?></span>s... Click the link to continue.</i>
	<?php } ?>
	<?php if ($untrusted) { ?>
	<br><font color="red"><b>ⓘ This website may be unsafe.</b></font>
	<?php } ?>
	 <p align="RIGHT"><b><a href="//t.me/KolymaOfficial">[★] Kolyma Network Telegram</a></b></p>
	 <p align="RIGHT"><b><a href="//news.kolyma.moe">[★] Kolyma News Navigator</a></b></p>
         <hr>
         <script async src="https://telegram.org/js/telegram-widget.js?24" data-telegram-post="KolymaOfficial/10" data-width="100%"></script>
         <hr>
         <p align="RIGHT"><b><font color="#080">★Jump★ | Kolyma Network</font></b></p>
</body>
</html>
