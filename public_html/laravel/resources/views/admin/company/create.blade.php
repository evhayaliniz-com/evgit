@extends('admin.inc.master')

@section('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
<style>
    .wizard {
        display: flex;
        justify-content: space-between;
        list-style: none;
        padding: 0;
    }
    .wizard li {
        width: 100%;
        text-align: center;
        padding: 10px;
        cursor: pointer;
        border-bottom: 3px solid #ddd;
    }
    .wizard li.active {
        font-weight: bold;
        border-bottom: 3px solid #007bff;
    }
    .wizard-content {
        display: none;
    }
    .wizard-content.active {
        display: block;
    }
</style>

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Yeni Firma Ekle</h5>
            <a href="{{ route('admin.companies.index') }}" class="btn btn-primary">
                <i class="bx bx-list-ul"></i> Firma Listesi
            </a>
        </div>
        <div class="card-body">
            <div class="row">
                <!-- Form Alanı -->
                <div class="col-12 col-lg-8">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Firma Bilgileri</h5>
                        </div>
                        <div class="card-body">
                            <ul class="wizard">
                                <li class="active" data-step="1"><i class="bx bx-building"></i> Firma Bilgileri</li>
                                <li data-step="2"><i class="bx bx-map"></i> Konum</li>
                                <li data-step="3"><i class="bx bx-share-alt"></i> Sosyal Medya</li>
                                <li data-step="4"><i class="bx bx-key"></i> Güvenlik</li>
                            </ul>
                            
                            <form action="{{ route('admin.companies.store') }}" method="POST">
                                @csrf
                                
                                <div class="wizard-content active" data-step="1">
                                    <div class="mb-3">
                                        <label class="form-label">Firma Adı</label>
                                        <input type="text" class="form-control" name="name" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Email</label>
                                        <input type="email" class="form-control" name="email" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Sabit Telefon</label>
                                        <input type="text" class="form-control" name="fixed_phone">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Cep Telefonu</label>
                                        <input type="text" class="form-control" name="mobile_phone" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Vergi No</label>
                                        <input type="text" class="form-control" name="tax_number" required>
                                    </div>
                                    <button type="button" class="btn btn-primary next">İleri</button>
                                </div>
                                
                                <div class="wizard-content" data-step="2">
                                    <div class="mb-3">
                                        <label class="form-label">İl</label>
                                        <input type="text" class="form-control" name="province" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">İlçe</label>
                                        <input type="text" class="form-control" name="district" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Adres</label>
                                        <textarea class="form-control" name="address" rows="3"></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Harita Konumu</label>
                                        <input type="text" class="form-control" name="map_location">
                                    </div>
                                    <button type="button" class="btn btn-secondary prev">Geri</button>
                                    <button type="button" class="btn btn-primary next">İleri</button>
                                </div>
                                
                                <div class="wizard-content" data-step="3">
                                    <div class="mb-3">
                                        <label class="form-label">Web Sitesi</label>
                                        <input type="url" class="form-control" name="website">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Facebook</label>
                                        <input type="url" class="form-control" name="facebook">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Instagram</label>
                                        <input type="url" class="form-control" name="instagram">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">YouTube</label>
                                        <input type="url" class="form-control" name="youtube">
                                    </div>
                                    <button type="button" class="btn btn-secondary prev">Geri</button>
                                    <button type="button" class="btn btn-primary next">İleri</button>
                                </div>
                                
                                <div class="wizard-content" data-step="4">
                                    <div class="mb-3">
                                        <label class="form-label">Şifre</label>
                                        <input type="password" class="form-control" name="password" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Şifre Tekrar</label>
                                        <input type="password" class="form-control" name="password_confirmation" required>
                                    </div>
                                    <button type="button" class="btn btn-secondary prev">Geri</button>
                                    <button type="submit" class="btn btn-success">Kaydet</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Bilgilendirme Alanı -->
                <div class="col-12 col-lg-4">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Bilgilendirme</h5>
                        </div>
                        <div class="card-body">
                            <p>Buradan yeni firma ekleyebilirsiniz.</p>
                            <ul>
                                <li>Firma adını ve iletişim bilgilerini girin.</li>
                                <li>Vergi numarasını belirtin.</li>
                                <li>İl ve ilçe seçimini yapın.</li>
                                <li>Adres ve firma hakkında bilgiler ekleyin.</li>
                                <li>Sosyal medya hesaplarını ekleyebilirsiniz.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> 
@endsection

@section('js')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        let steps = document.querySelectorAll(".wizard li");
        let contents = document.querySelectorAll(".wizard-content");
        let nextButtons = document.querySelectorAll(".next");
        let prevButtons = document.querySelectorAll(".prev");
        
        steps.forEach(step => {
            step.addEventListener("click", function() {
                let stepNum = this.dataset.step;
                showStep(stepNum);
            });
        });

        nextButtons.forEach(btn => {
            btn.addEventListener("click", function() {
                let activeStep = document.querySelector(".wizard-content.active");
                let nextStep = parseInt(activeStep.dataset.step) + 1;
                showStep(nextStep);
            });
        });

        prevButtons.forEach(btn => {
            btn.addEventListener("click", function() {
                let activeStep = document.querySelector(".wizard-content.active");
                let prevStep = parseInt(activeStep.dataset.step) - 1;
                showStep(prevStep);
            });
        });

        function showStep(stepNum) {
            steps.forEach(s => s.classList.remove("active"));
            contents.forEach(c => c.classList.remove("active"));
            document.querySelector(`.wizard li[data-step='${stepNum}']`).classList.add("active");
            document.querySelector(`.wizard-content[data-step='${stepNum}']`).classList.add("active");
        }
    });
</script>
@endsection