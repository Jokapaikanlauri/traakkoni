Käynnistämiseen tarvittavat ohjeet:
composer install
npm install
npm run dev
(avaa uusi konsoli)
php artisan migrate
php artisan db:seed
php artisan serve

Käyttäjätunnukset:
email => traakkoni@example.com
password=> phponihanaa123

Käyttäjätunnuksen tekeminen:

Jos haluat tehdä uuden tunnuksen onnistuu se kirjautumalla ulos ja rekisteröitymällä, kun sovellus ilmoittaa että sähköpostivahvistus tarvitaan se löytyy storage\logs\laravel.log
poista kaikki teksti tiedostosta ja paina resend verification mail painiketta. Tämän jälkeen rivillä 19 oleva linkki vahvistaa käyttäjätunnuksen ja pääset käyttämään sovellusta.

Reittien selailu:
Kotisivustolla pääset kirjautuneena käyttäjänä selaamaan, tykkäämään ja kommentoimaan kaikkien käyttäjien tekemiä reittejä. Omien kommenttien poisto onnistuu helposti kahdella klikkauksella ja oman reitin poisto onnistuu kätevästi myroutes sivustolla.

Reitin suunnittelu:

Reitin suunnitteleminen on tehty google maps apin avulla, jota on hieman muokattu omiin tarpeisiin sopivammaksi. Reittiin saa lisättyä välietappeja klikkaamalla karttaa, jonka jälkeen voidaan tarkistaa matkan pituus ja korkeusvaihtelut. Reitin tallentaminen onnistuu Save route painikkeesta.

