
<!-- place logic on top 
next prev buttons
prev evolution clickable
-->

<?php 
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
        
    //isset function — will determine if a variable is declared and is different than null
       if(isset($_GET['name'])){
            $name = strtolower($_GET['name']); // strtoupper will convert text to lowercase            
            $api_url = "https://pokeapi.co/api/v2/pokemon/$name";
            $api_species = "https://pokeapi.co/api/v2/pokemon-species/$name"; 
            
            $headers = get_headers($api_url, 1); //get_headers() function can fetch headers sent by the server in response to an HTTP request.
    
            if ($headers[0] !=='HTTP/1.1 200 OK' || ($_GET['name'])==NULL) { //checking if HTTP response is diffrrent than OK or if search is NULL then display default info and message to perform a valid search
                echo "<p>Enter a valid search</p>";
                $api_url = "https://pokeapi.co/api/v2/pokemon/1";
                $api_species = "https://pokeapi.co/api/v2/pokemon-species/1";
            }
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
   

        if(($species)!==NULL){
            $previous_poke = $response_data_species->evolves_from_species->name; //get the name of the previous species
            $api_previous = "https://pokeapi.co/api/v2/pokemon/$previous_poke"; //access data for the new pokemon
            $json_data_previous = file_get_contents($api_previous); // Read JSON file
            $response_data_previous = json_decode($json_data_previous); // Decode JSON data into PHP array

            $previous_poke_name = ucfirst($response_data_previous->forms[0]->name);
            $previous_poke_id = $response_data_previous->id;
            $previous_poke_img = $response_data_previous->sprites->front_default;
        }

        function nextPoke($poke){
            return $poke->id + 1;
        }
        function prevPoke($poke){
                return $poke->id - 1;
        }

    ?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pokemon challange</title>
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">
</head>
<body>

    <h1>Pokedex</h1> 
 
    <div class="main">
        <div class="left">
            <form name="form" action="index.php" method="get">  
                <input class="input" type="text" name="name" placeholder="Name/ID" />
                <button id="submit" value="button" class="button">Search</button>
            </form> 
            <div class="contentLeft">
                <div class="container">
                    <?php echo "<h3>$poke_name (# $response_data->id )</h3>"; ?>
                </div>
                <div class="container">
                    <?php echo "<img src='".$poke_img."'>"; ?>
                </div>
                <div class="container">
                    <ul>
                        <p>Moves</p>
                        <?php 
                        if(sizeof($poke_move)>=4){ //if there are more than 4 moves display the first 4 moves, else display all (with the foreach method)
                            for ($i=0; $i<4; $i++){
                                echo "<li>".$poke_move[$i]->move->name."</li>"; //displays the moves in a list
                            } 
                        } else {
                            foreach($poke_move as $value){
                                echo $value->move->name;
                                }
                            }
                         
                        ?>
                    </ul>
                </div>
            </div>
            <div class="prevNext">
            <form  method="get">
            <input type="hidden" name="name" value="<?php echo nextPoke($response_data);?>" required />
            <input class="button" type="submit" name="submit" value="Next" />
        </form>
        <form  method="get">
            <input type="hidden" name="name" value="<?php echo prevPoke($response_data);?>" required />
            <input class="button" type="submit" name="submit" value="Previous" />
        </form>
            </div>
        </div>
        <div class="right">
            <div class="contentRight">
                <?php
                        if(($species)!==NULL){
                            echo "<div class='container'><p>Evolves from: </p><h3>".$previous_poke_name." (#".$response_data_previous->id.")</h3></div>";
                            echo "<div class='container'><img src='".$previous_poke_img."'></div>";       
                        } else {
                            echo "<p>There is no previous evolution</p>";
                            }
                ?>
            </div>
        </div>

</body>
</html>