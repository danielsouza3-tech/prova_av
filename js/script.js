document.addEventListener("DOMContentLoaded", function () {

    const form = document.getElementById("form-cad");
    if (!form) return;

    form.addEventListener("submit", function (event) {
        
        const nome = document.getElementById("nome").value.trim();

        if (nome.length < 2) {
            event.preventDefault();
            alert("Preencha o nome corretamente (mínimo 2 caracteres).");
            return false;
        }

    });
});