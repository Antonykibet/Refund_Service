<?php

session_start();

//if (!$_SESSION['logged_in']) {
 //   header('Location: error.php');
//    exit();
//}

//extract($_SESSION['userData']);
$storeErr = $phoneErr = $orderErr = $credentialsErr = $amountErr = "";
?>
<head>
    <link rel="stylesheet" href="dashboard.css">
    <link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&family=Roboto:ital,wght@0,300;0,400;0,500;0,700;1,900&display=swap" rel="stylesheet">

</head>
<body>
    <div id="header">
        <span>Username</span>
        <div id="miniHeader">
                <div id="logo">Jservices</div>
                <div id="links">
                   <a href="home.html">
                   <div id="home">
                        Home
                    </div>
                   </a> 
                    <div id="refundable">Refundable Stores</div>
                    <a href="dashboard.php">
                        <div id="refunds">
                            Refunds
                            <div id="homeTab"></div>
                        </div>
                    </a>
                </div>
                <button id="login">
                    <img id="icon" src="icons8-discord-new-48.png" alt="">
                    Login</button>
            </div>
       <!-- <div id="home">Home</div>
        <div id="refundable">Refundable Stores</div>
        <div id="refunds">Refunds</div>
        <a href="logout.php">Logout</a>-->
    </div>
    


    <form  action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" method="post">
    <div id="Body">
        <div id="form">
        <h3 id="formTitles">Country</h3>
            <div id="radioButtons">
                 <input type="radio" id="countryButton" name="country" value="USA" checked>
                 <label id="countryNames" for="usa">USA</label><br>
                 <input type="radio" id="countryButton" name="country" value="Canada">
                 <label id="countryNames" for="canada">Canada</label><br>
                 <input type="radio" id="countryButton" name="country" value="UK">
                 <label id="countryNames" for="uk">UK</label>
            </div>
            
               <label id="formTitles" for="username">Discord Username</label><br>
               <div id="input1">
                    <input type="text" id="textBox" name="username" value="<?php echo $name?>"><br>
                    <img id="icon1" src="" alt="">
                </div>
            
            
            <label id="formTitles" for="store">Store</label><br>
            <select  name="store" id="store"></select>
            <span id="errorMessage" class="error"><?php echo $storeErr?></span><br>
    
        
            <label id="formTitles" for="phone">Phone</label><br>
            <input type="tel" name="phone" id="textBox">
            <span id="errorMessage" class="error"><?php echo $phoneErr?></span><br>


        
            <label id="formTitles" for="orderNumber">Order Number</label><br>
            <input type="text" name="orderNumber" id="textBox"><br>
            <span id="errorMessage" class="error"><?php echo $orderErr?></span><br>
            <span id="extraInfo">If multiple, separate them by commas. e.g. "orderid1,orderid2"</span>
        
        
            <label id="formTitles" for="credentials">Login Credentials</label><br>
            <input type="text" name="credentials" id="textBox">
            <span id="errorMessage" class="error"><?php echo $credentialsErr?></span><br>
            <span id="extraInfo">It must be in email:password format.</span><br>
            <span id="extraInfo">IF GUEST ORDER PLS PUT SHIPPING/BILLING INFO FOR PASSWORD SO WE CAN FIND YOUR ORDER!</span>
    
        
            <label id="formTitles" for="amount">Full total(including taxes&shipping)</label><br>
            <input type="text" name="amount" id="textBox"><br>
            <span id="errorMessage" class="error"><?php echo $amountErr?></span><br>
    
             <span id="extraInfo">By clicking Submit, you agree to the Terms & Conditions</span><br>
             <input type="submit" name="submit" id="submit" value="Submit">
            
        
        
            
        </div>
        <div id="terms"></div>
    </div>

        
    </form>
    

</body>
    

