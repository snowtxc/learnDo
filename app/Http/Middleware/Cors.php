<?php
namespace App\Http\Middleware;
use Closure;
class Cors
{
  public function handle($request, Closure $next)
  {
    return $next($request)
       //Url a la que se le dará acceso en las peticiones
      ->header("access-control-allow-origin", "*")  
      //Métodos que a los que se da acceso
      ->header("access-control-allow-methods", "GET, POST, PUT, DELETE")
      //Headers de la petición
      ->header("access-control-allow-headers", "X-Requested-With, Content-Type, X-Token-Auth, Authorization"); 
  }
}