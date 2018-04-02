<?php
echo '
<!doctype html>
<html>
<head>
<meta charset="utf-8" />
<title>Calendario</title>
<!--link rel="stylesheet" href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css" /-->
<link rel="stylesheet" type="text/css"	href="css/jquery-ui.css">
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>


<script >
$(function () {
$.datepicker.setDefaults($.datepicker.regional["es"]);
$("#datepicker").datepicker({
firstDay: 1
});
});
$(function () {
$("#off").click(function () {
$("#datepicker").datepicker().hide();
});
});
$(function () {
$("#on").click(function () {
$("#datepicker").datepicker().show();
});
});
</script>
</head>
<body>
<div id="datepicker"></div>
</body>
</html>

		';