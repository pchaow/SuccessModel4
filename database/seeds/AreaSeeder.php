

<?php
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Models\Area;

class AreaSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */


    public function run()
    {
        $areas = [
            "อำเภอเมือง",
            "อำเภอแม่ใจ",
            "อำเภอดอกคำใต้",
            "อำเภอภูกามยาว",
            "อำเภอภูซาง",
            "อำเภอเชียงคำ",
            "อำเภอเชียงม่วน",
            "อำเภอจุน",
            "อำเภอปง"
        ];

        foreach($areas as $area){
            $a = new Area();
            $a->name_th = $area;
            $a->save();
        }


    }

}

