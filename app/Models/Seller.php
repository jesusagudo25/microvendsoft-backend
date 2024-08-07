<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seller extends Model
{
    use HasFactory;

    protected $fillable = ['code', 'name',  'status'];

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function companys($period_start, $period_end)
    {
        return $this->belongsToMany(Company::class, 'company_seller')
            ->withPivot('goal', 'period_start', 'period_end')
            ->where('period_start', $period_start)
            ->where('period_end', $period_end);
    }

    public function commissions()
    {
        return $this->hasMany(SellerCommission::class);
    }

    public function searchCommission($name, $period_start, $period_end, $porcentaje, $company_id)
    {
        //Porcentajes
        $commissionsOne = [
            '100' => ['2' => 185, '1' => 180, '3' => 180],
            '98' => ['2' => 181, '1' => 176, '3' => 176],
            '96' => ['2' => 174, '1' => 169, '3' => 169],
            '94' => ['2' => 164, '1' => 159, '3' => 159],
            '92' => ['2' => 151, '1' => 146, '3' => 146],
            '90' => ['2' => 135, '1' => 132, '3' => 132],
            '88' => ['2' => 119, '1' => 116, '3' => 116],
            '86' => ['2' => 103, '1' => 100, '3' => 100],
            '84' => ['2' => 86, '1' => 84, '3' => 84],
            '82' => ['2' => 71, '1' => 69, '3' => 69],
            '80' => ['2' => 56, '1' => 55, '3' => 55],
            '78' => ['2' => 44, '1' => 43, '3' => 43],
            '76' => ['2' => 33, '1' => 33, '3' => 33],
        ];

        $commissionsTwo = [
            '100' => ['2' => 210, '1' => 210],
            '98' => ['2' => 206, '1' => 205.8],
            '96' => ['2' => 198, '1' => 198],
            '94' => ['2' => 186, '1' => 186],
            '92' => ['2' => 171, '1' => 171],
            '90' => ['2' => 154, '1' => 154],
            '88' => ['2' => 135, '1' => 135],
            '86' => ['2' => 116, '1' => 116],
            '84' => ['2' => 98, '1' => 98],
            '82' => ['2' => 80, '1' => 80],
            '80' => ['2' => 64, '1' => 64],
            '78' => ['2' => 50, '1' => 50],
            '76' => ['2' => 38, '1' => 38],
        ];

        $commissionsThree = [
            '100' => ['3' => 550],
            '98' => ['3' => 539],
            '96' => ['3' => 517],
            '94' => ['3' => 486],
            '92' => ['3' => 447],
            '90' => ['3' => 403],
            '88' => ['3' => 354],
            '86' => ['3' => 305],
            '84' => ['3' => 256],
            '82' => ['3' => 210],
            '80' => ['3' => 168],
            '78' => ['3' => 131],
            '76' => ['3' => 100],
        ];

        $specialsSellers = [
            'PAUL SOLIS'
        ];

        //Search all sellers with equal name
        $sellers = Seller::where('name', $name)->get();

        if (in_array($name, $specialsSellers)) {
            //Buscamos el id del vendedor que pertenezca a la compania
            $sellerId = null;
            foreach ($sellers as $seller) {
                $companySeller = Company::join('company_seller', 'companies.id', '=', 'company_seller.company_id')
                ->where('company_seller.company_id', $company_id)
                ->where('seller_id', $seller->id)
                ->where('period_start', $period_start)
                ->where('period_end', $period_end)
                ->get();

                if (!empty($companySeller[0])) {
                    $sellerId = $seller->id;
                }
            }

            //Buscar las ventas del vendedor de acuerdo al periodo, la compania. La comision sera el 1% de las ventas
            if (!empty($sellerId)) {
                $total = Invoice::where('seller_id', $sellerId)
                ->where('company_id', $company_id)
                ->whereBetween('date', [$period_start, $period_end])
                ->sum('total');

                return $total * 0.01;
            }
        }

        //buscar las companias de cada vendedor
        $companies = [];
        foreach ($sellers as $seller) {
            //guardar solamente id de las companias

            if (!empty($seller->companys($period_start, $period_end)->pluck('company_seller.company_id')->toArray()[0])){
                $companies[] = $seller->companys($period_start, $period_end)->pluck('company_seller.company_id')->toArray()[0];
            }

        }

        //if percentaje is >= 76, then the commission is not 0

        if($porcentaje < 76){
            return 0;
        }


        if (in_array(1, $companies) && in_array(2, $companies) && in_array(3, $companies)) {
            //Buscar el porcentaje de comision en comisionesOne, si no existe se busca el anterior mas cercano
            

            if (array_key_exists($porcentaje, $commissionsOne)) {
                return $commissionsOne[$porcentaje][$company_id];
            } else {
                $porcentajes = array_keys($commissionsOne);
                $sw = false;
        
                foreach ($porcentajes as $p) {

                    if ($p < $porcentaje && $sw == false) {
                        $porcentaje = $p;
                        $sw = true;
                    }
                }


                return $commissionsOne[$porcentaje][$company_id];
            }
        } elseif (in_array(1, $companies) && in_array(2, $companies)) {
            //return $commissionsTwo[$porcentaje][$company_id]; 
            if (array_key_exists($porcentaje, $commissionsTwo)) {
                return $commissionsTwo[$porcentaje][$company_id];
            } else {
                $porcentajes = array_keys($commissionsTwo);
                $sw = false;

                foreach ($porcentajes as $p) {
                    if ($p < $porcentaje && $sw == false) {
                        $porcentaje = $p;
                        $sw = true;
                    }
                }
                
                return $commissionsTwo[$porcentaje][$company_id];
            }
        } elseif (in_array(3, $companies)) {
            //return $commissionsThree[$porcentaje][$company_id];
            if (array_key_exists($porcentaje, $commissionsThree)) {
                return $commissionsThree[$porcentaje][$company_id];
            } else {
                $porcentajes = array_keys($commissionsThree);
                $sw = false;
                foreach ($porcentajes as $p) {
                    if ($p < $porcentaje && $sw == false) {
                        $porcentaje = $p;
                        $sw = true;
                    }
                }
                return $commissionsThree[$porcentaje][$company_id];
            }
        } else {
            return 0;
        }

    }
    
}
