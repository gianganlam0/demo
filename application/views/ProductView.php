<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<html>
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script> -->
<script src="<?=base_url()?>js/ProductView.js"></script>
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
</head>
<body>
	bake
	<?php
		$this->load->view('components/test',['data'=>'Hello World!']);
	?>
</body>

</html>
