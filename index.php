<!DOCTYPE html>
<html lang="ua">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel = "stylesheet" href = "style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>

<?php
$nameErr = $addressErr = $phoneErr = $emailErr = $dateErr = $connErr = "";
$cardNameErr = $cardNumberErr = $cardExpErr = $cardCvvErr="";

$name = $surname = $city = $district = $region = $postalCode = "";
$phone = $email = $date = $color = $connector = $additionally = "";
$cardName = $cardNumber = $cardExp = $cardCvv = "";
$country="Україна";
$submitted = false;
$price=40;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $submitted = true;
  $length = test_input($_POST["length"]);
  $color = test_input($_POST["color"]);
  $price = $length*20;

  if (empty($_POST["name"]) || empty($_POST["surname"])) {
    $nameErr = "Обов'язкове поле";
    $submitted = false;
  } 
  else {
    $name = test_input($_POST["name"]);
    $surname = test_input($_POST["surname"]);
    if (!preg_match("/^[a-zA-Z-' ]*$/",$name) || !preg_match("/^[a-zA-Z-' ]*$/",$surname)) {
      $nameErr = "В імені та прізвищі мають бути лише букви";
      $submitted = false;
    }
  }

  if (empty($_POST["city"]) ||
      empty($_POST["district"]) ||
      empty($_POST["region"]) ||
      empty($_POST["postalCode"])) {

    $addressErr = "Обов'язкове поле";
    $submitted = false;
  } 
  else {
    $city = test_input($_POST["city"]);
    $district = test_input($_POST["district"]);
    $region = test_input($_POST["region"]);
    $postalCode = test_input($_POST["postalCode"]);
    $country = test_input($_POST["country"]);

    if (!preg_match('~[0-9]+~', $postalCode)) {
      $addressErr = "В поштовому індексі мають бути лише цифри";
      $submitted = false;
    }
  }

  if (empty($_POST["phone"])) {
    $phoneErr = "Обов'язкове поле";
    $submitted = false;
  } else {
    $phone = test_input($_POST["phone"]);

    if (!preg_match('~[0-9]+~', $phone)) {
      $phoneErr = "Некоректний телефон";
      $submitted = false;
    }
  }

  if (empty($_POST["email"])) {
    $emailErr = "Обов'язкове поле";
    $submitted = false;
  } else {
    $email = test_input($_POST["email"]);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $emailErr = "Некоректний email";
      $submitted = false;
    }
  }

  $date=test_input($_POST["date"]);

  if ($date <= date("Y-m-d") && !empty($_POST["date"])) {
    $dateErr = "На-жаль у нас немає машини часу";
    $submitted = false;
  } 

  if (empty($_POST["connector"])) {
    $connErr = "Обов'язкове поле";
    $submitted = false;
  } else {
    $connector = test_input($_POST["connector"]);
    if($connector ==="Type C")
      $price+=20;
    else if($connector ==="Micro usb")
      $price+=15;
    else
     $price+=10;
  }

  if (empty($_POST["cardName"])) {
    $cardNameErr = "Обов'язкове поле";
    $submitted = false;
  } 
  else {
    $cardName = test_input($_POST["cardName"]);
    if (!preg_match("/^[a-zA-Z-' ]*$/",$cardName)) {
      $cardNameErr = "В імені та прізвищі мають бути лише букви";
      $submitted = false;
    }
  }

  if (empty($_POST["cardNumber"])) {
    $cardNumberErr = "Обов'язкове поле";
    $submitted = false;
  } 
  else {
    $cardNumber = test_input($_POST["cardNumber"]);
    if (!preg_match('~[0-9]+~', $cardNumber)) {
      $cardNumberErr = "Некоректний номер картки";
      $submitted = false;
    }
  }

  if (empty($_POST["cardExp"])) {
    $cardExpErr = "Обов'язкове поле";
    $submitted = false;
  } 
  else {
    $cardExp = test_input($_POST["cardExp"]);
  }

  if (empty($_POST["cardCvv"])) {
    $cardCvvErr = "Обов'язкове поле";
    $submitted = false;
  } 
  else {
    $cardCvv = test_input($_POST["cardCvv"]);
    if (!preg_match('~[0-9]+~', $cardCvv)) {
      $cardCvvErr = "Некоректне Cvv";
      $submitted = false;
    }
  }
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

