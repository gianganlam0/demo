<?php
defined('BASEPATH') or exit('No direct script access allowed');
// $code = $this->input->get_request_header('code', TRUE);
if ($res['code']==200) $title = 'Kích hoạt thành công';
else $title = 'Kích hoạt thất bại';
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?=$title?></title>
</head>

<body>
	<h1><?=$res['message']?></h1>
</body>

</html>
