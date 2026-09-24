@extends('site.inc.master')

@section('css')
<style>
    .contact-page-right li:after {
        width: 100%;
    }
</style>
@endsection

@section('content')
<div class="odeme-page-container">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="odeme-page-area odeme-page-success">
                        <h1>
                            Ödeme Başarılı!
                        </h1>
                        <p class="mb-0">
                            Ödeme İşleminiz Başarıyla Gerçekleştirildi. <span id="countdown">3</span> saniye sonra profilinize yönlendirileceksiniz...
                        </p>
                        <a href="{{ route('company.dashboard') }}">
                            <span>
                                Profilime Git 
                            </span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"><!-- Icon from Material Symbols by Google - https://github.com/google/material-design-icons/blob/master/LICENSE --><path fill="currentColor" d="M12.6 12L8.7 8.1q-.275-.275-.275-.7t.275-.7t.7-.275t.7.275l4.6 4.6q.15.15.213.325t.062.375t-.062.375t-.213.325l-4.6 4.6q-.275.275-.7.275t-.7-.275t-.275-.7t.275-.7z"/></svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
</div>

@endsection

@section('js')
<script>
    // 3 saniye geri sayım ve otomatik yönlendirme
    let countdown = 3;
    const countdownElement = document.getElementById('countdown');
    
    const timer = setInterval(function() {
        countdown--;
        countdownElement.textContent = countdown;
        
        if (countdown <= 0) {
            clearInterval(timer);
            window.location.href = "{{ route('company.dashboard') }}";
        }
    }, 1000);
</script>
@endsection