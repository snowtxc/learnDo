<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/*Models */
use App\Models\Client;

class ClientController extends Controller
{
    public function index(){
        $clients = Client::all();
        return $clients; 
    }


    public function store(Request $request)
    {
        $client = new Client();
        $client->name = $request->name;
        $client->save();
        return $client; 
        //Esta función guardará las tareas que enviaremos mediante vuejs
    }

    public function update(Request $request)
    {
        $client = Client::findOrFail($request->id);

        $client->name = $request->name;
    

        $client->save();

        return $client;
        //Esta función actualizará la tarea que hayamos seleccionado
       
    }

    public function destroy(Request $request)
    {
        $client = Client::destroy($request->id);
        return $client;
        //Esta función obtendra el id de la tarea que hayamos seleccionado y la borrará de nuestra BD
    }
}
