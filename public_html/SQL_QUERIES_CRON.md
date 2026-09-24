# 🔍 Otomatik Ödeme ve Paket Kontrol SQL Sorguları

## 📊 TEMEL KONTROLLER

### 1️⃣ **Otomatik Yenileme Açık Firmalar**

```sql
-- Otomatik yenileme açık ve kart bilgisi kayıtlı firmalar
SELECT 
    c.id,
    c.name AS firma_adi,
    u.email,
    c.mobile_phone,
    c.auto_renew,
    c.utoken,
    c.payment_retry_count,
    c.last_payment_date,
    c.status AS firma_status
FROM companies c
LEFT JOIN users u ON c.user_id = u.id
WHERE c.auto_renew = 1
  AND c.utoken IS NOT NULL
  AND c.utoken != ''
  AND c.status = 1
ORDER BY c.id DESC;
```

---

### 2️⃣ **Süresi Dolmuş Paketler**

```sql
-- Süresi dolmuş tüm paketler (aktif ve pasif)
SELECT 
    pp.id,
    pp.status AS paket_status,
    pp.end_date AS bitis_tarihi,
    DATEDIFF(NOW(), pp.end_date) AS kac_gun_once_doldu,
    c.name AS firma_adi,
    c.auto_renew,
    c.utoken AS kart_kayitli,
    pkg.title AS paket_adi,
    cat.name AS kategori,
    pp.price AS ucret,
    pp.type AS paket_tipi,
    pp.total_rights AS toplam_hak,
    pp.remaining_rights AS kalan_hak
FROM package_purchases pp
JOIN companies c ON pp.company_id = c.id
LEFT JOIN pro_packages pkg ON pp.pro_package_id = pkg.id
LEFT JOIN categories cat ON pp.category_id = cat.id
WHERE pp.end_date < NOW()
ORDER BY pp.end_date DESC;
```

---

### 3️⃣ **Otomatik Yenilenmesi Gereken Paketler (Kritik!)**

```sql
-- Süresi dolmuş + Otomatik yenileme açık + Kart kayıtlı
SELECT 
    c.id AS firma_id,
    c.name AS firma_adi,
    u.email,
    c.auto_renew,
    c.utoken AS kart_kayitli,
    c.payment_retry_count AS basarisiz_deneme_sayisi,
    pp.id AS paket_id,
    pp.end_date AS bitis_tarihi,
    DATEDIFF(NOW(), pp.end_date) AS kac_gun_once_doldu,
    pkg.title AS paket_adi,
    cat.name AS kategori,
    pp.price AS ucret,
    pp.type AS tip,
    pp.status AS paket_status
FROM companies c
LEFT JOIN users u ON c.user_id = u.id
JOIN package_purchases pp ON c.id = pp.company_id
LEFT JOIN pro_packages pkg ON pp.pro_package_id = pkg.id
LEFT JOIN categories cat ON pp.category_id = cat.id
WHERE c.auto_renew = 1
  AND c.utoken IS NOT NULL
  AND c.utoken != ''
  AND c.status = 1
  AND pp.end_date <= NOW()
ORDER BY pp.end_date DESC;
```

---

### 4️⃣ **MDesign Firmasının Detayları**

```sql
-- MDesign firmasının tüm bilgileri
SELECT 
    c.id,
    c.name AS firma_adi,
    c.email,
    c.mobile_phone,
    c.auto_renew AS otomatik_yenileme,
    c.utoken AS kart_token,
    c.payment_retry_count AS basarisiz_deneme,
    c.last_payment_date AS son_odeme_tarihi,
    c.status AS firma_durumu,
    c.created_at AS kayit_tarihi
FROM companies c
WHERE c.name LIKE '%MDesign%'
   OR c.name LIKE '%mdesign%'
   OR c.name LIKE '%MDESIGN%';
```

---

### 5️⃣ **MDesign'ın Paket Geçmişi**

```sql
-- MDesign'ın tüm paketleri
SELECT 
    pp.id,
    pp.status AS durum,
    pp.start_date AS baslangic,
    pp.end_date AS bitis,
    CASE 
        WHEN pp.end_date < NOW() THEN 'SÜRESİ DOLDU'
        ELSE 'AKTİF'
    END AS paket_durumu,
    pkg.title AS paket_adi,
    cat.name AS kategori,
    pp.price AS ucret,
    pp.type AS tip,
    pp.total_rights AS toplam_hak,
    pp.remaining_rights AS kalan_hak,
    c.auto_renew AS otomatik_yenileme,
    c.utoken AS kart_var_mi
FROM package_purchases pp
JOIN companies c ON pp.company_id = c.id
LEFT JOIN pro_packages pkg ON pp.pro_package_id = pkg.id
LEFT JOIN categories cat ON pp.category_id = cat.id
WHERE c.name LIKE '%MDesign%'
ORDER BY pp.created_at DESC;
```

