# 🔍 Kart Saklama Test ve utoken Alma

## ✅ DURUM: Kart Saklama ÇALIŞIYOR!

**Kanıt:**  
> "Ödeme ekranında geliyor kartlar"

Bu demek ki:
- ✅ PayTR'de kartlar kayıtlı
- ✅ `utoken` var (PayTR'de)
- ❌ Veritabanımızda yok

---

## 🎯 ÇÖZÜM 1: PayTR Panelden utoken Al

### **Adımlar:**

1. **PayTR Merchant Panel** → Giriş yap
2. **İşlemler** → **Başarılı İşlemler**
3. Son işlemi bul: `merchant_oid: 176712489234061227`
4. **Detaylar** tıkla
5. `utoken` değerini **kopyala**
6. SQL ile kaydet:

```sql
UPDATE companies 
SET utoken = 'PAYTR_PANELDEN_KOPYALANAN_UTOKEN',
    auto_renew = 1
WHERE id = 57;
```

---

## 🎯 ÇÖZÜM 2: Yeni Ödeme ile Test (Detaylı Log)

Kod güncellemesi yaptık. Şimdi yeni ödeme yap ve log'u kontrol et:

**Beklenen:**
```json
"CAPI LIST yanıtı" {
  "email": "akkuso700@gmail.com",
  "status": "error" or "success",
  "reason": "Invalid token" veya başka mesaj,
  "full_response": { tüm PayTR yanıtı }
}
```

Bu sayede CAPI LIST'in neden başarısız olduğunu göreceğiz!

---

## 🧪 MANUEL TEST: CAPI LIST Hash Kontrolü

PayTR dökümanına göre CAPI LIST hash:

```
merchant_id + email + merchant_salt
```

**Kod kontrolü:**
```php
// PaymentController.php - getUtokenFromCapiList()
$hash_str = $merchant_id . $email . $merchant_salt;
$token = base64_encode(hash_hmac('sha256', $hash_str, $merchant_key, true));
```

✅ **Doğru görünüyor!**

---

## 🔍 OLASI SORUNLAR:

### **1. PayTR Panelde CAPI Aktif Değil**

PayTR Panel → Ayarlar → **CAPI Servisi**
- ☑️ Aktif olmalı

### **2. Email Farklı**

PayTR'de kayıtlı email ile Laravel'deki farklı olabilir:

```sql
-- Email kontrolü
SELECT u.email, c.name 
FROM companies c
JOIN users u ON c.user_id = u.id
WHERE c.id = 57;
```

Eğer farklıysa, doğru email ile CAPI LIST çağır.

### **3. Kartlar Başka Email'de Kayıtlı**

PayTR'de kartlar farklı bir email'e bağlı olabilir.

---

## ✅ ACİL ÇÖZÜM (ŞİMDİ UYGULANIR)

**İki yol:**

### **A) PayTR Panelden utoken Al (ÖNERİLEN)**

```sql
-- 1. PayTR Panel → İşlemler → merchant_oid: 176712489234061227
-- 2. Detaylar → utoken kopyala
-- 3. SQL ile kaydet:

UPDATE companies 
SET utoken = 'BURAYA_PAYTR_PANELDEN_KOPYALADIĞIN_UTOKEN',
    auto_renew = 1
WHERE id = 57;
```

### **B) Geçici Token (Test İçin)**

```sql
-- Sadece UI test için
UPDATE companies 
SET utoken = 'test-utoken-mdesign-permanent',
    auto_renew = 1
WHERE id = 57;
```

**⚠️ Dikkat:** Test token ile otomatik ödeme ÇALIŞMAZ!

---

## 🧪 CAPI LIST'i Düzeltmek İçin

Yeni ödeme yap, detaylı log'u göster:

```bash
tail -f storage/logs/laravel.log | grep -A 5 "CAPI LIST yanıtı"
```

**Beklenen:**
```json
{
  "status": "error",
  "reason": "Invalid hash" veya "No cards found" veya başka mesaj
}
```

Bu reason'a göre düzeltme yapacağız!

---

## 📋 ÖZ NET:

| Sorun | Durum | Çözüm |
|-------|-------|-------|
| Paket aktif mi? | ✅ Evet | - |
| utoken var mı? | ❌ Hayır | PayTR panelden al |
| Kart kayd edilmiş mi? | ✅ Evet | PayTR'de kayıtlı |
| Otomatik yenileme çalışır mı? | ❌ Hayır | utoken gerekli |

---

**Ne yapalım:**
1. PayTR panel → utoken kopyala
2. SQL ile kaydet
3. Otomatik yenileme hazır! ✅

**PayTR panele erişim var mı? 🔑**
