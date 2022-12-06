<?php

namespace  Drupal\apirest_estvi\Controller;
use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Drupal\Core\Database\Connection;
use Symfony\Component\DependencyInjection\ContainerInterface;




class CrudControllet extends ControllerBase {


 /**
     * @var Connection
     */
    private $cn;

    public function __construct(Connection $database)
    {
        $this->cn = $database;
    }

    public static function create(ContainerInterface $container)
    {
        return new static(
            $container->get('database')
        );
    }

    public function getData(Request $request){
        global $base_url;

        try{

        
        $contenido = $request->getContent();
        $params = json_decode($content, TRUE);  
        

        $query = $this->cn->select('example_users', 'users');
        $query->fields('users', ['id', 'nombre', 'identificacion', 'fecha_nacimiento', 'cargo_usuario', 'Estado']);
        $valores = $query->execute();
        $resultados = $valores->fetchAll();

        $respuesta_api = array(
            "status" => "OK",
            "message" => "Usuarios registrados",
            "result" => $resultados
        );
        return new JsonRresponse($respuesta_api);

    } catch(Exception $ex){
        dpm($ex->getMessage());
    }


    }

}