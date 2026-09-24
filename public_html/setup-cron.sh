#!/bin/bash

# Laravel Cron Job Kurulum Script'i
# Kullanım: bash setup-cron.sh

echo "╔════════════════════════════════════════════════════════════╗"
echo "║         Laravel Cron Job Kurulum Script'i                 ║"
echo "╚════════════════════════════════════════════════════════════╝"
echo ""

# Renk tanımları
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
NC='\033[0m' # No Color

# Laravel dizini
LARAVEL_DIR="/Users/useer/Documents/MH/evhayaliniz.com.tr/laravel"

echo -e "${YELLOW}📋 Kontroller yapılıyor...${NC}"
echo ""

# PHP kontrolü
echo "1️⃣  PHP kontrolü..."
if command -v php &> /dev/null; then
    PHP_PATH=$(which php)
    PHP_VERSION=$(php -v | head -n 1)
    echo -e "${GREEN}✓ PHP bulundu: $PHP_PATH${NC}"
    echo "   Versiyon: $PHP_VERSION"
else
    echo -e "${RED}✗ PHP bulunamadı!${NC}"
    exit 1
fi
echo ""

# Laravel dizin kontrolü
echo "2️⃣  Laravel dizin kontrolü..."
if [ -d "$LARAVEL_DIR" ]; then
    echo -e "${GREEN}✓ Laravel dizini bulundu: $LARAVEL_DIR${NC}"
else
    echo -e "${RED}✗ Laravel dizini bulunamadı: $LARAVEL_DIR${NC}"
    exit 1
fi
echo ""

# Artisan dosyası kontrolü
echo "3️⃣  Artisan dosyası kontrolü..."
if [ -f "$LARAVEL_DIR/artisan" ]; then
    echo -e "${GREEN}✓ Artisan dosyası bulundu${NC}"
else
    echo -e "${RED}✗ Artisan dosyası bulunamadı!${NC}"
    exit 1
fi
echo ""

# Schedule listesi kontrolü
echo "4️⃣  Schedule görevleri kontrol ediliyor..."
cd "$LARAVEL_DIR"
SCHEDULE_LIST=$(php artisan schedule:list 2>&1)
if echo "$SCHEDULE_LIST" | grep -q "packages:deactivate-expired"; then
    echo -e "${GREEN}✓ packages:deactivate-expired komutu bulundu${NC}"
else
    echo -e "${YELLOW}⚠ packages:deactivate-expired komutu bulunamadı${NC}"
fi

if echo "$SCHEDULE_LIST" | grep -q "packages:renew-expired"; then
    echo -e "${GREEN}✓ packages:renew-expired komutu bulundu${NC}"
else
    echo -e "${YELLOW}⚠ packages:renew-expired komutu bulunamadı${NC}"
fi
echo ""

# Cron job oluşturma
echo "═══════════════════════════════════════════════════════════"
echo "5️⃣  Cron job kurulumu"
echo "═══════════════════════════════════════════════════════════"
echo ""

# Cron satırı
CRON_JOB="* * * * * cd $LARAVEL_DIR && $PHP_PATH artisan schedule:run >> /dev/null 2>&1"
CRON_JOB_WITH_LOG="* * * * * cd $LARAVEL_DIR && $PHP_PATH artisan schedule:run >> $LARAVEL_DIR/storage/logs/cron.log 2>&1"

echo "Eklenecek cron job:"
echo ""
echo -e "${YELLOW}$CRON_JOB${NC}"
echo ""

# Mevcut crontab'ı kontrol et
CURRENT_CRON=$(crontab -l 2>/dev/null | grep "schedule:run")

if [ -n "$CURRENT_CRON" ]; then
    echo -e "${YELLOW}⚠ Zaten bir Laravel schedule cron job'u var:${NC}"
    echo "$CURRENT_CRON"
    echo ""
    read -p "Yeni cron job eklemek ister misiniz? (e/h): " -n 1 -r
    echo ""
    if [[ ! $REPLY =~ ^[Ee]$ ]]; then
        echo -e "${YELLOW}⚠ İşlem iptal edildi${NC}"
        exit 0
    fi
