<?php
//classe dashboard
class Dashboard{
    public $data_inicio;
    public $data_fim;
    public $numero_vendas;
    public $total_vendas;
    public $clientes_ativos;
    public $clientes_inativos;
    public $reclamacoes;
    public $elogio;
    public $sugestao;
    public $despesa;

    public function __get($atributo)
    {
        return $this->$atributo;
    }
    public function __set($atributo, $value)
    {
        $this->$atributo = $value;
        return $this;
    }
}

//classe conexão
class Conexao{
    private $host = 'localhost';
    private $dbname = 'dashboard';
    private $user = 'root';
    private $pass = '';
    
    public function conectar(){
        try{
            $conexao = new PDO("mysql:host=$this->host;dbname=$this->dbname",
            "$this->user",
            "$this->pass");
             $conexao->exec('set charset utf8');
            
             return $conexao;

        }catch(PDOException $e){
            echo '<p>'.$e.'</p>';
        }
    }
}

//classe model
class Bd {
    private $conexao;
    private $dashboard;

    public function __construct(Conexao $conexao, Dashboard $dashboard)
    {
        $this->conexao = $conexao->conectar();
        $this->dashboard = $dashboard;
    }

 

    public function getTotalVendas(){
        $query = 'SELECT SUM(total) AS total_vendas
        FROM
            tb_vendas
            WHERE
            data_venda BETWEEN :data_inicio AND :data_fim';


        $stmt = $this->conexao->prepare($query);
        $stmt->bindValue(':data_inicio', $this->dashboard->__get('data_inicio'));
        $stmt->bindValue(':data_fim', $this->dashboard->__get('data_fim'));
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ)->total_vendas;
    }

    public function getNumeroVendas(){
        $query = 'SELECT COUNT(*) AS numero_vendas
        FROM
            tb_vendas
            WHERE
            data_venda BETWEEN :data_inicio AND :data_fim';


        $stmt = $this->conexao->prepare($query);
        $stmt->bindValue(':data_inicio', $this->dashboard->__get('data_inicio'));
        $stmt->bindValue(':data_fim', $this->dashboard->__get('data_fim'));
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ)->numero_vendas;
    }


    public function getClientesAtivos(){
        $query = 'SELECT COUNT(*) AS cliente_ativo
        FROM
            tb_clientes
            WHERE
            cliente_ativo = 1';


        $stmt = $this->conexao->prepare($query);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ)->cliente_ativo;
    }




}

//lógica do script


$dashboard = new Dashboard();
$conexao = new Conexao();
$bd = new Bd($conexao, $dashboard);

$competencia = explode('-', $_GET['competencia']);
$ano = $competencia[0];
$mes = $competencia[1];
$dias_do_mes = cal_days_in_month(CAL_GREGORIAN, $mes, $ano);


$dashboard->__set('data_inicio', $ano.'-'.$mes.'-01');
$dashboard->__set('data_fim', $ano.'-'.$mes.'-'.$dias_do_mes);
$dashboard->__set('numero_vendas', $bd->getNumeroVendas());
$dashboard->__set('total_vendas', $bd->getTotalVendas()); 
$dashboard->__set('clientes_ativos', $bd->getClientesAtivos()); 






echo json_encode($dashboard);


?>