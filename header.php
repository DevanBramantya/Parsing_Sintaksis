<?php 
    $conn=mysqli_connect('localhost','root','','pola_kalimat');
    function cyk(&$length,&$tabel,$conn,&$array_kalimat){
        $start_j=0;
        for($k=$length;$k>=1;$k--){
            $i=0;
            $j=$start_j;
            for($l=1;$l<=$k;$l++){
                $i++;
                $j++;
                if($i==$j){
                    $tabel[$i][$j]=proses($i,$j,$tabel,$conn,$array_kalimat);
                    while($tabel[$i][$j]==["0"]&&$length>$i){
                        $temp=array(implode(" ",array_slice($array_kalimat,$i-1,2)));
                        array_splice($array_kalimat,$i-1,2,$temp);
                        $length=count($array_kalimat);
                        $k--;
                        $tabel[$i][$j]=proses($i,$j,$tabel,$conn,$array_kalimat);
                    }
                }else{
                    $tabel[$i][$j]=proses($i,$j,$tabel,$conn,$array_kalimat);
                }
            }
            $start_j++;
        } 
    }
    function proses($i,$j,$tabel,$conn,$array_kalimat){
        if($i==$j){
            $return=array();
            $string=$array_kalimat[$i-1];
            $query=mysqli_query($conn,"select * from rule where body='$string'");
            if(mysqli_num_rows($query)>0){
                while($data=mysqli_fetch_array($query)){
                    array_push($return,$data['head']);
                }
                return array_unique($return);
            }else{
                return ["0"];
            }
        }else{
            $k=0;
            $cyk=array();
            while($i+$k<$j){
                $a=array();
                $b=array();
                $a=$tabel[$i][$i+$k];
                $b=$tabel[$i+$k+1][$j];
                foreach($a as $value1){
                    foreach($b as $value2){
                        if($value1!="0"&&$value2!="0"){
                            array_push($cyk,$value1." ".$value2);
                        }elseif($value2==0){
                            array_push($cyk,$value1);
                        }elseif($value1==0){
                            array_push($cyk,$value2);
                        }
                    }
                }
                $k++;
            }
            $return=array();
            foreach($cyk as $body){
                $query=mysqli_query($conn,"select * from rule where body='$body'");
                if(mysqli_num_rows($query)>0){
                    while($data=mysqli_fetch_array($query)){
                        array_push($return,$data['head']);
                    }
                }
            }
            if(count($return)>0){
                return array_unique($return);
            }else{
                return ["0"];
            }
        }
    }
    
    function cekvalid($tabel,$length){
        foreach($tabel[1][$length] as $cek){
            if($cek=="K"){
                return true;
            }
        }
        return false;
    }
?>