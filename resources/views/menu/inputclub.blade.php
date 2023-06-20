@extends('layout.app')
@section('content')
    @if($message = Session::get('failed'))
        <div class="modal fade" id="failedModal" tabindex="-1" role="dialog" aria-labelledby="failedModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="failedModalLabel">Club sudah terdaftar!</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @elseif ($message = Session::get('success'))
        <div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="successModalLabel">Register Club Berhasil!</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @elseif ($message = Session::get('dikit'))
        <div class="modal fade" id="dikitModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="successModalLabel">Club Terlalu Sedikit!</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <a href="/" class="back-icon"><img src="image/back.png" alt=""></a>
    <div class="formlist">
        <img src="image/club.png" class="img-fluid" alt="" />
        <form action="inputclub/process" method="POST">
            @csrf
            <label class="mb-10">Club Name</label>
            <input type="text" name="club" id="" class="form-control mb-10" required>
            <label class="mb-10">Club Origin</label>
            <input type="text" name="kota" id="" class="form-control mb-10" required>
            <button class="w-100 btn button">Submit</button>
        </form>
    </div>
    <script>
        // Munculkan modal sesuai pesan yang diterima
        @if($message = Session::get('failed'))
            $('#failedModal').modal('show');
        @elseif ($message = Session::get('success'))
            $('#successModal').modal('show');
        @elseif ($message = Session::get('dikit'))
            $('#dikitModal').modal('show');
        @endif
    </script>
@endsection
