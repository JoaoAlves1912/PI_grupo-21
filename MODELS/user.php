<?php

class User
{

    private $conexao;

    public function __construct($cone)
    {
        $this->conexao = $cone;
    }

    public function criarCompleto($nome, $email, $senha, $idade, $profissao, $objetivo, $saude)
{
    if ($this->consultaEmail($email)) {
        // E-mail já em uso
        session_start();
        $_SESSION['erro'] = true;
        header('Location: ../VIEWS/registerPg.php');
        exit();
    } else {
        $sql = "INSERT INTO users (name, email, password, idade, profissao, objetivo, saude) 
                VALUES (:nome, :email, :senha, :idade, :profissao, :objetivo, :saude)";
        $stmt = $this->conexao->prepare($sql);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':senha', $senha);
        $stmt->bindParam(':idade', $idade);
        $stmt->bindParam(':profissao', $profissao);
        $stmt->bindParam(':objetivo', $objetivo);
        $stmt->bindParam(':saude', $saude);

        if ($stmt->execute()) {
            // Usuário cadastrado com sucesso
            session_start();
            $_SESSION['erro'] = false;
            header('Location: ../VIEWS/loginPg.php');
            exit();
        } else {
            throw new Exception('Erro ao registrar o usuário: ' . implode(', ', $stmt->errorInfo()));
        }
    }
}


    public function fazerLogin($email, $senha) {
    if ($this->consultaEmail($email) == false) {
        // Email não existe
        session_start();
        $_SESSION['erro'] = true;
        header("Location: ../VIEWS/loginPg.php");
        exit();
    } else {
        $user = $this->verificaSenha($email, $senha);
        if (empty($user)) {
            // Senha incorreta
            session_start();
            $_SESSION['erro'] = true;
            header("Location: ../VIEWS/loginPg.php");
            exit();
        } else {
            // Logando
            session_start();
            $emailLogado = $user['email'];
            $iduser = $user['id'];
            $userName = $user['name'];
            $userIdade = $user['idade'];
            $userProfissao = $user['profissao'];
            $userObjetivo = $user['objetivo'];
            $userSaude = $user['saude'];
            $_SESSION['erro'] = false;
            $_SESSION['logado'] = true;
            $_SESSION['email'] = $emailLogado;
            $_SESSION['iduser'] = $iduser;
            $_SESSION['name'] = $userName;
            $_SESSION['idade'] = $userIdade;
            $_SESSION['profissao'] = $userProfissao;
            $_SESSION['objetivo'] = $userObjetivo;
            $_SESSION['saude'] = $userSaude;
            
            // Buscar consultas do paciente logado
            $consultas = $this->buscarConsultas($iduser);
            $_SESSION['consultas'] = $consultas;
            
            // Buscar medicamentos do paciente logado
            $medicamentos = $this->buscarMedicamentos($iduser);
            $_SESSION['medicamentos'] = $medicamentos;

            $sintomas = $this->buscarSintomas($iduser);
            $_SESSION['sintomas'] = $sintomas;

            header("Location: ../VIEWS/profilePg.php");
            exit();
        }
    }
}
    public function buscarSintomas($userId)
    {
        $sql = "SELECT sintoma, description FROM sintomas WHERE user_id = ?";
        $stmt = $this->conexao->prepare($sql); // Usa a conexão já definida
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Método para buscar medicamentos do usuário logado
    public function buscarMedicamentos($userId)
    {
        $sql = "SELECT * FROM medicamentos WHERE user_id = ? ORDER BY hora  ";
        $stmt = $this->conexao->prepare($sql); // Corrigido de $this->db para $this->conexao
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }



    public function alterarSenha($senha, $novaSenha, $email)
    {
        if (empty($this->verificaSenha($email, $senha))) {
            //Senha antiga errada
            session_start();
            $_SESSION['erro'] = true;
            header("location: ../VIEWS/edit_passwordPg.php");
        } else {
            $sql = "UPDATE users SET password=:novaSenha WHERE email=:email";
            $stmt = $this->conexao->prepare($sql);
            $stmt->bindParam(':novaSenha', $novaSenha);
            $stmt->bindParam(':email', $email);

            if ($stmt->execute()) {
                //Senha alterada com sucesso !
                session_start();
                $_SESSION['erro'] = false;
            } else {
                echo "(ferrou) Erro ao alterar senha: " . $stmt->errorInfo()[2];
            }
            header("Location: ../VIEWS/profilePg.php");
        }
    }
    public function consultaEmail($email)
    {
        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->conexao->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        if ($stmt->rowCount() > 0)
            return true;
        else
            return false;
    }


    public function verificaSenha($email, $senha)
    {
        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->conexao->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch();
        if ($user && password_verify($senha, $user['password']))
            return $user;
        else
        return null;
}
public function buscarConsultas($userId) {
    $sql = "SELECT * FROM consultas WHERE user_id = ? ORDER BY data_consulta, hora_consulta";
    $stmt = $this->conexao->prepare($sql);
    $stmt->execute([$userId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

}