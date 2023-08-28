<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\FormatDate;
use App\Models\FormatLetter;

class facture extends Model
{
    protected $table = 'facture';
    protected $fillable = [
        'iddemande',
        'date',
        'montant_total',
        'datemouvement',
    ];

    public $timestamps = false;
    protected $primaryKey = "idfacture";
    public $incrementing = false;

    public static function detailLogistique($iddemande)
    {
      $detailLogistique =  DB::select("SELECT l.* , v2.quantite , v2.idreparation_logistique , v2.prix_unitaire ,v2.prix_unitaire * v2.quantite * (1 + l.marge_beneficiaire / 100) AS total
            FROM v_demande v1
            JOIN reparation_logistique v2 USING (iddemande)
            JOIN logistique l USING (idlogistique)
            WHERE v1.iddemande = ?    
        ",[$iddemande]);
      return $detailLogistique;  
    }

    public static function detailService($iddemande)
    {
        $detailService = DB::select("select v2.idreparation_service , s.libelle , s.tarif as total from v_demande v1 join reparation_service v2 using(iddemande) join service s using(idservice) where v1.iddemande=?",[$iddemande]);
       return $detailService; 
    }

    public static function calculTotal($liste)
    {
        $total = 0;
         foreach($liste as $rows)
         {
             $total = $total + $rows->total;
         }
         return $total;
    }

 
    public static function estDemandeFacture($iddemande) {
        return \DB::table('facture')->where('iddemande', $iddemande)->exists();
    }


    public static function formatFacture($iddemande)
    {
  //idfacture 
      $facture = collect(\DB::select('select format_facture_id(f.idfacture) as idfacture , f.date from v_demande v1 join facture f using(iddemande) where v1.iddemande=?',[$iddemande]))->first();
      return $facture;
    }

    public static function genererPDF($iddemande)
    {
          //idfacture 
          $facture = self::formatFacture($iddemande);
          
          //info client
         $detailClient = \DB::table('v_demande')->where('v_demande.iddemande',$iddemande)->first();
  
          //detail reparation
          $detailLogistique = self::detailLogistique($iddemande); 
     

          // afficher produits
          $afficherTableauProduits = count($detailLogistique) > 0;


          //detail service
          $detailService = self::detailService($iddemande);

          //total produit
          $totalProduit = self::calculTotal($detailLogistique);
  
          //total service
          $totalService = self::calculTotal($detailService);

          // total  produit service prestation externe frais diverses
          $total = $totalProduit + $totalService;

          //conversion en texte
          $lettre = FormatLetter::convertDecimalToWords($total);
  
          // Récupérer le contenu de l'image
          $imageData = file_get_contents('assets/img/RN1_garage_bg-removebg-preview.png');
  
          // Encoder l'image en Base64
          $imageDataEncoded = base64_encode($imageData);
          $numeroSymbol = '№';

          // v_facture 
          $v_facture = DB::table("v_facture")->where("v_facture.iddemande",$iddemande)->first();
          
          $html = '
          <style>
          @page {
            margin: 10mm;
          }
          body {
              font-family: Arial, sans-serif;
          }
          .info {
              float: left;
              width: 45%;
          }
          .info1 {
              float: right;
              width: 25%;
              position:absolute;
              top:63px;
              left:500px;
          }
          table {
              border-collapse: collapse;
              width: 100%;
          }
          th, td {
              border: 1px solid #ddd;
              padding: 8px;
          }
          th {
              background-color: #456be7;
              color: white;
          }
          .facture-box {
              border: 0px solid; /* Couleur de la bordure */
              border-top: 1px solid;
              border-right: 1px solid;
              border-left: 1px solid;
              border-bottom: 1px solid;
              background-color: #f9d7d4; /* Couleur de fond rose */
              width: fit-content; /* Ajuster la largeur à son contenu */
          }
          p.email {
              text-decoration: underline;
          }
          h6 {
            font-size: 14px;
            margin: 0;
            padding: 0;
            font-weight:normal;
        }
        </style>
  
      <div class="info">
    <div>
    <img src="data:image/png;base64,' . $imageDataEncoded . '" alt="RN1 Garage" width="200px" height="100px">
    <p>Lot AZ 40 KIA Anosizato Ouest</p>
    <p>Antananarivo 102</p>
    <p>+261 33 64 600 31</p>
    <p class="email">rn1garages@gmail.com</p>
    <p>NIF: 3004272333</p>
    <p>STAT: 47521 11 2022 0 03641</p>
    </div>
    
    </div>
  
    <div class="info1">
   
    <div class="facture-box">
    <p><strong>FACTURE ' . $numeroSymbol  . ' ' . $facture->idfacture . '</strong></p>
    </div>    
    <br> 
    <b>Du ' . FormatDate::format($facture->date) . '</b>
    <br>
    <p><strong>Client: ' . $detailClient->nom  . '</strong></p>
    <p style="margin-left:58px;"><strong>Antananarivo</strong></p>
    <br>
    <p>REF : ' . $detailClient->immatriculation . '</p>
    <p style="margin-left:43px;">' . $detailClient->modele  . ' ' . $detailClient->marque  . '</p>
    </div>
        
      <div style="clear:both;"></div>';
      if($afficherTableauProduits) {
      $html.='<h1>Pièces :</h1>
      <table>
          <tr>
              <th>DESIGNATION</th>
              <th>QTE</th>
              <th>UNITE</th>
              <th>PU</th>
              <th>Marge</th>
              <th>MONTANT</th>
          </tr>';
          foreach ($detailLogistique as $detail) {
              $html .= '
                  <tr>
                      <td>' . $detail->libelle . '</td>
                      <td>' . number_format($detail->quantite,2,',',' ') . '</td>
                      <td>' . $detail->type_logistique . '</td>
                      <td>' . number_format($detail->prix_unitaire,2,',',' ') . '</td>
                      <td>' . $detail->marge_beneficiaire . '%</td>
                      <td>' . number_format($detail->total,2,',',' ') . '</td>
                  </tr>';
          }
          $html.= '
          <tr>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td>Total</td>
          <td>' . number_format($totalProduit,2,',',' ') . '</td>
         </tr>  
      </table>';
        }
      $html.='<h1>Main d\'œuvre :</h1>
      <table>
          <tr>
              <th>DESIGNATION</th>
              <th>TARIF</th>
          </tr>';
          foreach ($detailService as $detail) {
              $html .= '
                  <tr>
                      <td>' . $detail->libelle . '</td>
                      <td>' . number_format($detail->total,2,',',' ') . '</td>
                  </tr>';
          }
          $html.= '
          <tr>
          <td>Total</td>
          <td>' . number_format($totalService,2,',',' ') . '</td>
         </tr>  
      </table>
  <p>Net à payer: :  <strong>' .  number_format($total,2,',',' ') . ' Ariary.</strong></p>
  <p>Escompte : <strong>'  .  number_format($v_facture->montant_paye,2,',',' ') . ' Ariary.</strong></p>
  <p>Reste à payer : <strong>'  .  number_format($v_facture->reste_a_payer,2,',',' ') . ' Ariary.</strong></p>';

     return $html;
    }
    
}

?>