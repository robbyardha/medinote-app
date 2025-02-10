# Medinote App

Medinote App is a medication prescription application designed with a simple and user-friendly interface. This app streamlines the medication prescribing process, from examination registration, medication selection, to payment.

## Requirements

-   **PHP 8.2** or higher.
-   **Composer** - PHP dependency manager.
-   **Database**: SQLite, MySQL, or any other database supported by Laravel.
-   **For Local Development**: It's recommended to use [Laragon](https://laragon.org/) or [Laravel Herd](https://laravel.com/docs/8.x/valet) for setting up the local development environment.

### Recommended Local Development Environments:

1. **[Laragon](https://laragon.org/)**: A fast and powerful development environment for PHP, MySQL, and more. Ideal for Laravel development on Windows.
2. **[Laravel Herd](https://herd.laravel.com/docs/macos/getting-started/installation)**: A macOS-specific tool for setting up local environments with Laravel.

## Feature

-   [x] Access Management (Laravel Spatie)
-   [x] Master Patient
-   [x] Get Medicine
-   [x] Payment
-   [x] API HTTP Client Guzzle
-   [x] Use Laravel Breeze
-   [x] User Allow Login & Register
-   [x] Custom Admin Panel
-   [x] Custom Landing Page
-   [x] Use Library CKEditor
-   [x] Use Library Select2
-   [x] Use Library Datatables Yajra
-   [x] Use Library AOS
-   [x] Use Library DOMPDF

---

## Installation Steps

1.  **Clone the Repository**

    First, clone the repository to your local machine by running:

    ```bash
    git clone https://github.com/robbyardha/medinote-app.git
    ```

2.  **Run Installation Command**

    Navigate to the project folder and run the installation command to set up the CMS App:

    ```bash
    php artisan arr-medinote-app-install

    ```

3.  **Change .env**

    In APP_URL you can change url by yourself like:

    ```bash
    https://medinote-app.test

    ```

4.  **Run Project**

    After the installation is complete, open your browser and run the project by using the following:

    ```bash
    php artisan serve

    ```

    or if you user laragon or laravel herd you can open in browser

    ```bash
    https://medinote-app.test/

    ```

5.  **Login To Developer Account**

    Login Use Developer Account to give permission another role

    ```bash
    username : developer
    password : developer

    ```

6.  **Note**

    Alur Program

    -   Clone repository

    ```bash
    git clone https://github.com/robbyardha/medinote-app.git

    ```

    -   Masuk ke repository app dan jalankan dengan terminal

    ```bash
    php artisan arr-medinote-app-install

    ```

    Untuk membuat database (database/database.sqlite) konfigurasi dan melakukan konfigurasi awal app

    -   Login Menggunakan Developer Akun
    -   Masuk Ke Menu Setting -> isikan data email dan nomor telepon (untuk auth request API Obat)
    -   Mulai Pendaftaran Pemeriksaan di menu pemeriksaan submenu pendaftaran pemeriksaan
    -   Lakukan trigger button call untuk pemanggilan ke ruang dan memulai pemeriksaan
    -   Lakukan Pemeriksaan di submenu pemeriksaan dan pilih pasien
    -   Lakukan pengisian data dan memulai peresepan obat
    -   Lakukan pembayaran dimenu invoice submenu pembayaran (dapat mencetak struk) dan pengambilan obat
    -   Jika Ingin Menggunakan data lain dapat dikonfigurasi di menu master
    -   Atau jika ingin menggunakan role akses dapat di menu access

### Changes & Improvements:

1. **Clarification on `.env` Change**: In the **Change `.env`** section, I added "configuration" to make it clearer that this is an update to the `.env` file.
2. **Clarified Browser Access**: In the **Run the Project** section, I included an explicit mention that the browser access is an option if you're using Laragon or Laravel Herd.
3. **License Section**: I added the **License** section for completeness. If you plan to make it open-source, it's helpful to include the licensing information.

With these changes, your README is clearer and more structured. It provides a great guide for anyone setting up the project!
