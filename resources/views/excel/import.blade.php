<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Import Blog Posts</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.6.0/css/bootstrap.min.css">
    <style>
        .error-list, .success-list {
            margin-top: 20px;
        }
        .error-item, .success-item {
            margin-bottom: 10px;
        }
        .sample-download {
            margin-top: 30px;
        }
    </style>
</head>
<body>
<div class="container mt-4">
    <h1>Import Blog Posts</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('importSummary'))
        @php
            $importSummary = session('importSummary');
        @endphp

        @if(isset($importSummary['successes']) && count($importSummary['successes']) > 0)
            <div class="alert alert-success">
                <h4>Successfully Imported Rows:</h4>
                <ul class="list-group success-list">
                    @foreach($importSummary['successes'] as $success)
                        <li class="list-group-item success-item">
                            Row with title: <strong>{{ $success['title'] ?? 'N/A' }}</strong> imported successfully.
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if(isset($importSummary['failures']) && count($importSummary['failures']) > 0)
            <div class="alert alert-danger">
                <h4>Rows that Failed to Import:</h4>
                <ul class="list-group error-list">
                    @foreach($importSummary['failures'] as $failure)
                        <li class="list-group-item error-item">
                            <strong>Row {{ $failure['row'] }}:</strong>
                            <ul class="mb-0">
                                @foreach($failure['errors'] as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif
    @endif

    <form action="{{ route('excel.import') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="file">Select Excel file (xlsx, csv, ods):</label>
            <input type="file" name="file" id="file" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Import Blog Posts</button>
    </form>

    <div class="sample-download">
        <h4>Download Sample Excel File</h4>
        <p>Use the sample Excel file to see the required format.</p>
        <a href="{{ asset('sample/sample_blog_posts.xlsx') }}" class="btn btn-secondary" download>Download Sample</a>
    </div>
</div>
</body>
</html>
