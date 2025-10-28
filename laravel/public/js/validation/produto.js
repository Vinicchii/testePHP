"use strict";

document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("form-produto");
    if (!form) return;

    form.addEventListener("submit", function (e) {
        const errors = [];
        const nome = this.querySelector('input[name="nome"]').value.trim();
        const ean = this.querySelector('input[name="cod_barras"]').value.trim();
        const valor = parseFloat(
            this.querySelector('input[name="valor_unitario"]').value
        );
        if (!nome) errors.push("Nome do produto é obrigatório.");
        if (!ean) {
            errors.push("Código de barras é obrigatório.");
        } else if (ean.length !== 13) {
            errors.push("Código de barras deve ter exatamente 13 dígitos.");
        }

        if (isNaN(valor) || valor <= 0)
            errors.push("Valor unitário deve ser maior que zero.");

        const errorsDiv = document.getElementById("produto-errors");
        if (errors.length) {
            e.preventDefault();
            errorsDiv.classList.remove("d-none");
            errorsDiv.innerHTML =
                "<ul><li>" + errors.join("</li><li>") + "</li></ul>";
            window.scrollTo({
                top: errorsDiv.offsetTop - 20,
                behavior: "smooth",
            });
        } else {
            errorsDiv.classList.add("d-none");
            errorsDiv.innerHTML = "";
        }
    });
});
