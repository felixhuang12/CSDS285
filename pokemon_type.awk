# Usage: execute 'awk -f pokemon_type.awk' at the root of the repo

BEGIN {
    print "Enter a Pokemon type (e.g. fire, water, grass, etc.): "
    getline type < "-"

    cmd = "awk -F, 'tolower($3) == tolower(\""type"\") || tolower($4) == tolower(\""type"\") { print }' ./datasets/pokemon.csv"
    system(cmd)
}
