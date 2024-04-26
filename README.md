# CSDS 285 Portfolio
Link: http://eecslab-23.case.edu/~fyh5/portfolio/

## Projects
- <b>IP Address Identifier</b>: simple PHP script that outputs what the visiting user's IP address is
    - Relevant files:
        - `ip_address.php`
- <b>Calculator</b>: simple 4 function calculator implemented via PHP
    - Relevant files:
        - `calculator.php`
- <b>Pokemon Type Filter</b>: web service that uses awk and PHP to find pokemon based on specified types.
    - Relevant files:
        - `find_pokemon_by_type.php`
- <b>Resource Monitor</b>: displays graphs of CPU usage (us, sy, id, wa) and load average over the past 2 days based on the `top` command using grep, cut, and Chart.js
    - Relevant files:
        - `resource_monitor.php` - web page
        - `get_top.sh` - script that runs in the background to gather info from `top`, and outputs to a text file
- <b>UUID Generator</b>: web service that generates UUIDs
    - Relevant files:
        - `uuid_generator.php`
- <b>Word Frequencies</b>: web service that finds the top 10 most frequent words and punctuation in a piece of text
    - Relevant files:
        - `word_frequencies.php` - UI for input
        - `word_frequencies.sh` - carrying out the calculation