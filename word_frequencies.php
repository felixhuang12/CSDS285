<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Word and Punctuation Frequency Analyzer</title>
</head>
<body>
    <h1>Word and Punctuation Frequency Analyzer</h1>
    <form action="" method="post">
        <label for="text">Paste your text here:</label><br>
        <textarea name="text" id="text" rows="10" cols="50"></textarea><br>
        <input type="submit" name="submit" value="Analyze">
    </form>
    <p>Submit blank text if you would like to see the frequency of words and punctuation in <a href="https://www.gutenberg.org/cache/epub/84/pg84.txt">Frankenstein</a></p>

    <?php
        if(isset($_POST['submit'])) {
            if(isset($_POST['text']) && !empty($_POST['text'])) {
                $text = $_POST['text'];

                $temp_file = tempnam(sys_get_temp_dir(), 'word_freq_');
                $file_handle = fopen($temp_file, "w");
                fwrite($file_handle, $text);
                fclose($file_handle);

                $output = shell_exec("bash word_frequencies.sh $temp_file");;
                echo "<pre>$output</pre>";
                unlink($temp_file);
            } else {
                $output = shell_exec("bash word_frequencies.sh ./datasets/frankenstein.txt");;
                echo "<pre>$output</pre>";
            }
        }
    ?>
</body>
</html>
