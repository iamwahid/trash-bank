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

# API CRUD Barang 
jenis barang (type)
 - plastik
 - kertas
 - logam
 - kaca
 - lain
```
field = name, point, type
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
field = email, user_name, mobile, address, sex, password, password_confirmation, confirm_agreement, rt, is_koordinator
## show
GET /api/admin/warga/{id}
## update
POST /api/admin/warga/{id}
field = user_name, address, sex
## delete
DELETE /api/admin/warga/{id}
```
