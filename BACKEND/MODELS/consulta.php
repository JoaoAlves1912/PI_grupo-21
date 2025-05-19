<?php
class Consulta
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function agendar($userId, $data, $hora, $medico, $especialidade, $historico = '')
    {
        $sql = "INSERT INTO consultas 
            (user_id, data_consulta, hora_consulta, medico, especialidade, historico) 
            VALUES 
            (:user_id, :data, :hora, :medico, :especialidade, :historico)";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':user_id', $userId);
        $stmt->bindValue(':data', $data);
        $stmt->bindValue(':hora', $hora);
        $stmt->bindValue(':medico', $medico);
        $stmt->bindValue(':especialidade', $especialidade);
        $stmt->bindValue(':historico', $historico);

        return $stmt->execute();
    }

    public function listar($userId)
    {
        $sql = "SELECT * FROM consultas WHERE user_id = :user_id ORDER BY data_consulta ASC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function cancelar($idConsulta)
    {
        $sql = "DELETE FROM consultas WHERE id = :id ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $idConsulta);
        $stmt->execute();
    }
}
?>