<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Promotion;

class UpdatePromotionHours extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'promotion:update-hours';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    /*
    public function handle()
    {
        return Command::SUCCESS;
    }*/
    public function handle()
    {
        $promotions = Promotion::where('active', 1)->get();
        
        foreach ($promotions as $promotion) {
            if($promotion->id_type==1){
            $limit=48;
        }elseif ($promotion->id_type==2) {
            $limit=96;
        }else{
            $limit=240;
        }
        $promotion->increment('status');

            // Si se alcanza el límite de horas, finalizar la promoción
            if ($promotion->status >= $limit) {
                $promotion->update(['active' => 3]);
                // Aquí puedes agregar lógica adicional si es necesario
            }
        }

        $this->info('Promotion hours updated successfully.');
    }
}
