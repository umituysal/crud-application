<?php
//id parametresinin varlığını kontrol edelim
if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
    //config dosyasını dahil ettik.
    require_once "config.php";

    //sql ile id seçtik
    $sql = "SELECT * FROM employees WHERE id = :id";

    if($stmt=$pdo->prepare($sql)){
        //hazırlanan ifadeye değişkenleri parametre olarak bağladık
        $stmt->bindParam(":id",$param_id);

        $param_id = trim($_GET["id"]);

        //hazırlanan ifadeyi yerine getirme
        if($stmt->execute()){
            if ($stmt->rowCount()==1){

                $row=$stmt->fetch(PDO::FETCH_ASSOC);

               //alan değerlerini al
                $name=$row["name"];
                $address=$row["address"];
                $salary=$row["salary"];
            }else{
                //geçerli bi parametre yok ise error sayfasına yönlendir.
                header("location: error.php");
                exit();
            }
        }else{
            echo "Tekrar deneyin.";
        }
    }
    //bidirimi kapat
    unset($stmt);
    //bağlantıyı kapat
    unset($pdo);
}else{
    //id değeri içermiyor ise error sayfasına yönlendir
    header("location: error.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Detay sayfası</title>
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
                    <h1>Detay İşlemi</h1>
                </div>
                <div class="form-group">
                    <label>Adı</label>
                    <p class="form-control-static"><?php echo $row["name"]; ?></p>
                </div>
                <div class="form-group">
                    <label>Adres</label>
                    <p class="form-control-static">
                    <?php echo $row["address"]; ?>
                    </p>
                </div>
                <div class="form-group">
                    <label>Maaş</label>
                    <p class="form-group-static">
                    <?php echo $row["salary"]; ?>
                    </p>
                </div>
                <p><a href="index.php" class="btn btn-primary">Geri</a></p>
            </div>
        </div>
    </div>
</div>
</body>
</html>
