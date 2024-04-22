<center>
    <?php
        echo "<form method='post' action=''>";
        echo "<input type='text' name='num1' placeholder='First number'>";
        echo "<input type='text' name='num2' placeholder='Second number'>";
        echo "<select name='operator' id='operator'>";
        echo "<option value='add'>Add</option>";
        echo "<option value='subtract'>Subtract</option>";
        echo "<option value='multiply'>Multiply</option>";
        echo "<option value='divide'>Divide</option>";
        echo "</select>";
        echo "<input type='submit' name='submit'>";
        echo "</form>";

        function getResult($a, $b, $operator) {
            switch ($operator) {
                case 'add':
                    return $a + $b;

                case 'subtract':
                    return $a - $b;

                case 'multiply':
                    return $a * $b;

                case 'divide':
                    if ($b != 0) {
                        return $a / $b;
                    } else {
                        return "Division by zero error";
                    }

                default:
                    return false;
            }
        }

        if (isset($_POST['submit'])) {
            $result = getResult($_POST['num1'], $_POST['num2'], $_POST['operator']);

            if ($result !== FALSE) {
                echo "<br>" . $result;
            } else {
                echo "An error occurred";
            }
        }
    ?>
</center>