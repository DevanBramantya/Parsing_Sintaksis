<?php 
    include "header.php";

    if(isset($_POST['kalimat'])){
        $kalimat=$_POST['kalimat'];

        $array_kalimat=explode(" ",$kalimat);
        $tabel=array();
        $length=count($array_kalimat);
        cyk($length,$tabel,$conn,$array_kalimat);

        if(cekvalid($tabel,$length)){
            $valid= true;
        }else{
            $tidak_valid= true;
        }
    }
?>

<html>
    <head>
        <title>Parsing Sintaksis Bahasa Bali</title>
        <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>
    <body>
        <div class="container">
            <div class="col-md-6 mx-auto" style="margin-top: 17%;">
                <h1 class="text-center typography"> Parsing Sintaksis Bahasa Bali </h1>
                <form action="index.php" method="POST">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" name="kalimat" id="kalimat">
                        <button class="btn btn-outline-secondary" type="submit" name="cek" id="cek" value="cek">Search</button>
                    </div>
                </form>
                <?php  if( isset($valid) ) : ?>
                    <p style="color : red; font-style: italic"> 
                        Kalimat <b><?= $kalimat ?></b> Valid
                    </p>
                    <!-- Tabel CYK -->
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <?php for($x=1;$x<=$length;$x++){?>
                            <tr>
                                <?php for($y=1;$y<=$length;$y++){?>
                                <td>
                                    <?php if(array_key_exists($x,$tabel)&&array_key_exists($y,$tabel[$x])){
                                        echo "{";
                                        $z=0;
                                            foreach($tabel[$x][$y] as $value){
                                                if($value=="0"){
                                                    echo " ";
                                                }elseif(count($tabel[$x][$y])==1){
                                                    echo $value;
                                                }elseif($z==count($tabel[$x][$y])-1){
                                                    echo $value;
                                                }elseif($z<count($tabel[$x][$y])-1){
                                                    echo $value.",";
                                                }
                                                $z++;
                                            }
                                        echo "}";
                                        }
                                    ?>
                                </td>
                                    <?php }?>
                                </tr>
                            <?php }?>
                    </table>
                <?php endif ?>
                <?php  if( isset($tidak_valid) ) : ?>
                    <p style="color : red; font-style: italic"> 
                        Kalimat <b><?= $kalimat ?><b> Tidak Valid
                    </p>
                <?php endif ?>
            </div>
        </div>
    </body>
</html>