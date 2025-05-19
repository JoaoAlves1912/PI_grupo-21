<?php
session_start();
if (empty($_SESSION['logado']) || $_SESSION['logado'] == false)
    header('location: ../index.php');
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/styles4.css">
    <title>Dicas</title>

</head>

<body>
    <div class="container">
        <div class="menu-icon">
            <button onclick="location.href='profilePg.php'">←</button>
        </div>
        <h1>Olá, <?php echo $_SESSION['name']; ?> </h1>

        <p>Bem-vindo à área de Educação e Suporte. Aqui você encontrará recursos para cuidar da sua saúde de forma
            personalizada.</p>
        <section id="content">
            <!-- Conteúdo dinâmico será carregado aqui -->
        </section>
    </div>

    <script>
        const dbConteudo = [
            {
                tipo: "article",
                titulo: "Como melhorar sua alimentação",
                resumo: "Descubra como criar um plano alimentar saudável e equilibrado.",
                link: "https://joaoalves1912.github.io/"
            },
            {
                tipo: "video",
                titulo: "Exercícios para iniciantes",
                url: "https://youtu.be/2QDa7fvR_h0"
            },
            {
                tipo: "video",
                titulo: "Bons Habitos",
                url: "https://youtu.be/hZeDUSxT9cU?si=Wwb5COCEw-NAgU8G"
            },
            {
                tipo: "tips",
                titulo: "Dicas de saúde",
                dicas: ["Beba pelo menos 2L de água por dia.", "Durma 7-8 horas por noite.", "Pratique atividade física regularmente."]
            }
        ];

        function carregarConteudo() {
            const contentSection = document.getElementById("content");

            dbConteudo.forEach(item => {
                let element;
                if (item.tipo === "article") {
                    element = document.createElement("div");
                    element.className = "article";
                    element.innerHTML = `
                        <h3>${item.titulo}</h3>
                        <p>${item.resumo}</p>
                        <a href="${item.link}" class="button" target="_blank">Ler Mais</a>
                    `;
                } else if (item.tipo === "video") {
                    const embedUrl = item.url.replace("youtu.be/", "www.youtube.com/embed/").split("?")[0];
                    element = document.createElement("div");
                    element.className = "video";
                    element.innerHTML = `
                        <h3>${item.titulo}</h3>
                        <iframe src="${embedUrl}" allowfullscreen></iframe>
                    `;
                } else if (item.tipo === "tips") {
                    element = document.createElement("div");
                    element.className = "tips";
                    element.innerHTML = `
                        <h3>${item.titulo}</h3>
                        <ul>
                            ${item.dicas.map(dica => `<li>${dica}</li>`).join("")}
                        </ul>
                    `;
                }
                contentSection.appendChild(element);
            });
        }

        document.addEventListener("DOMContentLoaded", carregarConteudo);
    </script>
</body>

</html>