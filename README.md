# Scouts boilerplate 

Deze boilerplate heeft als doel om een vlotte start te maken met je idee omtrent web platform voor scouting groepen. 
Enkele features zijn standaard geimplementeerd. Zoals user management, acount instellingen en authenticatie. 

## Installatie 

Om deze boilerplate te gebruiken heeft u een webserver en een MySQL database nodig. Als ook zijn er enkele stappen nodig
nodig om de boilerplate te installeren en te starten met de ontwikkeling. 

**Stappen:**

- Nadat u deze repository hebt gekloond en de `.git` directory hebt verwijderd kunt u `composer install` uitvoeren.
- Stel uw omgeving in, kopieer het `.env.example` naar `.env` en vul de MySQL credentials 
- Nadat je de installatie van composer hebt uitgevoerd, voer je de volgende `php artisan key:generate` om de unieke applicatie sleutel te creeren
- Migreer en seed de databank met het `php artisan migrate --seed`
- Nadat je de volgende stappen hebt uitgevoerd kun je `php artisan serve` uitvoeren voor de local server op te starten.
- Ga dan naar je browser en je geen fouten ziet heb je de boilerplate successvol geinstalleerd.

## Standaard gebruikers in de applicatie 

De boilerplate komt met enkele standaard gebruikers hier onder vind je de authenticatie gegegevns. 

```
U: webmaster@domain.tld
P: password 

U: administrator@domain.tld
P: password
```

## Beveiligingslekken

Indien u een beveiligingslek hebt ondekt in de boilerplate, Vragen wij je om een email te sturen naar Tim Joosten via 
[Topairy@gmail.com](mailto:topairy@gmail.com). Alle beveiligheidslekken zullen met de nodige aandacht worden bekeken en verholpen.

## Synchronisatie 

De boilerplate is gesynchroniseerd met Laravel 8.5.11 en Bootstrap 4. <br>
De laatste synchronisatie is doorgevoerd op 26 Februari 2021.

## License 

The Scouts boilerplate is volledig open-source en vrijgegeven onder een MIT licentie.
