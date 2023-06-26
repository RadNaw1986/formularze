<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $to = 'rnawrot704@gmail.com';
    $subject = 'Nowe zgłoszenie formularza rejestracyjnego';

    $imie = $_POST['imie'];
    $nazwisko = $_POST['nazwisko'];
    $plec = $_POST['plec'];
    $haslo = $_POST['haslo'];
    $opcja = $_POST['opcja'];
    $komentarz = $_POST['komentarz'];
    $warunki = isset($_POST['warunki']) ? 'Tak' : 'Nie';

    // Walidacja danych
    if (!validateImie($imie)) {
        echo 'Wprowadź poprawne imię.';
        exit;
    }

    if (!validateNazwisko($nazwisko)) {
        echo 'Wprowadź poprawne nazwisko.';
        exit;
    }

    if (!validateHaslo($haslo)) {
        echo 'Wprowadź poprawne hasło (minimum 6 znaków).';
        exit;
    }

    if (!validateOpcja($opcja)) {
        echo 'Wybierz opcję.';
        exit;
    }

    $message = "Imię: $imie\n";
    $message .= "Nazwisko: $nazwisko\n";
    $message .= "Płeć: $plec\n";
    $message .= "Hasło: $haslo\n";
    $message .= "Opcja: $opcja\n";
    $message .= "Komentarz: $komentarz\n\n";
    $message .= "Użytkownik zapoznał się z warunkami: $warunki";

    $headers = 'From: rnawrot704@gmail.com' . "\r\n" .
        'Reply-To: rnawrot704@gmail.com' . "\r\n" .
        'X-Mailer: PHP/' . phpversion();

    if (mail($to, $subject, $message, $headers)) {
        echo 'Wiadomość została wysłana.';
    } else {
        echo 'Wystąpił problem podczas wysyłania wiadomości.';
    }

    // Zapisywanie danych do pliku CSV
    $imie = escape_csv($imie);
    $nazwisko = escape_csv($nazwisko);
    $plec = escape_csv($plec);
    $haslo = '"' . escape_csv(hash_password($haslo)) . '"';
    $opcja = escape_csv($opcja);
    $komentarz = '"' . escape_csv($komentarz) . '"';
    $warunki = isset($_POST['warunki']) ? 'Tak' : 'Nie';

    $data = array($imie, $nazwisko, $plec, $haslo, $opcja, $komentarz, $warunki);

    $csv_line = implode(',', $data) . "\n";

    $file = fopen('dane.csv', 'a');
    fwrite($file, $csv_line);
    fclose($file);

    echo 'Dane zostały zapisane w pliku dane.csv.';

    // Zapisywanie danych do bazy danych
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "formularze";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Błąd połączenia z bazą danych: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("INSERT INTO tabela (imie, nazwisko, plec, haslo, opcja, komentarz, warunki) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $imie, $nazwisko, $plec, $haslo, $opcja, $komentarz, $warunki);
    $stmt->execute();

    echo 'Dane zostały zapisane w bazie danych.';

    $stmt->close();
    $conn->close();
}

function validateImie($imie)
{
    $regex = '/^[a-zA-Z\s]+$/';
    return preg_match($regex, $imie);
}

function validateNazwisko($nazwisko)
{
    $regex = '/^[a-zA-Z\s]+$/';
    return preg_match($regex, $nazwisko);
}

function validateHaslo($haslo)
{
    return strlen($haslo) >= 6;
}

function validateOpcja($opcja)
{
    return $opcja !== '';
}

function escape_csv($value)
{
    $escaped_value = str_replace('"', '""', $value);
    $escaped_value = '"' . $escaped_value . '"';
    return $escaped_value;
}

function hash_password($password)
{
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    return $hashed_password;
}
?>
