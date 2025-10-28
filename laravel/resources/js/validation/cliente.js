document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("form-cliente");
    if (!form) return;

    form.addEventListener("submit", function (e) {
        //Errors: Adicionar as mensagens de erros neste array
        const errors = [];
        const nome = this.querySelector('input[name="nome"]').value.trim();
        const cpf = this.querySelector('input[name="cpf"]').value.trim();
        const email = this.querySelector('input[name="email"]').value.trim();

        // Nome: obrigatório, pelo menos 3 caracteres e apenas letras
        if (!nome) {
            errors.push("Nome é obrigatório.");
        } else if (nome.length < 3) {
            errors.push("Nome deve ter pelo menos 3 caracteres.");
        } else if (!/^[A-Za-zÀ-ÖØ-öø-ÿ\s]+$/.test(nome)) {
            errors.push("Nome deve conter apenas letras e espaços.");
        }

        // CPF: obrigatório e exatamente 11 dígitos
        const cpfDigits = cpf.replace(/\D/g, "");
        if (!cpf) {
            errors.push("CPF é obrigatório.");
        } else if (cpfDigits.length !== 11) {
            errors.push("CPF deve conter exatamente 11 dígitos.");
        }

        // Email: obrigatório e formato válido
        if (!email) {
            errors.push("Email é obrigatório.");
        } else {
            const re =
                /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\\.,;:\s@\"]+\.)+[^<>()[\]\\.,;:\s@\"]{2,})$/i;
            if (!re.test(email)) errors.push("Email inválido.");
        }
        //errosDiv: Exibe o array com as mensagens de erro
        const errorsDiv = document.getElementById("cliente-errors");
        if (errors.length) {
            e.preventDefault();
            errorsDiv.classList.remove("d-none");
            errorsDiv.innerHTML =
                "<ul><li>" + errors.join("</li><li>") + "</li></ul>";
            window.scrollTo({
                top: errorsDiv.offsetTop - 20,
                behavior: "smooth",
            });
        }
    });
});
