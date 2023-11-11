const form = document.querySelector("#registroForm")
const userName = document.querySelector("#name");
const userPassword = document.querySelector("#password");
const userEmail = document.querySelector("#email");
const confirmPassword = document.querySelector("#senha-confirm");

form.addEventListener('submit', async function (e) {
    e.preventDefault(); // Impede o envio padrão do formulário

    if (password.value !== confirmPassword.value) {
        alert('As senhas não coincidem.');
        return;
    }
    const formData = new FormData();
    formData.append('name', userName.value);
    formData.append('password', userPassword.value);
    formData.append('email', userEmail.value);
    try {
        const response = await fetch("../api/register.php", {
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
        } else {
            alert("Usuário cadastrado com sucesso")
            window.location.href = 'index.html'
        }
    
        const json = await response.json();
        console.log('Resposta do servidor:', json);
        // Faça o que quiser com a resposta JSON, como redirecionar o usuário se a autenticação for bem-sucedida
    } catch (error) {
        console.error('Erro na solicitação:', error);
    }
});