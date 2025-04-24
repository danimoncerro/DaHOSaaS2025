<?php
// public/taraba-view.php

// Pornim sesiunea si includem fisierele necesare
session_start();
require_once '../autoload.php';

?><!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Taraba Hortigrup - Comandă Produse</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        input.qty {
            text-align: center;
        }
    </style>
</head>
<body class="w3-light-grey">
<div class="w3-container w3-margin-top w3-white w3-padding w3-round-large w3-card-4">
    <h2 class="w3-center w3-text-blue">Taraba Hortigrup</h2>
    <p class="w3-center">Produse proaspete, cultivate responsabil, livrate direct la tine acasă.</p>

    <div id="productContainer" class="w3-row w3-margin-top"></div>

    <form method="post" action="#" class="w3-container w3-margin-top">
        <div class="w3-row">
            <label for="email">Email:</label>
            <input class="w3-input w3-border" type="email" name="email" id="email" required>
        </div>

        <div class="w3-row w3-margin-top">
            <label>Metodă de plată:</label>
            <select class="w3-select w3-border" name="plata">
                <option value="cash">Cash</option>
                <option value="card">Card</option>
            </select>
        </div>

        <div class="w3-row w3-margin-top">
            <label for="address">Adresă:</label>
            <input class="w3-input w3-border" type="text" name="address" id="address" required>
        </div>

        <div class="w3-row w3-margin-top">
            <label for="obs">Observații:</label>
            <textarea class="w3-input w3-border" name="obs" id="obs"></textarea>
        </div>

        <button class="w3-button w3-blue w3-margin-top w3-block" type="submit">Lansează comanda</button>
    </form>
</div>

<script>
    fetch('get_products.php')
        .then(res => res.json())
        .then(products => {
            const container = document.getElementById('productContainer');
            container.innerHTML = '';
            let width = 100 / 3;
            products.forEach(product => {
                let div = document.createElement('div');
                div.className = 'w3-col s12 m4 w3-padding';
                div.innerHTML = `
                    <div class='w3-card-4 w3-white w3-padding w3-round'>
                        <img src="${product.pic || '/pics/default_HG.jpg'}" alt="${product.denumire}" class="w3-image" style="height:200px;object-fit:cover">
                        <h5 class='w3-text-blue'>${product.denumire}</h5>
                        <p><strong>${product.pret} RON</strong></p>
                        <input class="qty w3-input w3-border" type="number" min="0" name="qty_${product.cod_produs}" placeholder="Cantitate">
                    </div>
                `;
                container.appendChild(div);
            });
        });
</script>

</body>
</html>
