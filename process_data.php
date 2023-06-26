<?php
// Konfiguracja połączenia z bazą danych
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "formularze";

// Nawiązanie połączenia z bazą danych
$conn = new mysqli($servername, $username, $password, $dbname);

// Sprawdzenie połączenia z bazą danych
if ($conn->connect_error) {
    die("Błąd połączenia z bazą danych: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    ini_set('SMTP', 'localhost');
    ini_set('smtp_port', 587);
    $to = 'rnawrot704@gmail.com';
    $subject = 'Nowe zgłoszenie formularza rejestracyjnego';

    $imie = $_POST['imie'];
    $nazwisko = $_POST['nazwisko'];
    $plec = $_POST['plec'];
    $haslo = $_POST['haslo'];
    $opcja = isset($_POST['opcja']) ? $_POST['opcja'] : '';
    $komentarz = $_POST['komentarz'];
    $warunki = isset($_POST['warunki']) ? 'Tak' : 'Nie';

    if (!validateImie($imie)) {
        echo 'Wprowadź poprawne imię.';
        exit();
    }

    if (!validateNazwisko($nazwisko)) {
        echo 'Wprowadź poprawne nazwisko.';
        exit();
    }

    if (!validateHaslo($haslo)) {
        echo 'Wprowadź poprawne hasło (minimum 6 znaków).';
        exit();
    }

    // Haszowanie hasła
    $hashedPassword = password_hash($haslo, PASSWORD_DEFAULT);

    if (!validateOpcja($opcja)) {
        echo 'Wybierz opcję.';
        exit();
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

    // Zapisywanie danych do bazy danych
    $stmt = $conn->prepare("INSERT INTO tabela (imie, nazwisko, plec, haslo, opcja, komentarz, warunki) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $imie, $nazwisko, $plec, $hashedPassword, $opcja, $komentarz, $warunki);
    $stmt->execute();

    // Zapisywanie danych do pliku CSV
    $csvContent = "$imie,$nazwisko,$plec,$haslo,$opcja,$komentarz,$warunki\n";
    $file = fopen("dane.csv", "a");
    fwrite($file, $csvContent);
    fclose($file);

    echo 'Dane zostały zapisane w bazie danych i pliku CSV.';

    // Zamykanie połączenia z bazą danych
    $stmt->close();
    $conn->close();
}

// Funkcja do walidacji imienia (walidacja - tylko litery i spacje)
function validateImie($imie)
{
    $regex = '/^[a-zA-Z\s]+$/';
    return preg_match($regex, $imie);
}

// Funkcja do walidacji nazwiska (walidacja - tylko litery i spacje)
function validateNazwisko($nazwisko)
{
    $regex = '/^[a-zA-Z\s]+$/';
    return preg_match($regex, $nazwisko);
}

// Funkcja do walidacji hasła (walidacja - minimum 6 znaków)
function validateHaslo($haslo)
{
    return strlen($haslo) >= 6;
}

// Funkcja do walidacji opcji (opcja musi być zaznaczona)
function validateOpcja($opcja)
{
    $regex = '/^.+$/'; // Dowolny niepusty ciąg znaków
    return preg_match($regex, $opcja);
}
?>
