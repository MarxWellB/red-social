<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Volcado extends Model
{
    use HasFactory;
    protected $table = 'volcado';

    protected $fillable = ['numero_vista', 'elemento', 'id_elemento', 'cities_id', 'fecha_metrica', 'hora'];

    public function ciudad()
    {
        return $this->belongsTo(Ciudad::class);
    }
    public static function getStats($idElemento, $startDate = null, $endDate = null, $startTime = null, $endTime = null, $country = null, $city = null)
{
    if (!$startDate) {
        $startDate = date('Y-m-d');
    }

    if (!$endDate) {
        $endDate = date('Y-m-d');
    }

    $startDateTime = $startDate . ' ' . ($startTime ?: '00:00:00');
    $endDateTime = $endDate . ' ' . ($endTime ?: '23:59:59');

    $query = self::where('id_elemento', $idElemento)
        ->whereBetween('fecha_metrica', [$startDateTime, $endDateTime]);

    if ($country && $city) {
        $query->whereExists(function ($subquery) use ($country, $city) {
            $subquery->select(DB::raw(1))
                ->from('ciudades')
                ->join('countries', 'ciudades.country_id', '=', 'countries.id')
                ->where('ciudades.nombre_ciudad', $city)
                ->where('countries.name', $country)
                ->whereColumn('volcado.cities_id', 'ciudades.id');
        });
    }

    return $query;
}

}
