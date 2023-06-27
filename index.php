/*RAD NAW Software Developer®*/

<!DOCTYPE html>
<html>
<head>
  <title>Formularz</title>
  <style>
    .input-container {
      background-color: #008000;
      padding: 5px;
    }
	.button-container {
      background-color: red;
      padding: 5px;
    }
	 form {
      border: 1px solid black;
      padding: 10px;
	  width: 300px;
    }
  </style>
    <script src="validate.js"></script> <!--dodaje walidacje-->
</head>
<body>
  <h3>Wypełnij formularz</h3>
  <form name="myForm" onsubmit="return validateForm()" method="POST" action="process_data.php"> <!-- Dodaje onsubmit="return validateForm()" -->

  <form method="POST" action="process_data.php">
    <table>
      <tr>
        <td class="input-container">Imię:</td>
        <td><input type="text" name="imie"></td>
      </tr>
      <tr>
        <td class="input-container">Nazwisko:</td>
        <td><input type="text" name="nazwisko"></td>
      </tr>
      <tr>
        <td class="input-container">Płeć:</td>
        <td>
          <input type="radio" name="plec" value="mężczyzna">Mężczyzna
          <input type="radio" name="plec" value="kobieta">Kobieta
        </td>
      </tr>
      <tr>
        <td class="input-container">Hasło:</td>
        <td><input type="password" name="haslo"></td>
      </tr>
      <tr>
        <td class="input-container">Opcja:</td>
        <td>
          <select name="opcja">
		    <option disabled selected>---wybierz jedną z opcji---</option>
            <option value="opcja1">Opcja 1</option>
            <option value="opcja2">Opcja 2</option>
            <option value="opcja3">Opcja 3</option>
          </select>
        </td>
      </tr>
      <tr>
        <td>Wpisz coś:</td>
        <td><textarea name="komentarz"></textarea></td>
      </tr>
      <tr>
        <td colspan="2">
          <input type="checkbox" name="warunki"> Zgadzam się na warunki umowy
        </td>
      </tr>
      <tr>
        <td></td>
        <td class="button-container">
          <div>
            <input type="submit" value="Wyślij">
            <input type="reset" value="Reset">
          </div>
        </td>
      </tr>
    </table>
  </form>
</body>
</html>