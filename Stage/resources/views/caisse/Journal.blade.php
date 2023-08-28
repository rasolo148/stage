<?php
use App\Models\FormatDate;
use App\Models\caisse;
?>
<!DOCTYPE html>
<html>
@include('template.Head')
<body id="page-top">
    <div id="wrapper">
      @include('template.SideBar')
        <div class="d-flex flex-column" id="content-wrapper">
            @include('template.Header')
            </nav>
            <header class="shadow-sm" style="width: 100%;height: auto;margin-top: -30px;padding: 0px;background-color: #ffffff;padding-left: 30px;padding-top: 14px;margin-bottom: 10px;"><label style="font-family: Nunito, sans-serif;font-size: 16px;">Journal de la Caisse</label></header>
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

                       </div>
                       <div class="text-center">
                        <h1>Journal de la caisse quotidienne</h1>
                      </div>
                    <div class="table-responsive">
<h1>Caisse principale : </h1>  
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                   <th></th>
                                   <th></th>
                                   <th></th>
                                   <th></th>
                                   <th></th>
                                   <th>Solde restant en caisse</th>
                    <th class="text-nowrap"  class="total-amount"><strong>{{ number_format(caisse::getLastSoldDay('Espece',$dateActuelle),2,',',' ') }}</strong></th>
                                </tr>    
                                <tr>
                                  <th class="text-nowrap" style="background-color: #ffffff;">Date</th>
                                  <th class="text-nowrap" style="background-color: #ffffff;">Réference</th> 
                                  <th class="text-nowrap" style="background-color: #ffffff;">Libellé</th>
                                  <th class="text-nowrap" style="background-color: #ffffff;">Affectation</th>
                                  <th class="text-nowrap" style="background-color: #ffffff;">Entrée</th>
                                  <th class="text-nowrap" style="background-color: #ffffff;">Sortie</th>
                                  <th class="text-nowrap" style="background-color: #ffffff;">SOLDE</th>
                                </tr>
                            </thead>
                            <tbody>
@foreach (caisse::journal('Espece',$dateActuelle) as $rows)
    

                              <tr>
                                <td class="text-nowrap">{{ FormatDate::format($rows->date) }}</td>
                                <td class="text-nowrap">{{ $rows->reference }}</td>
                                <td class="text-nowrap">{{ $rows->libelle }}</td>                               
                                <td class="text-nowrap"> <a href="{{ url('/verstableaudebord') }}">{{ $rows->affectation }}</a></td>
                                @if($rows->type_mouvement == 'entree')
                                <td class="text-nowrap">{{ number_format($rows->montant,2,',',' ') }} Ar</td>
                                <td class="text-nowrap"></td>
                                @else
                                <td class="text-nowrap"></td>
                                <td class="text-nowrap">{{ number_format($rows->montant,2,',',' ') }} Ar</td>
                               @endif  
                               <td class="text-nowrap">{{ number_format($rows->solde,2,',',' ') }} Ar</td>
                            </tr>
                            @endforeach                
                              <tr class="total-row">
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td><strong>Solde antérieur</strong></td>
                                <td class="text-nowrap"  class="total-amount"><strong>{{ number_format(caisse::getlastSolde('Espece',$dateActuelle),2,',',' ') }}</strong></td>
                            </tr>
                           
                            </tbody>
                        </table>
            <br>
            <h1>Caisse MVola : </h1>  
            <table class="table table-bordered">
                <thead>
                    <tr>
                       <th></th>
                       <th></th>
                       <th></th>
                       <th></th>
                       <th></th>
                       <th>Solde restant en caisse</th>
        <th class="text-nowrap"  class="total-amount"><strong>{{ number_format(caisse::getLastSoldDay('Mvola',$dateActuelle),2,',',' ') }}</strong></th>
                    </tr>    
                    <tr>
                      <th class="text-nowrap" style="background-color: #ffffff;">Date</th>
                      <th class="text-nowrap" style="background-color: #ffffff;">Réference</th> 
                      <th class="text-nowrap" style="background-color: #ffffff;">Libellé</th>
                      <th class="text-nowrap" style="background-color: #ffffff;">Affectation</th>
                      <th class="text-nowrap" style="background-color: #ffffff;">Entrée</th>
                      <th class="text-nowrap" style="background-color: #ffffff;">Sortie</th>
                      <th class="text-nowrap" style="background-color: #ffffff;">SOLDE</th>
                    </tr>
                </thead>
                <tbody>
