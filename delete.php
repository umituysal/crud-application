<?php
//onayladıktan sonra silme işlemi
if(isset($_POST["id"]) && !empty($_POST["id"])){
//config dosaysını dahil ediyoruz
require_once "config.php";

//Sorgu dilme islemi
$sql="DELETE FROM employees WHERE id= :id";
if($stmt=$pdo->prepare($sql)){
    //Hazırlanan ifadeye değişkenleri parametre olarak bağlayın
    $stmt->bindParam(":id",$param_id);

    // Parametreleri ayarla
    $param_id=trim($_POST["id"]);
    // Hazırlanan ifadeyi çalıştırma
    if($stmt->execute()){
        //işlem başarılı ise index.php sayfasına yönlendir.
        header("location: index.php");
        exit();
    }else{
        echo "Tekrar deneyiniz!";
    }
} 
//Bildirimi kapat
unset($stmt);
//Bağlantıyı kapat
unset($pdo);
}else{
    //İd parametresinin varlığını kontrol etme
    if(empty(trim($_GET["id"]))){
        //id yok ise error.php sayfasına yönlendirir.
        header("location: error.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Silme İşlemi</title>
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
                        <h1>Silme İşlemi</h1>
                    </div>
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <div class="alert alert-danger fade in">
                        <input type="hidden" name="id" value="<?php echo trim($_GET["id"]); ?>"/>
                        <p>Silmek istediğine emin misiniz?</p><br>
                        <p>
                            <input type="submit" class="btn btn-danger" value="Evet">
                            <a href="index.php" class="btn btn-default">Hayır</a>
                        </p>
                    
                    </div>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>