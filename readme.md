# API Auth
```
POST /api/auth/login
field = email, password, remember_me

POST /api/auth/signup
field = email, name, mobile, address, sex, password, password_confirmation, confirm_agreement

GET /api/auth/profile
GET /api/auth/logout
POST /api/auth/refresh
```

# API User Home
```
GET /api/home
GET /api/transaksi

POST /api/ambil_point
field = point
respon = trx_id, status

POST /api/update_profile
field = name, email, mobile, rt, address, sex

POST /api/update_password
field = old_password, password, password_confirmation
```

# API CRUD Barang 
```
field = name, point, type [plastik,kertas,logam,kaca,lain]
## list
GET /api/admin/barang
## create
POST /api/admin/barang
## show
GET /api/admin/barang/{id}
## update
POST /api/admin/barang/{id}
## delete
DELETE /api/admin/barang/{id}
```

# API CRUD Warga
```
## list
GET /api/admin/warga
## create
POST /api/admin/warga
field = email, user_name, mobile, address, sex, password, password_confirmation, confirm_agreement, rt [01-14]

## show
GET /api/admin/warga/{id}

## update
POST /api/admin/warga/{id}
field = user_name, address, sex, rt

## delete
DELETE /api/admin/warga/{id}
```

# API Bank Sampah
```
## list warga + barang
GET /api/kasir
## tukar barang
POST /api/kasir/tukar_barang/{id_warga}
field = barang, count

## ambil point
POST /api/kasir/ambil_point/{id_warga}
field = point
respon = trx_id, status

## konfirmasi pengambilan
POST /api/kasir/konfirmasi/{id_warga}
field = trx_id, verif_code

## langsung scan barcode
POST /api/kasir/scan
field = barcode
```

# API Config
```
GET /api/config/rt_list
GET /api/config/barang_type
```