<?php
// Inicialize a sessão
session_start();
 
// Remova todas as variáveis de sessão
$_SESSION = array();
 
// Destrua a sessão.
session_destroy();
 
// Redirecionar para a página de login
header("location: index.php");
exit;
?>