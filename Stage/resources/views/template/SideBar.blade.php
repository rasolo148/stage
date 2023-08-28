<nav class="navbar navbar-dark align-items-start sidebar sidebar-dark accordion bg-gradient-primary p-0">
  <div class="container-fluid d-flex flex-column p-0">
      <a class="navbar-brand d-flex justify-content-center align-items-center sidebar-brand m-0" href="#" style="height: 80px;">
          <div class="sidebar-brand-icon rotate-n-15"></div>
          <div class="sidebar-brand-text mx-3"><span><img src="<?php echo asset('assets/img/RN1_garage_bg-removebg-preview.png'); ?>" style="width: 150px;height: auto;"></span></div>
      </a>
      <ul class="nav navbar-nav text-light" id="accordionSidebar">
        <li class="nav-item" role="presentation">
        
          <a class="nav-link active" data-toggle="collapse" href="#gestion1"><i class="fas fa-cog"></i><span>Gérer Parc Auto</span></a>

          <div id="gestion1" class="collapse">
            <a class="nav-link active" href="{{ url('/listeParc') }}"><i class="fas fa-user"></i><span>Gérer Parking Auto</span></a>
            <a class="nav-link active" href="{{ url('/calendrierParc') }}"><i class="fas fa-user"></i><span>Calendrier Parc Auto</span></a>
          </div>

         
          <a class="nav-link active" data-toggle="collapse" href="#gestion"><i class="fas fa-cog"></i><span>Gérer les paramètres</span></a>
         
          <div id="gestion" class="collapse">
            <a class="nav-link active" href="{{ url('/listeLogistique') }}"><i class="fas fa-tools"></i><span>Inventaire des pièces et consommables</span></a>
            <a class="nav-link active" href="{{ url('/listeService') }}"><i class="fas fa-tachometer-alt"></i><span>Services</span></a>
            <a class="nav-link active" href="{{ url('/listeAffectation') }}"><i class="far fa-chart-bar"></i><span>Affectation</span></a>
          </div>
         
         
         
       
          <a class="nav-link active" data-toggle="collapse" href="#stock"><i class="fas fa-shopping-cart"></i><span>Achat et Vente</span></a>
      
          <div id="stock" class="collapse">
            <a class="nav-link active" href="{{ url('/listeStock') }}"><i class="fas fa-balance-scale"></i><span>Stock des logistiques</span></a>
            <a class="nav-link active" href="{{ url('/listeAchat') }}"><i class="fas fa-box"></i><span>Achat</span></a>
           
          </div>
     

          <a class="nav-link active" data-toggle="collapse" href="#reparation"><i class="fas fa-car"></i><span>Gestion Clientèle</span></a>
     
          <div id="reparation" class="collapse">
            <a class="nav-link active" href="{{ url('/listeClient') }}"><i class="fas fa-user"></i><span>Client</span></a>          
          </div>

          <div id="reparation" class="collapse">
            <a class="nav-link active" href="{{ url('/listeVoiture') }}"><i class="fas fa-car"></i><span>Véhicule</span></a>          
          </div>


          <div id="reparation" class="collapse">
            <a class="nav-link active" href="{{ url('/client') }}">
              <i class="fas fa-wrench"></i><span>Demande réparation</span>
            </a>
          </div>
          

          <a class="nav-link active" data-toggle="collapse" href="#reparations"><i class="fas fa-file-invoice-dollar"></i><span>Facturation</span></a>
        
          <div id="reparations" class="collapse">
            <a class="nav-link active" href="{{ url('/listeFacture') }}"><i class="fas fa-file-invoice"></i><span>Factures</span></a>
          </div>
  
         
          <a class="nav-link active" data-toggle="collapse" href="#reparationss"><i class="fas fa-chart-pie"></i><span>Caisse</span></a>
          <div id="reparationss" class="collapse">
           
            <a class="nav-link active" href="{{ url('/journalCaisse') }}"><i class="fas fa-history"></i><span>Journal de la caisse</span></a> 
            <a class="nav-link active" href="{{ url('/listeCaisse') }}/1">
              <i class="fas fa-box"></i><span>Caisse Principale</span>
            </a>
            <a class="nav-link active" href="{{ url('/listeCaisse') }}/2">
              <i class="fas fa-mobile-alt"></i><span>Caisse Mvola</span>
            </a>
            <a class="nav-link active" href="{{ url('/listeCaisse') }}/3">
              <i class="fas fa-credit-card"></i><span>Caisse Banque</span>
            </a>
            
          </div>

          <a class="nav-link active" data-toggle="collapse" href="#reparationsss"><i class="fas fa-chart-pie"></i><span>Analyses et Statistiques</span></a>
          <div id="reparationsss" class="collapse">
           
           
            <a class="nav-link active" href="{{ url('/verstableaudebord') }}">
              <i class="fas fa-tachometer-alt"></i><span>Tableau de Bord</span>
            </a>
            
            <a class="nav-link active" href="{{ url('/taux') }}">
              <i class="fas fa-stopwatch"></i><span>Analyse de l'efficacité des mains-d'œuvre</span>
            </a>
            
            <a class="nav-link active" href="{{ url('/listeStatistique') }}">
              <i class="fas fa-chart-line"></i><span>Graphique</span>
            </a>
            
          </div>

     
         
          </li>
          </ul>
   
          
  </div>  
</nav>