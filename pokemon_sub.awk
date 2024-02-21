# Usage: execute 'awk -f pokemon_sub.awk' at the root of the repo

function capitalize(word) {
    return toupper(substr(word,1,1)) substr(word,2)
}

BEGIN {
    print "Enter a Pokemon type (e.g. fire, water, grass, etc.): "
    getline type1 < "-"
    print "Enter another Pokemon type (e.g. fire, water, grass, etc.): "
    getline type2 < "-"
    type1 = tolower(type1)
    type1 = capitalize(type1)
    type2 = tolower(type2)
    type2 = capitalize(type2)
    printf "Swapping '%s' and '%s' types...\n", type1, type2
    print "-------------------------------------------------------"
    
    file = "./datasets/pokemon.csv"
    system("awk 'NR==1 { print }' " file)

    cmd = "awk -F, -v word1="type1" -v word2="type2" '{ \
        swapped = 0; \
        for (i=1; i<=NF; i++) { \
            if ($i == word1) { \
                $i = word2; \
                swapped = 1; \
            } else if ($i == word2) { \
                $i = word1; \
                swapped = 1; \
            } \
        } \
        if (swapped == 1) { \
            print; \
        } \
        }' " file
    system(cmd)
}
