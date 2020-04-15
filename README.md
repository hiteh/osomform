# Osom Form
Prosty motyw Wordpress wykonany w ramach zdania rekrutacyjnego.

## Instalacja:
* skopiować lub sklonować repozytorium
* zapisać katalog z motywem w wp_content/themes
* aktywować motyw
* Logo można dodać jak w standardowym motywie (obrazek nad formularzem)

## Development:
wykorzystałem WPGulp w związku z tym:
* npm install
* zmienić konfigurację w pliku wpgulp.config.js jeżeli potrzeba
* npm start

## Endpointy:
* GET /wp-json/osomform/v1/osomcontact - przeglądanie zapisanych formularzy -> administrator / wymaga autentykacji
* POST /wp-json/osomform/v1/osomcontact - wysyłenie formularza -> dostęp otwarty dla każdego

## Widoki
* Strona głowna:
	* Formularz responsywny z danymi użytkownika.
* Administracja:
	* OSOM Contacts - lista zapisancyh kontaktów
	* Settings - ustawienia zapisu/usuwania danych