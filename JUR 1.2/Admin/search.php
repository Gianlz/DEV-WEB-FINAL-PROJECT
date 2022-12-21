<?php
// incluir config.php
require_once "config.php";

// Obter parâmetros de busca e filtro da solicitação Ajax
$searchQuery = $_GET['search'];
$filter = $_GET['filter'];

// Construir consulta SELECT com parâmetros de busca e filtro
$sql = "SELECT * FROM jus_adv WHERE $filter LIKE";

?>