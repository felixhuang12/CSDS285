<!DOCTYPE html>
<html>
<head>
    <title>Resource Monitor</title>
    <script>
        function updateData() {
            fetch('resource_monitor.php')
                .then(response => response.text())
                .then(data => {
                    document.getElementById("output").innerHTML = data;
                })
                .catch(error => console.error('Error:', error));
        }

        setInterval(updateData, 1000);
    </script>
</head>
<body>
    <div id="output">
        <?php
        function getInfo() {
            $cmd = "top -n 1 -b";
            exec($cmd, $output);
            return $output;
        }

        $output = getInfo();
        foreach ($output as $line) {
            echo "$line<br>";
        }
        ?>
    </div>
</body>
</html>
