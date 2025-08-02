@extends('layouts.app')

@section('content')
    @if(session('report_download'))
        <div class="alert alert-success">
            Report generated. <a href="{{ session('report_download') }}" class="btn btn-sm btn-outline-primary">Download CSV</a>
        </div>
    @endif
    @if(session('message'))
        <div class="alert alert-info">{{ session('message') }}</div>
    @endif
    <div class="container py-4" id="theme-container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Website Traffic Dashboard</h2>
            <div>
                <a href="{{ route('visits.export', ['from' => $from->toDateString(), 'to' => $to->toDateString()]) }}" class="btn btn-sm btn-outline-success ms-2">
                    Export CSV
                </a>
                <button id="toggle-theme" class="btn btn-sm btn-secondary">Toggle Theme</button>
                <button id="toggle-view" class="btn btn-sm btn-primary">Toggle View</button>
            </div>
        </div>

        <form method="GET" class="row g-3 mb-4">
            <div class="col-md-3">
                <input type="date" name="from" value="{{ $from->toDateString() }}" class="form-control">
            </div>
            <div class="col-md-3">
                <input type="date" name="to" value="{{ $to->toDateString() }}" class="form-control">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-success w-100">Filter</button>
            </div>
        </form>

        <!-- Unique Visits Section -->
        <div class="mb-5">
            <h4>Unique Visits</h4>
            <div id="unique-table-view">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Page URL</th>
                        <th>Unique IPs</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($uniqueData as $row)
                        <tr>
                            <td>{{ $row->page_url }}</td>
                            <td>{{ $row->unique_visits }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div id="unique-box-view" class="d-none">
                <div class="row">
                    @foreach($uniqueData as $row)
                        <div class="col-md-4">
                            <div class="card mb-3 shadow-sm" style="border: 5px solid red;">
                                <div class="card-body">
                                    <h6 class="card-title text-truncate">{{ $row->page_url }}</h6>
                                    <p class="card-text">Unique IPs: <strong>{{ $row->unique_visits }}</strong></p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- All Visits Section -->
        <div>
            <h4>All Visits</h4>
            <div id="all-table-view">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>Page URL</th>
                        <th>IP Address</th>
                        <th>Country</th>
                        <th>Region</th>
                        <th>City</th>
                        <th>Isp</th>
                        <th>Visited At</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($allData as $visit)
                        <tr>
                            <td>{{ $visit->page_url }}</td>
                            <td>{{ $visit->ip_address }}</td>
                            <td>{{ $visit->country ?? '-' }}</td>
                            <td>{{ $visit->region ?? '-' }}</td>
                            <td>{{ $visit->city ?? '-' }}</td>
                            <td>{{ $visit->isp ?? '-' }}</td>
                            <td>{{ $visit->visited_at }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div id="all-box-view" class="d-none">
                <div class="row">
                    @foreach($allData as $visit)
                        <div class="col-md-4">
                            <div class="card mb-3 border-start border-5 border-primary shadow-sm">
                                <div class="card-body">
                                    <h6 class="card-title text-truncate">{{ $visit->page_url }}</h6>
                                    <p class="mb-1"><strong>IP:</strong> {{ $visit->ip_address }}</p>
                                    <p class="mb-1"><strong>Country:</strong> {{ $visit->country ?? '-' }}</p>
                                    <p class="mb-1"><strong>City:</strong> {{ $visit->city ?? '-' }}</p>
                                    <p class="mb-1"><strong>Org:</strong> {{ $visit->organization ?? '-' }}</p>
                                    <small class="text-muted">{{ $visit->visited_at }}</small>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-center mt-3">
            {{ $allData->links('pagination::bootstrap-5') }}
        </div>
    </div>

    <!-- Toggle Scripts -->
    <script>
        const toggleViewBtn = document.getElementById('toggle-view');
        const toggleThemeBtn = document.getElementById('toggle-theme');
        const uniqueTable = document.getElementById('unique-table-view');
        const uniqueBox = document.getElementById('unique-box-view');
        const allTable = document.getElementById('all-table-view');
        const allBox = document.getElementById('all-box-view');
        const container = document.getElementById('theme-container');

        toggleViewBtn.addEventListener('click', () => {
            uniqueTable.classList.toggle('d-none');
            uniqueBox.classList.toggle('d-none');
            allTable.classList.toggle('d-none');
            allBox.classList.toggle('d-none');
        });

        toggleThemeBtn.addEventListener('click', () => {
            container.classList.toggle('bg-dark');
            container.classList.toggle('text-light');
        });
    </script>
@endsection
