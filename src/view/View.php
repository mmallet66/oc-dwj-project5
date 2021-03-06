<?php

namespace Occazou\Src\View;

class View
{
    private $file;
    private $name;
    private $title;
    private $scriptPath = null;
    private $repertory = 'src/view/templates/';
    private $template;

    public function __construct(string $view)
    {
        $this->file = $this->repertory . $this->formatToCamelCase($view) . '.php';
        $this->name = $view;
        $this->template = $this->repertory.'template.php';
    }

    public function generate(array $data=null)
    {
        $this->content = $this->generateFile($this->file, $data);

        $view = $this->generateFile($this->template, array('title'=>$this->title, 'pageName'=>$this->name, 'content'=>$this->content, 'scriptPath'=>$this->scriptPath));

        echo $view;
    }

    private function generateFile(string $file, array $data=null)
    {
        if(file_exists($file)):
            if($data!=null):
                extract($data);
            endif;
            
            ob_start();
            require $file;
            return ob_get_clean();
        else:
            throw new \Exception('Le fichier ' . $file . ' n\'existe pas !');
        endif;
    }

    private function formatToCamelCase(string $fileName)
    {
        $fileName = explode('-', $fileName);
        foreach($fileName AS $key => $value):
            $fileName[$key] = ($key == 0)? $value : ucfirst($value);
        endforeach;
        return implode('', $fileName);
    }
}