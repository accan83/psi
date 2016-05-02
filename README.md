PSI Project with Yii 2 Advanced Template
========================================

PSI Project ini adalah aplikasi untuk memenuhi syarat kelulusan Mata Kuliah PSI (Pengembangan Sistem Informasi) dengan menggunakan framework [Yii 2 Advanced Template](http://www.yiiframework.com/).

Kerangka dari proyek ini meliputi: front end, back end, dan console, dimana
pemecahan mengikuti kerangka Yii application.

STRUKTUR DIREKTORI
-------------------

```
common
    config/              berisi konfigurasi menyeluruh
    mail/                berisi file-file view untuk e-mails
    models/              berisi kelas-kelas model yang digunakan untuk backend dan frontend
console
    config/              berisi konfigurasi console
    controllers/         berisi console controllers (commands)
    migrations/          berisi migrasi database
    models/              berisi kelas-kelas model
    runtime/             berisi file-file yang di-generate saat runtime
backend
    assets/              berisi asset-asset applikasi seperti JavaScript and CSS
    config/              berisi konfigurasi backend
    controllers/         berisi kelas-kelas Web controller
    models/              berisi kelas-kelas model untuk backend
    runtime/             berisi files generated during runtime
    views/               berisi file-file view untuk Web
    web/                 berisi the entry script and Web resources
frontend
    assets/              contains application assets such as JavaScript and CSS
    config/              contains frontend configurations
    controllers/         contains Web controller classes
    models/              contains frontend-specific model classes
    runtime/             contains files generated during runtime
    views/               contains view files for the Web application
    web/                 contains the entry script and Web resources
    widgets/             contains frontend widgets
environments/            contains environment-based overrides
tests                    contains various tests for the advanced application
    codeception/         contains tests developed with Codeception PHP Testing Framework
```
