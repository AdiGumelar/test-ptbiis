📌 Employee Management System (CRUD Pegawai)
Aplikasi berbasis Laravel untuk mengelola data pegawai dengan fitur CRUD lengkap, upload foto, relasi jabatan, serta API endpoint untuk integrasi data.

🗄️ Struktur Database
TABEL POSITIONS
Column Type
id bigint
name string
created_at timestamp
updated_at timestamp

TABEL EMPLOYEES
Column Type
id bigint
employee_code string
name string
email string
phone string
gender enum(laki-laki / perempuan)
birth_place string
birth_date date
hire_date date
salary decimal
status enum(active / inactive)
photo string
positions_id bigint
created_at timestamp
updated_at timestamp
