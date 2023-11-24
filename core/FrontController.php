<?php
class FrontController{
    public function start(){
        $uri = $_SERVER['REQUEST_URI'];
        $data = explode('/', $uri);
        array_shift($data);

        if(count($data) >= 2){
            $module = $data[0];
            $action = $data[1];
        }else{
            $module = "user";
            $action = "login";
        }


        $arguments = array();
        for ($i=2; $i < count($data); $i++) { 
            $arguments[] =  $data[$i];
        }

        $className = ucfirst($module) . "Controller";
        $fileName = "module/" . $module . "/" . $className . ".php";

        if (file_exists($fileName)) {
            require_once($fileName);
            $controller = new $className($action, $arguments);
        } else {
        echo "Error 404 path $fileName  not found ";
        }
    
        //var_dump($data);
        exit;
   }


}
?>