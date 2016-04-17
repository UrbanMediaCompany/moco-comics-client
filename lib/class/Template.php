<?php

	/**
	 * ==============================
	 * View
	 * ==============================
	 */

	class Template {

		private $data;
		private $viewContent;

		function __construct($expression, $data = null){
			$this -> data = $data;
			$this -> viewContent = $expression;
	    }

	    public function isCompilable(){
		    return $this -> data != null;
	    }

		public function compile(){
			$this -> compileTemplates();
			return $this -> viewContent;
		}

		private function compileTemplates(){
			do{
				$this -> compileForEachTemplates();
				$this -> compileSimpleTemplates();
			}while($this -> hasCompilables());

		}

		private function hasCompilables(){
			preg_match_all('/(\{\{>(\s?)(.*)\}\}|\{\{each(\s)(.*)\}\})/', $this -> viewContent, $matches);
			return !empty($matches[0]);
		}

		private function compileSimpleTemplates(){
			preg_match_all('/\{\{>(\s?)(.*)\}\}/', $this -> viewContent, $matches);
			if(!empty($matches)){
				foreach($matches[0] as $match){
					$matchName = trim(str_replace(array("{{>", "}}"), array("", ""), $match));
					$templateContent = file_get_contents("templates/" . $matchName . ".html");

					if($this -> data != null){
						if(array_key_exists ($matchName, $this -> data)){
							foreach($this -> data[$matchName] as $key => $value){
								$templateContent = str_replace("{{".$key."}}", $value, $templateContent);
							}
						}
					}

					$this -> viewContent = str_replace($match, $templateContent, $this -> viewContent);
				}
			}
		}


		private function compileForEachTemplates(){
			preg_match_all('/\{\{each(\s)(.*)\}\}/', $this -> viewContent, $matches);

			if(!empty($matches)){
				foreach($matches[0] as $match){

					$expression = explode(" ", trim(str_replace(array("{{each ", "}}"), array("", ""), $match)));
					$viewData = $expression[0];
					$view = file_get_contents("templates/" . $expression[1] . ".html");
					$compiledView = "";

					foreach($this -> data[$viewData] as $key => $value){
						$temp = $view;

						foreach($value as $valueKey => $simpleValue){
							$temp = str_replace("{{".$valueKey."}}", $simpleValue, $temp);
						}

						$compiledView .= $temp;
					}

					$this -> viewContent = str_replace($match, $compiledView, $this -> viewContent);
				}
			}

		}


		function __destruct() {

	    }

	}
?>