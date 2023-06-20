@extends('layout.app')
@section('content')
    <a href="/" class="back-icon"><img src="image/back.png" alt=""></a>
    <div class="container">
        <div class="gambar">
            <img src="image/klasemen.png" class="img-fluid" alt="" />
        </div>          
        <h1 style="text-align: center;" class="mb-30">Tampilan Klasemen</h1>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Klub</th>
                    <th>Main</th>
                    <th>Menang</th>
                    <th>Seri</th>
                    <th>Kalah</th>
                    <th>Goal</th>
                    <th>Kebobolan</th>
                    <th>Point</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($klasemen as $index => $klub)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $klub->klub }}</td>
                        <td>{{ $klub->main }}</td>
                        <td>{{ $klub->menang }}</td>
                        <td>{{ $klub->seri }}</td>
                        <td>{{ $klub->kalah }}</td>
                        <td>{{ $klub->goal_menang }}</td>
                        <td>{{ $klub->goal_kalah }}</td>
                        <td>{{ $klub->point }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

@endsection