fi

echo ""
read -p "Log dosyasına kayıt yapılsın mı? (e/h): " -n 1 -r
echo ""

if [[ $REPLY =~ ^[Ee]$ ]]; then
    SELECTED_CRON="$CRON_JOB_WITH_LOG"
    echo -e "${GREEN}✓ Log dosyasına kayıt yapılacak: $LARAVEL_DIR/storage/logs/cron.log${NC}"
else
    SELECTED_CRON="$CRON_JOB"
    echo -e "${YELLOW}⚠ Log dosyasına kayıt yapılmayacak${NC}"
fi
echo ""

# Crontab'a ekle
echo "Crontab'a ekleniyor..."
(crontab -l 2>/dev/null; echo "$SELECTED_CRON") | crontab -

if [ $? -eq 0 ]; then
    echo -e "${GREEN}✓ Cron job başarıyla eklendi!${NC}"
else
    echo -e "${RED}✗ Cron job eklenirken hata oluştu!${NC}"
    exit 1
fi
echo ""

# Doğrulama
echo "═══════════════════════════════════════════════════════════"
echo "6️⃣  Doğrulama"
echo "═══════════════════════════════════════════════════════════"
echo ""

echo "Mevcut crontab:"
echo ""
crontab -l | grep "schedule:run" | sed 's/^/   /'
echo ""

# Storage izinlerini kontrol et
echo "7️⃣  Storage izinleri kontrol ediliyor..."
if [ -w "$LARAVEL_DIR/storage/logs" ]; then
    echo -e "${GREEN}✓ Storage/logs yazılabilir${NC}"
else
    echo -e "${RED}✗ Storage/logs yazılamıyor!${NC}"
    echo "   Düzeltmek için: chmod -R 775 $LARAVEL_DIR/storage"
fi
echo ""

# Manuel test
echo "═══════════════════════════════════════════════════════════"
echo "8️⃣  Manuel Test"
echo "═══════════════════════════════════════════════════════════"
echo ""
read -p "Manuel test çalıştırmak ister misiniz? (e/h): " -n 1 -r
echo ""

if [[ $REPLY =~ ^[Ee]$ ]]; then
    echo ""
    echo -e "${YELLOW}Test çalıştırılıyor...${NC}"
    cd "$LARAVEL_DIR"
    
    echo ""
    echo "▶ packages:deactivate-expired"
    php artisan packages:deactivate-expired
    
    echo ""
    echo "▶ packages:renew-expired"
    php artisan packages:renew-expired
    
    echo ""
    echo -e "${GREEN}✓ Manuel test tamamlandı${NC}"
fi

# Özet
echo ""
echo "╔════════════════════════════════════════════════════════════╗"
echo "║                    KURULUM TAMAMLANDI                      ║"
echo "╚════════════════════════════════════════════════════════════╝"
echo ""
echo -e "${GREEN}✓ Cron job başarıyla kuruldu!${NC}"
echo ""
echo "📋 Çalışma Programı:"
echo "   • 01:00 - Süresi dolan paketler pasif yapılır"
echo "   • 02:00 - Otomatik yenileme aktif olanlar yenilenir"
echo ""
echo "🔍 Kontrol Komutları:"
echo "   • Crontab listesi:     crontab -l"
echo "   • Schedule listesi:    cd $LARAVEL_DIR && php artisan schedule:list"
echo "   • Manuel çalıştır:     cd $LARAVEL_DIR && php artisan schedule:run"
echo ""

if [[ $SELECTED_CRON == *"cron.log"* ]]; then
    echo "📝 Log Dosyası:"
    echo "   tail -f $LARAVEL_DIR/storage/logs/cron.log"
    echo ""
fi

echo "💡 İpucu: Değişikliklerin etkili olması için cron servisini yeniden başlatın:"
echo "   sudo service cron restart"
echo ""

