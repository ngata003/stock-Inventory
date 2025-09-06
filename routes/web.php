<?php

use App\Exports\CommandesExport;
use App\Exports\PaiementsExport;
use App\Exports\VentesExport;
use App\Http\Controllers\approvisionnementController;
use App\Http\Controllers\BoutiquesController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\clientsController;
use App\Http\Controllers\CommandesController;
use App\Http\Controllers\CoursiersController;
use App\Http\Controllers\FournisseursController;
use App\Http\Controllers\InventaireController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\PaiementController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReapprovisionnementController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\StatistiquesController;
use App\Http\Controllers\suggestionsController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VentesController;
use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Facades\Excel;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {return view('home');})->name('accueil');
Route::get('/profil' , [UserController::class , 'profil_user'])->name('profil');
Route::put('/update_profil/{id}' , [UserController::class , 'update_profil'])->name('update_profil');

/*ROUTES AUTHENTIFICATION*/
    Route::post('/send-reset-link', [UserController::class, 'sendResetLinkEmail'])->name('sendResetLinkEmail');
    Route::get('/reset-password-form/{token}', action: [UserController::class, 'showResetForm'])->name('reset.password.form');
    Route::post('/reset-password', [UserController::class, 'resetPassword'])->name('reset.password');
    Route::get('/password_forget', [UserController::class , 'reset_password'])->name('reset_password');
    Route::get('/sign_up', function () {return view('Users.auth.inscription');})->name('inscription');
    Route::get('/login', function () {return view('Users.auth.connexion');})->name('login');
    Route::post('signup' , [UserController::class, 'signup'])->name('signup');
    Route::post('login' , [UserController::class, 'login_post'])->name('login_post');
    Route::post('/logout' , [UserController::class , 'logout'])->name('logout');
/*FIN ROUTES AUTHENTIFICATION*/

/*ROUTES SUPER-ADMIN*/
    Route::middleware(['auth' , 'type:superadmin'])->group(function () {
        Route::get('liste_paiements/{mois?}' , [SuperAdminController::class , 'liste_paiements'])->name('liste_paiements');
        Route::put('/valider_paiement/{id}' , [PaiementController::class , 'valider_paiement'])->name('valider_paiement');
        Route::delete('/delete_paiement/{id}' , [PaiementController::class , 'delete_paiement'])->name('delete_paiement');
        Route::get('/roles' , [RoleController::class , 'roles_view'])->name('roles');
        Route::post('/add_roles' , [RoleController::class , 'add_roles'])->name('add_roles');
        Route::put('/update_roles/{id}' , [RoleController::class , 'update_roles'])->name('update_roles');
        Route::delete('/delete_roles/{id}' , [RoleController::class , 'delete_roles'])->name('delete_roles');
        Route::get('/liste_boutiques' , [SuperAdminController::class , 'liste_boutiques'])->name('liste_boutiques');
        Route::get('/liste_utilisateurs' , [SuperAdminController::class , 'liste_utilisateurs'])->name('liste_utilisateurs');
        Route::get('/export-paiements', function () {return Excel::download(new PaiementsExport, 'paiements.xlsx');})->name('export.paiements');
        Route::middleware(['auth', 'check.abonnement'])->group(function () {
            Route::get('/boutiques_admin', [BoutiquesController::class, 'store_view'])->name('boutiques_view');
        });

        Route::get('statistiques_superadmin/{mois?}' , [SuperAdminController::class , 'statistiques'])->name('statistiques_SA');
        Route::get('/details_admin/{id}', [SuperAdminController::class , 'details_admin'])->name('details_admin');
        Route::get('/statistiques_boutiques/{id}/{mois?}' , [StatistiquesController::class , 'statistiques_boutiques'])->name('statistiques_boutiques');
        Route::get('/suggestions_SA' , [SuggestionsController::class , 'SA_suggestions'])->name('suggestions_SA');
        Route::get('/notifications_SA' , [SuggestionsController::class , 'notifications_SA'])->name('notifications_SA');
        Route::get('/abonnements_pdf' , [SuperAdminController::class , 'paiementsPdf'])->name('abonnements_pdf');
    });
/*FIN ROUTES SUPER-ADMIN*/

