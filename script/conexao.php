<?php
$servername = "localhost"; //padrao - server local
$database = "producao"; //alterar conforme o nome do seu banco de dados
$username = "root"; // padrao - root
$password = ""; // senha de conexao do bd
//create connection
$conexao = mysqli_connect($servername,$username,$password,$database);