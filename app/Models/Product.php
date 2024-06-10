<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name', 'price', 'description', 'image', 'categories',
        'manche_longue', 'manche_courte', 'a_enfiler', 'col_rond',
        'col_a_col', 'bouton', 'col_v', 'ras_du_cou', 'coton',
         'avec_col', 'polyester'
    ];

    public function getFeaturesVector()
    {
        return [
            (int) $this->manche_longue,
            (int) $this->manche_courte,
            (int) $this->a_enfiler,
            (int) $this->col_rond,
            (int) $this->col_a_col,
            (int) $this->bouton,
            (int) $this->col_v,
            (int) $this->ras_du_cou,
            (int) $this->coton,
            (int) $this->avec_col,
            (int) $this->polyester,
        ];
    }
}
