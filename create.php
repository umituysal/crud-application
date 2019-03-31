<?php
//config dosyasını dahil ediyoruz.
require_once "config.php";

//değişkenleri tanımlayıp boş değere atıyoruz.
$name=$address=$salary = "";
$name_err=$address_err=$salary_err= "";

//form gönderildiğinde verilerin işlenmesi
if($_SERVER["REQUEST_METHOD"] == "POST"){
   //name'i onaylama
   $input_name = trim($_POST["name"]);
   if(empty($input_name)){
       $name_err="Lütfen ad giriniz.";
   } elseif(!filter_var($input_name,FILTER_VALIDATE_REGEXP,array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
       $name_err="Lütfen geçerli bir isim girin ";
   }else{
       $name=$input_name;
   }

   //address onaylama
   $input_address = trim($_POST["address"]);
   if(empty($input_address)){
       $address_err="Lütfen adres giriniz.";
   }else{
       $address=$input_address;
   }

   //maaş onaylama
   $input_salary = trim($_POST["salary"]);
   if(empty($input_salary)){
       $salary_err="Lütfen maaş tutarını giriniz.";
       //ctype_digit değerin 1-9 arası deger  olup olmadığını kontrol eder
   }elseif(!ctype_digit($input_salary)){
       $salary_err="Lütfen pozitif sayı giriniz.";
   }else{
       $salary=$input_salary;
   }

   //veritabanına eklemeden önce giriş hatalarını kontrol eder
   if(empty($name_err) && empty($address_err) && empty($salary_err)){
       //ekleme işlemi
       $sql = "INSERT INTO employees (name, address, salary) VALUES (:name, :address, :salary)";
       if($stmt=$pdo->prepare($sql)){
          //hazırlanan değişkenleri parametre olarak bağladık
           $stmt->bindParam(":name",$param_name);
           $stmt->bindParam(":address",$param_address);
           $stmt->bindParam(":salary",$param_salary);

           //formdan gelen parametreyi atadık
           $param_name=$name;
           $param_address=$address;
           $param_salary=$salary;

           //hazırlanan ifadeyi çalıştır
           if($stmt->execute()){
               //eğer çalışırsa index.php sayfasına yönlendir
               header("location: index.php");
               exit();//işlemi bitir sonraki aşamaya geç
           }else{
               echo "Lütfen tekrar deneyin.";
           }
       }
       //bildirimi kapat
       unset($stmt);
   }
   //bağlantıyı kapat
   unset($pdo);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Kayıt Oluştur</title>
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
                        <h2>Kayıt Oluştur</h2>
                    </div>
                    <p>Lütfen formu doldurun.</p>
                    <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group <?php echo (!empty($name_err)) ? 'has-error':' '; ?>">
                            <label>Adı</label>
                            <input type="text" name="name" class="form-control" value="<?php echo $name; ?>">
                            <span class="help-block"><?php echo $name_err; ?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($address_err)) ? 'has-error':' ' ?>">
                            <label >Adres</label>
                            <textarea type="text" name="address" class="form-control"  ><?php echo $address; ?></textarea>
                            <span class="help-block"><?php echo $address_err; ?></span>
                        </div>
                        <div class="form-group <?php echo(!empty($salary_err)) ? 'has-error':' ' ?>">
                            <label>Maaş</label>
                            <input type="text" name="salary" class="form-control" value="<?php echo $salary; ?>">
                            <span class="help-block"><?php echo $salary_err; ?></span>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Gönder">
                        <a href="index.php" class="btn btn-default">Çıkış</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>