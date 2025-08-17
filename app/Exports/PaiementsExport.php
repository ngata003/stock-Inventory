<?php

namespace App\Exports;

use App\Models\Paiement;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class PaiementsExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Paiement::orderBy('created_at', 'desc')->get([
            'nom_depositaire',
            'montant',
            'date_expiration',
            'date_paiement'
        ]);
    }

     public function headings(): array
    {
        return [
            'Nom dépositaire',
            'Montant',
            'Date Expiration',
            'Date paiement'
        ];
    }
}
