# 🔍 utoken NULL Sorunu - Debug ve Çözüm

## 🔴 SORUN

**Durum:**
- ✅ Ödeme başarılı
- ✅ Token alındı (paytr_logs'da var)
- ❌ Callback çağrılmadı
- ❌ `utoken` NULL kaldı

## 📊 LOG ANALİZİ

### **Mevcut Loglar:**
```json
{
  "id": "26",
  "type": "token_request",  ← Sadece TOKEN isteği
  "merchant_oid": "176711768898839052",
  "status": "success",
  "request_data": {
    "store_card": 1,  ← Kart saklama AÇIK
    "utoken": ""      ← Boş (henüz yok)
  },
  "response_data": {
    "status": "success",
    "token": "8d2ec5306e2bf88fdad999b5d9693c5f..."  ← Sadece TOKEN
  }
}
```

### **Eksik:**
❌ PayTR callback logu yok!
❌ `utoken` kaydı yok!

---

## 🔍 SORUN KONTROL ADIMLARI

### **1. PayTR Callback Çağrıldı mı?**

```sql
-- Callback loglarda var mı?
SELECT * FROM paytr_logs 
WHERE type = 'callback' 
  AND merchant_oid IN ('176711768898839052', '176711766402393586');

-- Paket aktif edildi mi?
SELECT 
    id, 
    merchant_oid, 
    status,
    created_at
FROM package_purchases 
WHERE merchant_oid IN ('176711768898839052', '176711766402393586');
```

**Beklenen:**
- `status = 1` ise callback geldi
- `status = 2` ise callback GELMEDİ (beklemede kaldı)

---

### **2. Laravel Loglarını Kontrol Et**

```bash
# Callback loglarını ara
grep "PayTR callback" storage/logs/laravel-*.log

# merchant_oid ile ara
grep "176711768898839052" storage/logs/laravel-*.log
grep "176711766402393586" storage/logs/laravel-*.log

# utoken loglarını ara
grep "utoken" storage/logs/laravel-*.log | tail -20
```

---

### **3. PayTR Panel Kontrolü**

PayTR Merchant Panel:
1. **İşlemler** → **Başarılı İşlemler**
2. merchant_oid'yi ara
3. **Detaylar** butonuna tıkla
4. `utoken` değerini kontrol et

---

## 🔧 OLASI SORUNLAR VE ÇÖZÜMLERİ

### **Sorun 1: Callback URL Yanlış**

**Kontrol:**
```php
// PackageController.php satır 478
$merchant_ok_url = env('APP_URL') . "/odeme-basarili";
$merchant_fail_url = env('APP_URL') . "/odeme-basarisiz";
```

**Doğru olmalı:**
- ✅ `https://demo.evhayaliniz.com/odeme-basarili`
- ✅ `https://demo.evhayaliniz.com/odeme-basarisiz`

**PayTR'nin callback URL'i (Bildirim URL):**
- ⚠️ PayTR panelinde ayarlanmalı!
- Örnek: `https://demo.evhayaliniz.com/payment/callback`

**ÇÖZÜM:**
1. PayTR Panel → **Ayarlar** → **Bildirim URL**
2. Şu URL'i gir: `https://demo.evhayaliniz.com/payment/callback`
3. Kaydet

---

### **Sorun 2: Route Tanımlı Değil**

**Kontrol:**
```bash
php artisan route:list | grep payment
```

**Olmalı:**
```
POST  payment/callback  → PaymentController@transactions
```

**Route varsa:**
```php
// routes/web.php
Route::post('/payment/callback', [PaymentController::class, 'transactions'])->name('payment.callback');
```

---

### **Sorun 3: CSRF Koruması**

PayTR'den gelen callback CSRF token içermez!

**ÇÖZÜM:**
```php
// app/Http/Middleware/VerifyCsrfToken.php
protected $except = [
    'payment/callback',  ← Ekle
];
```

---

### **Sorun 4: Hash Hatalı**

Callback geldi ama hash kontrolünden geçemedi.

**Laravel loglarını kontrol et:**
```bash
grep "hash mismatch" storage/logs/laravel.log
```

**ÇÖZÜM:**
Merchant key/salt doğru olmalı:
```php
$merchant_key = 'gsJN9qg9A8EhQLJ1';  ← PayTR panelden al
$merchant_salt = 'e4kE83W6RPyJMBy8'; ← PayTR panelden al
```

---

### **Sorun 5: PayTR Test Modu**

Test modunda `utoken` dönmeyebilir!

**Kontrol:**
```php
// PackageController.php satır 530
$test_mode = 0;  ← 0 olmalı (canlı mod)
```

---

## ✅ ÇÖZÜM ADIMLARI

### **Adım 1: Callback Route Ekle**

```php
// routes/web.php

use App\Http\Controllers\PaymentController;

// CSRF korumasından muaf
Route::post('/payment/callback', [PaymentController::class, 'transactions'])
    ->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class])
    ->name('payment.callback');
```

### **Adım 2: PayTR Panel Ayarı**

1. PayTR Panel → **Ayarlar**
2. **Bildirim URL:** `https://demo.evhayaliniz.com/payment/callback`
3. Kaydet

### **Adım 3: Mevcut Hesap İçin SQL**

```sql
-- MDesign için merchant_oid'den utoken al
-- (PayTR panelinden alınmalı)

UPDATE companies 
SET utoken = 'PAYTR_PANELDEN_ALINAN_UTOKEN'
WHERE id = (
    SELECT company_id 
    FROM package_purchases 
    WHERE merchant_oid = '176711768898839052'
    LIMIT 1
);
```

### **Adım 4: Test Et**

Yeni bir ödeme yap ve loglara bak:

```bash
# Real-time log monitoring
tail -f storage/logs/laravel.log | grep -E "PayTR|utoken"
```

**Beklenen loglar:**
```
[2025-12-30] PayTR callback received
[2025-12-30] PayTR callback data {"utoken": "xxx", ...}
[2025-12-30] utoken saved {"company_id": 1, "utoken": "xxx"}
```

---

## 🧪 MANUEL TEST

### **1. Callback URL Test**

```bash
# Terminal'den callback simülasyonu
curl -X POST https://demo.evhayaliniz.com/payment/callback \
  -H "Content-Type: application/x-www-form-urlencoded" \
  -d "merchant_oid=TEST123&status=success&total_amount=500&hash=xxx"
```

### **2. Route Test**

```bash
php artisan route:list | grep callback
```

**Çıktı olmalı:**
```
POST  payment/callback  PaymentController@transactions
```

---

## 📊 DEBUG CHECKLIST

- [ ] PayTR panelde **Bildirim URL** ayarlandı mı?
- [ ] Route `/payment/callback` tanımlı mı?
- [ ] CSRF koruması devre dışı mı?
- [ ] `store_card = 1` mi?
- [ ] `test_mode = 0` mı (canlı mod)?
- [ ] Merchant key/salt doğru mu?
- [ ] Laravel loglarında callback var mı?
- [ ] Package status = 1 mi (aktif)?

---

## 💡 HIZLI ÇÖZÜM (ŞİMDİLİK)

Callback düzeltilene kadar manuel ekleme:

```sql
-- 1. PayTR panelden utoken değerini al
-- 2. Manuel SQL ile kaydet

UPDATE companies c
JOIN package_purchases pp ON c.id = pp.company_id
SET c.utoken = 'PAYTR_PANELDEN_ALINAN_UTOKEN'
WHERE pp.merchant_oid IN ('176711768898839052', '176711766402393586')
LIMIT 1;

-- 3. Kontrol et
SELECT 
    c.id,
    c.name,
    c.utoken,
    pp.merchant_oid
FROM companies c
JOIN package_purchases pp ON c.id = pp.company_id
WHERE pp.merchant_oid IN ('176711768898839052', '176711766402393586');
```

---

## 🎯 SONUÇ

**Ana Sorun:** PayTR callback çağrılmadı/gelmedi

**Çözüm Önceliği:**
1. ⚠️ **En Önemli:** PayTR panelde Bildirim URL ayarla
2. ✅ Route ekle + CSRF muaf tut
3. 🧪 Test et
4. 💾 Mevcut hesap için manuel utoken ekle

---

**Hangi adımı atalım? 🚀**

