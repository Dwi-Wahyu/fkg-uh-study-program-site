<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePengunjungTable extends Migration
{
    /**
     * Metode 'up' digunakan untuk menerapkan perubahan ke database.
     * Dalam kasus ini, kita akan membuat tabel baru bernama 'pengunjung'
     * untuk mencatat statistik kunjungan harian.
     */
    public function up()
    {
        // Mendefinisikan kolom-kolom untuk tabel 'pengunjung'
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'tanggal_kunjungan' => [
                'type' => 'DATE',
                'null' => false,
                'unique' => true, // Ini sudah akan membuat indeks unik
            ],
            'jumlah_pengunjung' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'default'    => 0,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        // Menambahkan primary key
        $this->forge->addKey('id', true);

        // Membuat tabel
        $this->forge->createTable('pengunjung');

        // Opsional: Menambahkan pesan log
        // log_message('info', 'Tabel pengunjung berhasil dibuat.');
    }

    /**
     * Metode 'down' digunakan untuk mengembalikan perubahan yang dilakukan oleh metode 'up'.
     * Dalam kasus ini, kita akan menghapus tabel 'pengunjung'.
     */
    public function down()
    {
        // Menghapus tabel 'pengunjung'
        $this->forge->dropTable('pengunjung');

        // Opsional: Menambahkan pesan log
        // log_message('info', 'Tabel pengunjung berhasil dihapus.');
    }
}
