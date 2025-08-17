<!DOCTYPE html>
<html lang="en">
  <head>
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
    <link rel="shortcut icon" href="{{asset('assets/images/favicon.png')}}"/>

    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .btn-custom-primary {
            padding: 8px 20px;
            font-size: 15px;
            border-radius: 0; /* pas de coins arrondis */
            margin-left: 10px;
        }
    </style>
  </head>
  <body>
    <div class="container-scroller">
     @include('includes.user_profil_include')
      <div class="container-fluid page-body-wrapper">
        @include('includes.nav_include')

        <div class="main-panel">
          <div class="content-wrapper">
            <div class="row">
              <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="d-sm-flex justify-content-between align-items-start">
                      <div>
                        <h4 class="card-title card-title-dash">Espace Ventes </h4>
                        <p class="card-subtitle card-subtitle-dash"> Consultez toutes les ventes effectuées au sein de votre boutique </p>
                      </div>
                       <div class="d-flex justify-content-end mb-3">
                            <a href="#" class="btn btn-success me-1"><i class="icon-printer"></i> Print</a>
                            <a href="#" class="btn btn-primary text-white me-2"><i class="icon-download"></i> Export</a>
                        </div>
                    </div>
                    <div class="table-responsive">
                      <table class="table table-striped">
                        <thead>
                          <tr>
                            <th>id</th>
                            <th> Nom client </th>
                            <th> Email client   </th>
                            <th> montant paye  </th>
                            <th> montant rembourse </th>
                            <th> moyen paiement </th>
                            <th> date vente </th>
                            <th colspan="2"> Action </th>
                          </tr>
                        </thead>
                        <tbody>
                            @forelse ($ventes as $vt )
                                <tr>
                                    <td>{{$vt->id}}</td>
                                    <td >{{$vt->nom_client ?? '--'}}</td>
                                    <td>{{$vt->email_client ?? '--'}}</td>
                                    <td>{{$vt->montant_paye}}</td>
                                    <td> {{$vt->montant_remboursé}}</td>
                                    <td> {{$vt->moyen_paiement}}</td>
                                    <td> {{$vt->updated_at}}</td>
                                    <td>
                                    <a href="{{route('update_ventes_view' , ['id' => $vt->id])}}" class="btn btn-success">Modifier</a>
                                    <button type="button" class="btn btn-danger" data-id="{{$vt->id}}" onclick="openSuppModal(this)"> Annuler la vente  </button>
                                    <a href="{{route('imprimer_factures' , ['id' => $vt->id])}}" class="btn btn-dark"><i class="icon-printer"></i></a>
                                    </td>
                                </tr>
                            @empty
                                <td colspan="7" class="text-center text-muted">Aucune vente enregistrée</td>
                            @endforelse
                        </tbody>
                      </table>
                       <div class="mt-3 d-flex justify-content-center">
                        {{ $ventes->links('pagination::bootstrap-5') }}
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

    <div class="modal fade" id="deleterModal" tabindex="-1" aria-labelledby="deleterModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content border-danger shadow-lg">
                <div class="modal-body text-center p-4">
                    <div class="mb-3">
                        <i class="mdi mdi-trash-can-outline mdi-48px text-danger animate__animated animate__zoomIn"></i>
                    </div>
                    @if(session('invoice_delete'))
                        <h5 class="modal-title" id="deleterModalLabel">{{session('invoice_delete')}}</h5>
                    @endif
                    <button type="button" class="btn btn-danger btn-sm mt-3" data-bs-dismiss="modal">
                        Fermer
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de succès après édition -->
    <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content border-primary shadow-lg">
                <div class="modal-body text-center p-4">
                    <div class="mb-3">
                        <i class="mdi mdi-pencil-circle-outline mdi-48px text-primary animate__animated animate__zoomIn"></i>
                    </div>
                    @if(session('customer_updated'))
                        <h5 class="modal-title" id="deleterModalLabel">{{session('customer_updated')}}</h5>
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

    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content border-success shadow-lg">
                <div class="modal-body text-center p-4">
                    <div class="mb-3">
                        <i class="mdi mdi-check-circle-outline mdi-48px text-success animate__animated animate__zoomIn"></i>
                    </div>
                    @if(session('success_transfert'))
                        <h5 class="text-success fw-bold mb-2">{{ session('success_transfert') }}</h5>
                    @endif
                    <button type="button" class="btn btn-success btn-sm mt-3" data-bs-dismiss="modal">
                        Fermer
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="deleteModalLabel">Annuler la vente </h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              Êtes-vous sûr de vouloir annuler cette vente ?
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Non</button>
              <form method="POST" id="deleteForm">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Oui</button>
              </form>
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
        const AnnulerCommandsUrl =@json(route('annuler_commandes', ['id' => '__ID__'])) ;
        function openSuppModal(button) {
            var id = button.getAttribute('data-id');
            document.getElementById('deleteForm').action = AnnulerCommandsUrl.replace('__ID__', id);
            var deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
            deleteModal.show();
        }
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
        @if(session('invoice_delete'))
            var deleterModal = new bootstrap.Modal(document.getElementById('deleterModal'));
            deleterModal.show();
        @endif
        });

    </script>
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
        @if(session('customer_updated'))
            var updateModal = new bootstrap.Modal(document.getElementById('updateModal'));
            updateModal.show();
        @endif
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
        @if(session('success_transfert'))
            var successModal = new bootstrap.Modal(document.getElementById('successModal'));
            successModal.show();
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
  </body>
</html>