/* ROUTES ADMIN*/
    Route::middleware(['auth' , 'type:admin'])->group(function () {
        Route::get('/paiement_view', [PaiementController::class, 'paiement_view'])->name('paiement_view');
        Route::post('/add_paiement' , [PaiementController::class , 'add_paiement'])->name('add_paiement');
        Route::get('/boutique_activation/{id}',[BoutiquesController::class,'boutique_activation'])->name('boutique_activation');
        Route::middleware(['auth', 'check.abonnement'])->group(function () {
            Route::get('/boutiques_admin', [BoutiquesController::class, 'store_view'])->name('boutiques_view');
        });
        Route::post('/update_plan' , [PackageController::class , 'update_plan'])->name('packageUpdate');
        Route::post('/add_package', [PackageController::class,'add_package'])->name('add_package');
        Route::post('add_boutique',[BoutiquesController::class,'add_boutique'])->name('storeBoutiques');
        Route::put('/boutique_update/{id}',[BoutiquesController::class, 'update_boutique'])->name('update_boutique');
        Route::delete('/delete_boutique/{id}',[BoutiquesController::class , 'boutique_delete'])->name( 'delete_boutiques');
        Route::get('packages', function(){ return view('Admin.packages');})->name('packages');
        Route::get('/mes_paiements/{mois?}' , [PaiementController::class , 'mes_paiements'])->name('mes_paiements');
        Route::get('verification_paiement', function(){return view('verification_paiement');})->name('verification_paiement');
        Route::get('/export_ventes' , function(){ return Excel::download(new VentesExport , 'ventes_annuelles.xlsx');})->name('ventes_annuelles');
        Route::get('/export_commandes' , function(){ return Excel::download(new CommandesExport , 'commandes_annuelles.xlsx');})->name('export_commandes');
    });


    Route::middleware(['auth' , 'type:admin', 'check.boutique'])->group(function() {
        Route::get('/update_view' , [PackageController::class , 'update_view'])->name('update_view');
        Route::get('/suggestions' , [suggestionsController::class , 'suggestions_view'])->name('suggestions');
        Route::post('/add_suggestions' , [suggestionsController::class , 'send_suggestions'])->name('add_suggestions');
        Route::get('/statistiques/{mois?}', [StatistiquesController::class, 'statistiques_admin'])->name('statistiques');
        Route::get('/notifications/{mois?}' , [SuggestionsController::class , 'notifications'])->name('notifications');
        Route::get('/notifications_message/{id}' , [SuggestionsController::class , 'show_message'])->name('show_message');
        Route::delete('/delete_notifications_admin/{id}' , [SuggestionsController::class , 'delete_notifications_admin'])->name('delete_notifications_admin');
    });
/*FIN ROUTES ADMIN*/

/*ROUTES POUR ADMIN & EMPLOYES*/

