<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <h3 class="text-22 text-midnight text-bold mb-0">{{ $label }}</h3>
                    @if (!empty($sampleFile))
                        <a href="{{ asset($sampleFile) }}" class="btn btn-sm btn-success" download>
                            <i class="fas fa-download"></i> Sample Excel
                        </a>
                    @endif
                </div>

                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="post" action="{{ route($route) }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label>File</label>
                                    <input type="file" required class="form-control" name="excel_file">
                                </div>
                            </div>
                        </div>

                        <div class="form-group text-right">
                            <button type="submit" class="btn btn-sm btn-primary">Save</button>
                            <a href="{{ route($cancelRoute) }}" class="btn btn-sm btn-danger">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
