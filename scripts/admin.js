// script.js

document.addEventListener('DOMContentLoaded', async function () {
    try {
        const response = await fetch('../api/showReservations.php'); // Ajuste o caminho conforme necessário
        const data = await response.json();

        // Limpa a tabela
        document.getElementById('reservationsTableBody').innerHTML = '';

        // Adiciona as reservas à tabela
        data.forEach(reservation => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${reservation.name}</td>
                <td>${reservation.reservationDate}</td>
                <td>${reservation.peopleNumber}</td>
                <td>${reservation.info}</td>
            `;
            document.getElementById('reservationsTableBody').appendChild(row);
        });
    } catch (error) {
        console.error('Erro ao obter as reservas:', error);
    }
});
