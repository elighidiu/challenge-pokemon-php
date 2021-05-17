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
        //isset function — will determine if a variable is declared and is different than null
       if(isset($_GET['name'])){ 
            $name = strtolower($_GET['name']); // strtoupper will convert text to lowercase
            $api_url = "https://pokeapi.co/api/v2/pokemon/$name";
            $api_species = "https://pokeapi.co/api/v2/pokemon-species/$name"; 
       } else {
            $api_url = "https://pokeapi.co/api/v2/pokemon/1";
            $api_species = "https://pokeapi.co/api/v2/pokemon-species/1";
       }

        $json_data = file_get_contents($api_url); // Read JSON file
        $json_data_species = file_get_contents($api_species); // Read JSON file

        $response_data = json_decode($json_data); // Decode JSON data into PHP array
        $response_data_species = json_decode($json_data_species); // Decode JSON data into PHP array

        $poke_img = $response_data->sprites->front_default;
        $poke_name = ucfirst($response_data->forms[0]->name); //ucfirst will write the first letter in capital
        $poke_move = $response_data->moves;

        $species = $response_data_species->evolves_from_species;

        if($species!==NULL){
            $previous_poke = $response_data_species->evolves_from_species; //get the name of the previous species
        }
   
    ?>

        <?php echo "<h2>".$poke_name." (#".$response_data->id.")</h2>"; ?>
        <?php echo "<img src='".$poke_img."'>"; ?>
        
        <ul>
            <p>Moves</p>
            <?php for ($i=0; $i<4; $i++){
                echo "<li>".$poke_move[$i]->move->name."</li>"; //displays the moves in a list
                //"Move: ".$poke_move[$i]->move->name;   
                }  
            ?>
        </ul>
 

</body>
</html>