<?php
class Medico
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    // Método unificado para buscar especialidades
    public function buscarTodasEspecialidades()
    {
        try {
            $sql = "SELECT DISTINCT especialidade FROM medicos ORDER BY especialidade";
            $stmt = $this->pdo->query($sql);
            return $stmt->fetchAll(PDO::FETCH_COLUMN);
        } catch (PDOException $e) {
            error_log("Erro ao buscar especialidades: " . $e->getMessage());
            return [];
        }
    }

    // Método para buscar médicos por especialidade
    public function buscarPorEspecialidade($especialidade)
    {
        try {
            $sql = "SELECT id, nome, especialidade, endereco, telefone FROM medicos WHERE especialidade = :especialidade";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':especialidade', $especialidade, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erro ao buscar médicos: " . $e->getMessage());
            return [];
        }
    }
}
?>