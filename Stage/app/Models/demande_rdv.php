<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\demande_reparation;
use App\employe;
use App\reparation_employe;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class demande_rdv extends Model
{
         public static function getDemande($iddemande)
         {
            $demande = demande_reparation::find($iddemande);
            return $demande;         
         }

         public static function getDate($iddemande)
         {
            $demande = demande_reparation::find($iddemande);
            return $demande->date;         
         }

         public static function getDateFin($iddemande)
         {
          $demande = demande_reparation::find($iddemande);
          return $demande->datefin;     
         }

         public static function isAvailablePlace($date,$datefin)
         {
//             $count = demande_reparation::where('etat_sortie', '0')->where('etat_reparation', '<>', '0')
// ->whereDate('date', $date)->count();
$count = demande_reparation::where('etat_sortie', '0')
    ->where('etat_reparation', '<>', '0')
    ->where(function ($query) use ($date, $datefin) {
        $query->where(function ($subQuery) use ($date, $datefin) {
            $subQuery->where('date', '<', $date)
                     ->where('datefin', '>', $date);
        })
        ->orWhere(function ($subQuery) use ($date, $datefin) {
            $subQuery->where('date', '>', $date)
                     ->where('datefin', '<', $datefin);
        })
        ->orWhere(function ($subQuery) use ($date, $datefin) {
            $subQuery->where('date', '>=', $date)
                     ->where('date', '<=', $datefin);
        })
        ->orWhere(function ($subQuery) use ($date, $datefin) {
            $subQuery->where('datefin', '>=', $date)
                     ->where('datefin', '<=', $datefin);
        });
    })
    ->count();

            if($count+1 <= 15)
            {
                return true;
            }
            else {
                  return false;     
            }
         }

        public static function countTotalWorkingEmployees($date,$datefin) 
        {
        $count =  DB::table('demande_reparation')
            ->where('etat_reparation', '1')->where(function ($query) use ($date, $datefin) {
        $query->where(function ($subQuery) use ($date, $datefin) {
            $subQuery->where('date_entree', '<', $date)
                     ->where('datefin', '>', $date);
        })
        ->orWhere(function ($subQuery) use ($date, $datefin) {
            $subQuery->where('date_entree', '>', $date)
                     ->where('datefin', '<', $datefin);
        })
        ->orWhere(function ($subQuery) use ($date, $datefin) {
            $subQuery->where('date_entree', '>=', $date)
                     ->where('date_entree', '<=', $datefin);
        })
        ->orWhere(function ($subQuery) use ($date, $datefin) {
            $subQuery->where('datefin', '>=', $date)
                     ->where('datefin', '<=', $datefin);
        });
    })->sum('nombre_mecaniciens');

            return $count;
        }
    
        public static function availableMecanicien($iddemande,$date,$datefin)
        {
            $countEmploye = employe::count();  
            $countTotalWorkingEmploye = self::countTotalWorkingEmployees($date,$datefin);
            $available = $countEmploye - $countTotalWorkingEmploye;
            return $available;
        }

        public static function countWorks($iddemande)
        {
            $countWorks = demande_reparation::where('iddemande', $iddemande)->value('nombre_mecaniciens'); 
            return $countWorks;
        }

        public static function isAvalaibleMecanicien($iddemande,$date,$datefin)
        {
          $countWorks = self::countWorks($iddemande);
          $available = self::availableMecanicien($iddemande,$date,$datefin);
          if($available<$countWorks)
          {
            return false;
          }
          else {
            return true;
          }
        }

        public static function diffHours($demande)
        {
            $datefin =  Carbon::parse($demande->datefin);
            $date = Carbon::parse($demande->date);
            $diffInHours = $datefin->diffInHours($date);
            return $diffInHours;
        }

        public static function isRendezVousAvailable($iddemande) 
        {

            // date debut et date fin avec le nombre heure anatiny iny
            $demande = self::getDemande($iddemande);

            $diffInHours = self::diffHours($demande);

            $isAvailablePlace = self::isAvailablePlace($demande->date,$demande->datefin);

            $isAvalaibleMecanicien = self::isAvalaibleMecanicien($iddemande,$demande->date,$demande->datefin);

            // if ($isAvailablePlace && $isAvalaibleMecanicien) 
            // {
            //     $nextClosestDates = 
            //     [
            //         [
            //             'datedebut' => $demande->date,
            //             'datefin' => $demande->datefin
            //         ]
            //     ];
            // } 
            // else 
            // {
              //date debut suggerer
              $nextClosestDates = self::DatePlusProche($demande->date,$diffInHours,$iddemande);       
            // }
           return [
            'nextClosestDates' => $nextClosestDates
           ];
        }

        public static function DatePlusProche($requestedDateTime, $diffInHours, $iddemande) 
        {
            $requestedDateTimeCarbon = Carbon::parse($requestedDateTime);
        
            $closestDates = demande_reparation::where('etat_reparation', '1')
                ->where(function ($query) use ($requestedDateTimeCarbon) {
                    $query->where('datefin', '>', $requestedDateTimeCarbon)
                        ->orWhere(function ($subQuery) use ($requestedDateTimeCarbon) {
                            $subQuery->whereDate('datefin', $requestedDateTimeCarbon->toDateString())
                                     ->whereTime('datefin', '>', $requestedDateTimeCarbon->toTimeString());
                        });
                })
                ->orderBy('datefin')
                ->limit(5) // Limiter les résultats aux cinq prochaines dates de fin les plus proches
                ->get(['datefin']);
        
            $formattedDates = [];
        
            // Ajouter la date de début et la date de fin de la demande au début du tableau $formattedDates
            $formattedDates[] = [
                'datedebut' => $requestedDateTimeCarbon,
                'datefin' => Carbon::parse($requestedDateTimeCarbon)->addHours($diffInHours),
                'message' => self::getUnavailableMessage($requestedDateTimeCarbon, Carbon::parse($requestedDateTimeCarbon)->addHours($diffInHours), $iddemande),
            ];
        
            foreach ($closestDates as $date) 
            {
                $datefinSuggeree = Carbon::parse($date->datefin)->addHours($diffInHours);
        
                if ($datefinSuggeree->format('H:i') > '18:00') 
                {
                    // Calculate the remaining hours and minutes after 18:00
                    $remainingTime = $datefinSuggeree->diff(Carbon::parse($datefinSuggeree->toDateString() . ' 18:00'));
                    $datefinSuggeree->addDay()->setTime(8, 0); // Move to the next day at 08:00
                    $datefinSuggeree->addHours($remainingTime->h)->addMinutes($remainingTime->i); // Add the remaining hours and minutes to the next day
                }
        
                // if (self::isAvailablePlace($requestedDateTimeCarbon, $datefinSuggeree) && self::isAvalaibleMecanicien($iddemande, $requestedDateTimeCarbon, $datefinSuggeree)) 
                // {
                    $formattedDates[] = [
                        'datedebut' => $date->datefin,
                        'datefin' => $datefinSuggeree,
                        'message' => self::getUnavailableMessage($date->datefin, $datefinSuggeree, $iddemande),
                    ];
              //  }
            }  
                  
            return $formattedDates;
        }
        
      
        public static function getUnavailableMessage($startDate, $endDate, $iddemande)
{
    $isAvailablePlace = self::isAvailablePlace($startDate, $endDate);
    $isAvalaibleMecanicien = self::isAvalaibleMecanicien($iddemande, $startDate, $endDate);

    $message = '';

    if (!$isAvailablePlace && !$isAvalaibleMecanicien) {
        $message = 'Mécanicien indisponible et place indisponible';
    }

    if (!$isAvailablePlace && $isAvalaibleMecanicien) {
        $message = 'Mécanicien disponible et place indisponible';
    }

    if ($isAvailablePlace && !$isAvalaibleMecanicien) {
        $message = 'Mécanicien indisponible et place disponible';
    }

    if ($isAvailablePlace && $isAvalaibleMecanicien) {
        $message = 'Mécanicien disponible et place disponible';
    }

    return $message;
}

        
        
}

?>