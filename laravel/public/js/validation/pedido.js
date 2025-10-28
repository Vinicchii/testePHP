document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('form-pedido');
    if (!form) return;

    form.addEventListener('submit', function(e) {
        const errors = [];
        const cliente = this.querySelector('select[name="cliente_id"]').value;
        const dt = this.querySelector('input[name="dt_pedido"]').value;

        if (!cliente) errors.push('Selecione um cliente.');
        if (!dt) errors.push('Informe a data do pedido.');

        // Validate produtos
        const produtoItems = this.querySelectorAll('.produto-item');
        let validProduto = false;
        produtoItems.forEach(function(item, idx) {
            const sel = item.querySelector('select');
            const qty = item.querySelector('input[type="number"]');
            const selVal = sel ? sel.value : '';
            const qtyVal = qty ? parseInt(qty.value) : 0;
            
            if (selVal && qtyVal > 0) validProduto = true;
            if (!selVal) errors.push('Produto na linha ' + (idx + 1) + ' não foi selecionado.');
            if (isNaN(qtyVal) || qtyVal < 1) errors.push('Quantidade na linha ' + (idx + 1) + ' deve ser >= 1.');
        });

        if (!validProduto) errors.push('Adicione pelo menos um produto com quantidade válida.');

        const errorsDiv = document.getElementById('pedido-errors');
        if (errors.length) {
            e.preventDefault();
            // remove duplicates
            const uniq = Array.from(new Set(errors));
            errorsDiv.classList.remove('d-none');
            errorsDiv.innerHTML = '<ul><li>' + uniq.join('</li><li>') + '</li></ul>';
            window.scrollTo({ top: errorsDiv.offsetTop - 20, behavior: 'smooth' });
        }
    });
});