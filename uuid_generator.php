<!DOCTYPE html>
<html>
<head>
    <title>UUID Generator</title>
    <script>
        function copyText(id) {
            var r = document.createRange();
            r.selectNode(document.getElementById(id));
            window.getSelection().removeAllRanges();
            window.getSelection().addRange(r);
            document.execCommand('copy');
            window.getSelection().removeAllRanges();
        }
    </script>
</head>
<body>
    <h2>UUID Generator</h2>
    <form method="post">
        <label for="quantity">Enter the number of UUIDs to generate (optional: 1 will be generated if left blank):</label><br>
        <input type="number" id="quantity" name="quantity" min="1" max="100"><br><br>
        
        <input type="submit" value="Generate">
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $quantity = $_POST["quantity"];
        $cmd = "uuidgen -r";
        $output = [];
        
        if (!empty($quantity)) {
            for ($i = 0; $i < $quantity; $i++) {
                $output[$i] = shell_exec($cmd);
            }
        } else {
            $output[0] = shell_exec($cmd);
        }

        if (!empty($output)) {
            echo "<h3>Generated UUIDs:</h3>";
            echo "<div>";
            foreach ($output as $index => $uuid) {
                echo "<div id='uuid$index'>$uuid</div>";
                echo "<button onclick='copyText(\"uuid$index\")'>Copy</button><br>";
            }
            echo "</div>";
        }
    }
    ?>
</body>
</html>