---

## 🚨 SORUN TESPİT SORULARI

### 6️⃣ **Otomatik Yenileme AÇIK ama Kart KAYITLI DEĞİL**

```sql
-- Problem: Auto renew açık ama kart bilgisi yok
SELECT 
    c.id,
    c.name AS firma_adi,
    u.email,
    c.auto_renew,
    c.utoken,
    COUNT(pp.id) AS suresi_dolmus_paket_sayisi
FROM companies c
LEFT JOIN users u ON c.user_id = u.id
LEFT JOIN package_purchases pp ON c.id = pp.company_id 
    AND pp.end_date <= NOW()
WHERE c.auto_renew = 1
  AND (c.utoken IS NULL OR c.utoken = '')
  AND c.status = 1
GROUP BY c.id
HAVING suresi_dolmus_paket_sayisi > 0;
```

---

### 7️⃣ **Kart KAYITLI ama Otomatik Yenileme KAPALI**

```sql
-- Problem: Kart var ama auto renew kapalı
SELECT 
    c.id,
    c.name AS firma_adi,
    u.email,
    c.auto_renew,
    c.utoken,
    COUNT(pp.id) AS suresi_dolmus_paket_sayisi
FROM companies c
LEFT JOIN users u ON c.user_id = u.id
LEFT JOIN package_purchases pp ON c.id = pp.company_id 
    AND pp.end_date <= NOW()
WHERE c.auto_renew = 0
  AND c.utoken IS NOT NULL
  AND c.utoken != ''
  AND c.status = 1
GROUP BY c.id
HAVING suresi_dolmus_paket_sayisi > 0;
```

---

### 8️⃣ **Maksimum Deneme Sayısına Ulaşmış Firmalar**

```sql
-- 3 veya daha fazla başarısız ödeme denemesi
SELECT 
    c.id,
    c.name AS firma_adi,
    u.email,
    c.auto_renew,
    c.payment_retry_count AS basarisiz_deneme_sayisi,
    c.last_payment_date AS son_odeme_tarihi
FROM companies c
LEFT JOIN users u ON c.user_id = u.id
WHERE c.payment_retry_count >= 3
  AND c.status = 1
ORDER BY c.payment_retry_count DESC;
```

---

## 🔧 DÜZELTİCİ İŞLEMLER

### 9️⃣ **MDesign İçin Otomatik Yenilemeyi AÇ**

```sql
-- MDesign firması için otomatik yenilemeyi aktif et
UPDATE companies 
SET auto_renew = 1
WHERE name LIKE '%MDesign%';
```

---

### 🔟 **Test Kartı Ekle (Geliştirme İçin)**

```sql
-- Geliştirme ortamı için test token ekle
UPDATE companies 
SET utoken = 'test-token-12345'
WHERE name LIKE '%MDesign%';
```

---

### 1️⃣1️⃣ **Başarısız Deneme Sayacını Sıfırla**

```sql
-- Payment retry count sıfırla
UPDATE companies 
SET payment_retry_count = 0
WHERE id = 1; -- MDesign'ın ID'si
```

---

## 📈 İSTATİSTİK SORULARI

### 1️⃣2️⃣ **Genel Durum Raporu**

```sql
SELECT 
    COUNT(*) AS toplam_firma,
    SUM(CASE WHEN auto_renew = 1 THEN 1 ELSE 0 END) AS otomatik_yenileme_acik,
    SUM(CASE WHEN utoken IS NOT NULL AND utoken != '' THEN 1 ELSE 0 END) AS kart_kayitli,
    SUM(CASE WHEN auto_renew = 1 AND utoken IS NOT NULL AND utoken != '' THEN 1 ELSE 0 END) AS otomatik_yenileme_hazir,
    SUM(CASE WHEN payment_retry_count >= 3 THEN 1 ELSE 0 END) AS max_denemeye_ulasmis
FROM companies
WHERE status = 1;
```

---

### 1️⃣3️⃣ **Paket Durumu İstatistiği**

```sql
SELECT 
    CASE 
        WHEN end_date < NOW() THEN 'SÜRESİ DOLDU'
        WHEN end_date < DATE_ADD(NOW(), INTERVAL 7 DAY) THEN '7 GÜN İÇİNDE DOLACAK'
        WHEN end_date < DATE_ADD(NOW(), INTERVAL 30 DAY) THEN '30 GÜN İÇİNDE DOLACAK'
        ELSE 'AKTİF'
    END AS durum,
    COUNT(*) AS paket_sayisi,
    SUM(price) AS toplam_tutar
FROM package_purchases
WHERE status = 1
GROUP BY durum;
```

---

### 1️⃣4️⃣ **Bugün Yenilenecek Paketler**

