<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Usuario;


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
       $user  = Usuario::find(1);
       $user->nombre = "perrito";
       $user->save();
       $this->info('usuario actualizado');

    }
}
