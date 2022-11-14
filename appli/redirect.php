<?php
http_response_code($_GET["to"] ? 200 : 400);
?>
<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width">
	<title>クッションページ</title>
	<?= ADDMETA ?>
	<?= ADDLINK ?>
	<link rel="stylesheet" href="/bootstrap/css/bootstrap.min.css">
	<?= ADDSTYLE ?>
</head>
<body>
<main class="container">
	<?php if ($_GET["to"]): ?>
	<?php else: ?>
		<article>
			<h2>パラメータ不足</h2>
			<section>
				<h3>概要</h3>
				<p>
					要求に必要なパラメータが不足していたため、
					<wbr>
					クッションページを表示できませんでした。
				</p>
				<p>
					正常に表示するには次のパラメータを
					<wbr>
					要求と共に送出してください：
					<wbr>
					<code>to</code>
				</p>
			</section>
			<section>
				<h3>パラメータ解説</h3>
				<section>
					<h4><code>to</code></h4>
					<p>
						<span class="text-warning">必須</span><br>
						型：文字列型
					</p>
					<p>
						リダイレクト先のURLを指します。
						<wbr>
						リダイレクトを行う前に、
						<wbr>
						必ずクッションページを表示します。
					</p>
				</section>
			</section>
		</article>
	<?php endif ?>
</main>
<footer>
	<div class="container text-end">
		<?= ZEUS_VERSION_COMPLEX ?>
	</div>
</footer>
<script src="/jquery/js/jquery-3.6.1.min.js"></script>
<script src="/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="/site/js/site.js"></script>
<?= ADDSCRIPT ?>
</body>
</html>
