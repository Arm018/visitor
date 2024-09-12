<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}

include 'db.php';

$sql = "SELECT HOUR(visit_time) AS hour, COUNT(DISTINCT ip) AS visits FROM visits GROUP BY hour";
$statement = $pdo->query($sql);
$visitData = $statement->fetchAll(PDO::FETCH_ASSOC);

$sql = "SELECT city, COUNT(DISTINCT ip) AS visits FROM visits GROUP BY city";
$statement = $pdo->query($sql);
$cityData = $statement->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html>
<head>
    <title>Visit Statistics</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        h1 {
            margin: 20px 0;
            font-size: 28px;
            color: #333;
        }

        .container {
            width: 80%;
            max-width: 1000px;
            margin: 20px;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        canvas {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Visit Statistics</h1>

    <canvas id="hourlyVisits" style="width: 300px !important;"></canvas>
    <script>
        var ctx = document.getElementById('hourlyVisits').getContext('2d');
        var hourlyVisits = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode(array_column($visitData, 'hour')); ?>,
                datasets: [{
                    label: 'Unique Visits by Hour',
                    data: <?php echo json_encode(array_column($visitData, 'visits')); ?>,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>

    <canvas id="cityBreakdown" width="300" height="150"></canvas>
    <script>
        var ctx = document.getElementById('cityBreakdown').getContext('2d');
        var cityBreakdown = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: <?php echo json_encode(array_column($cityData, 'city')); ?>,
                datasets: [{
                    label: 'Visits by City',
                    data: <?php echo json_encode(array_column($cityData, 'visits')); ?>,
                    backgroundColor: ['rgba(255, 99, 132, 0.2)', 'rgba(54, 162, 235, 0.2)', 'rgba(255, 206, 86, 0.2)', 'rgba(75, 192, 192, 0.2)'],
                    borderColor: ['rgba(255, 99, 132, 1)', 'rgba(54, 162, 235, 1)', 'rgba(255, 206, 86, 1)', 'rgba(75, 192, 192, 1)'],
                    borderWidth: 1
                }]
            }
        });
    </script>
</div>
</body>
</html>
