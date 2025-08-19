<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title> CAMES IMPORT </title>
    <link rel="stylesheet" href="{{asset('assets/vendors/feather/feather.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendors/mdi/css/materialdesignicons.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendors/ti-icons/css/themify-icons.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendors/font-awesome/css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendors/typicons/typicons.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendors/simple-line-icons/css/simple-line-icons.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendors/css/vendor.bundle.base.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css')}}">

    <link rel="stylesheet" href="{{asset('assets/vendors/select2/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendors/select2-bootstrap-theme/select2-bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
    <link rel="shortcut icon" href="{{asset('assets/images/favicon.png')}}" />
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  </head>
  <style>
   .autocomplete-container {
    position: relative;
    width: 100%;
    }

    .autocomplete-suggestions {
        position: absolute;
        top: 100%;
        left: 0;
        width: 100%;
        background: white;
        border: 1px solid #ddd;
        max-height: 200px;
        overflow-y: auto;
        z-index: 1000;
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        border-radius: 5px;
    }

    .suggestion-item {
        padding: 10px;
        cursor: pointer;
        border-bottom: 1px solid #ddd;
    }

    .suggestion-item:hover {
        background: #f1f1f1;
    }

  </style>
  <body>
    <div class="container-scroller">
        @include('includes.user_profil_include')
        <div class="container-fluid page-body-wrapper">
        @include('includes.nav_include')
        <div class="main-panel">
          <div class="content-wrapper">
            <div class="row">
              <div class="col-12 grid-margin">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title"> Espace ventes </h4>
                    <form class="form-sample" id="formulaireCommande" method="POST" action="{{route('add_ventes')}}">
                        @csrf
                        <p class="card-description">Rentrer une vente</p>

                        <!-- Infos client -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Nom Client</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="nom_client" class="form-control" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Email client</label>
                                    <div class="col-sm-8">
                                        <input type="email" name="email_client" class="form-control" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Conteneur des commandes -->
                        <div id="commandesContainer">
                            <div class="row align-items-center g-3 mb-3" id="nouvelle_commande0">
                                <div class="col-md-3">
                                    <div class="autocomplete-container">
                                        <input type="text" id="nom_produit0" name="nom_produit0" class="form-control"
                                            placeholder="Entrer un nom de produit" onkeyup="autoCompletion_produits(0)" />
                                        <div id="suggestions_0" class="autocomplete-suggestions"></div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <input type="number" id="quantite0" name="qte0" class="form-control"
                                        placeholder="Entrer une quantité" oninput="calculTotal(0)" />
                                </div>
                                <div class="col-md-3">
                                    <input type="number" id="prix_unitaire0" name="prix_unitaire0" class="form-control"
                                        placeholder="Prix unitaire" readonly />
                                </div>
                                <div class="col-md-3">
                                    <input type="number" id="total0" name="montant_total0" class="form-control" placeholder="Total"
                                        readonly />
                                </div>
                            </div>
                        </div>

                        <div class="row align-items-center g-3 mb-3">
                            <div class="col-md-3">
                                <select class="form-select form-select-sm" name="moyen_paiement">
                                    <option selected>moyen paiement</option>
                                    <option value="orange_money">Orange Money</option>
                                    <option value="mobile_money">Mobile Money</option>
                                    <option value="cash">Cash</option>
                                    <option value="paiement_bancaire">Paiement bancaire</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <input type="number" id="total_commandee"  name="montant_total" class="form-control" placeholder=" total commande" oninput="calculerReste()"  />
                            </div>
                            <div class="col-md-3">
                                <input type="number" id="montant_paye" name="montant_paye" class="form-control" placeholder="montant verse" oninput="calculerReste()" />
                            </div>
                            <div class="col-md-3">
                                <input type="number" id="reste" name="montant_rembourse" class="form-control" placeholder="reste" readonly />
                            </div>
                            <input type="hidden" name="numRows" id="numRows">
                            <input type="hidden" name="type_operation" value="vente">
                        </div>
                        <button type="submit" class="btn btn-success me-2">Enregistrer</button>
                        <button type="button" class="btn btn-danger me-2" id="btnAnnuler">Recommencer la commande</button>
                        <button type="button" class="btn btn-primary me-2" id="ajouterCommande">Ajouter une nouvelle commande</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
          @include('includes.footer')
        </div>
      </div>
    </div>

    <div class="modal fade" id="errorNbModal" tabindex="-1" aria-labelledby="errorNbModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content border-danger shadow-lg">
                <div class="modal-body text-center p-4">
                    <div class="mb-3">
                        <i class="mdi mdi-alert-circle-outline mdi-48px text-danger animate__animated animate__zoomIn"></i>
                    </div>
                     @if(session('error'))
                        <h5 class="modal-title" id="deleterModalLabel">{{session('error')}}</h5>
                    @endif
                    <button type="button" class="btn btn-danger btn-sm mt-3" data-bs-dismiss="modal">
                        Fermer
                    </button>
                </div>
            </div>
        </div>
    </div>


    <script src="{{asset('assets/vendors/js/vendor.bundle.base.js')}}"></script>
    <script src="{{asset('assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{asset('assets/vendors/typeahead.js/typeahead.bundle.min.js')}}"></script>
    <script src="{{asset('assets/vendors/select2/select2.min.js')}}"></script>
    <script src="{{asset('assets/js/off-canvas.js')}}"></script>
    <script src="{{asset('assets/js/template.js')}}"></script>
    <script src="{{asset('assets/js/settings.js')}}"></script>
    <script src="{{asset('assets/js/hoverable-collapse.js')}}"></script>
    <script src="{{asset('assets/js/todolist.js')}}"></script>
    <script src="{{asset('assets/js/file-upload.js')}}"></script>
    <script src="{{asset('assets/js/typeahead.js')}}"></script>
    <script src="{{asset('assets/js/select2.js')}}"></script>
    <script>
           let index = 1;
        const numRows = document.getElementById('numRows');
        numRows.value = 1;
        const divCommande = document.getElementById('commandesContainer');
        const boutonAjouter = document.getElementById('ajouterCommande');
        boutonAjouter.addEventListener('click', () => {
            const produit0 = document.getElementById('nom_produit0').value.trim();
            const qte0 = document.getElementById('quantite0').value.trim();

            if (produit0 === "" || qte0 === "" || parseFloat(qte0) <= 0) {
                alert("Veuillez remplir la première commande avant d'en ajouter une nouvelle.");
                return;
            }

            const nouvelleCommande = document.createElement('div');
            nouvelleCommande.classList.add('row', 'align-items-center', 'g-3', 'mb-3', 'test');
            nouvelleCommande.id = `nouvelle_commande${index}`;

            nouvelleCommande.innerHTML = `
                <div class="col-md-3">
                    <div class="autocomplete-container">
                        <input type="text" id="nom_produit${index}" name="nom_produit${index}" class="form-control"
                            placeholder="Entrer un nom de produit" onkeyup="autoCompletion_produits(${index})" />
                        <div id="suggestions_${index}" class="autocomplete-suggestions"></div>
                    </div>
                </div>
                <div class="col-md-3">
                    <input type="number" id="quantite${index}" name="qte${index}" class="form-control"
                        placeholder="Entrer une quantité" oninput="calculTotal(${index})" />
                </div>
                <div class="col-md-3">
                    <input type="number" id="prix_unitaire${index}" name="prix_unitaire${index}" class="form-control"
                        placeholder="Prix unitaire" readonly />
                </div>
                <div class="col-md-2">
                    <input type="number" id="total${index}" name="montant_total${index}" class="form-control"
                        placeholder="Total" readonly />
                </div>
                <div class="col-md-1">
                    <button type="button" class="btn btn-danger px-3 py-1 rounded-pill shadow-sm"
                        onclick="retirerCommande(${index}, this)">
                        <i class="fas fa-trash-alt"></i> Retirer
                    </button>
                </div>
            `;

            divCommande.appendChild(nouvelleCommande);
            index++;
            numRows.value = index;
        });
        
        function autoCompletion_produits(index) {
            let input = document.getElementById(`nom_produit${index}`);
            let suggestionsContainer = document.getElementById(`suggestions_${index}`);
            let prixUnitaire = document.getElementById(`prix_unitaire${index}`);

            let query = input.value.trim();

            if (query.length < 2) {
                suggestionsContainer.innerHTML = "";
                return;
            }

            fetch(`/autocompletion_produits?query=${encodeURIComponent(query)}`)
                .then(response => response.json())
                .then(data => {
                    suggestionsContainer.innerHTML = "";

                    data.forEach(produit => {
                        let suggestion = document.createElement("div");
                        suggestion.textContent = produit.nom_produit;
                        suggestion.classList.add("suggestion-item");

                        suggestion.addEventListener("click", () => {
                            input.value = produit.nom_produit;
                            if (prixUnitaire) {
                                prixUnitaire.value = produit.prix_vente;
                            }
                            suggestionsContainer.innerHTML = "";

                            calculTotal(index);
                        });

                        suggestionsContainer.appendChild(suggestion);
                    });
                })
                .catch(error => console.error('Erreur:', error));
        }

        function calculTotal(idx) {
            const quantite = parseFloat(document.getElementById(`quantite${idx}`).value) || 0;
            const prix = parseFloat(document.getElementById(`prix_unitaire${idx}`).value) || 0;
            document.getElementById(`total${idx}`).value = (quantite * prix).toFixed(2);
            calculerTotalGeneral();
        }

        function calculerTotalGeneral() {
            let totalGeneral = 0;
            // On prend uniquement les inputs de total par ligne (id qui commence par "total" et pas "total_commandee")
            document.querySelectorAll("input[id^='total']:not(#total_commandee)").forEach(input => {
                const val = parseFloat(input.value) || 0;
                totalGeneral += val;
            });
            document.getElementById('total_commandee').value = totalGeneral.toFixed(2);
            calculerReste();
        }

        function calculerReste(){
            let montantInput = document.getElementById('montant_paye');
            let reste = document.getElementById('reste');
            let total_commandeeInput = document.getElementById('total_commandee');

            montant = parseFloat(montantInput.value);
            total_com = parseFloat(total_commandeeInput.value);

            if ( montant >= total_com){
                let restes = montant - total_com;

                reste.value = restes.toFixed(2);
            }

            else{
                reste.value = '';
            }

        }


        function retirerCommande(idx) {
            const commande = document.getElementById(`nouvelle_commande${idx}`);
            if (commande) {
                commande.remove();
                calculerTotalGeneral();
            }
        }

        document.getElementById('btnAnnuler').addEventListener('click', () => {
            divCommande.innerHTML = `
                <div class="row align-items-center g-3 mb-3" id="nouvelle_commande0">
                    <div class="col-md-3">
                        <div class="autocomplete-container">
                            <input type="text" id="nom_produit0" name="nom_produit0" class="form-control"
                                placeholder="Entrer un nom de produit" onkeyup="autoCompletion_produits(0)" />
                            <div id="suggestions_0" class="autocomplete-suggestions"></div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <input type="number" id="quantite0" name="qte0" class="form-control"
                            placeholder="Entrer une quantité" oninput="calculTotal(0)" />
                    </div>
                    <div class="col-md-3">
                        <input type="number" id="prix_unitaire0" name="prix_unitaire0" class="form-control"
                            placeholder="Prix unitaire" readonly />
                    </div>
                    <div class="col-md-3">
                        <input type="number" id="total0" name="montant_total0" class="form-control" placeholder="Total"
                            readonly />
                    </div>
                </div>`;
            index = 1;
            numRows.value = index;
            calculerTotalGeneral();
        });

    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
        @if(session('error'))
            var NbModal = new bootstrap.Modal(document.getElementById('errorNbModal'));
            NbModal.show();
        @endif
        });
    </script>
  </body>
</html>
