<?php

namespace app\Services;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use EasyWeChat\Factory;
// use app\wechat\model\UserAddress as uam;
use app\admin\model\UserApply as uam;
class OrderServices
{  
    // 获取回收站点信息
    public function getRecyclingSite($address){
        $lng = $address['lng']??0;
        $lat = $address['lat']??0;

        $list = (new uam)->where(['state'=>2])->field('
                id,user_id,management_area,the_name,mobile,
                ROUND(
                    6378.138 * 2 * ASIN(
                        SQRT(
                            POW(
                                SIN(
                                    (
                                        '.$lat.' * PI() / 180 - lat * PI() / 180
                                    ) / 2
                                ),
                                2
                            ) + COS('.$lat.' * PI() / 180) * COS(lat * PI() / 180) * POW(
                                SIN(
                                    (
                                        '.$lng.' * PI() / 180 - lng * PI() / 180
                                    ) / 2
                                ),
                                2
                            )
                        )
                    ) 
                ,2) AS km

            ')->select();
        $list_arr = [];
        foreach($list as $v){
            if($v['km'] <= 5){
              $list_arr[]=$v;  
            }
        }
        $arr_list = $this->arraySort($list_arr,'km');  
                                
        
        return $arr_list[0]??[];    
    }

    /**
     * 二维数组根据某个字段排序
     * @param array $array 要排序的数组
     * @param string $keys   要排序的键字段
     * @param string $sort  排序类型  SORT_ASC     SORT_DESC 
     * SORT_ASC - 按照上升顺序排序
     * SORT_DESC - 按照下降顺序排序
     * @return array 排序后的数组
     */
    public function arraySort($array, $keys, $sort = SORT_ASC){
        $keysValue = [];
        foreach ($array as $k => $v) {
                $keysValue[$k] = $v[$keys]; 
        }
        array_multisort($keysValue, $sort, $array);
        return $array;
    }
}
?>