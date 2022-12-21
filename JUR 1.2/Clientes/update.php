<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$name  = $sobrenome = $cpf = "";
$name_err  = $sobrenome_err = $cpf_err = "";
 
// Processing form data when form is submitted
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Get hidden input value
    $id = $_POST["id"];
    
    $input_name = trim($_POST["name"]);
    if(empty($input_name)){
        $name_err = "Digite um nome.";
    } elseif(!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $name_err = "Entre um nome válido.";
    } else{
        $name = $input_name;
    }

    // Validade surname
    $input_sobrenome = trim($_POST["sobrenome"]);
    if(empty($input_sobrenome)){
        $sobrenome_err = "Por favor digite um sobrenome.";
    } elseif(!filter_var($input_sobrenome, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $sobrenome_err = "Entre um sobrenome válido.";
    } else{
        $sobrenome = $input_sobrenome;
    }

    // Validate cpf
    $input_cpf = trim($_POST["cpf"]);
    if(empty($input_cpf)){
        $cpf_err = "Por favor digite um cpf.";
    } elseif(!preg_match('/^\d{11}$/', $input_cpf)){
        $cpf_err = "Entre um cpf válido com 11 dígitos.";
    } else {
        $cpf = $input_cpf;

}  
    // Check input errors before inserting in database
    if(empty($name_err) && empty($sobrenome_err) && empty($cpf_err) ){
        // Prepare an update statement
        $sql = "UPDATE cliente_adv SET name=:name, sobrenome=:sobrenome, cpf=:cpf WHERE id=:id";
 
        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":id", $param_id);
            $stmt->bindParam(":name", $param_name);
            $stmt->bindParam(":sobrenome", $param_sobrenome);
            $stmt->bindParam(":cpf", $param_cpf);

            
            
            // Set parameters
            $param_id = $id;
            $param_name = $name;
            $param_sobrenome = $sobrenome;
            $param_cpf = $cpf;

            
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Records updated successfully. Redirect to landing page
                header("location: clientes.php");
                exit();
            } else{
                echo "Error.";
            }
        }
         
        // Close statement
        unset($stmt);
    }
    
    // Close connection
    unset($pdo);
} else{
    // Check existence of id parameter before processing further
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        // Get URL parameter
        $id =  trim($_GET["id"]);
        
        // Prepare a select statement
        $sql = "SELECT * FROM cliente_adv WHERE id = :id";
        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":id", $param_id);
            
            // Set parameters
            $param_id = $id;
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                if($stmt->rowCount() == 1){
                    /* Fetch result row as an associative array. Since the result set
                    contains only one row, we don't need to use while loop */
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                
                    // Retrieve individual field value
                    $name = $row["name"];
                    $sobrenome = $row["sobrenome"];
                    $telefone = $row["cpf"];



                } else{
                    // URL doesn't contain valid id. Redirect to error page
                    header("location: error.php");
                    exit();
                }
                
            } else{
                echo "Error.";
            }
        }
        
        // Close statement
        unset($stmt);
        
        // Close connection
        unset($pdo);
    }  else{
        // URL doesn't contain id parameter. Redirect to error page
        header("location: error.php");
        exit();
    }
}
?>
 
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Update</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5">Update de Cadastro</h2>
                    <p>Editar valores no cadastro.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                    <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" maxlength="100" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $name; ?>">
                            <span class="invalid-feedback"><?php echo $name_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Sobrenome</label>
                            <input type="text" name="sobrenome" maxlength="45" class="form-control <?php echo (!empty($sobrenome_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $sobrenome; ?>">
                            <span class="invalid-feedback"><?php echo $sobrenome_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Cpf</label>
                            <input type="text" name="cpf" maxlength="11" class="form-control <?php echo (!empty($cpf_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $cpf; ?>">
                            <span class="invalid-feedback"><?php echo $cpf_err;?></span>
                        </div>

                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="clientes.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>