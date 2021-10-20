# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

- Stripped out all the docblocks out of the application boilerplate. 

## 1.0.0 - Adult wolf

**Toegevoegd**

- Testcase voor de login controller
- Testcase voor de registratie controller
- Testcase voor de Reset en forgot password controller
- Github actions voor PHPUnit en PHP-CS-FIXER.
- Lgout andere andere apperaten functionaliteit
- Github action voor de shift left security analyses
- API authenticatie
- Versie bump voor `cybercog/laravel-ban`
- Account confirmatie check voor het verwijderen van een gebruikersaccount.
- Extra check in telescope voor ongewesnt verkeer.
- Bug report formulier in de github repo.

**Wijzigingen**

- Laravel/ui is geconverteerd naar Laravel/fortify
- Verschillende readme verbeteringen
- Herontwerpen van de welkom pagina
- Naamswijziging in de `composer.json` pagina.
- Design wijzigingen aan de account settings weergaves + verschillende bugfixes.
- Project gesync'ed naar Laravel v8.6.3
- Telescope assets ziin geupdated.

**Bugfixes**

- `.idea` folder is toegevoegd aan de `.gitignore` file

**Verwijderd**

- PHPStan is terug verwijderd uit het project

## 1.0.0-b2 - Helpful wolf

**Toegevoegd**

- Shift Left Analysis toegevoegd voor een security audit bij elke PR.
- API authenticatie features. (Voor het aanmaken en revoken van api tokens.)
- PHPUnit tests
- CI workflow bestanden voor PHPUnit testing en PHP CS FIXER
- Functionaliteit voor het uitloggen van sessies in andere browsers.
- Lokalisatie voor Carbon gebaseerd op de `app.locale` key.

**Gewijzigd**

- Authenticatie description docs vervangen met class docs
- Synchronisatie naar Laravel v8.5.6
- Project beschrijving en naam gewijzigd in `composer.json` (laravel/laravel naar zakmes/scouts-boilerplate)
- De `.idea` directory is verwijderd en de `.gitignore` file is aangepast om de `.idea` directory niet mee te committen
- Standaard readme is vervangen door een project specifieke readme.
- Default MySQL wachtwoord is gewijzigd van `null` naar `root`.
- Refactoring van de account instellen naar een tabbed layout.
- `database` is nu de default locatie voor de sessie opslag.
- Standaard taal voor de applicatie is nu nederlands. (nl)

**Verwijderd**

- Een paar `@todo` comments die al gefixt waren en in de codebase vergeten waren

## 1.0.0-b1 - Helpful wolf 

- Initial project release
