<?php
class Acessibilidade {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function carregarPreferencias($userId) {
        $stmt = $this->pdo->prepare("SELECT * FROM acessibilidade WHERE user_id = :user_id");
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: [];
    }

    public function salvarPreferencias($userId, $altoContraste, $tamanhoFonte, $leitorTela) {
    $sql = "INSERT INTO acessibilidade (user_id, alto_contraste, tamanho_fonte, leitor_tela) 
            VALUES (:user_id, :alto_contraste, :tamanho_fonte, :leitor_tela)
            ON DUPLICATE KEY UPDATE
            alto_contraste = VALUES(alto_contraste),
            tamanho_fonte = VALUES(tamanho_fonte),
            leitor_tela = VALUES(leitor_tela)";
    
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
    $stmt->bindParam(':alto_contraste', $altoContraste, PDO::PARAM_BOOL);
    $stmt->bindParam(':tamanho_fonte', $tamanhoFonte, PDO::PARAM_STR);
    $stmt->bindParam(':leitor_tela', $leitorTela, PDO::PARAM_BOOL);
    
    if (!$stmt->execute()) {
        throw new Exception("Falha ao executar a query");
    }
}
    
}
?>