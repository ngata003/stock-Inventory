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
    <link rel="shortcut icon" href="{{asset('assets/images/cames_favIcon.png')}}" />
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
                <!-- Colonne Formulaire -->
                <div class="col-md-8 grid-margin">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Espace ventes</h4>
                            <form class="form-sample" id="formulaireCommande" method="POST" action="{{ route('add_ventes') }}">
                                @csrf
                                <p class="card-description">Rentrer une vente</p>

                                <!-- Infos client -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label">Nom Client</label>
                                            <div class="col-sm-8">
                                                <input type="text" name="nom_client" class="form-control" oninput="majFacture()" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label">Email client</label>
                                            <div class="col-sm-8">
                                                <input type="email" name="email_client" class="form-control" oninput="majFacture()" />
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
                                                    placeholder="Entrer un nom de produit" onkeyup="autoCompletion_produits(0)" oninput="majFacture()" />
                                                <div id="suggestions_0" class="autocomplete-suggestions"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <input type="number" id="quantite0" name="qte0" class="form-control"
                                                placeholder="Quantité" oninput="calculTotal(0)" />
                                        </div>
                                        <div class="col-md-3">
                                            <input type="number" id="prix_unitaire0" name="prix_unitaire0" class="form-control"
                                                placeholder="PU" readonly />
                                        </div>
                                        <div class="col-md-3">
                                            <input type="number" id="total0" name="montant_total0" class="form-control"
                                                placeholder="Total" readonly />
                                        </div>
                                    </div>
                                </div>

                                <div class="row align-items-center g-3 mb-4">
                                    <div class="col-md-3">
                                        <select class="form-select form-select-sm text-dark" name="moyen_paiement" oninput="majFacture()">
                                            <option selected>moyen paiement</option>
                                            <option value="orange_money">Orange Money</option>
                                            <option value="mobile_money">Mobile Money</option>
                                            <option value="cash">Cash</option>
                                            <option value="paiement_bancaire">Paiement bancaire</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="number" id="total_commandee" name="montant_total" class="form-control"
                                            placeholder="Total commande" readonly />
                                    </div>
                                    <div class="col-md-3">
                                        <input type="number" id="montant_paye" name="montant_paye" class="form-control"
                                            placeholder="Montant versé" oninput="calculerReste()" />
                                    </div>
                                    <div class="col-md-3">
                                        <input type="number" id="reste" name="montant_rembourse" class="form-control"
                                            placeholder="Reste" readonly />
                                    </div>

                                    <input type="hidden" name="numRows" id="numRows" value="1">
                                    <input type="hidden" name="type_operation" value="vente">
                                </div>
                                <div class="row mb-4">
                                    <div class="col-md-3">
                                        <input type="number" id="reduction" name="reduction" class="form-control"
                                            placeholder="Réduction en FCFA"  oninput="calculerTotalGeneral()" />
                                    </div>
                                    <div class="col-md-3">
                                        <input type="number" id="remise" name="remise"  class="form-control"
                                            placeholder="tva:25%" oninput="calculerTotalGeneral()"/>
                                    </div>
                                </div>

                                <!-- Boutons -->
                                <button type="submit" class="btn btn-success me-2">Enregistrer</button>
                                <button type="button" class="btn btn-danger me-2" id="btnAnnuler">Recommencer</button>
                                <button type="button" class="btn btn-primary me-2" id="ajouterCommande">Ajouter commande</button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Colonne Facture -->
                <div class="col-md-4">
                    <div class="card shadow-sm">
                        <div class="card-body" id="facture-apercu" style="font-size:12px;">
                            <div class="header text-center mb-3">
                                <h5>FACTURE (aperçu)</h5>
                                <p id="facture-date"></p>
                            </div>

                            <!-- Infos client -->
                            <div class="mb-3">
                                <strong>Client :</strong> <span id="facture-client">---</span><br>
                                <strong>Email :</strong> <span id="facture-email">---</span>
                            </div>

                            <!-- Produits -->
                            <table class="table table-sm table-bordered">
                                <thead>
                                    <tr>
                                        <th>Produit</th>
                                        <th>Qte</th>
                                        <th>PU</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody id="facture-produits"></tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3" class="text-end">TOTAL</td>
                                        <td id="facture-total">0</td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" class="text-end">Payé</td>
                                        <td id="facture-paye">0</td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" class="text-end">Reste</td>
                                        <td id="facture-reste">0</td>
                                    </tr>
                                </tfoot>
                            </table>

                            <div class="footer text-center mt-3">
                                <small>Merci pour votre confiance</small>
                                <div class="mt-2">
                                    <button type="button" class="btn btn-dark" onclick="imprimerFacture()">🖨️ Imprimer la facture</button>
                                </div>
                            </div>
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
                     @if(session('error_produit'))
                        <h5 class="modal-title" id="deleterModalLabel">{{session('error_produit')}}</h5>
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
            nouvelleCommande.classList.add('row', 'align-items-center', 'g-3', 'mb-3');
            nouvelleCommande.id = `nouvelle_commande${index}`;

            nouvelleCommande.innerHTML = `
                <div class="col-md-3">
                    <div class="autocomplete-container">
                        <input type="text" id="nom_produit${index}" name="nom_produit${index}" class="form-control"
                            placeholder="Produit" onkeyup="autoCompletion_produits(${index})" oninput="majFacture()" />
                        <div id="suggestions_${index}" class="autocomplete-suggestions"></div>
                    </div>
                </div>
                <div class="col-md-3">
                    <input type="number" id="quantite${index}" name="qte${index}" class="form-control"
                        placeholder="Quantité" oninput="calculTotal(${index})" />
                </div>
                <div class="col-md-3">
                    <input type="number" id="prix_unitaire${index}" name="prix_unitaire${index}" class="form-control"
                        placeholder="PU" readonly />
                </div>
                <div class="col-md-2">
                    <input type="number" id="total${index}" name="montant_total${index}" class="form-control"
                        placeholder="Total" readonly />
                </div>
                <div class="col-md-1">
                    <button type="button" class="btn btn-danger px-3 py-1"
                        onclick="retirerCommande(${index}, this)">🗑 Retirer</button>
                </div>
            `;

            divCommande.appendChild(nouvelleCommande);
            index++;
            numRows.value = index;

            majFacture();
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
            majFacture();
        }

        function calculerTotalGeneral() {
            let totalGeneral = 0;
            document.querySelectorAll("input[id^='total']:not(#total_commandee)").forEach(input => {
                const val = parseFloat(input.value) || 0;
                totalGeneral += val;
            });

            let remise = document.getElementById('remise').value || 0;
            let reduction = document.getElementById('reduction').value || 0;

            if(reduction > 0){
                totalGeneral -= parseFloat(reduction);
            }
            else if(remise > 0){
                totalGeneral -= (totalGeneral * parseFloat(remise) / 100);
            }
            else if( remise && reduction){
                alert('svp remplir un seul champ entre remise et reduction');
            }


            document.getElementById('total_commandee').value = totalGeneral.toFixed(2);
            calculerReste();
        }

        function calculerReste() {
            let montant = parseFloat(document.getElementById('montant_paye').value) || 0;
            let total = parseFloat(document.getElementById('total_commandee').value) || 0;
            let reste = document.getElementById('reste');

            reste.value = (montant - total ).toFixed(2);
            majFacture();
        }

        function retirerCommande(idx) {
            const commande = document.getElementById(`nouvelle_commande${idx}`);
            if (commande) {
                commande.remove();
                calculerTotalGeneral();
                majFacture();
            }
        }

        document.getElementById('btnAnnuler').addEventListener('click', () => {
            divCommande.innerHTML = `
                <div class="row align-items-center g-3 mb-3" id="nouvelle_commande0">
                    <div class="col-md-3">
                        <div class="autocomplete-container">
                            <input type="text" id="nom_produit0" name="nom_produit0" class="form-control"
                                placeholder="Produit" onkeyup="autoCompletion_produits(0)" oninput="majFacture()" />
                            <div id="suggestions_0" class="autocomplete-suggestions"></div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <input type="number" id="quantite0" name="qte0" class="form-control"
                            placeholder="Quantité" oninput="calculTotal(0)" />
                    </div>
                    <div class="col-md-3">
                        <input type="number" id="prix_unitaire0" name="prix_unitaire0" class="form-control"
                            placeholder="PU" readonly />
                    </div>
                    <div class="col-md-3">
                        <input type="number" id="total0" name="montant_total0" class="form-control" placeholder="Total"
                            readonly />
                    </div>
                </div>`;
            index = 1;
            numRows.value = index;
            calculerTotalGeneral();
            majFacture();
        });

        function majFacture() {
            document.getElementById('facture-date').textContent = new Date().toLocaleDateString();
            document.getElementById('facture-client').textContent = document.querySelector("input[name='nom_client']").value || "---";
            document.getElementById('facture-email').textContent = document.querySelector("input[name='email_client']").value || "---";

            const tbody = document.getElementById('facture-produits');
            tbody.innerHTML = "";
            document.querySelectorAll("div[id^='nouvelle_commande']").forEach(div => {
                const idx = div.id.replace("nouvelle_commande", "");
                const produit = document.getElementById(`nom_produit${idx}`)?.value || "";
                const qte = document.getElementById(`quantite${idx}`)?.value || 0;
                const prix = document.getElementById(`prix_unitaire${idx}`)?.value || 0;
                const total = document.getElementById(`total${idx}`)?.value || 0;

                if (produit) {
                    const tr = document.createElement("tr");
                    tr.innerHTML = `<td>${produit}</td><td>${qte}</td><td>${prix}</td><td>${total}</td>`;
                    tbody.appendChild(tr);
                }
            });

            document.getElementById('facture-total').textContent = document.getElementById('total_commandee').value || 0;
            document.getElementById('facture-paye').textContent = document.getElementById('montant_paye').value || 0;
            document.getElementById('facture-reste').textContent = document.getElementById('reste').value || 0;
        }

        function imprimerFacture() {
            let contenuFacture = document.getElementById('facture-apercu').innerHTML;
            let fenetre = window.open('', '', 'height=600,width=800');
            fenetre.document.write('<html><head><title>Facture</title>');
            fenetre.document.write('<style>table{width:100%;border-collapse:collapse}td,th{border:1px solid #000;padding:5px;text-align:center}</style>');
            fenetre.document.write('</head><body>');
            fenetre.document.write(contenuFacture);
            fenetre.document.write('</body></html>');
            fenetre.document.close();
            fenetre.print();
        }

        function enregistrerEtImprimer() {
            document.getElementById('formulaireCommande').submit();
            setTimeout(() => { imprimerFacture(); }, 800);
        }
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
        @if(session('error_produit'))
            var NbModal = new bootstrap.Modal(document.getElementById('errorNbModal'));
            NbModal.show();
        @endif
        });
    </script>

  </body>
</html>
