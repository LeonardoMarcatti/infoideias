<?php

use ClanCats\Hydrahon\Query\Sql\Exists;

if (isset($_POST['year'])) {
        $year = filter_input(INPUT_POST, 'year', FILTER_SANITIZE_NUMBER_INT);

        function SeculoAno($year)
        {
            if ($year != '') {
                $length = strlen($year);
                $last_two_digits = substr($year, $length-2, 2);
                return ($last_two_digits != '00') ? (int)substr($year, 0, ($length-2))+1 : (int)substr($year, 0, ($length-2));
            } else {
                return 'Digite o ano';
            };
        };

        $sec = SeculoAno($year);
    };

    if (isset($_POST['number'])) {
        $number = filter_input(INPUT_POST, 'number', FILTER_SANITIZE_NUMBER_INT);
        $numbers = [];
        $max = '';

        if ($number > 1) {
            for ($i=1; $i < $number; $i++) { 
                array_push($numbers, $i);
            };
    
            for ($i2=0; $i2 < $number; $i2++) { 
                for ($i3=1; $i3 < $i2; $i3++) { 
                    if($i2%$i3 == 0 && ($i3 != 1)){
                        $found = array_search($i2, $numbers);
                        unset($numbers[$found]);
                    };
                };
            };
            $max = max($numbers);
        } else {
           $max = 0;
        };
    };
    $randon_numbers = [];
    
    if (isset($_POST['val'])) {
        

        for ($i=0; $i < 20; $i++) { 
            array_push($randon_numbers, rand(1, 10));
        };

        $occ = array_count_values($randon_numbers);
        $max2 = max($occ);
        $max_numbers = [];
        $string = '';
        foreach ($occ as $key => $value) {
            if ($value == $max2) {
                array_push($max_numbers, $key);
            };
        };
        //print_r(count($max_numbers));
        for ($i=0; $i < count($max_numbers); $i++) { 
            if ($i == count($max_numbers)-1) {
                $string .= $max_numbers[$i];
            } else {
                $string .= $max_numbers[$i] . ', ';
            };
        };
    };

    if ($_POST['grow_array'] != '') {
        $array = explode(',',  $_POST['grow_array']);
        asort($array);
        $length = count($array);
        $removed_item = rand(0, $length-1);
        array_splice($array, $removed_item, 1);
        $grow = 'False';
        for ($i=0; $i < $length-1; $i++) {
            if (isset($array[$i+1])) {
               if ($array[$i+1] > $array[$i]) {
                   $grow = 'True';
               } else {
                    $grow = 'False';
                   break;                   
               };
            };
        };
        unset($_POST['grow_array']);
    };
?>

<!DOCTYPE html>
<html lang="pt_BR">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link rel="icon" href="https://phproberto.gallerycdn.vsassets.io/extensions/phproberto/vscode-php-getters-setters/1.2.3/1525759974843/Microsoft.VisualStudio.Services.Icons.Default" type="image/gif" sizes="16x16">
        <style>
            #quadro{
                width: 500px;
                height: auto;
                background-color: silver;
                margin: 10px auto;
                border-radius: 20px;
                padding: 20px;
            }

            h1{
                margin: 10px auto;
                font-size: 50px;
            }
            p{
                text-indent: 1rem;
            }
        </style>
        <title>Teste</title>
    </head>
    <body>
        <div class="container-fluid">
            <div id="quadro">
                <form action="desafio.php" method="post">
                    <div class="mb-3">
                        <input type="text" name="year" id="year" class="form-control">
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Verificar Século</button>
                        <button type="reset" class="btn btn-warning">Limpa</button>
                    </div>
                </form>    
               <h3>Século: <?=(isset($sec)) ? $sec : '' ;?></h3>
               <hr>
               <br><br>
               <form action="desafio.php" method="post">
                    <div class="mb-3">
                        <input type="number" name="number" id="number" class="form-control">
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Verificar Primo</button>
                        <button type="reset" class="btn btn-warning">Limpa</button>
                    </div>
                    <h3>Maior primo: 
                        <?php
                           echo (isset($max)) ? $max : '';
                        ?>
                    </h3>
               </form>
               <hr>
               <br><br>
                <form action="" method="post">
                    <h3>Números Aleatórios</h3>
                    <input type="text"  name="val" id="val" hidden>
                    <div class="mb-3">
                        <?php
                            if (isset($randon_numbers)) {
                                foreach ($randon_numbers as $key => $value) {
                                    if ($key == 19) {
                                        echo $value;
                                    } else{
                                        echo $value . ' ,';
                                    };
                                };
                            };
                        ?>
                    </div>
                    <div class="mb-3">
                        <p>Numero(s) que mais se repete(m): <?= (isset($string)) ? $string : '' ; ?> </p>
                    </div>
                    <div class="mb-3">
                        <p>Número de repetições: <?= (isset($max2)) ? $max2 : '' ;?></p>
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Sortear</button>
                    </div>
                </form>
                <hr>
                <br><br>
                <div class="mb-3">
                    <p>Abaixo, digite um número que será adicionado ao array no campo inferior.</p>
                </div>
                <form action="desafio.php" method="post">
                    <div class="mb-3">
                        <label for="grow_number" class="form-label">Digite um número:</label>
                        <input type="number" name="grow_number" id="grow_number" class="form-control">
                        <button type="button" class="btn btn-primary" id="add">Adicionar</button>
                    </div>
                    <div class="mb-3">
                        <label for="grow_array" class="form-label">Seu array:</label>
                        <input type="text" name="grow_array" id="grow_array" class="form-control" readonly>
                    </div>
                    <div class="mb-3">
                        <p id="response"><?= (isset($grow)) ? $grow : '' ;?></p>
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Crescente?</button>
                    </div>
                    <?php
                        if (isset($array)) {
                            echo 'Seu array é: [';
                            for ($i=0; $i < count($array); $i++) {
                                if ($i == (count($array)-1)) {
                                    echo $array[$i] . ']';
                                } else {
                                    echo $array[$i] . ', ';
                                };
                            };
                        };

                        unset($grow, $array);
                    ?>             
                </form>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
        <script src="https://kit.fontawesome.com/ec29234e56.js" crossorigin="anonymous"></script>
        <script>
            $('#add').on('click', () =>{
                let added_number = $('#grow_number').val();
                let myarray = $('#grow_array').val();
                if (myarray != '') {
                    $('#grow_array').val($('#grow_array').val() + ', ' + added_number);
                } else {
                    $('#grow_array').val(added_number);
                };
            });
            
        </script>
    </body>
</html>