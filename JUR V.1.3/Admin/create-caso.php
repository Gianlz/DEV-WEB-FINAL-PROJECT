<?php
// Include config.php
require_once "config.php";

// Variables
$nome = $descricao = $adv = $cliente = "";
$nome_err = $descricao_err = $adv_err = $cliente_err = "";

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate name
    $input_nome = trim($_POST["nome"]);
    if (empty($input_nome)) {
        $nome_err = "Insira um nome válido.";
    } elseif (!filter_var($input_nome, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[a-zA-Z\s]+$/")))) {
        $nome_err = "Preencha o campo.";
    } else {
        $nome = $input_nome;
    }

    // Validate description

    $input_descricao = trim($_POST["descricao"]);
    if (empty($input_descricao)) {
        $descricao_err = "Digite uma descrição.";
    } elseif (!filter_var($input_descricao, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[a-zA-Z\s]+$/")))) {
        $descricao_err = "Preencha o campo.";
    } else {
        $descricao = $input_descricao;
    }

    // Validate adv

    $input_adv = trim($_POST["adv"]);
    if (empty($input_adv)) {
        $adv_err = "Digite o advogado.";
    } elseif (!filter_var($input_adv, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[a-zA-Z\s]+$/")))) {
        $adv_err = "Digite um advogado válido.";
    } else {
        $adv = $input_adv;
    }

    // Validate cliente

    $input_cliente = trim($_POST["cliente"]);
    if (empty($input_cliente)) {
        $cliente_err = "Digite um cliente.";
    } elseif (!filter_var($input_cliente, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[a-zA-Z\s]+$/")))) {
        $cliente_err = "Digite um cliente válido.";
    } else {
        $cliente = $input_cliente;
    }

    if (
        empty($nome_err) && empty($descricao_err) && empty($adv_err) && empty($cliente_err)
    ) {
        // Prepare an insert statement
        $sql = "INSERT INTO casos (nome, descricao, adv, cliente) VALUES (:nome, :descricao, :adv, :cliente)";

        if ($stmt = $pdo->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":nome", $param_nome);
            $stmt->bindParam(":descricao", $param_descricao);
            $stmt->bindParam(":adv", $param_adv);
            $stmt->bindParam(":cliente", $param_cliente);






            // Set parameters
            $param_nome = $nome;
            $param_descricao = $descricao;
            $param_adv = $adv;
            $param_cliente = $cliente;





            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Records created successfully. Redirect to landing page
                header("location: admin.php");
                exit();
            } else {
                echo "Error.";
            }
        }

        // Close statement
        unset($stmt);
    }

    // Close connection
    unset($pdo);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Caso</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        .wrapper {
            width: 500px;
            margin: 0 auto;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h2>Cadastrar Caso</h2>
                    </div>
                    <p>Preencher.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group <?php echo (!empty($nome_err)) ? 'has-error' : ''; ?>">
                            <label>NOME</label>
                            <input type="text" name="nome" class="form-control" value="<?php echo $nome; ?>">
                            <span class="help-block"><?php echo $nome_err; ?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($descricao_err)) ? 'has-error' : ''; ?>">
                            <label>DESCRICAO</label>
                            <input type="text" name="descricao" class="form-control" value="<?php echo $descricao; ?>">
                            <span class="help-block"><?php echo $descricao_err; ?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($adv_err)) ? 'has-error' : ''; ?>">
                            <label>ADVOGADO</label>
                            <input type="text" name="adv" class="form-control" value="<?php echo $adv; ?>">
                            <span class="help-block"><?php echo $adv_err; ?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($cliente_err)) ? 'has-error' : ''; ?>">
                            <label>CLIENTE</label>
                            <input type="text" name="cliente" class="form-control" value="<?php echo $cliente; ?>">
                            <span class="help-block"><?php echo $cliente_err; ?></span>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="admin.php" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>

</body>

</html>