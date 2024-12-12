<?php
session_start();

if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header("Location: ../../index.php");
    exit();
} else {
    echo '
    <div id="popup" class="popup">
        <div class="popup-content">
            <h2>Bạn có chắc chắn muốn đăng xuất?</h2>
            <button id="logout-btn" class="btn">Đăng xuất</button>
            <button id="cancel-btn" class="btn">Hủy</button>
        </div>
    </div>
    <script type="text/javascript">
        // Hiện popup
        document.getElementById("popup").style.display = "block";

        // Đăng xuất
        document.getElementById("logout-btn").onclick = function() {
            window.location.href = "?logout=true";
        };

        // Hủy bỏ đăng xuất
        document.getElementById("cancel-btn").onclick = function() {
            window.location.href = "../../index.php";
        };
    </script>';
}
?>
<style>
    .popup {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    justify-content: center;
    align-items: center;
    animation: fadeIn 0.5s ease-out;
}

.popup-content {
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    text-align: center;
    max-width: 400px;
    width: 100%;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    animation: slideIn 0.5s ease-out;
}

.popup h2 {
    margin-bottom: 20px;
    font-size: 18px;
    font-weight: bold;
}

.btn {
    padding: 10px 20px;
    margin: 10px;
    border: none;
    background-color: #007BFF;
    color: white;
    font-size: 16px;
    cursor: pointer;
    border-radius: 5px;
}

.btn:hover {
    background-color: #0056b3;
}

@keyframes fadeIn {
    0% { opacity: 0; }
    100% { opacity: 1; }
}

@keyframes slideIn {
    0% { transform: translateY(-50px); opacity: 0; }
    100% { transform: translateY(0); opacity: 1; }
}
