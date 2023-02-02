<?php

session_start();

if (!$_SESSION['logged_in']) {
    header('Location: error.php');
    exit();
}

extract($_SESSION['userData']);
$storeErr = $phoneErr = $orderErr = $credentialsErr = $amountErr = "";
?>

<div>
    <div>
        <span><?php echo $name;?></span>
    </div>
    <div>
        <a href="logout.php">Logout</a>
    </div>
</div>

<div>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" method="post">
        <div>
            <span>Country</span><br>
            <input type="radio" id="usa" name="country" value="USA" checked>
            <label for="usa">USA</label><br>
            <input type="radio" id="canada" name="country" value="Canada">
            <label for="canada">Canada</label><br>
            <input type="radio" id="uk" name="country" value="UK">
            <label for="uk">UK</label>
        </div>
        <div>
            <label for="username">Discord Username</label><br>
            <input type="text" id="username" name="username" value="<?php echo $name?>"><br>
        </div>
        <div>
            <label for="store">Store</label><br>
            <select name="store" id="store"></select>
            <span class="error"><?php echo $storeErr?></span><br>
        </div>
        <div>
            <label for="phone">Phone</label><br>
            <input type="tel" name="phone" id="phone">
            <span class="error"><?php echo $phoneErr?></span><br>
        </div>
        <div>
            <label for="orderNumber">Order Number</label><br>
            <input type="text" name="orderNumber" id="orderNumber"><br>
            <span class="error"><?php echo $orderErr?></span><br>
            <span>If multiple, separate them by commas. e.g. "orderid1,orderid2"</span>
        </div>
        <div>
            <label for="credentials">Login Credentials</label><br>
            <input type="text" name="credentials" id="credentials">
            <span class="error"><?php echo $credentialsErr?></span><br>
            <span>It must be in email:password format.</span><br>
            <span>IF GUEST ORDER PLS PUT SHIPPING/BILLING INFO FOR PASSWORD SO WE CAN FIND YOUR ORDER!</span>
        </div>
        <div>
            <label for="amount">Full total including taxes + shipping</label><br>
            <input type="text" name="amount" id="amount"><br>
            <span class="error"><?php echo $amountErr?></span><br>
        </div>
        <span>By clicking Submit, you agree to the Terms & Conditions</span><br>
        <input type="submit" name="submit" id="submit" value="Submit">
    </form>
</div>

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