<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Maintenance</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('maintenance.png');
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;
            color: #ffffff;
            text-align: center;
            padding: 40px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        h1 {
            font-size: 48px;
            margin-top: 0;
        }

        p {
            font-size: 24px;
            margin-bottom: 20px;
        }

        #countdown {
            font-size: 72px;
            font-weight: bold;
        }
    </style>
    <script>
        function countdown() {
            var targetDate = new Date('July 19, 2023 06:00:00')
                .getTime(); // Mengatur waktu target menjadi 06:00 PM tanggal 13 Juli 2023
            var countdownElement = document.getElementById("countdown");

            var countdownInterval = setInterval(function() {
                var currentTime = new Date().getTime();
                var remainingTime = targetDate - currentTime;

                var hours = Math.floor((remainingTime % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                var minutes = Math.floor((remainingTime % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((remainingTime % (1000 * 60)) / 1000);

                countdownElement.textContent = hours.toString().padStart(2, '0') + ":" + minutes.toString()
                    .padStart(2, '0') + ":" + seconds.toString().padStart(2, '0');

                if (remainingTime < 0) {
                    clearInterval(countdownInterval);
                    countdownElement.textContent = "Maintenance Selesai";
                }
            }, 1000);
        }

        window.onload = function() {
            countdown();
        };
    </script>
</head>

<body>
    <h1>Maaf, kami sedang dalam tahap pemeliharaan.</h1>
    <p>Kami akan segera kembali dengan peningkatan dan perbaikan.</p>
    <p>Maintenance akan selesai dalam:</p>
    <p id="countdown"></p>
</body>

</html>
