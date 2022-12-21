<?php
// Incluir config.php
require_once "config.php";
 
// variaveis
$name  = $sobrenome = $cpf ="";
$name_err  = $sobrenome_err = $cpf_err  =  "";
 
// Processar form enviada
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate name
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
    if(empty($name_err) && empty($sobrenome_err) && empty($cpf_err)
){
        // Prepare an insert statement
        $sql = "INSERT INTO jus_adv (name, sobrenome, cpf) VALUES (:name, :sobrenome, :cpf)";
 
        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":name", $param_name);
            $stmt->bindParam(":sobrenome", $param_sobrenome);
            $stmt->bindParam(":cpf", $param_cpf);
            



            
            // Set parameters
            $param_name = $name;
            $param_sobrenome = $sobrenome;
            $param_cpf = $cpf;
        

            
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Records created successfully. Redirect to landing page
                header("location: admin.php");
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
}
?>
 
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastrar</title>
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
                    <h2 class="mt-5">Cadastrar Contato</h2>
                    <p>Preencha os campos abaixo.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group">
                            <label>Nome</label>
                            <input type="text" name="name" maxlength="100" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $name; ?>" required>
                            <span class="invalid-feedback"><?php echo $name_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Sobrenome</label>
                            <input type="text" name="sobrenome" maxlength="45" class="form-control <?php echo (!empty($sobrenome_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $sobrenome; ?>" required>
                            <span class="invalid-feedback"><?php echo $sobrenome_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Cpf</label>
                            <input type="text" name="cpf" maxlength="45" class="form-control <?php echo (!empty($cpf_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $cpf; ?>" required>
                            <span class="invalid-feedback"><?php echo $cpf_err;?></span>
                        </div>

                        
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="admin.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>