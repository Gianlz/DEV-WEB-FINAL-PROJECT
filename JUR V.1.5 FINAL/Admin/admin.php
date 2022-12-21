<?php
// Inicialize a sessão
session_start();

// Verifique se o usuário está logado, se não, redirecione-o para uma página de login
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: index.php");
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
    <style>
        body {
            background-color: #aba6a6
        }

        .wrapper {
            width: 1300px;
            margin: 0 auto;
        }

        table tr td:last-child {
            width: 120px;
        }

        @media (max-width: 767px) {

            /* styles for screens with a width of 767px or smaller */
            .wrapper {
                width: 100%;
                /* make the wrapper take up the full width of the screen */
            }
        }

        @media (min-width: 768px) and (max-width: 991px) {

            /* styles for screens with a width between 768px and 991px */
            .wrapper {
                width: 90%;
                /* make the wrapper take up 90% of the screen */
            }
        }

        @media (min-width: 992px) {

            /* styles for screens with a width of 992px or larger */
            .wrapper {
                width: 1300px;
                /* keep the original width of the wrapper */
            }
        }
    </style>



</head>

<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="mt-5 mb-3 clearfix">
                        <h2 class="pull-left">Cadastro Advogado</h2>
                        <a href="create-caso.php" class="btn btn-success pull-right"><i class="fa fa-plus"></i>
                            Adicionar Caso</a>
                        <a href="create.php" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Adicionar
                            Advogado</a>
                        <div class="search-box">
                            <input type="text" autocomplete="off" class="form-control  my-2"
                                placeholder="Mousemove search" id="search-input" onload="filterTable()" />
                        </div>
                        <?php
                        // incluir config.php
                        require_once "config.php";


                        // Tentativa de Query
                        $sql = "SELECT * FROM jus_adv";
                        if ($result = $pdo->query($sql)) {
                            if ($result->rowCount() > 0) {
                                echo '<table id="tabl" class="table table-dark">';
                                echo "<thead>";
                                echo "<tr>";
                                echo "<th>#</th>";
                                echo "<th>NOME</th>";
                                echo "<th>SOBRENOME</th>";
                                echo "<th>CPF</th>";
                                echo "<th>CASOS</th>"; // add a new column for the lawyer name
                                echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                while ($row = $result->fetch()) {
                                    echo "<tr>";
                                    echo "<td>" . $row['id'] . "</td>";
                                    echo "<td>" . $row['nome'] . "</td>";
                                    echo "<td>" . $row['sobrenome'] . "</td>";
                                    echo "<td>" . $row['cpf'] . "</td>";
                                    // get the lawyer name for this case
                                    $query = "SELECT casos.nome FROM casos, jus_adv WHERE jus_adv.nome = casos.adv AND jus_adv.id = :id";
                                    $stmt = $pdo->prepare($query);
                                    $stmt->bindParam(':id', $row['id'], PDO::PARAM_INT);
                                    $stmt->execute();
                                    echo "<td>";
                                    echo "<select>";
                                    while ($linha = $stmt->fetch()) {
                                        echo "<option>" . $linha['nome'] . "</option>";
                                    }
                                    echo "</select>";
                                    echo "</td>";
                                    echo "<td>";
                                    echo '<a href="read.php?id=' . $row['id'] . '" class="mr-3" title="View Record" data-toggle="tooltip"><span class="fa fa-eye"></span></a>';
                                    echo '<a href="update.php?id=' . $row['id'] . '" class="mr-3" title="Update Record" data-toggle="tooltip"><span class="fa fa-pencil"></span></a>';
                                    echo '<a href="delete.php?id=' . $row['id'] . '" title="Delete Record" data-toggle="tooltip"><span class="fa fa-trash"></span></a>';
                                    echo "</td>";
                                    echo "</tr>";
                                }


                                echo "</tbody>";
                                echo "</table>";


                                // remover resultados
                                unset($result);
                            } else {
                                echo '<div class="alert alert-danger"><em>Sem registro de contatos.</em></div>';
                            }
                        } else {
                            echo "Error.";
                        }

                        // Fechar conexão
                        unset($pdo);
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <script>
            function filterTable() {
                var searchValue = document.getElementById('search-input').value;
                // Find rows that match the search criteria and hide the rows that do not match
                var rows = document.getElementById('tabl').rows;
                for (var i = 0; i < rows.length; i++) {
                    var cells = rows[i].cells;
                    var match = false;
                    for (var j = 0; j < cells.length; j++) {
                        if (cells[j].textContent.toLowerCase().includes(searchValue.toLowerCase())) {
                            match = true;
                            break;
                        }
                    }
                    if (!match) {
                        rows[i].style.display = 'none';
                    } else {
                        rows[i].style.display = '';
                    }
                }
            }

            document.getElementById('search-input').addEventListener('mousemove', filterTable);
        </script>


</body>

</html>
