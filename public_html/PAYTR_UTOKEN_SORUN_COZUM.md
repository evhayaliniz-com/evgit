# 🔴 PayTR utoken Gelmiyor Sorunu - Çözüm

## 📊 LOG ANALİZİ

### **Ne Gördük:**

```json
Line 1792706:
"all_post_keys": [
  "hash",
  "merchant_oid", 
  "status",
  "total_amount",
  "payment_type",
  "payment_amount",
  "currency",
  "installment_count",
  "merchant_id"
]
```

❌ **`utoken` yok!**  
❌ **`card_token` yok!**  
❌ **Hiçbir kart bilgisi yok!**

---

## 🔍 NEDEN?

### **Olası Sebepler:**

1. **PayTR Panelde Kart Saklama KAPALI**
   - Ayarlar → Kart Saklama → ❌ Pasif

2. **PayTR API Versiyonu Değişmiş**
   - Eski API → `utoken`
   - Yeni API → Farklı field veya CAPI LIST gerekli

3. **Test Modunda utoken Dönmüyor**
   - `test_mode = 1` → Test kartlarında utoken gelmez

4. **Kart Saklama İsteği Gönderilmemiş**
   - `store_card = 0` olarak gitmiş

---

## ✅ ÇÖZÜMLER

### **Çözüm 1: PayTR Panel Kontrolü (EN ÖNEMLİ)**

**PayTR Merchant Panel:**
1. Giriş yap: https://www.paytr.com/
2. **Ayarlar** → **Ödeme Ayarları**
3. **Kart Saklama** özelliğini kontrol et
4. **Aktif** olmalı (✅)

**Eğer kapalıysa:**
- ☑️ **Kart Saklama** → Aktif et
- Kaydet
- Yeni ödeme yap

---

### **Çözüm 2: CAPI LIST Kullan (PayTR Yeni API)**

PayTR'nin yeni versiyonunda `utoken` callback'de gelmiyor!  
**CAPI LIST** servisi ile kart listesi alınmalı.

**İşte kod:**

```php
// PayTR CAPI LIST ile kayıtlı kartları al
private function getUtokenFromPaytr($merchant_oid, $email)
{
    $merchant_id = '553263';
    $merchant_key = 'gsJN9qg9A8EhQLJ1';
    $merchant_salt = 'e4kE83W6RPyJMBy8';
    
    // Hash oluştur
    $hash_str = $merchant_id . $merchant_oid . $merchant_salt;
    $token = base64_encode(hash_hmac('sha256', $hash_str, $merchant_key, true));
    
    $post_vals = [
        'merchant_id' => $merchant_id,
        'merchant_oid' => $merchant_oid,
        'token' => $token
    ];
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://www.paytr.com/odeme/capi/list");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_vals);
    curl_setopt($ch, CURLOPT_TIMEOUT, 20);
    
    $result = @curl_exec($ch);
    curl_close($ch);
    
    $result = json_decode($result, true);
    
    if (isset($result['status']) && $result['status'] == 'success') {
        // Kayıtlı kartlardan ilkinin utoken'ını al
        if (!empty($result['cards']) && isset($result['cards'][0]['utoken'])) {
            return $result['cards'][0]['utoken'];
        }
    }
    
    return null;
}
```

---

### **Çözüm 3: store_card Parametresini Kontrol Et**

```php
// PackageController.php - getToken() metodu
$store_card = 1;  // ✅ 1 olmalı

$post_vals = [
    // ...
    'store_card' => $store_card,  // ✅ Gönderiliyor mu?
    'utoken' => $utoken
];
```

---

## 🔧 PAYMENTCONTROLLER DÜZELTMESİ

### **utoken için Alternatif Yöntem Ekle:**

