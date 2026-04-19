# drkafasis-betheme-audit

Τοπικό audit repo για το WordPress theme `betheme` του site `drkafasis.gr`.

## Σκοπός
- Έλεγχος custom αλλαγών που έχουν γίνει στο parent theme
- Προετοιμασία μεταφοράς σε child theme
- Ασφαλής versioning των theme-level παρεμβάσεων

## Παρατηρήσεις
- Active theme: betheme
- Δεν υπάρχει child theme στο production site
- Έχουν βρεθεί custom αλλαγές τουλάχιστον στα:
  - functions.php
  - header.php

## Μην κάνεις από εδώ
- απευθείας deploy στο live site
- update production theme χωρίς migration plan