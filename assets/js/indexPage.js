// COLOR BUTTONS SELECTED
let type = document.getElementById('search_type')
let rarity = document.getElementById('search_rarity')
let series = document.getElementById('search_series')

function colorButton(labels) {
    for (const label of labels) {
        label.addEventListener("click", function () {
            label.classList.toggle('checked')
        })
    }
}

if (type && rarity && series) {
    let typeLabel = type.getElementsByTagName('label')
    let rarityLabel = rarity.getElementsByTagName('label')
    let seriesLabel = series.getElementsByTagName('label')

    colorButton(typeLabel)
    colorButton(rarityLabel)
    colorButton(seriesLabel)
}


// ADD TO COLLECTION
let pokeballs = document.getElementsByClassName('pokeball')

if (pokeballs) {
    for (const pokeball of pokeballs) {
        pokeball.addEventListener('click', function () {
            let id = pokeball.id
            fetch('/api/addToCollection/' + id)
                .then(response => response.json())
                .then(add => {
                    if (add == true) {
                        pokeball.classList.toggle("opacity")
                    }
                })
        })

        pokeball.addEventListener('mouseover', function () {
            pokeball.classList.toggle("opacity")
        })

        pokeball.addEventListener('mouseleave', function () {
            pokeball.classList.toggle("opacity")
        })
    }
}

