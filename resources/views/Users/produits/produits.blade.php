<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title> CAMES STOCK </title>
    <link rel="stylesheet" href="{{asset('assets/vendors/feather/feather.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendors/mdi/css/materialdesignicons.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendors/ti-icons/css/themify-icons.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendors/font-awesome/css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendors/typicons/typicons.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendors/simple-line-icons/css/simple-line-icons.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendors/css/vendor.bundle.base.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
    <link rel="shortcut icon" href="{{asset('assets/images/favicon.png')}}" />
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  </head>
  <body>
    <div class="container-scroller">
     @include('includes/user_profil_include')
      <div class="container-fluid page-body-wrapper">
       @include('includes/nav_include')
        <div class="main-panel">
          <div class="content-wrapper">
            <div class="row">
              <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="d-sm-flex justify-content-between align-items-start">
                      <div>
                        <h4 class="card-title card-title-dash">Espace Produits </h4>
                        <p class="card-subtitle card-subtitle-dash">managez vos Produits en toute aisance</p>
                      </div>
                      <div>
                        <button class="btn btn-primary btn-lg text-white mb-0 me-0" data-bs-toggle="modal" data-bs-target="#shopModal" type="button"><i class="mdi mdi-package-variant"></i> Ajouter un nouveau produit </button>
                      </div>
                    </div>
                    <div class="table-responsive">
                      <table class="table table-striped">
                        <thead>
                          <tr>
                            <th> Nom produit  </th>
                            <th> Prix vente   </th>
                            <th> Qte commandée  </th>
                            <th> Qte restante </th>
                            <th> description </th>
                            <th> image produit  </th>
                            <th> QrCodes</th>
                            <th colspan="2"> Action </th>
                          </tr>
                        </thead>
                        <tbody>
                            @php
                                use SimpleSoftwareIO\QrCode\Facades\QrCode;
                            @endphp
                            @forelse ($produits as $prod )
                            <tr>
                                <td >{{$prod->nom_produit}}</td>
                                <td>{{$prod->prix_vente}}</td>
                                <td>{{$prod->qte_commandee}}</td>
                                <td>{{$prod->qte_restante}}</td>
                                <td>{{$prod->description}}</td>
                                @if ($prod->image_produit)
                                    <td class="py-1">
                                        <img src="{{asset('assets/images/'.$prod->image_produit)}}" alt="image" />
                                    </td>
                                @else
                                <td class="py-1">
                                    pas d'image
                                </td>
                                @endif
                                <td class="py-1">
                                    <img src="{{asset('assets/images/qrCodes/'.$prod->qr_code)}}" alt="image" />
                                </td>
                                <td>
                                    <button type="button" data-id="{{$prod->id}}" data-nom="{{$prod->nom_produit}}" data-image="{{$prod->image_produit}}" data-vente="{{$prod->prix_vente}}" data-achat="{{$prod->prix_achat}}" data-description="{{ $prod->description}}" data-produit_pris="{{$prod->produit_pris}}" data-commande="{{$prod->qte_commandee}}" data-reste="{{$prod->qte_restante}}" onclick="openEditModal(this)" class="btn btn-success">Modifier</button>
                                    <button type="button" data-id="{{$prod->id}}" onclick="openSuppModal(this)" class="btn btn-danger">Supprimer</button>
                                    <button type="button" data-id="{{$prod->id}}" class="btn btn-dark"><i class="icon-printer"></i> Qr Code</button>

                                    <div id="qr-code-{{ $prod->id }}" style="display: none;">
                                        {!! QrCode::size(200)->generate($prod->id) !!}
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted">Aucun produit enregistré</td>
                            </tr>
                            @endforelse
                        </tbody>
                      </table>
                      <div class="mt-3 d-flex justify-content-center">
                        {{ $produits->links('pagination::bootstrap-5') }}
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

    <div class="modal fade" id="shopModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"> Ajouter une produit   </h5>
                    <button type="button" class="btn text-white fs-4" data-bs-dismiss="modal" aria-label="Close">&times;</button>
                </div>

                <div class="modal-body">
                    <form method="POST" action="{{route('add_products')}}" id="formulaire" enctype="multipart/form-data" >
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="centreName" class="form-label">Nom produit </label>
                                <input type="text" name="nom_produit" class="form-control" id="" placeholder="entrer le nom du produit ">
                            </div>
                            <div class="col-md-6">
                                <label for="centreName" class="form-label"> Qté commandée </label>
                                <input type="number" name="qte_commandee" class="form-control" id="" placeholder="entrer la qte commandée ">
                            </div>
                            <div class="col-md-6">
                                <label for="centreName" class="form-label"> prix vente </label>
                                <input type="number" name="prix_vente" class="form-control" id="" placeholder="entrer un prix de vente  ">
                            </div>
                            <div class="col-md-6">
                                <label for="centreName" class="form-label"> prix achat </label>
                                <input type="number" name="prix_achat" class="form-control" id="" placeholder="entrer un prix d'achat  ">
                            </div>
                            <div  class="col-12">
                                <label for="centreName" class="form-label">description </label>
                                <textarea name="description"  class="form-control" rows="3" placeholder="Entrez une description du produit"></textarea>
                            </div>
                            <div  class="col-12">
                                <label for="centreName" class="form-label"> Image du produit </label>
                                <input type="file" name="image_produit" class="form-control" >
                            </div>
                            <div  class="col-12">
                                <label for="categorie_produit" class="form-label">Catégorie du produit</label>
                                <select name="fk_categorie" id="categorie_produit" class="form-select">
                                    <option value="" selected disabled>— Sélectionnez une catégorie —</option>
                                    @foreach ($categories as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->categorie }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div  class="col-12">
                                <label for="fournisseur" class="form-label"> fournisseur </label>
                                <select name="fk_fournisseur" id="fournisseur" class="form-select">
                                    <option value="" selected disabled>— Sélectionnez une fournisseur —</option>
                                    @foreach ($fournisseurs as $fournis)
                                        <option value="{{ $fournis->id }}">{{ $fournis->nom_fournisseur }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="button-container">
                                <button type="submit" id="bouton" class="button btn btn-success" > enregistrer </button>
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Fermer</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel"> Modifier les informations des produits   </h5>
                    <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" enctype="multipart/form-data" action="" id="editForm">
                        @csrf
                        @method('PUT')

                        <div class="row g-3">

                            <div class="col-md-6" id="nom_bloc">
                                <label for="nom_produit" class="form-label">Nom produit</label>
                                <input type="text" name="nom_produit" class="form-control" id="nom_produit" placeholder="Entrer le nom du produit">
                            </div>

                            <div class="col-md-6" id="qte_bloc">
                                <label for="qte_commandee" class="form-label">Qté commandée</label>
                                <input type="number" name="qte_commandee" class="form-control" id="qte_commandee" placeholder="Entrer la qté commandée">
                            </div>

                            <div class="col-md-6">
                                <label for="prix_vente" class="form-label">Prix vente</label>
                                <input type="number" name="prix_vente" class="form-control" id="prix_vente" placeholder="Entrer un prix de vente">
                            </div>

                            <div class="col-md-6">
                                <label for="prix_achat" class="form-label">Prix achat</label>
                                <input type="number" name="prix_achat" class="form-control" id="prix_achat" placeholder="Entrer un prix d'achat">
                            </div>

                            <div class="col-12" >
                                <label for="description" class="form-label">Description</label>
                                <textarea name="description" id="description" class="form-control" rows="3" placeholder="Entrez une description du produit"></textarea>
                            </div>

                            <div class="col-12">
                                <label for="image_produit" class="form-label">Image du produit</label>
                                <input type="file" name="image_produit" class="form-control" id="image_produit_input">
                                <img src="" id="image_produit" alt="" class="img-fluid mt-2" height="65px" width="65px"  style="">
                            </div>

                            <div class="col-12">
                                <label for="categorie_produit" class="form-label">Catégorie du produit</label>
                                <select name="fk_categorie" id="categorie_produit" class="form-select">
                                    <option value="" id="categorie" selected >— Sélectionnez une categorie —</option>
                                    @foreach ($categories as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->categorie }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12">
                                <label for="fournisseur" class="form-label">fournisseur</label>
                                <select name="fk_fournisseur" id="categorie_produit" class="form-select">
                                    <option value="" id="fournisseur" selected >— Sélectionnez une fournisseur —</option>
                                    @foreach ($fournisseurs as $fournis)
                                        <option value="{{ $fournis->id }}">{{ $fournis->nom_fournisseur }}</option>
                                    @endforeach
                                </select>
                            </div>

                        </div>

                        <div class="mt-4 d-flex gap-2 justify-content-end">
                            <button type="submit" id="bouton" class="btn btn-success"> Enregistrer </button>
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal"> Fermer </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deleterModal" tabindex="-1" aria-labelledby="deleterModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content border-danger shadow-lg">
                <div class="modal-body text-center p-4">
                    <div class="mb-3">
                        <i class="mdi mdi-trash-can-outline mdi-48px text-danger animate__animated animate__zoomIn"></i>
                    </div>
                    @if(session('product_deleted'))
                        <h5 class="modal-title" id="deleterModalLabel">{{session('product_deleted')}}</h5>
                    @endif
                    <button type="button" class="btn btn-danger btn-sm mt-3" data-bs-dismiss="modal">
                        Fermer
                    </button>
                </div>
            </div>
        </div>
    </div>


        <!-- Success Modal -->
    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content border-success shadow-lg">
                <div class="modal-body text-center p-4">
                    <div class="mb-3">
                        <i class="mdi mdi-check-circle-outline mdi-48px text-success animate__animated animate__zoomIn"></i>
                    </div>
                    @if(session('product_creation'))
                        <h5 class="text-success fw-bold mb-2">{{ session('product_creation') }}</h5>
                    @endif
                    <button type="button" class="btn btn-success btn-sm mt-3" data-bs-dismiss="modal">
                        Fermer
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content border-danger shadow-lg">
                <div class="modal-body text-center p-4">
                    <div class="mb-3">
                        <i class="mdi mdi-alert-circle-outline mdi-48px text-danger animate__animated animate__zoomIn"></i>
                    </div>
                    <h5 class="text-danger fw-bold mb-3">Supprimer le produit ?</h5>
                    <p class="text-muted mb-3">Êtes-vous sûr de vouloir supprimer ce produit ?</p>
                    <div class="d-flex justify-content-center gap-2">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Non</button>
                        <form method="POST" id="deleteForm">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Oui</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content border-primary shadow-lg">
                <div class="modal-body text-center p-4">
                    <div class="mb-3">
                        <i class="mdi mdi-pencil-circle-outline mdi-48px text-primary animate__animated animate__zoomIn"></i>
                    </div>
                    @if(session('produits_updated'))
                        <h5 class="modal-title" id="deleterModalLabel">{{session('produits_updated')}}</h5>
                    @endif
                    <button type="button" class="btn btn-primary btn-sm mt-3" data-bs-dismiss="modal">
                        Fermer
                    </button>
                </div>
            </div>
        </div>
    </div>

    @if ($errors->any())
        <div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-sm">
                <div class="modal-content border-danger shadow-lg">
                    <div class="modal-body text-center p-4">
                        <div class="mb-3">
                            <i class="mdi mdi-alert-circle-outline mdi-48px text-danger animate__animated animate__zoomIn"></i>
                        </div>
                        <h5 class="text-danger fw-bold mb-3">Erreur(s) détectée(s)</h5>
                        <ul class="text-start text-danger small">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn btn-danger btn-sm mt-3" data-bs-dismiss="modal">
                            Fermer
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="modal fade" id="errorNbModal" tabindex="-1" aria-labelledby="errorNbModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content border-danger shadow-lg">
                <div class="modal-body text-center p-4">
                    <div class="mb-3">
                        <i class="mdi mdi-alert-circle-outline mdi-48px text-danger animate__animated animate__zoomIn"></i>
                    </div>
                     @if(session('error_price'))
                        <h5 class="modal-title" id="deleterModalLabel">{{session('error_price')}}</h5>
                    @endif
                    <button type="button" class="btn btn-danger btn-sm mt-3" data-bs-dismiss="modal">
                        Fermer
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="{{asset('assets/vendors/js/vendor.bundle.base.j')}}s"></script>
    <script src="{{asset('assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{asset('assets/js/off-canvas.js')}}"></script>
    <script src="{{asset('assets/js/template.js')}}"></script>
    <script src="{{asset('assets/js/settings.js')}}"></script>
    <script src="{{asset('ssets/js/hoverable-collapse.js')}}"></script>
    <script src="{{asset('assets/js/todolist.js')}}"></script>

    <script>
        function openEditModal(button) {

            var id = button.getAttribute('data-id');
            var nom = button.getAttribute('data-nom');
            var prix_achat = button.getAttribute('data-achat');
            var prix_vente = button.getAttribute('data-vente');
            var description = button.getAttribute('data-description');
            var image_produit = button.getAttribute('data-image');
            var qte_commandee = button.getAttribute('data-commande');
            var produit_pris = parseInt(button.getAttribute('data-produit_pris'));

            const updateproduitUrl = @json(route('update_produits', ['id' => '__ID__']));


            document.getElementById('editModalLabel').textContent = ' Modifier un produit ';
            document.getElementById('editForm').action = updateproduitUrl.replace('__ID__', id);
            document.getElementById('nom_produit').value = nom;
            document.getElementById('prix_vente').value = prix_vente;
            document.getElementById('prix_achat').value = prix_achat;
            document.getElementById('description').value = description;
            document.getElementById('image_produit').src = 'assets/images/' + image_produit;

            if (produit_pris == 1) {
                document.getElementById('qte_bloc').style.display = 'none';
                document.getElementById('nom_bloc').classList.remove('col-md-6');
                document.getElementById('nom_bloc').classList.add('col-md-12');
            }

            else{
                document.getElementById('qte_bloc').style.display = 'block';
                document.getElementById('qte_commandee').value = qte_commandee;
                document.getElementById('nom_bloc').classList.remove('col-md-12');
                document.getElementById('nom_bloc').classList.add('col-md-6');

            }

            var editModal = new bootstrap.Modal(document.getElementById('editModal'));
            editModal.show();

        }

    </script>

    <script>

        const deleteProduitsUrl =@json(route('delete_produits', ['id' => '__ID__'])) ;
        function openSuppModal(button) {
            var id = button.getAttribute('data-id');
            document.getElementById('deleteForm').action = deleteProduitsUrl.replace('__ID__', id);
            var deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
            deleteModal.show();
        }
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
        @if(session('product_deleted'))
            var deleterModal = new bootstrap.Modal(document.getElementById('deleterModal'));
            deleterModal.show();
        @endif
        });

    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
        @if(session('product_creation'))
            var successModal = new bootstrap.Modal(document.getElementById('successModal'));
            successModal.show();
        @endif
        });

    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
        @if(session('produits_updated'))
            var updateModal = new bootstrap.Modal(document.getElementById('updateModal'));
            updateModal.show();
        @endif
        });
    </script>

    @if ($errors->any())
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
                errorModal.show();
            });
        </script>
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', function () {
        @if(session('error_price'))
            var NbModal = new bootstrap.Modal(document.getElementById('errorNbModal'));
            NbModal.show();
        @endif
        });
    </script>

    <script>
    function printQrCode(id) {
        // récupérer le QR code
        let qrContent = document.getElementById("qr-code-" + id).innerHTML;

        // ouvrir une nouvelle fenêtre d’impression
        let printWindow = window.open('', '', 'width=400,height=400');
        printWindow.document.write('<html><head><title>QR Code</title></head><body>');
        printWindow.document.write(qrContent);
        printWindow.document.write('</body></html>');
        printWindow.document.close();
        printWindow.print();
    }
    </script>


  </body>
</html>
