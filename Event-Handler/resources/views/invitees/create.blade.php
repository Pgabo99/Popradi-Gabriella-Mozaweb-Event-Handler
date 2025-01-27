@extends("layouts.default")
@section("title", "Eseményeim")
@section("content")
{{-- Modal to Invite users--}}
<div class="modal fade inviteModel" id="invite" tabindex="-1" aria-labelledby="inviteTitle" aria-hidden="true">
    <form id="inviteForm">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="inviteTitle">{{$event->name . ' - ' . $event->date}}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="event_id" class="form-control" name="event_id" value="{{$event->id}}">
                    <!-- Users-->
                    <div class="form-group mb-3">
                        <label for="user_id" class="form-label">Felhasználók</label>
                        <select class="form-control" id="user_id" name="user_id">
                            @foreach ($users as $user)
                                <option value="{{$user->id}}">
                                    {{$user->name . ' - ' . $user->email}}
                                </option>
                            @endforeach
                        </select>
                        <span id="userIdError" class="text-danger error-msg"></span>
                    </div>
                    {{-- Close and Save Buttons --}}
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Bezárás</button>
                        <button type="button" class="btn btn-primary" id="inviteSaveBTn">Mentés</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
{{-- New invite modal trigger button --}}
<div class="d-grid gap-2">
    <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#invite" id="addInvite"
        width="100%"> Emberek meghívása</button>
</div>
<div class="card">
    {{-- Invites table--}}
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-sm table-hover align-middle caption-bottom table-bordered" id="invites-table">
                <thead class="table-light align-middle">
                    <tr>
                        <th colspan="5" style="text-align: center;">Meghívottak</th>
                    </tr>
                    <tr>
                        <th scope="col">Felhasználó id</th>
                        <th scope="col">Név</th>
                        <th scope="col">Esemény id</th>
                        <th scope="col">Esemény neve</th>
                        <th scope="col">Művelet</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        //Binding data for the Invites Table
        var table = $('#invites-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{route('invitees.index', $event->id)}}",
            columns: [
                { data: 'user_id' },
                { data: 'user_name' },
                { data: 'event_id' },
                { data: 'event_name' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ]
        });
        // Deleting the error messages
        $('.error-msg').html('');
        //Saving/Updating data
        var form = $('#inviteForm')[0];
        $('#inviteSaveBTn').click(function () {
            //Disabling the save button during action
            $('#inviteSaveBTn').attr('disabled', true);
            $('#inviteSaveBTn').html('Folyamatban...');
            var formData = new FormData(form);
            formData.append("confirmed", "no")
            // Saving the datas
            $.ajax({
                url: '{{route("invitees.store")}}',
                method: 'POST',
                processData: false,
                contentType: false,
                data: formData,
                success: function (response) {
                    table.draw();
                    $('.inviteModel').modal('hide');
                    $('.error-msg').html('');
                    if (response) {
                        swal("Sikeres mentés!", response.success, "success");
                    }
                },
                error: function (error) {
                    if (error.responseJSON && error.responseJSON.errors && typeof error.responseJSON.errors.user_id !== "undefined") {
                        $('#userIdError').html(error.responseJSON.errors.user_id);
                    } else {
                        swal("Sikertelen!", 'Őt nem hívtad már meg?', "error");
                        $('.inviteModel').modal('hide');
                    }
                }
            });
            $('#inviteSaveBTn').attr('disabled', false);
            $('#inviteSaveBTn').html('Mentés');
        });
        //Delete button code
        $('body').on('click', '.deleteButton', function () {
            var event_id = $(this).data('event_id');
            var user_id = $(this).data('user_id');
            if (confirm("Biztos hogy törölni akarod?")) {
                $.ajax({
                    url: '{{url("invitees", '')}}' + '/' + user_id + '/' + event_id + '/delete',
                    method: 'DELETE',
                    success: function (response) {
                        table.draw();
                        swal("Sikeres törlés!", "Sikeresen törölted az eseményt.", "success");
                    },
                    error: function (error) {
                        swal("Sikertelen!", 'Próbáld újra', "error");
                    }
                });
            }
        });
        //Before new invite the default values are restored
        $('#addInvite').click(function () {
            $('#user_id').val('');
            $('.inviteModel').modal('hide');
            $('.error-msg').html('');
        });
    });
</script>
@endsection