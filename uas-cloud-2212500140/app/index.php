<?php
require 'dbconn.php';

$pesan = '';

// Handle form submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nim   = trim($_POST['nim']);
    $nama  = trim($_POST['nama']);
    $email = trim($_POST['email']);

    if (!empty($nim) && !empty($nama) && !empty($email)) {
        $stmt = $conn->prepare("INSERT INTO mahasiswa (nim, nama, email) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $nim, $nama, $email);
        $stmt->execute();
        $stmt->close();

        // Redirect to prevent re-insertion on refresh
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    } else {
        $pesan = "Harap isi semua field.";
    }
}

// Fetch all student data
$result = $conn->query("SELECT * FROM mahasiswa ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Form Mahasiswa</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap');

        body {
            font-family: 'Roboto', sans-serif;
            background-color: #eef2f7;
            color: #333;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 800px;
            margin: 40px auto;
            padding: 30px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        h1,
        h3 {
            color: #333;
            text-align: center;
        }

        .error-message {
            color: #b94a48;
            background-color: #fbe3e4;
            border: 1px solid #fbc2c4;
            padding: 12px;
            border-radius: 6px;
            text-align: center;
            margin-bottom: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 18px;
            margin-bottom: 30px;
        }

        form div {
            display: flex;
            flex-direction: column;
        }

        form label {
            margin-bottom: 6px;
            font-weight: 500;
            color: #444;
        }

        form input[type="text"],
        form input[type="email"] {
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 16px;
            transition: border 0.2s ease, box-shadow 0.2s ease;
        }

        form input[type="text"]:focus,
        form input[type="email"]:focus {
            border-color: #66afe9;
            box-shadow: 0 0 8px rgba(102, 175, 233, 0.3);
            outline: none;
        }

        form input[type="submit"] {
            padding: 12px;
            background-color: #4a90e2;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        form input[type="submit"]:hover {
            background-color: #357ab8;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 15px;
        }

        table th,
        table td {
            padding: 14px 12px;
            border: 1px solid #e1e1e1;
            text-align: left;
        }

        table th {
            background-color: #4a90e2;
            color: white;
            font-weight: 600;
        }

        table tr:nth-child(even) {
            background-color: #f9fbfd;
        }

        table tr:hover {
            background-color: #edf2f7;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Form Input Data Mahasiswa</h1>

        <?php if ($pesan) : ?>
            <p class="error-message"><?php echo htmlspecialchars($pesan); ?></p>
        <?php endif; ?>

        <form method="post">
            <div>
                <label for="nim">NIM:</label>
                <input type="text" id="nim" name="nim" required>
            </div>
            <div>
                <label for="nama">Nama:</label>
                <input type="text" id="nama" name="nama" required>
            </div>
            <div>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <input type="submit" value="Simpan">
        </form>

        <h3>Data Mahasiswa:</h3>
        <table>
            <thead>
                <tr>
                    <th>NIM</th>
                    <th>Nama</th>
                    <th>Email</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) : ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['nim']); ?></td>
                        <td><?php echo htmlspecialchars($row['nama']); ?></td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>

</html>
