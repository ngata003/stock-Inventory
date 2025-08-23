<?php

namespace App\Exports;

use App\Models\Vente;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class CommandesExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $fk_boutique = session('boutique_active_id');

        $ventes = Vente::where('fk_boutique' , $fk_boutique)
        ->whereYear('created_at' , now()->year)
        ->where('type_operation' , 'commande')
        ->where('status' , 1)
        ->get([
            'contact_client',
            'type_operation',
            'montant_total',
            'moyen_paiement',
            'montant_paye',
            'created_at',
        ]);

        return $ventes->map(function ($vente) {
            return [
                'nom_client'     => $vente->contact_client,
                'type_operation' => $vente->type_operation,
                'montant_total'  => $vente->montant_total,
                'moyen_paiement' => $vente->moyen_paiement,
                'montant_paye'   => $vente->montant_paye,
                'created_at'     => $vente->created_at->format('Y-m-d'),
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Contact client',
            'Type Operation',
            'Montant Total',
            'Moyen Paiement',
            'Montant Payé',
            'Date achat'
        ];
    }
}
