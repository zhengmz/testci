<?php
//best way to compress a css code:
//Usage:
//Include in <head>:
//<link rel="stylesheet" type="text/css" href="/css_compress.php" media="all" />

	header('Content-type: text/css');

	ob_start("compress");
	function compress($buffer) {
		// remove comments
		$buffer = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $buffer);
		// remove tabs, spaces, newlines, etc.
		$buffer = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $buffer);
		return $buffer;
	}

	include(APPPATH.'view/template/main.css');
	include(APPPATH.'view/template/classes.css');

	ob_end_flush();
?>

