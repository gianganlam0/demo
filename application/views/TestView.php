<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href='https://fonts.googleapis.com/css?family=Cookie' rel='stylesheet' type='text/css'>
	<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js'></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'>
	<link rel="stylesheet" href="https://kendo.cdn.telerik.com/2023.1.117/styles/kendo.default-main.min.css">
	<script src="https://kendo.cdn.telerik.com/2023.1.117/js/kendo.all.min.js"></script>
	<script src="/assets/js/Utils.js"></script>
	<script src="/assets/js/Header.js"></script>
	<link rel="stylesheet" href="/assets/css/Header.css">
	<!-- <script src="/assets/js/Home.js"></script>
	<link rel="stylesheet" href="/assets/css/Home.css"> -->
	<title>Test paeg</title>
</head>

<body>
	<?php
		$this->load->view('/components/header');
		$dropdownlist = new \Kendo\UI\DropDownList('DropDownList');
		$dropdownlist->attr('style', 'width: 50%');
		$dropdownlist->attr('class', 'text-center');
		//simple data
		$data = array(
			array('text' => 'Item 1', 'value' => 1),
			array('text' => 'Item 2', 'value' => 2),
			array('text' => 'Item 3', 'value' => 3),
			array('text' => 'Item 4', 'value' => 4)
		);
		$dropdownlist->dataSource($data);
		$dropdownlist->dataTextField('text');
		$dropdownlist->dataValueField('value');
		$dropdownlist->value(1997);


		echo $dropdownlist->render();

	?>
</body>

</html>