```php
// PaymentController.php - transactions() metodu

// Paket başarıyla aktif edildikten SONRA, CAPI LIST ile utoken al
if ($post['status'] == 'success') {
    // ... mevcut kod ...
    
    // Paket aktif edildi
    PackagePurchase::where('merchant_oid', $post['merchant_oid'])
        ->where('status', 2)
        ->update(['status' => 1]);
    
    $companyUpdateData = [
        'last_payment_date' => now(), 
        'payment_retry_count' => 0
    ];
    
    // PayTR'den utoken gelmemişse, CAPI LIST ile al
    if (!isset($post['utoken']) || empty($post['utoken'])) {
        Log::warning('utoken callback\'de gelmedi, CAPI LIST deneniyor');
        
        // Ödeme başarılı olduğuna göre, kullanıcının emaili ile kartları çek
        $utokenFromCapi = $this->getUtokenFromCapiList(
            $post['merchant_oid'], 
            $company->user->email ?? null
        );
        
        if ($utokenFromCapi) {
            $companyUpdateData['utoken'] = $utokenFromCapi;
            Log::info('utoken CAPI LIST\'ten alındı', [
                'company_id' => $company->id,
                'utoken' => $utokenFromCapi
            ]);
        }
    } else {
        $companyUpdateData['utoken'] = $post['utoken'];
        Log::info('utoken callback\'ten alındı', [
            'company_id' => $company->id
        ]);
    }
    
    Company::whereId($company->id)->update($companyUpdateData);
}
```

---

## ⚡ ACİL DÜZELTİCİ KOD

PaymentController'a ekle:

```php
/**
 * PayTR CAPI LIST ile kullanıcının kayıtlı kartlarını al
 */
private function getUtokenFromCapiList($merchantOid, $email)
{
    if (!$email) {
        return null;
    }
    
    $merchant_id = '553263';
    $merchant_key = 'gsJN9qg9A8EhQLJ1';
    $merchant_salt = 'e4kE83W6RPyJMBy8';
    
    // Hash oluştur
    $hash_str = $merchant_id . $email . $merchant_salt;
    $token = base64_encode(hash_hmac('sha256', $hash_str, $merchant_key, true));
    
    $post_vals = [
        'merchant_id' => $merchant_id,
        'email' => $email,
        'token' => $token
    ];
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://www.paytr.com/odeme/capi/list");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_vals);
    curl_setopt($ch, CURLOPT_TIMEOUT, 20);
    
    $result = @curl_exec($ch);
    
    if (curl_errno($ch)) {
        Log::error('CAPI LIST curl hatası', ['error' => curl_error($ch)]);
        curl_close($ch);
        return null;
    }
    
    curl_close($ch);
    $result = json_decode($result, true);
    
    Log::info('CAPI LIST yanıtı', ['result' => $result]);
    
    // Başarılı ve kartlar varsa
    if (isset($result['status']) && $result['status'] == 'success') {
        if (!empty($result['cards']) && isset($result['cards'][0]['utoken'])) {
            return $result['cards'][0]['utoken'];
        }
    }
    
    return null;
}
```

---

## 📋 SQL DÜZELTMESİ

```sql
-- companies tablosuna package_id ekle (VEYA kaldır)

-- SEÇENEK 1: Sütunu ekle
ALTER TABLE companies 
ADD COLUMN package_id INT NULL AFTER category_id;

-- SEÇENEK 2: Kod'dan kaldır (önerilir - gereksiz alan)
-- PaymentController'da zaten kaldırdık ✅
```

---

## 🎯 HIZLI ÇÖZÜM

1. ✅ `package_id` hatası düzeltildi (koddan kaldırıldı)
2. ⚠️ `utoken` sorunu devam ediyor

**Şimdi 2 seçenek:**

**A) CAPI LIST Ekle (Kalıcı Çözüm):**
- PaymentController'a `getUtokenFromCapiList()` metodu ekle
- Callback'de yoksa CAPI LIST'ten al

**B) Manuel SQL (Geçici Çözüm):**
- Her ödeme sonrası manuel utoken ekle

---

**Hangi çözümü uygulayalım? CAPI LIST'i ekleyeyim mi? 🚀**

