<!DOCTYPE html>
<html>
@include('template.Head')
<body id="page-top">
    <div id="wrapper">
      @include('template.SideBar')
        <div class="d-flex flex-column" id="content-wrapper">
            @include('template.Header')
            </nav>
            <header class="shadow-sm" style="width: 100%;height: auto;margin-top: -30px;padding: 0px;background-color: #ffffff;padding-left: 30px;padding-top: 14px;margin-bottom: 10px;"><label style="font-family: Nunito, sans-serif;font-size: 16px;">Tableau de Bord</label></header>
            @include('template.Message')
            <div class="container-fluid" >
              {{-- ato miasa --}}
                      
              <div class="row" style="margin-top:-80px;">
                <div class="col" style="margin-top: 100px;">
                    <div class="input-group" style="width: 100%;height: auto;padding: 8px;">
                        <div>
                                                  
                        </div>
                  
                        <div class="input-group-append">
                        </div>
                        {{ $moisFR  }} {{ $annee }}
                        <form action="{{ url('/recherchetableaudebord') }}" method="POST" class="d-none d-sm-inline-block mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search" style="width: 80%;margin: 0px;margin-right: 0px;margin-left: 60%;">
                          @csrf
                          <div class="input-group" style="width: auto;margin-left: 60%;">
                            <select class="shadow-sm form-control border-0 small" name="mois" style="font-size: 13px;height: 36px;width: 20%;background-color: rgb(255,255,255);">
                             <option value="">choisir mois</option>
                              @foreach (range(1, 12) as $month)
                                  <option value="{{ $month }}">{{ \Illuminate\Support\Carbon::createFromDate(null, $month)->monthName }}</option>
                              @endforeach
                          </select>

                          <input class="shadow-sm form-control border-0 small" type="text" name="annee" placeholder="entrez un année" style="font-size: 13px;height: 36px;width: 20%;background-color: rgb(255,255,255);">
                          
                          <div class="input-group-append">
                                <button class="btn btn-primary py-0" type="submit" style="background-color: rgb(231,142,69);"><i class="fas fa-search"></i></button>
                              </div>
                          </div>
                      </form>
                    </div>
                    <div class="table-responsive">
<h1>FRAIS DE SIEGE : </h1>  
                        <table class="table">
                            <thead>
                                <tr>
                                  <th style="background-color: #ffffff;">AFFECTATION</th>
                                  <th style="background-color: #ffffff;">Montant total</th>                                    
                                </tr>
                            </thead>
                            <tbody>

                              @foreach ($listeFraisDeSiege as $rows)
                              <tr>
                                <td> {{ $rows->libelle }}</td>
                                <td>{{ number_format($rows->montant_total,2,',',' ') }} Ar</td>
                            </tr>
                              @endforeach
                              <tr class="total-row">
                                <td><strong>Total</strong></td>
                                <td class="total-amount"><strong>{{ number_format(\App\Models\caisse::getMontantTotal($listeFraisDeSiege), 2, ',', ' ') }} Ar</strong></td>
                            </tr>
                           
                            </tbody>
                        </table>
                        <style>
                            /* Ajoutez ce style CSS personnalisé dans votre balise <style> ou dans un fichier CSS externe */
                        
                            .total-row {
                                background-color: #f2f2f2; /* Couleur d'arrière-plan pour la ligne du total */
                            }
                        
                            .total-amount {
                                background-color: #f2f2f2; /* Couleur d'arrière-plan pour le montant total */
                                font-weight: bold; /* Texte en gras pour le montant total */
                            }
                        </style>
<br>
<h1>FRAIS D'ATELIER : </h1>
                        <table class="table">
                            <thead>
                                <tr>
                                  <th style="background-color: #ffffff;">AFFECTATION</th>
                                  <th style="background-color: #ffffff;">Montant total</th>                                    
                                </tr>
                            </thead>
                            <tbody>

                              @foreach ($listeFraisDAtelier as $rows)
                              <tr>
                                <td> {{ $rows->libelle }}</td>
                                <td>{{ number_format($rows->montant_total,2,',',' ') }} Ar</td>
                            </tr>
                              @endforeach
                              <tr class="total-row">
                                <td><strong>Total</strong></td>
                                <td class="total-amount"><strong>{{ number_format(\App\Models\Caisse::getMontantTotal($listeFraisDAtelier), 2, ',', ' ') }} Ar</strong></td>
                            </tr>
                            </tbody>
                        </table>
<br>
<h1>Recettes : </h1>
<table class="table">
    <thead>
        <tr>
          <th style="background-color: #ffffff;">AFFECTATION</th>
          <th style="background-color: #ffffff;">Montant total</th>                                    
        </tr>
    </thead>
    <tbody>

      @foreach ($listeRecettes as $rows)
      <tr>
        <td> {{ $rows->libelle }}</td>
        <td>{{ number_format($rows->montant_total,2,',',' ') }} Ar</td>
    </tr>
      @endforeach
      <tr class="total-row">
        <td><strong>Total</strong></td>
        <td class="total-amount"><strong>{{ number_format(\App\Models\Caisse::getMontantTotal($listeRecettes), 2, ',', ' ') }} Ar</strong></td>
    </tr>
    </tbody>
</table>
                    </div>
                </div>
            </div>
            </div>
        </div>
       
    </div>
    </div>
    </div>
     @include('template.Footer')
     <script src="<?php echo asset('assets4/Acc_Admin/bootstrap/js/bootstrap.min.js');?>"></script>
    <script src="<?php echo asset('assets4/Acc_Admin/js/bs-init.js');?>"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <script src="<?php echo asset('assets4/Acc_Admin/js/HTML-Table-to-Excel-V2.js');?>"></script>
    <script src="<?php echo asset('assets4/Acc_Admin/js/theme.js');?>"></script>
</body>

</html>