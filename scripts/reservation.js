const reservationForm = document.querySelector("form");

reservationForm.addEventListener('submit', async function (e) {
    e.preventDefault(); // Impede o envio padrão do formulário

    const nome = document.querySelector("#name").value;
    const date = document.querySelector("#date").value;
    const hour = document.querySelector("#hour").value;
    const peopleNumber = document.querySelector("#peopleNumber").value;
    const info = document.querySelector("#info").value;

    const formData = new FormData();
    formData.append('name', nome);
    formData.append('date', date);
    formData.append('hour', hour);
    formData.append('peopleNumber', peopleNumber);
    formData.append('info', info);

    try {
        const response = await fetch("../api/reservation.php", {
            method: 'POST',
            body: formData
        });

        if (!response.ok) {
            // Verifica se a resposta tem um código de erro (ex: 400 Bad Request)
            const json = await response.json();
            if (response.status === 400) {
                alert("[ERROR] " + json.error);
            } else {
                console.error('Erro na solicitação:', json);
            }
            return;
        }

        const json = await response.json();
        console.log('Resposta do servidor:', json);
        alert("Reserva cadastrada com sucesso!");

        // Você pode adicionar mais ações aqui, como redirecionar o usuário para outra página

    } catch (error) {
        console.error('Erro na solicitação:', error);
    }
});
