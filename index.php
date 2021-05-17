<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pokemon challange</title>
</head>
<body>
    <form name="form" action="index.php" method="get">
        <input type="text" name="name" placeholder="Name/ID" />
        <button id="submit" value="button" class="button">Search</button>
    </form> 
    

    <?php
        $name = $_GET['name'];
   
        $api_url = "https://pokeapi.co/api/v2/pokemon/$name";
        $json_data = file_get_contents($api_url); // Read JSON file
        $response_data = json_decode($json_data); // Decode JSON data into PHP array

       // $poke_forms = $response_data->forms; // Info that exists in 'forms'
        $poke_img = $response_data->sprites->front_default;
        $poke_name = $response_data->forms[0]->name;

        echo "name: ".$poke_name;
        echo "<br />";
        echo "id: ".$response_data->id;
        echo "<br />";
        
        echo "<img src='".$poke_img."'>";
               
    ?> 

</body>
</html>