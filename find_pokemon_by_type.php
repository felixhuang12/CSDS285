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
    <form method="post">
        <label for="type">Enter a Pokemon type (e.g. fire, water, grass, etc.):</label><br>
        <input type="text" id="type" name="type"><br><br>
        <input type="submit" value="Search">
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $type = $_POST["type"];
        $cmd = "awk -F, 'tolower(\$3) == tolower(\"$type\") || tolower(\$4) == tolower(\"$type\") { print }' ./datasets/pokemon.csv";
        exec($cmd, $output);

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
        } else {
            echo "<p>No Pokemon found for type '$type'.</p>";
        }
    }
    ?>
</body>
</html>