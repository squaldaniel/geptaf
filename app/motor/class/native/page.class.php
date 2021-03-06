<?php
class page{
	/**
	Classe: pagesite || classe que gera a página
	Data criação: 03/12/2016
	Ultima alteração: 11/01/2017
	Autor: Daniel J. Santos
	Email: Daniel.santos.ap@gmail.com
	**/
	public $language; 			// linguagem da pagina
	public $titlepage;			// titulo da página
	public $headersinclude;		// headers adicionais como css e scripts
	public $bodyextras;			// informações adicionais a tag body
	public $bodycontent;		// o conteudo da pagina em si.
	public $outrosmeta;			// informações de metadados, para sistemas de busca
	public $scriptsendpage;		// scripts para serem adicionadosno fim da pagina
	public function __construct(){
		if(!isset($this->language)){$this->language="pt-br";};if(!isset($this->titlepage)){$this->titlepage="";};if(!isset($this->headersinclude)){$caminho=urlcss($_GET);$this->headersinclude='<link href="'.$caminho.'public/css/bootstrap.min.css" rel="stylesheet"><link href="'.$caminho.'public/css/bootstrap-theme.min.css" rel="stylesheet"><script src="'.$caminho.'public/js/jquery-1.11.1.min.js"></script><script src="'.$caminho.'public/js/bootstrap.min.js"></script><style type="text/css">.label,.glyphicon,.fa{margin-right:5px;}</style>';};if(!isset($this->scriptsendpage)){$this->scriptsendpage="";};
	}
	public function render(){
		echo '<!DOCTYPE html><html lang="'.$this->language.'"><head><meta charset="utf-8">'.$this->outrosmeta.'<title>'.$this->titlepage.'</title><meta name="viewport" content="width=device-width, initial-scale=1">'.$this->headersinclude.'</head><body '.$this->bodyextras.'>'.$this->bodycontent.'</body><script type="text/javascript">'.$this->scriptsendpage.'</script></html>';
	}
	public function helpme(){
			if(file_exists(PATHMOTOR."helpme/".get_class()."_help.php")){include(PATHMOTOR ."helpme/".get_class()."_help.php");}else{echo "não existe ajuda para </b>".get_class()."</b,>:";};
		}
}
?>