```sql
-- Bugün süresi dolacak ve otomatik yenileme açık olanlar
SELECT 
    c.id,
    c.name AS firma_adi,
    u.email,
    pp.end_date,
    pkg.title AS paket,
    cat.name AS kategori,
    pp.price AS ucret
FROM package_purchases pp
JOIN companies c ON pp.company_id = c.id
LEFT JOIN users u ON c.user_id = u.id
LEFT JOIN pro_packages pkg ON pp.pro_package_id = pkg.id
LEFT JOIN categories cat ON pp.category_id = cat.id
WHERE c.auto_renew = 1
  AND c.utoken IS NOT NULL
  AND c.utoken != ''
  AND DATE(pp.end_date) = CURDATE()
  AND pp.status = 1
ORDER BY pp.end_date;
```

---

## 🎯 HIZLI TEŞHİS SORGUSU

### 1️⃣5️⃣ **Tek Sorguda Tüm Sorunları Tespit Et**

```sql
SELECT 
    c.id,
    c.name AS firma_adi,
    u.email,
    -- Otomatik yenileme durumu
    CASE 
        WHEN c.auto_renew = 0 THEN '❌ KAPALI'
        ELSE '✅ AÇIK'
    END AS otomatik_yenileme,
    -- Kart durumu
    CASE 
        WHEN c.utoken IS NULL OR c.utoken = '' THEN '❌ KART YOK'
        ELSE '✅ KART VAR'
    END AS kart_durumu,
    -- Süresi dolmuş paket var mı?
    COUNT(pp.id) AS suresi_dolmus_paket,
    -- Başarısız deneme
    c.payment_retry_count AS basarisiz_deneme,
    -- Sorun tespiti
    CASE 
        WHEN c.auto_renew = 0 THEN '🔴 OTOMATİK YENİLEME KAPALI'
        WHEN c.utoken IS NULL OR c.utoken = '' THEN '🔴 KART BİLGİSİ YOK'
        WHEN c.payment_retry_count >= 3 THEN '🔴 MAX DENEMEYE ULAŞTI'
        WHEN COUNT(pp.id) > 0 THEN '🟢 YENİLENEBİLİR'
        ELSE '⚪ SORUN YOK'
    END AS durum
FROM companies c
LEFT JOIN users u ON c.user_id = u.id
LEFT JOIN package_purchases pp ON c.id = pp.company_id 
    AND pp.end_date <= NOW()
    AND pp.status = 1
WHERE c.status = 1
GROUP BY c.id, u.email
HAVING suresi_dolmus_paket > 0
ORDER BY 
    CASE durum
        WHEN '🟢 YENİLENEBİLİR' THEN 1
        WHEN '🔴 OTOMATİK YENİLEME KAPALI' THEN 2
        WHEN '🔴 KART BİLGİSİ YOK' THEN 3
        WHEN '🔴 MAX DENEMEYE ULAŞTI' THEN 4
        ELSE 5
    END;
```

---

## 💡 KULLANIM ÖRNEĞİ

### **phpMyAdmin'de:**

1. Veritabanınızı seçin
2. "SQL" sekmesine tıklayın
3. Yukarıdaki sorgulardan birini yapıştırın
4. "Go" / "Çalıştır" tıklayın

### **Terminal'den:**

```bash
mysql -u root -p evhayaliniz_db

# Sorguyu çalıştır
SELECT * FROM companies WHERE auto_renew = 1;
```

---

## 📝 BEKLENEN SONUÇLAR

### **MDesign İçin:**

Muhtemelen şu durumlardan biri:

1. ❌ `auto_renew = 0` (Otomatik yenileme kapalı)
2. ❌ `utoken IS NULL` (Kart bilgisi yok)
3. ❌ `payment_retry_count >= 3` (Başarısız denemeler)
4. ❌ `status = 0` (Firma pasif)

**Sorgu 4 veya 5'i çalıştırın ve durumu kontrol edin!**

---

## ✅ KONTROL LİSTESİ

Sırasıyla şunu kontrol edin:

```sql
-- 1. Firma aktif mi?
SELECT status FROM companies WHERE name LIKE '%MDesign%';
-- Beklenen: 1

-- 2. Otomatik yenileme açık mı?
SELECT auto_renew FROM companies WHERE name LIKE '%MDesign%';
-- Beklenen: 1

-- 3. Kart kayıtlı mı?
SELECT utoken FROM companies WHERE name LIKE '%MDesign%';
-- Beklenen: NULL değil, boş string değil

-- 4. Başarısız deneme var mı?
SELECT payment_retry_count FROM companies WHERE name LIKE '%MDesign%';
-- Beklenen: < 3
```

---

**Hangi sorguyu çalıştırayım, sonuçları görelim! 🔍**

