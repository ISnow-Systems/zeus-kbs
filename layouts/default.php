<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width">
	<?php
	//追加のメタ要素
	foreach (ADDMETA as $item) {
		echo "\n\t\t<meta";
		foreach ($item as $key => $value) {
			echo " $key='$value'";
		}
		echo ">";
	}
	echo "\n";
	//Open Graph Protocol 及び、それに類するメタ要素
	foreach (OPENGRAPH as $key => $item) {
		if (!$item) continue;
		if (!$key) continue;
		$nametype = "property";
		switch ($key) {
			case "twitter":
				$prefix = "twitter";
				break;
			case "facebook":
				$prefix = "fb";
				break;
			case "opengraph":
			default:
				$prefix = "og";
		}
		if (isset($item["@prefix"])) $prefix = $item["@prefix"];
		if ($key == "twitter" || $item["@propname"] == "name") $nametype = "name";
		foreach ($item as $propname => $content) {
			if (str_starts_with($content, "@")) continue;
			echo "\t\t<meta $nametype='$prefix:$propname' content='$content'>\n";
		}
	}
	//追加のリンク要素
	foreach (ADDLINK as $item) {
		echo "\n\t\t<link";
		foreach ($item as $key => $value) {
			echo " $key='$value'";
		}
		echo ">";
	}
	//追加のスタイル要素
	foreach (ADDSTYLE as $item) {
		if ($item["@is-inline"]) {
			echo "<style>${item["style"]}</style>";
		}
		echo "\n\t\t<link rel='stylesheet' href='${item["style"]}'>";
	}
	?>
	<link rel="stylesheet" href="/bootstrap/css/bootstrap.min.css">
</head>
<body>
<header></header>
<main class="container">
	<?= BODY ?>
</main>
<footer>
	<div class="container text-end">
		<?= ZEUS_VERSION_COMPLEX ?>
	</div>
</footer>
<div class="position-fixed" aria-live="polite" aria-atomic="true">
	<div class="toast-container p-3 bottom-0 end-0" id="toast-container"></div>
</div>
<script src="/jquery/js/jquery-3.6.1.min.js"></script>
<script src="/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="/site/js/layout/default.js"></script>
<script src="/site/js/site.js"></script>
<?php
//追加のスクリプト要素
foreach (ADDSCRIPT as $item) {
	if ($item["@is-async"]) {
		if ($item["@is-inline"]) {
			echo "<style async>${item["style"]}</style>";
		}
		echo "\n\t\t<script src='${item["style"]}' async></script>";
	} else {
		if ($item["@is-inline"]) {
			echo "<style>${item["style"]}</style>";
		}
		echo "\n\t\t<script src='${item["style"]}'></script>";
	}
}
?>
</body>
</html>