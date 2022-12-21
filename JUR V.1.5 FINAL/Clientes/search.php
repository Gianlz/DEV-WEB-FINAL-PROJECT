<?php

    include('config.php');

    $column = array('nome', 'sobrenome', 'cpf', 'caso');

    $query = "SELECT * FROM students ";

    if(isset($_POST['filter_sobrenome']) && $_POST['filter_sobrenome'])
    {
       $query .= 'WHERE sobrenome = "'.$_POST['filter_sobrenome'];
    }

    if(isset($_POST['order']))
    {
       $query .= 'ORDER BY '.$column[$_POST['order']['0']['column']].$_POST['order']['0']['dir'];

    }else {
       $query .= 'ORDER BY id DESC ';
    }

    $query1 = '';

    if($_POST["length"] != -1)
    {
       $query1 = 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
    }

    $statement = $connect->prepare($query);
    $statement->execute();
    $number_filter_row = $statement->rowCount();
    $statement = $connect->prepare($query . $query1);
    $statement->execute();
    $result = $statement->fetchAll();

    $data = array();

    foreach($result as $row)
    {
        $sub_array = array();
        $sub_array[] = $row['nome'];
        $sub_array[] = $row['sobrenome'];
        $sub_array[] = $row['cpf'];
        $sub_array[] = $row['caso'];
        $data[] = $sub_array;
    }

    function count_all_data($connect)
    {
        $query = "SELECT * FROM cliente_adv";
        $statement = $connect->prepare($query);
        $statement->execute();
        return $statement->rowCount();
    }

    $output = array(
        "draw"       =>  intval($_POST["draw"]),
        "recordsTotal"   =>  count_all_data($connect),
        "recordsFiltered"  =>  $number_filter_row,
        "data"       =>  $data
    );

    echo json_encode($output);

?>
