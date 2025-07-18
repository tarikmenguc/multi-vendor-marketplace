---

## 🛒 Multi-Vendor Marketplace – Laravel 12 Backend & API

Bu proje, Laravel 12 kullanılarak geliştirilen **çok satıcılı bir e-ticaret sisteminin yalnızca backend ve API kısmını** kapsar.
Frontend olarak Breeze (Vue + Inertia) yapısı kuruludur, ancak bu çalışma **özellikle API, iş mantığı (service layer) ve test süreçlerine** odaklanır.

---

## 🎯 Amaç

* Gerçek bir projede backend tarafında **temiz, modüler ve test edilebilir Laravel mimarisi** kurmak.
* Laravel’in gelişmiş özelliklerini (Sanctum, Policy, MediaLibrary, Queue, Mail Job, Scout, vb.) proje içinde deneyimlemek.
* GitHub Actions ile CI süreçlerini öğrenmek.

---

## ⚙️ Backend Stack & Kullanılan Teknolojiler

* **Laravel 12 (minimal kurulum)**
* **MySQL**
* **Auth:** Breeze + Sanctum (cookie tabanlı)
* **Queue:** database (→ Redis'e geçilecek)
* **Test:** PHPUnit + Pest
* **API Format:** Standart JSON:

  ```json
  { "data": {...}, "meta": { "message":"ok", "page":1 } }
  ```

---

## 📦 Kullanılan Paketler

| Paket                           | Amaç                                 |
| ------------------------------- | ------------------------------------ |
| `spatie/laravel-permission`     | Rol & yetki kontrolü                 |
| `spatie/laravel-medialibrary`   | Dosya (görsel) yükleme               |
| `laravel/scout` + `meilisearch` | Arama motoru (full-text)             |
| `laravel/horizon` & `telescope` | Kuyruk ve HTTP gözlemleme (devtools) |

---

## 🧱 Proje Mimarisi (Backend)

```
app/
├── Models/                // Eloquent modelleri
├── Services/              // Tüm iş mantığı (business logic)
├── Http/
│   ├── Controllers/Api/   // Sadece API için controller'lar
│   ├── Requests/          // Form Request → validasyon
│   └── Middleware/
├── Policies/              // Yetki kontrolleri
├── Resources/             // API response JSON formatlayıcı
routes/
├── api.php                // API endpoint'leri
tests/
├── Feature/               // API testleri (CRUD, auth, flow…)
```

Her bileşen net şekilde ayrılmıştır. Tüm mantık Controller’da değil, **Service katmanında** bulunur.

---

## 🧪 Test & CI Süreci

* Her özellik için `Feature Test` yazılmıştır.
* **Cart**, **Product**, **Order** işlemleri uçtan uca test edilmiştir.
* `pestphp/pest` ile sade syntax’a geçiş hedeflenmektedir.
* GitHub Actions ile tüm PR’larda testler otomatik çalışır.
* `php artisan test` komutu ile lokalde testler çalıştırılabilir.

---

## 🚀 Sprint Planı (Yalnızca Backend Aşamaları)

| Sprint | Konu                                        | Durum |
| ------ | ------------------------------------------- | ----- |
| **S0** | Auth (Breeze + Sanctum + CSRF)              | ✅     |
| **S1** | Category & Product modeli, migration        | ✅     |
| **S2** | Product CRUD + Policy + Service + Test      | ✅     |
| **S3** | Cart & CartItem işlemleri (servis, test)    | ✅     |
| **S4** | Sipariş: stok düşme, mail job kuyruğa girme | ✅     |
| **S5** | Görsel yükleme (Spatie MediaLibrary)        | ✅     |
| **S6** | Rol-izin sistemi (admin/vendor/customer)    | ✅     |
| **S7** | Pest'e geçiş + Coverage ≥ %80               | 🔜     |
| **S8** | Scout + Meilisearch ile full-text arama     | ⏳      |
| **S9** | Horizon & Telescope kurulumu                | ⏳      |

---

## 📚 Öğrendiklerim / Kazanımlarım

Bu proje ile Laravel'de:

* Service Layer mimarisini,
* API yazım kurallarını (validation, response, policy),
* Job ve Mail Queue yönetimini,
* Queue monitoring (Horizon), HTTP log takibi (Telescope),
* Test-first mantığı ile API endpoint geliştirmeyi,
* GitHub Actions ile CI pipeline kurulumunu,
* Medya dosya yönetimi ve full-text arama entegrasyonunu öğrendim.

---

## ⛔️ Notlar

* Bu repo sadece **API + Backend** geliştirmesini içerir.
* Frontend: Sadece Breeze kurulu. (Vue tarafı boş)
* Proje, test edilebilir, genişletilebilir mimari yapıya sahiptir.

---