@foreach (caisse::journal('Mvola',$dateActuelle) as $rows)


                  <tr>
                    <td class="text-nowrap">{{ FormatDate::format($rows->date) }}</td>
                    <td class="text-nowrap">{{ $rows->reference }}</td>
                    <td class="text-nowrap">{{ $rows->libelle }}</td>                               
                    <td class="text-nowrap"> <a href="{{ url('/verstableaudebord') }}">{{ $rows->affectation }}</a></td>
                    @if($rows->type_mouvement == 'entree')
                    <td class="text-nowrap">{{ number_format($rows->montant,2,',',' ') }} Ar</td>
                    <td></td>
                    @else
                    <td></td>
                    <td class="text-nowrap">{{ number_format($rows->montant,2,',',' ') }} Ar</td>
                   @endif  
                   <td class="text-nowrap">{{ number_format($rows->solde,2,',',' ') }} Ar</td>
                </tr>
                @endforeach                
                  <tr class="total-row">
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><strong>Solde antérieur</strong></td>
                    <td class="text-nowrap"  class="total-amount"><strong>{{ number_format(caisse::getlastSolde('Mvola',$dateActuelle),2,',',' ') }}</strong></td>
                </tr>
               
                </tbody>
            </table>
            <br>
            <h1>Caisse Banque : </h1>  
            <table class="table table-bordered">
                <thead>
                    <tr>
                       <th></th>
                       <th></th>
                       <th></th>
                       <th></th>
                       <th></th>
                       <th>Solde restant en caisse</th>
        <th class="text-nowrap"  class="total-amount"><strong>{{ number_format(caisse::getLastSoldDay('Banque',$dateActuelle),2,',',' ') }}</strong></th>
                    </tr>    
                    <tr>
                      <th class="text-nowrap" style="background-color: #ffffff;">Date</th>
                      <th class="text-nowrap" style="background-color: #ffffff;">Réference</th> 
                      <th class="text-nowrap" style="background-color: #ffffff;">Libellé</th>
                      <th class="text-nowrap" style="background-color: #ffffff;">Affectation</th>
                      <th class="text-nowrap" style="background-color: #ffffff;">Entrée</th>
                      <th class="text-nowrap" style="background-color: #ffffff;">Sortie</th>
                      <th class="text-nowrap" style="background-color: #ffffff;">SOLDE</th>
                    </tr>
                </thead>
                <tbody>
@foreach (caisse::journal('Banque',$dateActuelle) as $rows)


                  <tr>
                    <td class="text-nowrap">{{ FormatDate::format($rows->date) }}</td>
                    <td class="text-nowrap">{{ $rows->reference }}</td>
                    <td class="text-nowrap">{{ $rows->libelle }}</td>                               
                    <td class="text-nowrap"> <a href="{{ url('/verstableaudebord') }}">{{ $rows->affectation }}</a></td>
                    @if($rows->type_mouvement == 'entree')
                    <td class="text-nowrap">{{ number_format($rows->montant,2,',',' ') }} Ar</td>
                    <td></td>
                    @else
                    <td></td>
                    <td class="text-nowrap">{{ number_format($rows->montant,2,',',' ') }} Ar</td>
                   @endif  
                   <td class="text-nowrap">{{ number_format($rows->solde,2,',',' ') }} Ar</td>
                </tr>
                @endforeach                
                  <tr class="total-row">
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><strong>Solde antérieur</strong></td>
                    <td class="text-nowrap"  class="total-amount"><strong>{{ number_format(caisse::getlastSolde('Banque',$dateActuelle),2,',',' ') }}</strong></td>
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
                            .table td.text-nowrap {
    white-space: nowrap;
  }
  .table th.text-nowrap {
    white-space: nowrap;
  }
                        </style>
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