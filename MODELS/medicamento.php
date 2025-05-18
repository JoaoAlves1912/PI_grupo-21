<?php

class Medicamento
{
    private $conexao;

    public function __construct($cone)
    {
        $this->conexao = $cone;
    }

    // Método para cadastrar um medicamento
    public function cadastrar($userId, $name, $hora)
    {
        $sql = "INSERT INTO medicamentos (user_id, name, hora) VALUES (:user_id, :name, :hora)";
        $stmt = $this->conexao->prepare($sql);
        $stmt->bindParam(':user_id', $userId);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':hora', $hora);

        if ($stmt->execute()) {

            $medicamentos = $this->buscarMedicamentos($userId);
            $_SESSION['medicamentos'] = $medicamentos;

            header('Location: ../VIEWS/medicamentoPg.php');

            return true; // Medicamento cadastrado com sucesso
        } else {
            throw new Exception('Erro ao cadastrar o medicamento: ' . implode(', ', $stmt->errorInfo()));
        }
    }

    public function buscarMedicamentos($userId)
    {
        $sql = "SELECT * FROM medicamentos WHERE user_id = ? ORDER BY hora";
        $stmt = $this->conexao->prepare($sql); // Corrigido de $this->db para $this->conexao
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    
    // Método para deletar um medicamento por ID
    public function deletar($id, $iduser)
    {
        $sql = "DELETE FROM medicamentos WHERE id = :id";
        $stmt = $this->conexao->prepare($sql);
        $stmt->bindParam(':id', $id);

        if ($stmt->execute()) {
            
            $medicamentos = $this->buscarMedicamentos($iduser);
            $_SESSION['medicamentos'] = $medicamentos;

            header('Location: ../VIEWS/medicamentoPg.php');

            return true; // Medicamento deletado com sucesso
        } else {
            throw new Exception('Erro ao deletar o medicamento: ' . implode(', ', $stmt->errorInfo()));
        }
    }
}
?>