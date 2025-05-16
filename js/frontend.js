function buscar() {
    const numero = document.getElementById("numero_reloj").value;

    fetch(`http://localhost:3006/solicitudes/${numero}`)
        .then(res => res.json())
        .then(data => {
            document.getElementById("resultado").textContent = JSON.stringify(data, null, 2);
        })
        .catch(err => {
            console.error("Error al buscar:", err);
        });
}
