<?php
namespace core\classes;
use PDO;
use PDOException;

/**
 * Classe responsável por fazer a conexão com a base de dados.
 */
class Database {

    private $ligacao;

    /**
     * Método para fazer a conexão ao banco de dados.
     */
    private function ligar() {
        $this->ligacao = new PDO(
             'mysql:'
            .'host='    . MYSQL_SERVER      . ';'
            .'dbname='  . MYSQL_DATABASE    . ';'
            .'charset=' . MYSQL_CHARSET, 
            MYSQL_USER,
            MYSQL_PASS,
            array(PDO::ATTR_PERSISTENT => true)
        );
        
        //debug
        $this->ligacao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    }

    /**
     * Método para desconectar do banco de dados.
     */
    private function desligar() {
        $this->ligacao = null;
    }

    /**
     * Executa pesquisa de SQL, recebe a Query e os parametros para os comandos
     * SQL, como auxilio contra injections.
     * @param string $sql
     * @param string $parametros
     */
    public function select($sql, $parametros = null){
        // liga a base
        $this->ligar();

        $resultados = null;
        //comunicar
        try {
            //comunicacao com a bd
            if(!empty($parametros)){
                $executar = $this->ligacao->prepare($sql);
                $executar->execute($parametros);
                $resultados = $executar->fetchAll(PDO::FETCH_CLASS);
            }
            else {
                $executar = $this->ligacao->prepare($sql);
                $resultados = $executar->fetchAll(PDO::FETCH_CLASS);
            }
        } catch (PDOException $e) {
            return false;
        }
        // desliga a comunicação com a base
        $this->desligar();
        
        //devolver os resultados obtidos
        return $resultados;
    }
}
