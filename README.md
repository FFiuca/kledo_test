


## How to run:



- Pastikan anda menyiapkan database kosong untuk kebutuhan project dan telah di config di env pada variable :

DB_HOST=127.0.0.1 // contoh di PC saya

DB_PORT=3302

DB_DATABASE=kledo_test

DB_USERNAME=root

DB_PASSWORD=admin

- buka terminal dengan path menuju root folder

-  `composer install`

-  `php artisan migrate --seed`

-  `php artisan serve`

- open browser : http://127.0.0.1:8000/api/documentation



Perlu diketahui, saya running menggunakan :

- PHP 8.*

- MySQL 8.*



*Jika terdapat masalah saat running mohon untuk menghubungi saya karena saya tau terdapat beberapa perbedaan antara PHP versi 7 dan 8 dan saya tidak hafal perbedaannya. Mohon ketersidaannya untuk menhubungi jika terjadi masalah nantinya*



# Hasil Automation Test :
![Image](https://drive.google.com/file/d/1zvSimRqijIwFfXIU21KBkkFm9JLTIzNG/view?usp=sharing)

Rincian :
- Pengujian ApproverTest bertujuan untuk memastikan bahwa penambahan data approver berfungsi dengan benar dengan mengirimkan permintaan POST ke route approver.create menggunakan nama approver yang dihasilkan oleh factory. pengujian ini memverifikasi bahwa respons HTTP memiliki status 200 dan nama approver dalam respons JSON sesuai dengan nama yang dimasukkan
- Pengujian ApprovalStageTest dilakukan untuk memastikan fungsionalitas penambahan, penambahan dengan validasi approver yang tidak ada, dan pembaruan data pada tabel approval_stages dengan menggunakan pendekatan pengujian fitur; pengujian mencakup skenario pengiriman permintaan POST untuk menambahkan data tahap persetujuan dengan approver_id yang valid, menguji respons HTTP dengan status 200 dan memverifikasi nilai approver_id dalam respons JSON; pengujian berikutnya menguji skenario ketika approver yang diberikan tidak ada di database, memastikan respons HTTP dengan status 400; dan pengujian terakhir mengecek pembaruan data approval_stages menggunakan approver_id baru melalui permintaan PUT
- Pengujian Expense2Test bertujuan untuk memverifikasi berbagai fungsionalitas terkait dengan model Expense. Pengujian dimulai dengan mempersiapkan data uji yang melibatkan approver, expense, dan approvals. Dalam metode test_add, pengujian dilakukan untuk menambahkan entri baru ke tabel expenses, memastikan respons HTTP status 200, serta memverifikasi bahwa amount yang dikirimkan sesuai dengan data yang diterima, dan memastikan bahwa entri baru memiliki jumlah persetujuan yang sesuai dengan jumlah approver yang dibuat serta status awal yang benar. Metode test_detail menguji endpoint detail untuk mendapatkan informasi tentang expense, memeriksa bahwa respons HTTP status 200 dikembalikan, dan memverifikasi bahwa data yang diterima mencakup amount, status, dan approval, serta memastikan bahwa approval adalah array
- Pengujian ApprovalExpenseTest bertujuan untuk memverifikasi berbagai skenario terkait persetujuan pengeluaran. Pengujian dimulai dengan mempersiapkan data uji, termasuk approver, expense, dan approvals, dengan approver yang dibuat memiliki status awal 'menunggu'. Dalam metode test_approve_all_is_approved, diuji apakah persetujuan semua approver berhasil dan apakah status pengeluaran diperbarui menjadi 'disetujui' setelah semua persetujuan dilakukan. Metode test_approve_just_2_person_from_3_person menguji apakah persetujuan dari dua orang dari tiga orang approver tidak mengubah status pengeluaran, yang tetap 'menunggu'. Metode test_approve_just_1_person_from_3_person memeriksa apakah hanya satu persetujuan tidak mengubah status dari 'menunggu'. Akhirnya, test_approve_out_of_order menguji skenario di mana persetujuan dilakukan dengan approver yang tidak sesuai urutan dan memverifikasi bahwa status pengeluaran tetap 'menunggu' dan respons HTTP status 500 diterima.
