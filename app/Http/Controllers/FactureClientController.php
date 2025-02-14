<?php

namespace App\Http\Controllers;

use App\Models\Parametre\Societe;
use App\Models\Vente\Client;
use App\Models\Vente\FactureClient;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class FactureClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        try {
            Log::info('Début du chargement de la liste des factures');
            $date = Carbon::now()->locale('fr')->isoFormat('dddd D MMMM YYYY');
            $configuration = Societe::first();
            $tauxTva = $configuration ? $configuration->taux_tva : 18;

            // Chargement des factures avec les relations nécessaires
            $factures = FactureClient::with(['client'])
                ->where("type_facture", "NORMALISE")
                ->whereNotNull("date_validation")
                ->select([
                    'id',
                    'numero',
                    'date_facture',
                    'date_echeance',
                    'type_facture',
                    'client_id',
                    'statut',
                    'montant_ht',
                    'montant_ttc',
                    'montant_regle',
                    'session_caisse_id',
                    'created_by',
                    'validated_by',
                    'encaissed_at'
                ])
                ->orderBy('date_facture', 'desc')
                ->get();

            // Ajouter des attributs calculés pour chaque facture
            $factures_transformed = $factures->transform(function ($facture) {
                // Calcul du reste à payer
                $facture->reste_a_payer = $facture->montant_ttc - $facture->montant_regle;

                // Détermination du vrai statut basé sur le paiement
                if ($facture->statut === 'brouillon') {
                    $facture->statut_reel = 'brouillon';
                } elseif ($facture->statut === 'validee') {
                    if ($facture->montant_regle == 0) {
                        $facture->statut_reel = 'validee';
                    } elseif ($facture->montant_regle < $facture->montant_ttc) {
                        $facture->statut_reel = 'partiellement_payee';
                    } elseif ($facture->montant_regle >= $facture->montant_ttc) {
                        $facture->statut_reel = 'payee';
                    }
                }

                // Vérifier si la facture est en retard
                $facture->is_overdue = $facture->statut !== 'payee'
                    && Carbon::now()->startOfDay()->gt($facture->date_echeance);

                $facture->type = $facture->type_facture;
                return $facture;
            });

            $facturesResteAPayer = $factures->filter(function ($facture) {
                return $facture->reste_a_payer > 0;
            });
            $montantResteAPyer = $facturesResteAPayer->sum('montant_ttc');

            // Calculer le montant total des factures du mois en cours
            $currentMonth = Carbon::now()->month;
            $currentYear = Carbon::now()->year;

            $facturesDuMois = $factures->filter(function ($facture) use ($currentMonth, $currentYear) {
                return Carbon::parse($facture->date_facture)->month == $currentMonth &&
                    Carbon::parse($facture->date_facture)->year == $currentYear;
            });

            $montantFactureMois = $facturesDuMois->sum('montant_ttc');

            // Calculer le total encaissé et le nombre de factures encaissées
            $facturesEncaissees = $facturesDuMois->filter(function ($facture) {
                return !is_null($facture->encaissed_at);
            });

            $totalEncaisse = $facturesEncaissees->sum('montant_ttc');
            $nombreEncaisse = $facturesEncaissees->count();

            $statsFactures = [
                'total_mois' => $montantFactureMois,
                'total_encaisse' => $totalEncaisse,
                'nombre_encaisse' => $nombreEncaisse,
                'montant_en_attente' => $montantResteAPyer,
                'factures_en_attente' => $facturesResteAPayer,
            ];

            Log::info('Liste des factures chargée avec succès', [
                'nombre_factures' => $factures->count()
            ]);
            // Charger la liste des clients pour le filtre
            $clients = Client::where('point_de_vente_id', Auth()->user()->point_de_vente_id)->orderBy('raison_sociale')->get(['id', 'raison_sociale', 'taux_aib']);

            return view('pages.ventes-module.factures.index', compact('factures', 'clients', 'date', 'tauxTva', 'statsFactures'));
        } catch (Exception $e) {
            Log::error('Erreur lors du chargement de la liste des factures', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return back()->with('error', 'Une erreur est survenue lors du chargement des factures');
        }
    }
}
