@extends('admin.inc.master')

@section('content')
<div class="row">
    <div class="col-12 col-lg-12">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Hakkımızda</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.about.update') }}" method="POST">
                    @method('PUT')
                    @csrf

                    <div class="row">
                        <div class="mb-3">
                            <label class="form-label">Başlık</label>
                            <input type="text" class="form-control" name="title" value="{{ $about?->title }}" required>
                        </div>

                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">Açıklama</label>
                                <textarea class="form-control" name="content" id="editor" rows="6" required
                                >{{ $about?->content }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Vizyon</label>
                                <textarea class="form-control" name="box1_content" rows="3"
                                >{{ $about?->box1_content }}</textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Misyon</label>
                                <textarea class="form-control" name="box2_content" rows="3"
                                >{{ $about?->box2_content }}</textarea>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success"><i class="bx bx-save"></i> Kaydet</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
