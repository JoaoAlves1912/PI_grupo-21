<?php
session_start();
if (empty($_SESSION['logado']) || $_SESSION['logado'] == false)
    header('location: ../index.php');

require_once('../../BACKEND/MODELS/conexao_db.php');
require_once('../../BACKEND/MODELS/medico.php');
$medico_model = new Medico($pdo);
$especialidades = $medico_model->buscarTodasEspecialidades();
?>


<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Médicos Recomendados</title>
    <link rel="stylesheet" href="../CSS/styles5.css">
</head>

<body>
    <div class="container">
        <div class="menu-icon">
            <button onclick="location.href='profilePg.php'">←</button>
        </div>
        <div class="header">
            <h1>Médicos Recomendados</h1>
        </div>

        <div class="content">
            <div class="search-box">
                <div class="form-group">
                    <label for="especialidade">Especialidade:</label>
                    <select id="especialidade" class="form-control">
                        <option value="">Selecione uma especialidade</option>
                        <?php foreach ($especialidades as $esp): ?>
                            <option value="<?= htmlspecialchars($esp); ?>"><?= htmlspecialchars($esp); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <button id="buscar-medicos" class="button">Buscar Médicos Próximos</button>
            </div>

            <div id="resultados" class="results">
                <p>Selecione uma especialidade e permita o acesso à sua localização para encontrar médicos próximos.</p>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('buscar-medicos').addEventListener('click', function () {
            const especialidade = document.getElementById('especialidade').value;

            if (!especialidade) {
                alert('Por favor, selecione uma especialidade.');
                return;
            }

            // Mostrar loading
            document.getElementById('resultados').innerHTML = '<p>Buscando médicos...</p>';

            fetch(`../../BACKEND/CONTROLLERS/medico_controller.php?especialidade=${encodeURIComponent(especialidade)}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Erro na requisição');
                    }
                    return response.json();
                })
                .then(data => {
                    const resultados = document.getElementById('resultados');

                    if (data.error) {
                        resultados.innerHTML = `<p class="error">${data.error}</p>`;
                        return;
                    }

                    if (data.length === 0) {
                        resultados.innerHTML = '<p>Nenhum médico encontrado para essa especialidade.</p>';
                        return;
                    }

                    let html = '<h2>Médicos Encontrados</h2><div class="medicos-list">';

                    data.forEach(medico => {
                        html += `
                <div class="medico-card">
                    <h3>${medico.nome}</h3>
                    <p><strong>Especialidade:</strong> ${medico.especialidade}</p>
                    <p><strong>Endereço:</strong> ${medico.endereco}</p>
                    <p><strong>Telefone:</strong> ${medico.telefone}</p>
                    <a href="tel:${medico.telefone}" class="button small">Ligar</a>
                </div>
                `;
                    });

                    html += '</div>';
                    resultados.innerHTML = html;
                })
                .catch(error => {
                    console.error('Erro:', error);
                    document.getElementById('resultados').innerHTML =
                        '<p class="error">Ocorreu um erro ao buscar médicos. Por favor, tente novamente.</p>';
                });
        });
    </script>
</body>

</html>