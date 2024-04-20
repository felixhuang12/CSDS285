<!DOCTYPE html>
<html>
<head>
    <title>Pokemon Type Search</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h2>Search Pokemon by Type</h2>
    <p>Types: Normal, Fire, Water, Grass, Electric, Ice, Fighting, Poison, Ground, Flying, Psychic, Bug, Rock, Ghost, Dark, Dragon, Steel, Fairy</p>
    <form method="post">
        <label for="primary_type">Enter a Pokemon primary type:</label><br>
        <input type="text" id="primary_type" name="primary_type"><br><br>
        
        <label for="secondary_type">Enter a Pokemon secondary type (optional):</label><br>
        <input type="text" id="secondary_type" name="secondary_type"><br><br>
        
        <input type="submit" value="Search">
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $primary_type = $_POST["primary_type"];
        $secondary_type = $_POST["secondary_type"];
        $cmd = "awk -F, 'tolower(\$3) == tolower(\"$primary_type\") && tolower(\$4) == tolower(\"$secondary_type\") || tolower(\$3) == tolower(\"$secondary_type\") && tolower(\$4) == tolower(\"$primary_type\") { print }' ./datasets/pokemon.csv";
        
        if (!empty($primary_type) && !empty($secondary_type)) {
            exec($cmd, $output);
        } elseif (!empty($primary_type)) {
            $cmd = "awk -F, 'tolower(\$3) == tolower(\"$primary_type\") || tolower(\$4) == tolower(\"$primary_type\") { print }' ./datasets/pokemon.csv";
            exec($cmd, $output);
        } else {
            echo "<p>Please enter at least one type.</p>";
        }

        if (!empty($output)) {
            echo "<h3>Search Results:</h3>";
            echo "<table>";
            echo "<tr><th>#</th><th>Name</th><th>Type 1</th><th>Type 2</th><th>Total</th><th>HP</th><th>Attack</th><th>Defense</th><th>Sp. Atk</th><th>Sp. Def</th><th>Speed</th><th>Generation</th><th>Legendary</th></tr>";
            foreach ($output as $pokemon) {
                echo "<tr>";
                $attributes = explode(",", $pokemon);
                foreach ($attributes as $attribute) {
                    echo "<td>$attribute</td>";
                }
                echo "</tr>";
            }
            echo "</table>";
        } elseif (!empty($primary_type)) {
            $error_msg = !empty($secondary_type) ? "for types '$primary_type' and '$secondary_type'" : "for type '$primary_type'";
            echo "<p>No Pokemon found $error_msg.</p>";
        }
    }
    ?>
</body>
</html>
