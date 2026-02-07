<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    use HasFactory;

    /**
     * Nama tabel di database (opsional jika sudah jamak 'tables')
     */
    protected $table = 'tables';

    /**
     * Kolom yang boleh diisi secara massal.
     */
    protected $fillable = [
        'name',
        'capacity',
        'type',
        'position_x',
        'position_y',
    ];

      public function reservations()
    {
        return $this->hasMany(TableReservation::class);
    }
}
