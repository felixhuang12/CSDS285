# Usage: execute 'awk -f pokemon.awk' at the root of the portfolio directory

BEGIN {
    printf "Enter a Pokemon type (e.g. fire, water, grass, etc.): "
    getline type < "-"

    cmd = "awk -F, 'tolower($3) == tolower(\""type"\") || tolower($4) == tolower(\""type"\") { print }' ./datasets/Pokemon.csv"
    system(cmd)
}