?>

    <div class="box">
        <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" <?php if($submitted) echo "hidden";?>>
            <div>
          <h1>Інформація про замовлення</h1>

          <div class="item">
            <p>Ваше ім'я</p>
            <div class="name-class">
              <input type="text" placeholder="Прізвище" name="surname" value="<?php echo $surname;?>"/>
              <input type="text" placeholder="ім'я" name="name" value="<?php echo $name;?>"/>
              <div class="error"><?php echo $nameErr;?></div>
            </div>
          </div>

          <div class="item">
            <p>Адреса доставки</p>
            <input type="text" name="city" placeholder="Місто, вулиця, будинок, квартира" value="<?php echo $city;?>"/>
            <div class="address">
              <input type="text" name="district" placeholder="Район" value="<?php echo $district;?>"/>
              <input type="text" name="region" placeholder="Область" value="<?php echo $region;?>"/>
              <input type="text" name="postalCode" placeholder="Поштовий індекс" value="<?php echo $postalCode;?>"/>
              <select name="country" value="<?php echo $country;?>">
                <option value="Україна" selected >Україна</option>
                <option value="Польща">Польща</option>
                <option value="Америка">Америка</option>
              </select>
            </div>
            <div class="error"><?php echo $addressErr;?></div>
          </div>

          <div class="item">
            <p>Телефон</p>
            <input type="tel" name="phone" placeholder="380000000000" pattern="[0-9]{12}" value="<?php echo $phone;?>"/>
            <div class="error"><?php echo $phoneErr;?></div>
          </div>
          
          <div class="item">
            <p>E-mail</p>
            <input type="email" name="email" placeholder="example@gmail.com" value="<?php echo $email;?>"/>
            <div class="error"><?php echo $emailErr;?></div>
          </div>

          <div class="item">
            <p>Очікувана дата доставки</p>
            <input type="date" name="date" value="<?php echo $date;?>"/>
            <div class="error"><?php echo $dateErr;?></div>
          </div>

          <div class="item">
            <p>Колір товару</p>
            <input type="color" name="color" value="<?php echo $color;?>"/>
          </div>

          <div class="item">
            <p>Довжина кабелю</p>
            <input type="number" min="1" max="10" value="1" name="length" value="<?php echo $length;?>"/>
          </div>

          <div class="item">
            <p>Тип роз'єму</p>
            <input type="radio" id="Type-C" value="Type C" name="connector" <?php if (isset($connector) && $connector=="Type C") echo "checked";?>/>
            <label for="Type-C">Type C</label>
            <input type="radio" id="Micro-usb" value="Micro usb" name="connector" <?php if (isset($connector) && $connector=="Micro usb") echo "checked";?>/>
            <label for="Micro-usb">Micro usb</label>
            <input type="radio" id="Mini-usb" value="Mini usb" name="connector" <?php if (isset($connector) && $connector=="Mini usb") echo "checked";?>/>
            <label for="Mini-usb">Mini usb</label>
            <div class="error"><?php echo $connErr;?></div>
          </div>
          
          <div class="item">
            <p>Додаткові побажання</p>
            <textarea rows="5" name="additionally">
              <?php echo $additionally;?>
            </textarea>
          </div>

          <div class="item price">
            <p name=price>Ціна: <?php echo $price;?></p>
          </div>
        </div>

        <div>
        
          <h1>Оплата</h1>

          <div class="item">
            <div class="icon-container">
              <i class="fa fa-cc-visa" style="color:navy;"></i>
              <i class="fa fa-cc-amex" style="color:blue;"></i>
              <i class="fa fa-cc-mastercard" style="color:red;"></i>
              <i class="fa fa-cc-discover" style="color:orange;"></i>
            </div>
          </div>

          <div class="item">
            <p>Ім'я власника карти</p>
            <input type="text" name="cardName" placeholder="Ім'я" value="<?php echo $cardName;?>"/>
            <div class="error"><?php echo $cardNameErr;?></div>
          </div>

          <div class="item">
            <p>Номер карти</p>
            <input type="text" name="cardNumber" placeholder="1111-2222-3333-4444" pattern="[0-9]{16}" value="<?php echo $cardNumber;?>"/>
            <div class="error"><?php echo $cardNumberErr;?></div>
          </div>

          <div class="item">
            <p>Термін дії</p>
            <input type="month" name="cardExp" value="<?php echo $cardExp;?>"/>
            <div class="error"><?php echo $cardExpErr;?></div>
          </div>

          <div class="item">
            <p>CVV</p>
            <input type="text" name="cardCvv" placeholder="000" pattern="[0-9]{3}" value="<?php echo $cardCvv;?>"/>
            <div class="error"><?php echo $cardCvvErr;?></div>
          </div>

          <div class="btn">
            <input type="submit" class="button" value="Оплатити" name="done">
          </div>
        </div>
        </form>
        <div class="blank" <?php if(!$submitted) echo "hidden";?>>
          <div style="text-align: center;">
            <b>Дані успішно відправлені:</b>
          </div>
          <b>Прізвище ім'я:</b> <?php echo " ", $surname, " ", $name, '<br>';?>
          <b>Адреса:</b> <?php echo " ", $country, ", ", $region, ", область ", $district, ", район ", $city, ", ", $postalCode, '<br>';?>
          <b>Телефон:</b> <?php echo " ", $phone, '<br>';?>
          <b>Поштова скринька:</b> <?php echo " ", $email, '<br>';?>
          <b>Очікувана дата доставки:</b> <?php echo " ", $date, '<br>';?>
          <b>Колір товару:</b> <?php echo " ", $color, '<br>';?>
          <b>Довжина кабелю:</b> <?php echo " ", $length, '<br>';?>
          <b>Тип роз'єму:</b> <?php echo " ", $connector, '<br>';?>
          <b>Додаткові побажання:</b> <?php echo " ", $additionally, '<br>';?>
          <b>Ціна:</b> <?php echo " ", $price, '<br>';?>
          <b>Ім'я власника карти:</b> <?php echo " ", $cardName, '<br>';?>
          <b>Номер карти:</b> <?php echo " ", $cardNumber, '<br>';?>
          <b>Термін дії:</b> <?php echo " ", $cardExp, '<br>';?>
          <b>CVV:</b> <?php echo " ", $cardCvv, '<br>';?>
        </div>
      </div>
</body>
</html>