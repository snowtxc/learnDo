<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Usuario;
use App\Models\SeminarioVirtual;
use App\Models\Evento;
use App\Models\CompraEvento;


use App\Http\Controllers\MailController;



use \Datetime;



class RecordatorioSeminarioVirtual extends Command 
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'recordatorios_seminarios:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Schedule que se ejecutara cada 24 horas y enviara un recordatorio via email a los estudiantes inscriptos en un seminario virtual';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        //Seleccionar todos los seminarios virtuales con previo aviso de 24 horas
        //acceder a estudiante 1 por 1 y enviarlo un email
        date_default_timezone_set('America/Montevideo');
        $now = new DateTime();
        $nowStr = $now->format('d/m/Y'); 
        $this->info($nowStr);
        $seminarios  = SeminarioVirtual::where(["fecha" => $nowStr])->get();
        $mailController = new MailController();

        foreach($seminarios as $seminario){
           $eventoid = $seminario->evento_id;
           $evento =  Evento::find($eventoid);
           $compras = CompraEvento::where(["evento_id" => $eventoid])->get();

           $subject = "RECORDATORIO A SEMINARIO ONLINE: " . $evento->nombre;

           foreach($compras as $compra){
             $userId = $compra->estudiante_id; 
             $user = Usuario::find($userId);
             $reminderData = array(
                "hora" => $seminario->hora,
                "fecha" => $seminario->fecha,
                "link" => $seminario->link,
                "plataforma" => $seminario->nombre_plataforma,
                "evento_nombre" => $evento->nombre,
                "nombre_user" => $user->nombre
            );
            $emailToSend = trim($user->email);
            $mailController->send_seminario_reminder($emailToSend, $subject, $reminderData);

           }
                       
        }
        
        $this->info('Se ha completado los cursos!');
        return 1;
    }
}
