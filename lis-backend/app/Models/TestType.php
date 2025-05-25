<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TestType extends Model
{
    use HasFactory;



     
    use SoftDeletes;


    protected $fillable=['uniqid','name','facility_ref','description','hidename','meta','threshold','tat','cost','type','tatunit','lab_section','clinicaldata'];


    protected $casts = [
        'meta' => 'json',
    ];

    public function getMetaAttribute(){
        $meta=json_decode($this->attributes['meta'],true);
        // meta.fields.measures[i].type=='numericrange'"
        if(isset($meta) && isset($meta['fields']['measures']) && is_array($meta['fields']['measures'])){
            $counter=0;

            foreach($meta['fields']['measures'] as $measure){
                if($measure['type']=='numericrange'){
                    // meta.fields.measures[i].numericrangevalues[j].comparison
                    $counter2=0;
                    if(isset($measure['numericrangevalues']) && is_array($measure['numericrangevalues'])){
                        foreach($measure['numericrangevalues'] as $value){
                            if(!empty($value['comparison'])){
                                switch($value['comparisonvalue']){
                                    case "<": 
                                        $meta['fields']['measures'][$counter]['numericrangevalues'][$counter2]['start']=-9999999999999999999999999999999; 
                                        $meta['fields']['measures'][$counter]['numericrangevalues'][$counter2]['end']=$value['comparisonoperand']-0.00000000001; 
                                        //end is same minus a very small value (since it is strictly)
                                        break;
                                    case "<=": 
                                        $meta['fields']['measures'][$counter]['numericrangevalues'][$counter2]['start']=-9999999999999999999999999999999; 
                                        //end is same
                                        break;
                                    case ">": 
                                        $meta['fields']['measures'][$counter]['numericrangevalues'][$counter2]['start']=$value['comparisonoperand']+0.00000000001; 
                                        $meta['fields']['measures'][$counter]['numericrangevalues'][$counter2]['end']=9999999999999999999999999999999; 
                                        //end is same minus a very small value (since it is strictly)
                                        break;
                                    case ">=": 
                                        $meta['fields']['measures'][$counter]['numericrangevalues'][$counter2]['start']=$value['comparisonoperand']; 
                                        $meta['fields']['measures'][$counter]['numericrangevalues'][$counter2]['end']=9999999999999999999999999999999; 
                                        //end is same
                                        break;
                                }
                            }
                            $counter2++;
                        }
                    }
                }
                $counter++;
            }
        }
        return $meta;
    }
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($type) {
            $type->uniqid = gen_uniqid();
            if(!$type->type){
                $type->type="SINGLE";
            }
        });
    }
}
