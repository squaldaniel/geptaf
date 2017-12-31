<?php
class jsincludes {
	/**
	Data criação: 15/06/2017
	Data alteração: 31/12/2017
	**/
	public $path;
	public $files = [];
	public $content;

	public function __construct(){

	}
	public function render(){
		foreach ($this->files as $key => $value) {
        echo '<script type="text/javascript" href="'.$this->path.$value.'"></script>';
		}
	}
	public function html(){
		foreach ($this->files as $key => $value) {
        $this->content .= '<script type="text/javascript" href="'.$this->path.$value.'"></script>';
		}
		return $this->content;
	}
	public function helpme(){
			if(file_exists(PATHMOTOR."helpme/".get_class()."_help.php")){include(PATHMOTOR ."helpme/".get_class()."_help.php");}else{echo "não existe ajuda para </b>".get_class()."</b,>:";};
		}
}
?>