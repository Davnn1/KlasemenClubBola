@extends('layout.app')

@section('content')
    @if ($message = Session::get('failed'))
        <div class="alert alert-danger">{{ $message }}</div>
    @elseif ($message = Session::get('success'))
        <div class="alert alert-success">{{ $message }}</div>
    @endif

    <a href="/" class="back-icon"><img src="image/back.png" alt=""></a>
    <form action="inputmatch/process" method="POST">
        @csrf
        <div class="matchlist">
            <img src="image/match.png" class="img-fluid" alt="" />
            <h3>Input Match</h3>
            <label id="per1" for="matches">Pertandingan 1</label>
            <div id="matches-container">
                <div class="match">
                    <div class="form-row">
                        <div class="col">
                            <select name="matches[0][klub1]" class="match-control" id="club1" required>
                                <option value="">Pilih Klub 1</option>
                                @foreach ($clubs as $club)
                                    <option value="{{ $club->nama_club }}">{{ $club->nama_club }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col">
                            <select name="matches[0][klub2]" class="match-control" id="club2"required>
                                <option value="">Pilih Klub 2</option>
                                @foreach ($clubs as $club)
                                    <option value="{{ $club->nama_club }}">{{ $club->nama_club }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col">
                            <input type="number" name="matches[0][score1]" class="match-control" placeholder="Score Klub 1" required min="0" onkeydown="return false;">
                        </div>
                        <div class="col">
                            <input type="number" name="matches[0][score2]" class="match-control" placeholder="Score Klub 2" required min="0" onkeydown="return false;">
                        </div>                        
                    </div>
                </div>
            </div>
            <button type="button" class="btn tombol" id="add" onclick="addMatch()">ADD</button>
            <button type="submit" class="btn tombol" id="save">SAVE</button>
        </div>
    </form>

    <script>
        var matchIndex = 1;

        function addMatch() {
            var matchesContainer = document.getElementById('matches-container');
        
            var match = document.createElement('div');
            match.classList.add('match');
        
            var formRow = document.createElement('div');
            formRow.classList.add('form-row');
        
            var label = document.createElement('label');
            label.innerText = 'Pertandingan ' + (matchIndex + 1);
            formRow.appendChild(label);
        
            var col1 = document.createElement('div');
            col1.classList.add('col');
            var select1 = document.createElement('select');
            select1.name = 'matches[' + matchIndex + '][klub1]';
            select1.classList.add('match-control');
            select1.required = true;
            var option1 = document.createElement('option');
            option1.value = '';
            option1.text = 'Pilih Klub 1';
            select1.appendChild(option1);
            var clubs = {!! json_encode($clubs) !!};
            for (var i = 0; i < clubs.length; i++) {
                var option = document.createElement('option');
                option.value = clubs[i].nama_club;
                option.text = clubs[i].nama_club;
                select1.appendChild(option);
            }
            col1.appendChild(select1);
        
            var col2 = document.createElement('div');
            col2.classList.add('col');
            var select2 = document.createElement('select');
            select2.name = 'matches[' + matchIndex + '][klub2]';
            select2.classList.add('match-control');
            select2.required = true;
            var option2 = document.createElement('option');
            option2.value = '';
            option2.text = 'Pilih Klub 2';
            select2.appendChild(option2);
            for (var i = 0; i < clubs.length; i++) {
                var option = document.createElement('option');
                option.value = clubs[i].nama_club;
                option.text = clubs[i].nama_club;
                select2.appendChild(option);
            }
            col2.appendChild(select2);
        
            var col3 = document.createElement('div');
            col3.classList.add('col');
            var input1 = document.createElement('input');
            input1.type = 'number';
            input1.name = 'matches[' + matchIndex + '][score1]';
            input1.classList.add('match-control');
            input1.placeholder = 'Score Klub 1';
            input1.required = true;
            input1.min = 0; // Skor tidak bisa negatif
            input1.addEventListener('keydown', function(event) {
                if (event.keyCode !== 38 && event.keyCode !== 40) { // 38 = panah atas, 40 = panah bawah
                    event.preventDefault();
                }
            });
            col3.appendChild(input1);
        
            var col4 = document.createElement('div');
            col4.classList.add('col');
            var input2 = document.createElement('input');
            input2.type = 'number';
            input2.name = 'matches[' + matchIndex + '][score2]';
            input2.classList.add('match-control');
            input2.placeholder = 'Score Klub 2';
            input2.required = true;
            input2.min = 0; // Skor tidak bisa negatif
            input2.addEventListener('keydown', function(event) {
                if (event.keyCode !== 38 && event.keyCode !== 40) { // 38 = panah atas, 40 = panah bawah
                    event.preventDefault();
                }
            });
            col4.appendChild(input2);
        
            formRow.appendChild(col1);
            formRow.appendChild(col2);
            formRow.appendChild(col3);
            formRow.appendChild(col4);
        
            match.appendChild(formRow);
        
            matchesContainer.appendChild(match);
        
            // Validasi klub 1 dan klub 2 tidak boleh sama
            select1.addEventListener('change', function() {
                validateClubSelection(select1, select2);
            });
        
            select2.addEventListener('change', function() {
                validateClubSelection(select1, select2);
            });
        
            matchIndex++;
        }
        var select3 = document.getElementById('club1');
        var select4 = document.getElementById('club2');
        select3.addEventListener('change', function() {
            validateSelection(select3, select4);
        });
    
        select4.addEventListener('change', function() {
            validateSelection(select3, select4);
        });

        function validateClubSelection(select1, select2) {
            if (select1.value === select2.value) {
                alert('Klub 1 dan Klub 2 tidak boleh sama!');
                select1.value = '';
                select2.value = '';
            }
        }
        function validateSelection(select3, select4) {
            if (select3.value === select4.value) {
                alert('Klub 1 dan Klub 2 tidak boleh sama!');
                select3.value = '';
                select4.value = '';
            }
        }

    </script>
@endsection
