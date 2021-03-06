<?php 
/**
Criação 15/11/2017
Última Alteração: 15/11/2017
Autor: Daniel J. Santos
E-mail: daniel.santos.ap@gmail.com
**/
$_SESSION["load"]=parse_ini_file("config.ini.php", true);
/**
Arquivo .ini com configurações do banco de dados
encarregado de armazenar as informações de confuguração do banco de dados tanto off-line quanto on-line
**/
function urlcss($url){
	if (!isset($url["urldigitada"])){$url["urldigitada"] = "";};$espacos = explode("/", $url["urldigitada"]);$total = count($espacos);$barras="";$x=2;while ($x <= $total){$barras .= "../";$x++;};return $barras;
};
/**
##########################################################################################################
AREA DE CONSULTAS E INSERÇÕES NO BANCO DE DADOS
##########################################################################################################
**/
function fastquery($sql){
/**
    Nome:           fastquery
    Função:         executa uma inserção no banco de dados. basicamente para auditorias.
    @param sql->    string (sql) de inserção
    Data de criação:
    Última alteração:
**/
    $pdo = new pdo($_SESSION["load"]["banco_de_dados"]["driver"] . ":dbname=". $_SESSION["load"]["banco_de_dados"]["banco"] . ";charset=UTF8;host=" . $_SESSION["load"]["banco_de_dados"]["host"] . ";" , $_SESSION["load"]["banco_de_dados"]["usuario"], $_SESSION["load"]["banco_de_dados"]["senha"]);
    //$pdo->prepare($sql);
    $pdo->exec($sql);
    
};
function fastquery_messages($sql, $mensagem1, $mensagem2){
/**
    Nome:           fastquery_messages
    Função:         executa uma inserção no banco de dados. basicamente para auditorias.
    @param sql->    string (sql) de inserção
    Data de criação: 15/11/2017
    Última alteração: 15/11/2017
**/
    $pdo = new pdo($_SESSION["load"]["banco_de_dados"]["driver"] . ":dbname=". $_SESSION["load"]["banco_de_dados"]["banco"] . ";charset=UTF8;host=" . $_SESSION["load"]["banco_de_dados"]["host"] . ";" , $_SESSION["load"]["banco_de_dados"]["usuario"], $_SESSION["load"]["banco_de_dados"]["senha"]);
    //$pdo->prepare($sql);
    if (!$pdo->exec($sql)){
        return $mensagem1;
    } else {
        return $mensagem2;
    };
};
function retornadbinfo($dados){
/**
    Nome:           retornadbinfo
    Função:         executa uma inserção no banco de dados
    @param sql->    string (sql) de consulta
    Data de criação: 15/11/2017
    Última alteração: 15/11/2017
**/
    $pdo = new pdo(
        $_SESSION["load"]["banco_de_dados"]["driver"] . ":dbname=" 
        . $_SESSION["load"]["banco_de_dados"]["banco"] . ";charset=UTF8;host=" 
        . $_SESSION["load"]["banco_de_dados"]["host"] . ";" ,
        $_SESSION["load"]["banco_de_dados"]["usuario"],
        $_SESSION["load"]["banco_de_dados"]["senha"]);
        //$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
        $result = $pdo->query($dados);
    /*
    # declare uma variavel com a sql
    $dados = retornadbinfo("select email, keyident from precadastro");
    # coloque em um laço e imprima como quiser.
        while ($linha = $dados->fetch(PDO::FETCH_ASSOC)) {
            echo $linha["email"] . "<br/>";
        };
    */
    return $result;
};
function retornaqueryinfo($dados){
/**
    Nome:           retornaqueryinfo
    Função:         executa uma inserção no banco de dados
    @param sql->    string (sql) de consulta
    Data de criação:    15/11/2017
    Última alteração:   15/11/2017
**/
    $pdo = new pdo(
        $_SESSION["load"]["banco_de_dados"]["driver"] . ":dbname=" 
        . $_SESSION["load"]["banco_de_dados"]["banco"] . ";charset=UTF8;host=" 
        . $_SESSION["load"]["banco_de_dados"]["host"] . ";" ,
        $_SESSION["load"]["banco_de_dados"]["usuario"],
        $_SESSION["load"]["banco_de_dados"]["senha"]);
        if ($result = $pdo->query($dados)){
          $result = $pdo->errorInfo();
        } else {
            $result = $pdo->errorInfo();
        };
    return $result;
};
function minimalheader($pastas){
	/**
	data criação 15/11/2017
	**/
	return '<link href="'.$pastas.'public/css/bootstrap.min.css" rel="stylesheet"><link href="'.$pastas.'public/css/bootstrap-theme.min.css" rel="stylesheet"><script src="'.$pastas.'jquery-1.11.1.min.js"></script><script src="'.$pastas.'public/js/bootstrap.min.js"></script><style type="text/css">.label,.glyphicon, .fa{ margin-right:5px; }</style>';
};
function fontawesome($pastas){
    return '<link rel="stylesheet" href="'.$pastas.'public/css/font-awesome/font-awesome.min.css">';
};
function compacta($template){
    $compatada = preg_replace(array("/\n/", "/\s{2}/", "/\t/"), "", file_get_contents($template));
    return $compatada;
};
class tag{
    /**
    Data de criação: 15/11/2017
    **/
    public $tagnome;        // nome da tag
    public $double;         // TRUE || FALSE - se a tag é simples ou composta padrão: TRUE
    public $tagcontent;     // conteudo da tag
    public $tagfunctions;   // tudo que vai dentro da tag
    public $somacontent;

