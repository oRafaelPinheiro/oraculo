<?php

// Inicialize a sessão
session_start();

// Verifique se o usuário está logado, se não, redirecione-o para uma página de login
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: index.php");
    exit;
}
include('database_connection.php');

$column = array("chatroom","frase", "id" );

$query = "SELECT * FROM cadastro";

if(isset($_POST["order"]))
{
	$query .= ' ORDER BY '.$column[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' ';
}
else
{
	$query .= ' ORDER BY id DESC ';
}

$query1 = '';

if($_POST["length"] != -1)
{
	$query1 = 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
}

$statement = $connect->prepare($query);

$statement->execute();

$number_filter_row = $statement->rowCount();

$result = $connect->query($query . $query1);

$data = array();

foreach($result as $row)
{
	$sub_array = array();
	$sub_array[] = $row['chatroom'];
	$sub_array[] = $row['frase'];
	$sub_array[] = $row['id'];
	$data[] = $sub_array;
}


function count_all_data($connect)
{
	$query = "SELECT * FROM cadastro";

	$statement = $connect->prepare($query);

	$statement->execute();

	return $statement->rowCount();
}

$output = array(
	'draw'		=>	intval($_POST['draw']),
	'recordsTotal'	=>	count_all_data($connect),
	'recordsFiltered'	=>	$number_filter_row,
	'data'		=>	$data
);

echo json_encode($output);

?>