<script>
    let country = "";
    let USA_Stores = [
        "Windsorstore", "Amazon", "Amazon Third Party", "Target (Grocerry)", "Apple",
        "Adidas", "Macy's", "Victoria's Secret", "Bath & Body Works", "Hollister",
        "Abercrombie & Fitch", "Lululemon", "Glasses / Contacts", "H&M", "Gymshark",
        "SHEIN", "Levis", "Ralph Lauren", "UGG", "Designer Stores", "Crocs", "Microsoft",
        "REI", "Home Depot", "Reebok", "evo", "Estee Lauder", "awaytravel", "1800flowers",
        "kohl's", "Crunchyroll Store", "LEGO", "HSN", "QVC", "casper.com", "Crateandbarrel",
        "New Balance", "META"
    ];

    let canadaStores = [
        "Amazon.ca", "Victoria's Secret", "Ralph Lauren", "BestBuy", "Apple.ca", "Wayfair.ca",
        "Reebok.ca", "FANATICS.CA"
    ];

    let UK_Stores = [
        "Amazon", "ZALANDO", "Pretty Little Thing", "Bohoo"
    ];

    let storeElement = document.getElementById('store');

    for (let i = 0; i <= USA_Stores.length; i++) {
        let option_element = document.createElement("option");
        option_element.value = USA_Stores[i];
        option_element.innerHTML = USA_Stores[i];
        storeElement.appendChild(option_element);
    }

    document.getElementById('usa').onclick = () => {
        country = "USA";
        updateStores(country);
    };

    document.getElementById('canada').onclick = () => {
        country = "Canada";
        updateStores(country);
    };

    document.getElementById('uk').onclick = () => {
        country = "UK";
        updateStores(country);
    };

    function updateStores(Country) {
        storeElement.innerHTML = "";
        if (Country == "USA") {
            for (let i = 0; i < USA_Stores.length; i++) {
                let optionElement = document.createElement("option");
                optionElement.value = USA_Stores[i];
                optionElement.innerHTML = USA_Stores[i];
                storeElement.appendChild(optionElement);
            }
        } else if (Country == "Canada") {
            for (let i = 0; i < canadaStores.length; i++) {
                let optionElement = document.createElement("option");
                optionElement.value = canadaStores[i];
                optionElement.innerHTML = canadaStores[i];
                storeElement.appendChild(optionElement);
            }
        } else {
            for (let i = 0; i < UK_Stores.length; i++) {
                let optionElement = document.createElement("option");
                optionElement.value = UK_Stores[i];
                optionElement.innerHTML = UK_Stores[i];
                storeElement.appendChild(optionElement);
            }
        }
    }
</script>

<?php

$servername = "localhost";
$username = "owuorian";
$password = "Valmamucera95";
$database = "discord_records";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function test_input($data) {
    $data = trim($data);
    $data = stripcslashes($data);
    $data = htmlspecialchars($data);

    return $data;
}

$store = $phone = $orderNum = $credentials = $amount = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["store"])) {
        $storeErr = "Store is required";
    } else {
        $store = test_input($_POST['store']);
    }

    if (empty($_POST["phone"])) {
        $phoneErr = "Phone is required";
    } else {
        $phone = test_input($_POST['phone']);
    }

    if (empty($_POST["orderNumber"])) {
        $orderErr = "Order Number is required";
    } else {
        $orderNum = test_input($_POST['orderNumber']);
    }

    if (empty($_POST["credentials"])) {
        $credentialsErr = "Login credentials are required";
    } else {
        $credentials = test_input($_POST['credentials']);
    }

    if (empty($_POST["amount"])) {
        $amountErr = "Amount is required";
    } else {
        $amount = test_input($_POST['amount']);
    }
}

if (isset($_POST['submit'])) {
    $username = $_POST['username'];

    $sql = "INSERT INTO refund_requests (username, Store, Phone, order_number, login_credentials, amount) 
    VALUES ('$username', '$store', '$phone', '$orderNum', '$credentials', '$amount')";

    if (mysqli_query($conn, $sql)) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}




mysqli_close($conn);
?>