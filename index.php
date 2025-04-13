<?php
// Thông tin người dùng có thể chỉnh sửa ở đây
$name = "TRẦN VĂN THÀNH";
$phone = "0394 454 056";
$email = "vanwthanhh47@gmail.com";
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thông báo mất thẻ ProID</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(to right, #f1f1f1, #e0f7fa);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #333;
        }

        .card {
            background: #fff;
            padding: 30px 40px;
            border-radius: 20px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            max-width: 480px;
            width: 100%;
            text-align: center;
        }

        .card h1 {
            color: #d62828;
            font-size: 28px;
            margin-bottom: 10px;
        }

        .card p {
            font-size: 16px;
            line-height: 1.6;
        }

        .highlight {
            font-weight: bold;
            font-size: 18px;
            color: #264653;
            margin: 20px 0 10px;
        }

        .info-box {
            background-color: #f0f4f8;
            border-left: 5px solid #2a9d8f;
            padding: 15px 20px;
            border-radius: 10px;
            text-align: left;
            margin: 20px 0;
        }

        .info-box p {
            margin: 5px 0;
        }

        .thank-you {
            color: #2a9d8f;
            font-weight: bold;
            font-size: 16px;
            margin-top: 25px;
        }

        @media screen and (max-width: 500px) {
            .card {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="card">
        <h1>📢 THÔNG BÁO</h1>
        <p class="highlight">Tôi đã làm rơi một <strong>thẻ ProID</strong></p>
        <p>Nếu bạn nhặt được thẻ này, xin vui lòng liên hệ với tôi theo thông tin dưới đây:</p>

        <div class="info-box">
            <p><strong>👤 Họ tên:</strong> <?= htmlspecialchars($name) ?></p>
            <p><strong>📞 SĐT:</strong> <?= htmlspecialchars($phone) ?></p>
            <p><strong>✉️ Email:</strong> <?= htmlspecialchars($email) ?></p>
        </div>

        <p class="thank-you">Xin chân thành cảm ơn và mong nhận được sự giúp đỡ!</p>
    </div>
</body>
</html>
