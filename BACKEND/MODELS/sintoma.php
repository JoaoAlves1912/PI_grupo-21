<?php

class Sintoma
{
    private $conexao;

    public function __construct($cone)
    {
        $this->conexao = $cone;
    }

    // Método para cadastrar um sintoma
    public function cadastrar($userId, $sintoma, $description)
    {
        $sql = "INSERT INTO sintomas (user_id, sintoma, description) VALUES (:user_id, :sintoma, :description)";
        $stmt = $this->conexao->prepare($sql);
        $stmt->bindParam(':user_id', $userId);
        $stmt->bindParam(':sintoma', $sintoma);
        $stmt->bindParam(':description', $description);

        if ($stmt->execute()) {


            $sintomas = $this->buscarSintomas($userId);
            $_SESSION['sintomas'] = $sintomas;

            header('Location: ../../FRONTEND/VIEWS/sintomaPg.php');
            return true; // Sintoma cadastrado com sucesso
        } else {
            header('Location: ../../FRONTEND/VIEWS/error.php');
            throw new Exception('Erro ao cadastrar o sintoma: ' . implode(', ', $stmt->errorInfo()));
        }
    }
    public function buscarSintomas($userId)
    {
        $sql = "SELECT sintoma, description FROM sintomas WHERE user_id = ?";
        $stmt = $this->conexao->prepare($sql); // Usa a conexão já definida
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Método para deletar um sintoma por ID
    public function deletar($id)
    {
        $sql = "DELETE FROM sintomas WHERE id = :id";
        $stmt = $this->conexao->prepare($sql);
        $stmt->bindParam(':id', $id);

        if ($stmt->execute()) {
            return true; // Sintoma deletado com sucesso
        } else {
            throw new Exception('Erro ao deletar o sintoma: ' . implode(', ', $stmt->errorInfo()));
        }
    }
}
?>