<?php
// Inicialize a sessão
session_start();
 
// Verifique se o usuário está logado, se não, redirecione-o para uma página de login
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
?>
 
 <!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>ADMIN</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="Script/validation.js"></script>
    <style>

        .wrapper{
            width: 1300px;
            margin: 0 auto;
        }
        table tr td:last-child{
            width: 120px;
        }
    </style>
    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();   
        });
    </script>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="mt-5 mb-3 clearfix">
                        <h2 class="pull-left">Cadastro Clientes</h2>
                        <a href="create.php" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Adicionar Clientes</a>
                        <form id="search-form">
                        <input type="text" class="form-control" id="search-query" placeholder="Pesquisa...">
                        <select id="filter" class="form-select">
                            <option value="name">Name</option>
                            <option value="cpf">CPF</option>
                            <option value="sobrenome">Sobrenome</option>
                        </select>
                        <button type="submit" class="btn btn-primary" id="search-button">Search</button>
                        </form>


                    </div>
                    <?php
                    // incluir config.php
                    require_once "config.php";
                    
                    // Tentativa de Query
                    $sql = "SELECT * FROM cliente_adv";
                    if($result = $pdo->query($sql)){
                        if($result->rowCount() > 0){
                            echo '<table class="table table-bordered table-striped">';
                                echo "<thead>";
                                    echo "<tr>";
                                        echo "<th>#</th>";
                                        echo "<th>Nome</th>";
                                        echo "<th>Sobrenome</th>";
                                        echo "<th>Cpf</th>";
                                        echo "<th>Casos</th>";
                                        
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                while($row = $result->fetch()){
                                    echo "<tr>";
                                        echo "<td>" . $row['id'] . "</td>";
                                        echo "<td>" . $row['name'] . "</td>";
                                        echo "<td>" . $row['sobrenome'] . "</td>";
                                        echo "<td>" . $row['cpf'] . "</td>";
                                        echo "<td>" . $row['casos'] . "</td>";
                                        echo "<td>";
                                            echo '<a href="read.php?id='. $row['id'] .'" class="mr-3" title="View Record" data-toggle="tooltip"><span class="fa fa-eye"></span></a>';
                                            echo '<a href="update.php?id='. $row['id'] .'" class="mr-3" title="Update Record" data-toggle="tooltip"><span class="fa fa-pencil"></span></a>';
                                            echo '<a href="delete.php?id='. $row['id'] .'" title="Delete Record" data-toggle="tooltip"><span class="fa fa-trash"></span></a>';
                                        echo "</td>";
                                    echo "</tr>";
                                }
                                echo "</tbody>";                            
                            echo "</table>";
                            // remover resultados
                            unset($result);
                        } else{
                            echo '<div class="alert alert-danger"><em>Sem registro de contatos.</em></div>';
                        }
                    } else{
                        echo "Error.";
                    }
                    
                    // Fechar conexão
                    unset($pdo);
                    ?>
                </div>
            </div>        
        </div>
    </div>

   
</script>
</body>
</html>