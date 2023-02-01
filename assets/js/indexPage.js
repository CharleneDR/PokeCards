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