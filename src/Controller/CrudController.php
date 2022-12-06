<?php

namespace Drupal\apirest_estvi\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Database\Connection;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class CrudController extends ControllerBase
{

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

    public function getData(Request $request)
    {
        try {

            $contenido = $request->getContent();
            $params = json_decode($contenido, true);

            $query = $this->cn->select('example_users', 'users');
            $query->fields('users', ['id', 'nombre', 'identificacion', 'fecha_nacimiento', 'cargo_usuario', 'Estado']);
            $valores = $query->execute();
            $resultados = $valores->fetchAll();

            $respuesta_api = array(
                "status" => "OK",
                "message" => "Usuarios registrados",
                "result" => $resultados,
            );
            return new JsonResponse($respuesta_api);

        } catch (Exception $ex) {
            dpm($ex->getMessage());
        }

    }

/*
public function addData(Request $request){

try{

$contenido = $request->getContent();
$params = json_decode($contenido, TRUE);

$query = $this->cn->select('example_users', 'users');
$query->fields('users', ['id', 'nombre', 'identificacion', 'fecha_nacimiento', 'cargo_usuario', 'Estado']);
$valores = $query->execute();
$resultados = $valores->fetchAll();

$respuesta_api = array(
"status" => "OK",
"message" => "Usuarios registrados",
"result" => $resultados
);
return new JsonResponse($respuesta_api);

} catch(Exception $ex){
dpm($ex->getMessage());
}
 */

    public function deleteData(Request $request)
    {
        global $base_url;

        try {

            $contenido = $request->getContent();
            $params = json_decode($contenido, true);
            $key = $params['uid'];
            $valor = 12;

            if (!empty($key)) {
                $query = $this->cn->delete('example_users');
                $query->condition('id', $key);
                $query->execute();

                $respuesta_api = array(
                    "status" => "OK",
                    "message" => "Usuarios registrados",

                );
            }

            return new JsonResponse($respuesta_api);

        } catch (Exception $ex) {
            dpm($ex->getMessage());
        }

    }

}
