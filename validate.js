// Funkcja do weryfikacji formularza
function validateForm() {
  // Pobierz wartości pól formularza
  var imie = document.forms["myForm"]["imie"].value;
  var nazwisko = document.forms["myForm"]["nazwisko"].value;
  var haslo = document.forms["myForm"]["haslo"].value;
  var opcja = document.forms["myForm"]["opcja"].value;

  // Sprawdź warunki walidacji
  if (!validateImie(imie)) {
    alert("Wprowadź poprawne imię.");
    return false;
  }

  if (!validateNazwisko(nazwisko)) {
    alert("Wprowadź poprawne nazwisko.");
    return false;
  }

  if (!validateHaslo(haslo)) {
    alert("Wprowadź poprawne hasło (minimum 6 znaków).");
    return false;
  }

  if (!validateOpcja(opcja)) {
    alert("Wybierz opcję.");
    return false;
  }

  // Jeśli dane przeszły walidację, zezwól na wysłanie formularza
  return true;
}

// Funkcja do walidacji imienia (walidacja - tylko litery i spacje)
function validateImie(imie) {
  var regex = /^[a-zA-Z\s]+$/;
  return regex.test(imie);
}

// Funkcja do walidacji nazwiska (walidacja - tylko litery i spacje)
function validateNazwisko(nazwisko) {
  var regex = /^[a-zA-Z\s]+$/;
  return regex.test(nazwisko);
}

// Funkcja do walidacji hasła (walidacja - minimum 6 znaków)
function validateHaslo(haslo) {
  return haslo.length >= 6;
}

// Funkcja do walidacji opcji (opcja musi być zaznaczona)
function validateOpcja(opcja) {
  return opcja !== "";
}
