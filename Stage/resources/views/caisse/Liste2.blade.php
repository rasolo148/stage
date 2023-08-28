<?php
use App\Models\FormatDate;
?>
<!DOCTYPE html>
<html>
@include('template.Head')
<body id="page-top">
  <style>
    /* Optionnel : Style personnalisé pour éviter le wrap du texte dans les cellules */
    .table td.text-nowrap {
      white-space: nowrap;
    }
    .table th.text-nowrap {
      white-space: nowrap;
    }
  </style>
    <div id="wrapper">
      @include('template.SideBar')
        <div class="d-flex flex-column" id="content-wrapper">
            @include('template.Header')
            </nav>
            <header class="shadow-sm" style="width: 100%;height: auto;margin-top: -30px;padding: 0px;background-color: #ffffff;padding-left: 30px;padding-top: 14px;margin-bottom: 10px;"><label style="font-family: Nunito, sans-serif;font-size: 16px;">Caisse MVola</label></header>
            @include('template.Message')
            <div class="container-fluid" >
              {{-- ato miasa --}}
                      
              <div class="row" style="margin-top:-80px;">
                <div class="col" style="margin-top: 100px;">
                    <div class="input-group" style="width: 100%;height: auto;padding: 8px;">
                        <div>
                       
                           <a> <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#exampleModal"  style="background-color: #e78e45;">
                            Faire un mouvement
                              <i class="fa fa-plus" style="margin: 0px;margin-left: 10px;"></i>
                            </button> </a>
                            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                              <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Faire un mouvement dans la caisse</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                    </button>
                                  </div>
                                  <div class="modal-body">
                                                                                         
                                                      <form action="{{ url('/ajout_caisse') }}" method="post">
                                                        @csrf  
                                                       
                                                        <input type="hidden" name="indice" value="2">

                                                        <select name="type_mouvement" class="form-control" id="input" style="margin: auto; margin-top: 10px;">
                                                          <option value="" disabled selected>Choisir un mouvement</option>
                                                          <option value="entree">Entrée</option>
                                                          <option value="sortie">Sortie</option>
                                                        </select>
                                                        <br>
                                                        <input list="cars" placeholder="choisir affectation" class="bg-light border rounded" style="width: 90%; height: 35px;" id="car" />
                                                        <datalist id="cars">
                                                          <!-- This will be populated dynamically using JavaScript -->
                                                        </datalist>
                                                        <input type="hidden" name="idaffectation" />
                                                        
                                                        <script>
                                                          const inputMouvement = document.querySelector('#input');
                                                          const inputAffectation = document.querySelector('#car');
                                                          const datalistAffectation = document.querySelector('#cars');
                                                          
                                                          // An array to store all affectations
                                                          const allAffectations = {!! json_encode($listeAffectation) !!}; // Make sure to encode your PHP data correctly
                                                          
                                                          // Listen for changes to the inputMouvement element
                                                          inputMouvement.addEventListener('change', () => {
                                                            const selectedMouvement = inputMouvement.value;
                                                            
                                                            // Clear existing options in datalistAffectation
                                                            datalistAffectation.innerHTML = '';
                                                            
                                                            // Populate datalistAffectation based on selectedMouvement
                                                            allAffectations.forEach(affectation => {
                                                              if (affectation.type_mouvement === selectedMouvement) {
                                                                const option = document.createElement('option');
                                                                option.value = `${affectation.libelle} ${affectation.categorie}`;
                                                                option.setAttribute('data-idaffectation', affectation.idaffectation);
                                                                datalistAffectation.appendChild(option);
                                                              }
                                                            });
                                                          });
                                                          
                                                          // Listen for changes to the inputAffectation element
                                                          inputAffectation.addEventListener('change', () => {
                                                            const selectedValue = inputAffectation.value;
                                                            const selectedOption = datalistAffectation.querySelector(`option[value="${selectedValue}"]`);
                                                            
                                                            if (selectedOption) {
                                                              const idAffectation = selectedOption.getAttribute('data-idaffectation');
                                                              document.querySelector('input[name="idaffectation"]').value = idAffectation;
                                                            }
                                                          });
                                                        </script>
                                                        
                                                                <input name="reference" class="form-control" type="text" id="input" placeholder="Réference" style="margin: auto;margin-top: 10px;">
                                                                
                                                                <input name="libelle" class="form-control" type="text" id="input" placeholder="libellé" style="margin: auto;margin-top: 10px;">

                                                     
                                     
                                                              <input name="montant" class="form-control" type="text" id="input" placeholder="montant" style="margin: auto;margin-top: 10px;">

                                                              <input name="date" class="form-control" type="date" id="input" placeholder="date" style="margin: auto;margin-top: 10px;">

                                                                <input type="submit" class="btn btn-primary"
                                                                        role="button" id="button" style="background-color: #e78e45;margin: auto;margin-top: 10px;" value="Enregistrer">
                                                        
                                                    </form>
                                                  
                        
                                                        <div><button class="btn btn-primary d-block w-100" type="submit" style="background: var(--bs-gray);border-style: none;">ok</button></div>       
                                  </div>
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                                  </div>
                                </div>
                              </div>
                            </div>
                        </div>
                  
                        <div class="input-group-append">
                        </div>
                        <form action="{{ url('/recherchecaisse') }}" method="POST" class="d-none d-sm-inline-block mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search" style="width: 80%;margin: 0px;margin-right: 0px;margin-left: 60%;">
                          @csrf
                          <div class="input-group" style="width: auto;margin-left: 60%;">
                            <input type="hidden" name="indice" value="2">
                            <input class="shadow-sm form-control border-0 small" type="text" name="motcle" placeholder="motcle" style="font-size: 13px;height: 36px;width: 20%;background-color: rgb(255,255,255);">
                            <input class="shadow-sm form-control border-0 small" type="date" name="datedebut" placeholder="date debut" style="font-size: 13px;height: 36px;width: 20%;background-color: rgb(255,255,255);">
                              <div class="input-group-append">
                                <button class="btn btn-primary py-0" type="submit" style="background-color: rgb(231,142,69);"><i class="fas fa-search"></i></button>
                              </div>
                          </div>
                      </form>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                  <th class="text-nowrap"  style="background-color: #ffffff;">Date</th>
                                  <th class="text-nowrap"  style="background-color: #ffffff;">Réference</th> 
                                  <th class="text-nowrap"  style="background-color: #ffffff;">Libellé</th>
                                  <th class="text-nowrap"  style="background-color: #ffffff;">Affectation</th>
                                  <th class="text-nowrap"  style="background-color: #ffffff;">Entrée</th>
                                  <th class="text-nowrap"  style="background-color: #ffffff;">Sortie</th>
                                  <th class="text-nowrap"  style="background-color: #ffffff;">SOLDE</th>
                                </tr>
                            </thead>
                            <tbody>
                              @foreach ($liste as $rows)
                              <tr>
                                <td class="text-nowrap" >{{ FormatDate::format($rows->date) }}</td>
                                <td class="text-nowrap" >{{ $rows->reference }}</td>
                                <td class="text-nowrap" >{{ $rows->libelle }}</td>                               
                                <td class="text-nowrap" > <a href="{{ url('/verstableaudebord') }}">{{ $rows->affectation }}</a></td>
                                @if($rows->type_mouvement == 'entree')
                                <td class="text-nowrap" >{{ number_format($rows->montant,2,',',' ') }} Ar</td>
                                <td></td>
                                @else
                                <td></td>
                                <td class="text-nowrap" >{{ number_format($rows->montant,2,',',' ') }} Ar</td>
                               @endif  
                               <td class="text-nowrap" >{{ number_format($rows->solde,2,',',' ') }} Ar</td>
                              
                               <td class="text-nowrap"  style="width: 248px;">    
                                <a><button class="btn btn-primary" type="button" data-toggle="modal" data-target="#exampleModal{{ $rows->idcaisse }}" style="background-color: #eb3834;">Modifier</button> </a>
                              </td>

                            </tr>
                            <div class="modal fade" id="exampleModal{{ $rows->idcaisse }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                              <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Mot de passe Super Admin</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                    </button>
                                  </div>
                                  <div class="modal-body">
                                                                                         
                                                      <form action="{{ url('/versmodifcaisse') }}" method="post">
                                                        @csrf  
                                                      
                                                       <input type="hidden" name="idcaisse" value="{{ $rows->idcaisse }}" >

                                              
                                                                <div class="login-one-ico" style="width: 100%;height: auto;"><img src="<?php echo asset('assets/img/RN1_garage_bg-removebg-preview.png'); ?>" style="width: 100%;height: auto;"></div>
                                                             
                                                                <input name="mdp" class="form-control" type="password" value="hardi" id="input" placeholder="Password" style="margin: auto;margin-top: 10px;">
                                                                
                                                                <input type="submit" class="btn btn-primary"
                                                                        role="button" id="button" style="background-color: #e78e45;margin: auto;margin-top: 10px;" value="Valider">
                                                        
                                                    </form>
                                                  
                        
                                                        <div><button class="btn btn-primary d-block w-100" type="submit" style="background: var(--bs-gray);border-style: none;">ok</button></div>
                                                        @if (session('error'))
                                                        <div class="alert alert-danger" style="margin-top: 10px;">
                                                            {{ session('error') }}
                                                        </div>
                                                        @endif            
                                  </div>
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                                  </div>
                                </div>
                              </div>
                            </div>
                              @endforeach
                           
                            </tbody>
                        </table>
                    </div>
  

                    <style>
                      .pagination .page-link,
                      .pagination .page-item.active .page-link {
                        background:#e78e45;
                        border-color: orange;
                        color: white;
                      }
                    
                      .pagination .page-link:hover {
                        background: #e78e45;
                        border-color: darkorange;
                      }
                    </style>
                    <nav aria-label="Page navigation example">
                      <ul class="pagination">
                        <li class="page-item {{ $currentPage == 1 ? 'disabled' : '' }}">
                          <a class="page-link" href="{{ $currentPage == 1 ? '#' : url('/paginationcaisse') }}/{{ $currentPage - 1 }}/2" aria-label="Précédent">
                            <span aria-hidden="true">&laquo;</span>
                            <span class="sr-only">Précédent</span>
                          </a>
                        </li>
                        @foreach($listeNumeroPage as $rows)
                        <li class="page-item {{ $rows == $currentPage ? 'active' : '' }}">
                          <a class="page-link" href="{{ url('/paginationcaisse') }}/{{ $rows }}/2">{{ $rows }}</a>
                        </li>
                        @endforeach
                        <li class="page-item {{ $currentPage == $lastPage ? 'disabled' : '' }}">
                          <a class="page-link" href="{{ $currentPage == $lastPage ? '#' : url('/paginationcaisse') }}/{{ $currentPage + 1 }}/2" aria-label="Suivant">
                            <span aria-hidden="true">&raquo;</span>
                            <span class="sr-only">Suivant</span>
                          </a>
                        </li>
                      </ul>
                    </nav>
                    
                </div>
            </div>
            </div>
        </div>
       
    </div>
    </div>
    </div>
     @include('template.Footer')
</body>

</html>