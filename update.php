<?php
//config dosyasını dahil ediyoruz
require_once "config.php";

//değşkenleri tanımlayıp boş değerlerlle başlatıyoruz

$name=$address=$salary="";
$name_err=$address_err=$salary_err="";

//form gönderildiğinde form verilerinin işlenmesi
if(isset($_POST["id"]) && !empty($_POST["id"])){
    //gizli giriş değerini al
    $id=$_POST["id"];

    //ad onaylama
    $input_name= trim($_POST["name"]);
    if(empty($input_name)){
        $name_err="Lütfen isim giriniz.";
    } elseif (!filter_var($input_name,FILTER_VALIDATE_REGEXP,array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $name_err="Lütfen geçerli isim giriniz";
    } else{
        $name=$input_name;
    }

    //adres onaylama
    $input_address= trim($_POST["address"]);
    if(empty($input_address)){
        $address_err="Lütfen adres giriniz.";
    } else{
        $address=$input_address;
    }

    //maas onaylama

    $input_salary= trim($_POST["salary"]);
    if(empty($input_salary)){
        $salary_err="Lütfen maaş miktarını giriniz.";
    }elseif(!ctype_digit($input_salary)){
        $salary_err="Lütfen positif sayı giriniz";
    }else{
        $salary=$input_salary;
    }
    //veritabanına güncellemeden hata verilerini kontrol edelim
    if(empty($name_err) && empty($address_err) &&empty($salary_err)){
        //güncelleme sorgusu
        $sql = "UPDATE employees SET name= :name, address= :address, salary= :salary WHERE id= :id";

        if($stmt = $pdo->prepare($sql)){
            //hazırlanan değişkenleri parametre olarak bağlayın
            $stmt->bindParam(":name",$param_name);
            $stmt->bindParam(":address",$param_address);
            $stmt->bindParam(":salary",$param_salary);
            $stmt->bindParam(":id",$param_id);

            //parametreleri tanımla
            $param_name=$name;
            $param_address=$address;
            $param_salary=$salary;
            $param_id=$id;

            //Hazırlanan ifadeyi çalıştırma
            if($stmt->execute()){
                //update işlemi başarılı ise index.php sayfasına yönlendirir.
                header("location: index.php");
                exit();
            }else{
                echo "Tekrar deneyiniz!";
            }
        }
        //Bildirimi kapat
        unset($stmt);
    }
    //bağlantıyı kapat
    unset($pdo);
}else{
    //id parametresinin varlığını kontrol etme
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        //parametreyi al
      $id= trim($_GET["id"]);
      //  seçme sorgusu
      $sql= "SELECT * FROM employees WHERE id= :id";
      if($stmt=$pdo->prepare($sql)){
          //Hazırlanan ifadeye değişkenleri parametre olarak bağlayın
          $stmt->bindParam(":id",$param_id);
          //parametreyi ayarla
          $param_id=$id;

          if($stmt->execute()){
              if($stmt->rowCount()==1){
                $row=$stmt->fetch(PDO::FETCH_ASSOC);

                //ALAN DEĞERLERİNİ AL
                $name=$row["name"];
                $address=$row["address"];
                $salary=$row["salary"];
              }else{
                  //url çalışmaz ise error sayfasına yönlendirir
                 header("location: error.php");
                 exit(); 
              }
          }else{
              echo "Tekrar deneyiniz!";
          }
      }
      unset($stmt);

      unset($pdo);
    }else{
        header("location: error.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Güncelleme Sayfası</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        .wrapper{
            width: 500px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h2>Güncelleme</h2>
                    </div>
                    <p>Lütfen güncel form verileri giriniz.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                    <div class="form-group<?php echo (!empty($name_err)) ? 'has-error':''; ?>">
                        <label>Adı</label>
                        <input type="text" name="name" class="form-control" value="<?php echo $name; ?>">
                        <span class="help-block"><?php echo $name_err; ?></span>
                    </div>
                    <div class="form-group<?php echo(!empty($address_err)) ? 'has-error':''; ?>">
                        <label>Adres</label>
                        <textarea name="address" class="form-control" cols="30" rows="10"><?php echo $address; ?></textarea>
                        <span class="help-block"><?php echo $address_err; ?></span>
                    </div>
                    <div class="form-group<?php echo (!empty($salary_err)) ? 'has-error': ''; ?>">
                        <label>Maaş</label>
                        <input type="text" name="salary"  class="form-control" value="<?php echo $salary; ?>">
                        <span><?php echo $salary_err; ?></span>
                    </div>
                    <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                    <input type="submit" class="btn btn-primary" value="Gönder">
                    <a href="index.php" class="btn btn-default">Geri</a>
                    </form>

                </div>
            </div>        
        </div>
    </div>
</body>
</html>
