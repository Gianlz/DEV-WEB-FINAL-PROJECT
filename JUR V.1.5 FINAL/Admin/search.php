<?php

    include('config.php');

    $column = array('first_name', 'gender', 'address', 'city', 'postalcode', 'country');

    $query = "SELECT * FROM students ";

    if(isset($_POST['filter_gender'], $_POST['filter_country']) && $_POST['filter_gender'] != '' && $_POST['filter_country'] != '')
    {
       $query .= 'WHERE gender = "'.$_POST['filter_gender'].'" AND country = "'.$_POST['filter_country'].'" ';
    }

    if(isset($_POST['order']))
    {
       $query .= 'ORDER BY '.$column[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' ';

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
        $sub_array[] = $row['first_name'];
        $sub_array[] = $row['gender'];
        $sub_array[] = $row['address'];
        $sub_array[] = $row['city'];
        $sub_array[] = $row['postalcode'];
        $sub_array[] = $row['country'];
        $data[] = $sub_array;
    }

    function count_all_data($connect)
    {
        $query = "SELECT * FROM students";
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