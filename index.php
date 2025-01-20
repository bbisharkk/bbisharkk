<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="VTEE Mãi Yêu Sharkk.">
    <meta name="keywords" content="VTEE, BBI SHARKK, LOVE, love, vteelovesharkk, sharkklovevtee, vtee, bbisharkk, sharkk, tranvanthanh, TRAN VAN THANH, NGUYEN KHANH VAN, TRẦN VĂN THÀNH, NGUYỄN KHÁNH VÂN, Vân, Thành, Khánh Vân, Văn Thành, bbisharkk, vteebbisharkk, bbisharkkvtee">
    <meta name="author" content="VTEE Mãi Yêu Sharkk">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@500&display=swap" rel="stylesheet">
    <link rel="sitemap" type="application/xml" title="Sitemap" href="https://vtee.dev/sitemap.xml">
    <link rel="icon" href="lovesharkk/sharkk.png" type="image/x-icon">
    <title>VTEE x BBI SHARKK</title>

    <!-- Structured Data -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "WebSite",
      "name": "VTEE x BBI SHARKK",
      "url": "https://www.vtee.dev",
      "description": "VTEE Mãi Yêu Sharkk.",
      "sameAs": [
        "https://www.facebook.com/vtee_thanh",
        "https://www.instagram.com/sharkk._105/",
        "https://www.tiktok.com/@kv_150511"
      ]
    }
    </script>

    <style>
        body {
            font-family: 'Orbitron', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f4e1f1;
            overflow: hidden;
        }

        h1 {
            font-size: 3em;
            letter-spacing: 1.5px;
            color: #333;
            animation: fadeIn 1.5s ease-in-out;
        }

        #container {
            text-align: center;
        }

        button {
            display: block;
            margin: 20px auto;
            padding: 15px 40px;
            background: linear-gradient(135deg, #f09eae, #f9c9d3);
            color: #fff;
            font-size: 1.2em;
            font-weight: bold;
            border: 2px solid #f0a1b3;
            border-radius: 30px;
            cursor: pointer;
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.2);
            transition: all 0.4s ease;
            position: relative;
            overflow: hidden;
        }

        button:hover {
            background: linear-gradient(135deg, #f9c9d3, #f09eae);
            border-color: #f08a99;
            box-shadow: 0px 6px 20px rgba(0, 0, 0, 0.4);
            transform: scale(1.05);
        }

        button::before {
            content: '';
            position: absolute;
            top: 0;
            left: -75%;
            width: 50%;
            height: 100%;
            background: rgba(255, 255, 255, 0.3);
            transform: skewX(-45deg);
            transition: left 0.5s ease;
        }

        button:hover::before {
            left: 130%;
        }

        @keyframes fadeIn {
            0% {
                opacity: 0;
                transform: translateY(-30px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        h2 {
            font-size: 1.5em;
            color: #f08a99;
            margin-top: 10px;
            font-weight: bold;
            animation: fadeIn 1.5s ease-in-out 1s;
        }

        /* Audio Player */
        audio {
            margin-top: 30px;
            border-radius: 10px;
        }
    </style>
</head>
<body>

<div id="container">
    <h1>VTEE Mãi Yêu Sharkk</h1>
    <h2>VTEE nhớ Sharkk quá đi, trời ơi mãi yêuiiii!</h2>
    <button onclick="alert('Mãi yêu Sharkk!')">Gửi Thương Lời Yêu</button>
    
    <!-- Thêm nhạc ở đây -->
    <audio controls autoplay loop>
        <source src="love_song.mp3" type="audio/mp3">
        Trình duyệt của bạn không hỗ trợ thẻ audio.
    </audio>
</div>

</body>
</html>