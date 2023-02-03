/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.scss';
require('bootstrap');

// start the Stimulus application
import './bootstrap';


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
                    } else {
                        document.location.pathname = '/login'
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

// ADD OPTION TO COUNTRY TYPE FIELD
let country = document.getElementById('registration_form_country')
let countryBis = document.getElementById('user_country')

if (country) {
    let option = document.createElement("option");
    option.value = ""
    option.text = ""
    option.disabled = true
    option.selected = true
    country.add(option)
}

if (countryBis) {
    let option = document.createElement("option");
    option.value = ""
    option.text = ""
    option.disabled = true
    option.selected = true
    country.add(option)
}


// SCROLL TO TOP BUTTON
let mybutton = document.getElementById("topButtonDiv");

window.onscroll = function () { scrollFunction() };

function scrollFunction() {
    if (document.body.scrollTop > 10 || document.documentElement.scrollTop > 10) {
        mybutton.style.display = "flex";
    } else {
        mybutton.style.display = "none";
    }
}