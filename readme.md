# Contract API
## Model

## Users
- id : integer
- name : string(199)
- email : string(199)->unique
- tanggal_lahir : date(199)
- jenis_kelamin : string(199)
- instansi : string(199)
- password : string(199)
- ktm : string(199)
- saldo : string(199)

## Jenis Paket
- id : integer
- jumlah_pertanyaan : int(11)
- jumlah_hari : string(199)
- harga : string(199)

## Registrasi Paket Pertanyaan
- id : integer
- user_id : integer references on id(users)
- paket_id : integer references on id(jenis_paket)
- name : string(199)
- email : string(199)
- jumlah_reponden : int(11)
- amount : decimal(20, 2)
- status : string(199)
- snap_token : string(199)
- judul : string(199)
- deskripsi : string(199)

## Detail Pertanyaan Screening
- id : int(10)
- pertanyaan_id : integer references on id(registrasi_paket_pertanyaan)
- pertanyaan : string(199)
- j1 : string(199)
- j2 : string(199)
- j3 : string(199)
- j4 : string(199)

## Detail Pertanyaan
- id : int(10)
- pertanyaan_id : integer references on id(registrasi_paket_pertanyaan)
- pertanyaan : string(199)
- j1 : string(199)
- j2 : string(199)
- j3 : string(199)
- j4 : string(199)

## Jawab Pertanyaan Screening
- id : int (10)
- user_id : integer references on id(users)
- pertanyaan_id : integer references on id(detail_pertanyaan_screening)
- jawaban : string(199)

## Jawab Pertanyaan
- id : int (10)
- user_id : integer references on id(users)
- pertanyaan_id : integer references on id(detail_pertanyaan)
- jawaban : string(199)

## Responden
- id : integer
- user_id : integer references on id(user)
- no_rek : string(199)
- type_rek : string(199)