Route::middleware(['auth', 'check.abonnement', 'check.boutique'])->group(function () {

    Route::get('/clients' , [clientsController::class , 'clients_view'])->name('clients')->middleware('type:admin,employe');
    Route::get('/fournisseurs' , [FournisseursController::class , 'fournisseurs_view'])->name('fournisseurs')->middleware('type:admin,employe');
    Route::get('/approvisionnement/{mois?}',[ReapprovisionnementController::class, 'approvisionnement'])->name('approvisionnement')->middleware('type:admin,employe');
    Route::post('/add_fournisseurs', [FournisseursController::class , 'add_fournisseurs'])->name('add_fournisseurs')->middleware('type:admin,employe');
    Route::get('/produits' , [ProductController::class ,'product_view'])->name('produits')->middleware('type:admin,employe');
    Route::put('/fournisseurs/{id}' , [FournisseursController::class , 'update_fournisseurs'])->name('update_fournisseurs')->middleware('type:admin,employe');
    Route::delete('/delete_fournisseurs/{id}' , [FournisseursController::class , 'delete_fournisseurs'])->name('delete_fournisseurs')->middleware('type:admin,employe');
    Route::post('/add_produits' , [ProductController::class , 'add_products'])->name('add_products')->middleware('type:admin,employe');
    Route::delete('/delete_produits/{id}', [ProductController::class , 'delete_produits'])->name('delete_produits')->middleware('type:admin,employe');
    Route::put('/update_produits/{id}' , [ProductController::class , 'update_produits'])->name('update_produits')->middleware('type:admin,employe');
    Route::get('/coursiers', [CoursiersController::class, 'coursiers_view'])->name('coursiers')->middleware('type:admin,employe');
    Route::post('/add_coursiers' ,[CoursiersController::class , 'add_coursiers'])->name('add_coursiers')->middleware('type:admin,employe');
    Route::put('/update_coursiers/{id}', [CoursiersController::class, 'update_coursiers'])->name('update_coursiers')->middleware('type:admin,employe');
    Route::delete('/delete_coursiers/{id}' , [CoursiersController::class , 'delete_coursiers'])->name('delete_coursiers')->middleware('type:admin,employe');
    Route::post('/add_clients' , [clientsController::class , 'add_clients'])->name('add_clients')->middleware('type:admin,employe');
    Route::put('/update_clients/{id}' , [clientsController::class , 'update_customers'])->name('update_customers')->middleware('type:admin,employe');
    Route::delete('/delete_clients/{id}' , [clientsController::class , 'delete_customers'])->name('delete_customers')->middleware('type:admin,employe');
    Route::get('/gestionnaires', [UserController::class , 'employes_view'])->name('gestionnaires')->middleware('type:admin,employe');
    Route::post('/add_gestionnaires' , [UserController::class , 'add_employes'])->name('add_gestionnaires')->middleware('type:admin,employe');
    Route::delete('/delete_employes/{id}' , [UserController::class , 'delete_employes'])->name('delete_employes')->middleware('type:admin,employe');
    Route::put('/update_employes/{id}' , [UserController::class , 'update_employes'])->name('update_employes')->middleware('type:admin,employe');
    Route::get('/admin_details' , [UserController::class , 'admin_details'])->name('admin_details')->middleware('type:admin,employe');
    Route::get('/categories' , [CategorieController::class , 'categories_view'])->name('categories')->middleware('type:admin,employe');
    Route::put('/update_categories/{id}' , [CategorieController::class , 'update_categories'])->name('update_categories')->middleware('type:admin,employe');
    Route::delete('/delete_categories/{id}' , [CategorieController::class , 'delete_categories'])->name('delete_categories')->middleware('type:admin,employe');
    Route::post('/add_category' , [CategorieController::class , 'add_category'])->name('add_category')->middleware('type:admin,employe');
    Route::get('/boutiques_view', [BoutiquesController::class , 'boutiques_view'])->name('boutiques_user')->middleware('type:admin,employe');
    Route::get('/boutique' , [BoutiquesController::class , 'boutiques_nav'])->name('boutique')->middleware('type:admin,employe');
    Route::get('/boutique_details/{id}', [BoutiquesController::class , 'boutique_details'])->name('boutique_details')->middleware('type:admin,employe');
    Route::post('/add_approvisionnement' , [ReapprovisionnementController::class , 'reapprovisionnement'])->name('add_approvisionnement')->middleware('type:admin,employe');
    Route::delete('/annuler_approvisionnement/{id}' , [ReapprovisionnementController::class , 'annuler_approvisionnement'])->name('annuler_approvisionnement')->middleware('type:admin,employe');
    Route::get('/ventes' , [VentesController::class , 'ventes_view'])->name('ventes')->middleware('type:admin,employe');
    Route::get('/autocompletion_produits',[ProductController::class,'autocompletion_produits'])->middleware('type:admin,employe');
    Route::get('/commandes' , [VentesController::class , 'commandes_view'])->name('commandes')->middleware('type:admin,employe');
    Route::post('/add_ventes' , [VentesController::class , 'add_ventes'])->name('add_ventes')->middleware('type:admin,employe');
    Route::get('/liste_ventes/{mois?}' , [VentesController::class , 'liste_ventes'])->name('liste_ventes')->middleware('type:admin,employe');
    Route::get('/liste_commandes/{mois?}' , [CommandesController::class , 'liste_commandes'])->name('liste_commandes')->middleware('type:admin,employe');
    Route::get('/update_plan' , [PackageController::class , 'update_plan'])->name('update_plan')->middleware('type:admin,employe');
    Route::get('/imprimer_factures/{id}' , [VentesController::class , 'imprimer_factures'])->name('imprimer_factures')->middleware('type:admin,employe');
    Route::get('/update_vente/{id}' , [VentesController::class ,'update_ventes_view'])->name('update_ventes_view')->middleware('type:admin,employe');
    Route::post('/update_ventes' , [VentesController::class , 'update_ventes'])->name('update_ventes')->middleware('type:admin,employe');
    Route::put('/valid_commandes/{id}' , [CommandesController::class , 'valid_commandes'])->name('valid_commandes')->middleware('type:admin,employe');
    Route::delete('/annuler_commandes/{id}' , [VentesController::class , 'delete_ventes'])->name('annuler_commandes')->middleware('type:admin,employe');
});
/* FIN ROUTES ADMIN & EMPLOYES*/