    public function __construct(){
        $this->double=TRUE;$this->tagfunctions="";
    }
    public function render(){
        switch ($this->double) {
            case FALSE:
                echo '<'.$this->tagnome.' '.$this->tagfunctions.' />';
                break;
            default:
                echo '<'.$this->tagnome.' '.$this->tagfunctions.' >'.$this->tagcontent.'</'.$this->tagnome.'>';
                break;
        }
    }
    public function html(){
        switch ($this->double) {
            case FALSE:
                $this->somacontent = '<'.$this->tagnome.' '.$this->tagfunctions.' />';
                break;
            default:
                $this->somacontent = '<'.$this->tagnome.' '.$this->tagfunctions.' >'.$this->tagcontent.'</'.$this->tagnome.'>';
                break;
        }
    return $this->somacontent;
    }
}
class inline{
    /**
    data de criação: 15/11/2017
    **/
    public $somacontent;
    public function __construct(){
        
    }
    public function html(){
        $this->somacontent = '<div class="form-inline" style="margin-left:10px; margin-right: 10px"><label for="nasc">Nascimento : </label><select class="form-control" style="margin-bottom:10px;" name="anouser"><option> ANO </option>';$x=2017; while ($x >= 1900) {$this->somacontent .= '<option value="'.$x.'"">'.$x.'</option>';$x--;};$this->somacontent .= '</select> <select class="form-control" style="margin-bottom:10px;" name="mesuser"><option> MÊS </option>';$meses = array("01"=>"Janeiro", "02"=>"Fevereiro", "03"=>"Março", "04"=>"Abril", "05"=>"Maio", "06"=>"Junho", "07"=>"Julho", "08"=>"Agosto", "09"=>"Setembro", "10"=>"Outubro", "11"=>"Novembro", "12"=>"Dezembro");foreach ($meses as $key => $value) {$this->somacontent .= '<option value="'.$key.'">'.$value.'</option>';};$this->somacontent .= '</select> <select class="form-control" style="margin-bottom:10px;" name="diauser"><option> DIA </option>';$x=1;while ($x <= 31) {$this->somacontent .= '<option value="'.$x.'">'.$x.'</option>';$x++;};$this->somacontent .= '</select></div>';
        return $this->somacontent;
    }
    public function render(){
    echo '<div class="form-inline" style="margin-left:10px; margin-right: 10px"><label for="nasc">Nascimento : </label><select class="form-control" name="anouser" style="margin-bottom:10px;"><option> ANO </option>';$x=2017; while ($x >= 1900) {echo '<option value="'.$x.'"">'.$x.'</option>';$x--;};echo '</select> <select class="form-control" name="mesuser" style="margin-bottom:10px;"><option> MÊS </option>';$meses = array("01"=>"Janeiro", "02"=>"Fevereiro", "03"=>"Março", "04"=>"Abril", "05"=>"Maio", "06"=>"Junho", "07"=>"Julho", "08"=>"Agosto", "09"=>"Setembro", "10"=>"Outubro", "11"=>"Novembro", "12"=>"Dezembro");foreach ($meses as $key => $value) {echo '<option value="'.$key.'">'.$value.'</option>';};echo '</select> <select class="form-control" name="anouser" style="margin-bottom:10px;"><option> DIA </option>';$x=1;while ($x <= 31) {echo '<option value="'.$x.'">'.$x.'</option>';$x++;};echo '</select></div>';
    }
}
class submit{
    /**
    data de criação: 15/11/2017
    **/
    public $funcaovalida;
    public $somacontent;
    public $valida;
    public function __construct(){
        if(!isset($this->valida)){$this->valida="";};
    }
    public function render(){
        echo '<div class="form-group" style="margin:10px"><input type="reset" value="Limpar" class="btn btn-warning"> <input type="submit" class="btn btn-primary" value="Confirmar" onclick="'.$this->valida.'"></div>';
    }
    public function html(){
        $this->somacontent = '<div class="form-group" style="margin:10px"><input type="reset" value="Limpar" class="btn btn-warning"> <input type="submit" class="btn btn-primary" value="Confirmar" onclick="'.$this->funcaovalida.'"></div>';
        return $this->somacontent;
    }
}
function in_data ($pegaadata){
            $tratando = explode("/", $pegaadata); // pega a data e divide em array 
            //print_r($tratando);       // para debugar
            //echo "<br/>";             // para debugar
            $revertido = array_reverse($tratando); // inverte a posição do array
            //print_r($revertido);      // para debugar
            //echo "<br/>";             // para debugar
            $pronto = implode("-", $revertido); // junta o array separando com "-" em uma única string
            //echo $pronto . "<br/>";   // para debugar
            return $pronto;
        };
function out_data ($pegaadata){
            $tratando = explode("-", $pegaadata); // pega a data e divide em array 
            //print_r($tratando);       // para debugar
            //echo "<br/>";             // para debugar
            $revertido = array_reverse($tratando); // inverte a posição do array
            //print_r($revertido);      // para debugar
            //echo "<br/>";             // para debugar
            $pronto = implode("/", $revertido); // junta o array separando com "-" em uma única string
            //echo $pronto . "<br/>";   // para debugar
            return $pronto;
        };
?>