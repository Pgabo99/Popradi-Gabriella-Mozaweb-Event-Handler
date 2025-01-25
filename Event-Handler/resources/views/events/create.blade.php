@extends("layouts.default")
@section("title", "Eseményeim")
@section("content")
{{-- Modal for the Creating and Editing--}}
<div class="modal fade eventModel" id="Event" tabindex="-1" aria-labelledby="EventTitle" aria-hidden="true">
    <form id="eventForm">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="EventTitle"></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="event_edit" class="form-control" name="event_edit">
                    <input type="hidden" id="event_id" class="form-control" name="event_id">

                    {{-- Event name --}}
                    <div class="form-group mb-3">
                        <label for="name" class="form-label">Esemény neve</label>
                        <input type="text" placeholder="Esemény neve" id="name" class="form-control" name="name"
                            required autofocus>
                        <span id="eventNameError" class="text-danger error-msg"></span>
                    </div>

                    {{-- Event date --}}
                    <div class="form-group mb-3">
                        <label for="date" class="form-label">Esemény napja</label>
                        <input type="date" min="<?= date('Y-m-d'); ?>" value="<?= date('Y-m-d'); ?>" id="date"
                            class="form-control" name="date" required>
                        <span id="eventDateError" class="text-danger error-msg"></span>
                    </div>

                    {{-- Event location --}}
                    <div class="form-group mb-3">
                        <label for="location" class="form-label">Helyszín</label>
                        <input type="text" placeholder="Esemény helye" id="location" class="form-control"
                            name="location" required>
                        <span id="locationError" class="text-danger error-msg"></span>
                    </div>

                    {{-- Picture --}}
                    <div class="form-group mb-3">
                        <label for="picture" class="form-label">Kép</label>
                        <input type="text" placeholder="Kép" id="picture" class="form-control" name="picture" required>
                        <span id="pictureError" class="text-danger error-msg"></span>
                    </div>

                    {{-- Event type--}}
                    <div class="form-group mb-3">
                        <label for="type" class="form-label">Típus</label>
                        <select class="form-control" id="type" name="type" required>
                            <option value="public" selected>Publikus</option>
                            <option value="private">Private</option>
                        </select>
                        <span id="EventTypeError" class="text-danger error-msg"></span>
                    </div>

                    {{-- Description--}}
                    <div class="form-group mb-3">
                        <label for="description" class="form-label">Leírás</label>
                        <textarea class="form-control" id="description" rows="3" placeholder="Leírás..."
                            name="description"></textarea>
                        <span id="descriptionError" class="text-danger error-msg"></span>
                    </div>
                </div>

                {{-- Close and Save Buttons --}}
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Bezárás</button>
                    <button type="button" class="btn btn-primary" id="eventSaveBTn">Mentés</button>
                </div>

            </div>
        </div>
    </form>
</div>

{{-- New competition modal trigger button --}}
<div class="d-grid gap-2">
    <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#Event" id="addEvent"
        width="100%"> Új verseny </button>
</div>


<div class="card">
    {{-- Events table--}}
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-sm table-hover align-middle caption-bottom table-bordered" id="events-table">
                <caption>Előnézet megtekintéséhez kattints egy sorra</caption>
                <thead class="table-light align-middle">
                    <tr>
                        <th colspan="8" style="text-align: center;">Eseményeim</th>
                    </tr>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Név</th>
                        <th scope="col">Dátum</th>
                        <th scope="col">Helyszín</th>
                        <th scope="col">Kép</th>
                        <th scope="col">Típus</th>
                        <th scope="col">Leírás</th>
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

        //Binding data for the Events Table
        var table = $('#events-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{route('events.index')}}",
            columns: [
                { data: 'id', className: "clickable" },
                { data: 'name', className: "clickable" },
                { data: 'date', className: "clickable" },
                { data: 'location', className: "clickable" },
                { data: 'picture', className: "clickable" },
                { data: 'type', className: "clickable" },
                { data: 'description', className: "clickable" },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ]
        });

        // Deleting the error messages
        $('.error-msg').html('');

        //Saving/Updating data
        var form = $('#eventForm')[0];
        $('#eventSaveBTn').click(function () {

            //Disabling the save button during action
            $('eventSaveBTn').attr('disabled', true);
            $('eventSaveBTn').html('Folyamatban...');
            var formData = new FormData(form);

            // Saving the datas
            $.ajax({
                url: '{{route("events.store")}}',
                method: 'POST',
                processData: false,
                contentType: false,
                data: formData,
                success: function (response) {
                    table.draw();
                    $('.eventModel').modal('hide');
                    $('eventSaveBTn').attr('disabled', false);
                    $('eventSaveBTn').html('Mentés');
                    $('.error-msg').html('');
                    if (response) {
                        swal("Sikeres mentés!", response.success, "success");
                    }
                },
                error: function (error) {
                    if (error) {
                        $('#eventNameError').html(error.responseJSON.errors.name);
                        $('#eventDateError').html(error.responseJSON.errors.date);
                        $('#locationError').html(error.responseJSON.errors.location);
                        $('#pictureError').html(error.responseJSON.errors.picture);
                        $('#eventTypeError').html(error.responseJSON.errors.type);
                        $('#descriptionError').html(error.responseJSON.errors.description);
                    }
                }
            });

        });

        //Edit button code
        $('body').on('click', '.editButton', function () {
            var event_id = $(this).data('event_id');
            $.ajax({
                url: '{{url("events", '')}}' + '/' + event_id + '/edit',
                method: 'GET',
                success: function (response) {
                    $('.eventModel').modal('show');
                    $('#EventTitle').html('Verseny módosítása');

                    $('#event_edit').val('editing');
                    $('#event_id').val(response.id);
                    $('#name').val(response.name);
                    $('#date').val(response.date);
                    $('#location').val(response.location);
                    $('#picture').val(response.picture);
                    $('#type').val(response.type);
                    $('#description').val(response.description);
                },
                error: function (error) {
                    swal("Sikertelen!", 'Próbáld újra', "error");
                }
            });
        });

        //Delete button code
        $('body').on('click', '.deleteButton', function () {
            var event_id = $(this).data('event_id');
            if (confirm("Biztos hogy törölni akarod?")) {

                $.ajax({
                    url: '{{url("events", '')}}' + '/' + event_id + '/delete',
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

        //Before new event the default values are restored
        $('#addEvent').click(function () {
            $('#event_edit').val(null);
            $('#event_id').val(null);
            $('#name').val('');
            $('#date').val(new Date().toISOString().slice(0, 10));
            $('#location').val('');
            $('#picture').val('');
            $('#type').val('public');
            $('#description').val('');
            $('.eventModel').modal('hide');
            $('#EventTitle').html('Verseny felvétele');
            $('#event_edit').val(null);
            $('.error-msg').html('');
        });
    });
</script>
@endsection