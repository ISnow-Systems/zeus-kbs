<?php
require_once "../loader.php";
$raddr = $_SERVER["REQUEST_URI"];
$parsedown = new Parsedown();
if (str_ends_with($raddr, "/")) $raddr .= "index";
if (str_ends_with($raddr, ".php") || str_ends_with($raddr, ".htm")) $raddr = substr($raddr, 0, strlen($raddr) - 4);
if (str_ends_with($raddr, ".html")) $raddr = substr($raddr, 0, strlen($raddr) - 4);
if (str_starts_with(basename($raddr), ".")) {
	// 403 FORBIDDEN
} elseif (str_starts_with($raddr, "/special:redirect")) {
	require_once ZEUS_APPLICATION . DS . "redirect.php";
} elseif (str_starts_with($raddr, "/ajax/")) {
	// AJAX
	require_once ZEUS_APPLICATION . DS . "ajax.php";
} elseif (str_starts_with($raddr, "/api/")) {
	// API
	require_once ZEUS_APPLICATION . DS . "api.php";
} elseif (str_starts_with($raddr, "/storage/") && file_exists(ZEUS_STORAGE . DS . str_replace("/", "\\", $raddr))) {
	// STORAGE
	header("Content-Type: " . mime_content_type(ZEUS_STORAGE . DS . str_replace("/", "\\", $raddr)));
	readfile(ZEUS_STORAGE . DS . str_replace("/", "\\", $raddr));
} elseif (file_exists(ZEUS_STATIC . DS . str_replace("/", "\\", $raddr))) {
	// STATIC
	if (str_ends_with($raddr, ".css")) {
		header("Content-Type: text/css");
	} elseif (str_ends_with($raddr, ".js")) {
		header("Content-Type: application/javascript");
	} else {
		header("Content-Type: " . mime_content_type(ZEUS_STATIC . DS . str_replace("/", "\\", $raddr)));
	}
	readfile(ZEUS_STATIC . DS . str_replace("/", "\\", $raddr));
} elseif (file_exists(ZEUS_PAGES . DS . str_replace("/", "\\", $raddr) . ".md")) {
	// PAGES
	define("SOURCERAW", file_get_contents(ZEUS_PAGES . DS . str_replace("/", "\\", $raddr) . ".json"));
	define("SOURCEARRAY", json_decode(SOURCERAW, TRUE));
	define("TITLE", empty(SOURCEARRAY["data"]["title"]) ? ("無題 - " . ZEUS_SITE_NAME) : (SOURCEARRAY["data"]["title"] . " - " . ZEUS_SITE_NAME));
	define("ADDMETA", SOURCEARRAY["data"]["meta"]);
	define("OPENGRAPH", SOURCEARRAY["data"]["ogp"]);
	define("ADDLINK", SOURCEARRAY["data"]["link"]);
	define("ADDSTYLE", SOURCEARRAY["data"]["style"]);
	define("ADDSCRIPT", SOURCEARRAY["data"]["script"]);
	define("CACHEENABLE", SOURCEARRAY["data"]["cache"]);
	define("LAYOUTNAME", trim(SOURCEARRAY["data"]["layout"]) == "" ? "default" : trim(SOURCEARRAY["data"]["layout"]));
	define("HEADERS", SOURCEARRAY["data"]["http"]["header"]);
	define("HASH_HEX", hash("sha1", SOURCERAW));
	define("HASH_B64", base64_encode(hash("sha1", SOURCERAW, true)));
	if (CACHEENABLE && DS == "\\" && file_exists(ZEUS_CACHE . DS . HASH_HEX)) {
		if (HEADERS != []) {
			foreach (HEADERS as $key => $item) {
				if (!$item) continue;
				header("${key}: ${item}");
			}
		}
		readfile(ZEUS_CACHE . DS . HASH_HEX);
	} elseif (CACHEENABLE && DS == "/" && file_exists(ZEUS_CACHE . DS . HASH_B64)) {
		if (HEADERS != []) {
			foreach (HEADERS as $key => $item) {
				if (!$item) continue;
				header("${key}: ${item}");
			}
		}
		readfile(ZEUS_CACHE . DS . HASH_B64);
	} else {
		define("BODY", preg_replace(
			"/<a( .*?)href=[\"'](http:\\/\\/.+?)[\"'](.*?)>(.+?)<\\/a>/",
			"<a$1href='/special:redirect?to=$2'$3>$4</a>",
			preg_replace(
				"/<a( .*?)href=[\"']((https:)?\\/\\/)(.+?)[\"'](.*?)>(.+?)<\\/a>/",
				"<a$1href='https://$4' target='_blank'$5>$6</a>",
				$parsedown->text(SOURCEARRAY[7])
			)
		));
		if (HEADERS != []) {
			foreach (HEADERS as $key => $item) {
				if (!$item) continue;
				header("${key}: ${item}");
			}
		}
		if (CACHEENABLE) ob_start();
		if (!file_exists(ZEUS_LAYOUTS . DS . LAYOUTNAME . ".php")) {
			require_once ZEUS_LAYOUTS . DS . "default.php";
		} else {
			require_once ZEUS_LAYOUTS . DS . LAYOUTNAME . ".php";
		}
		if (CACHEENABLE) {
			$ob = ob_get_contents();
			file_put_contents(DS == "\\" ? (ZEUS_CACHE . DS . HASH_HEX) : (ZEUS_CACHE . DS . HASH_B64), $ob);
			ob_end_clean();
			echo $ob;
		}
	}
} elseif (isset(ZEUS_GONELIST[$raddr])) {
	// 410 GONE
	define("TITLE", "410 HTTP Gone" . ZEUS_SITE_NAME);
	define("ADDMETA", [
		[
			"name" => "robots",
			"content" => "noindex"
		]
	]);
	define("OGP", []);
	define("ADDLINK", []);
	define("ADDSTYLE", []);
	define("ADDSCRIPT", []);
	define("CACHEAVAIL", false);
	define("HEADERS", []);
	define("BODY", $parsedown->text(file_get_contents(ZEUS_APPLICATION . DS . "410.md")));
} else {
	// 404 NOT FOUND
	define("TITLE", "404 HTTP Not Found" . ZEUS_SITE_NAME);
	define("ADDMETA", [
		[
			"name" => "robots",
			"content" => "noindex"
		]
	]);
	define("OGP", []);
	define("ADDLINK", []);
	define("ADDSTYLE", []);
	define("ADDSCRIPT", []);
	define("CACHEAVAIL", false);
	define("HEADERS", []);
	define("BODY", $parsedown->text(file_get_contents(ZEUS_APPLICATION . DS . "404.md")));
}