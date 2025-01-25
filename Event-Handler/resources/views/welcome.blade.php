@extends("layouts.default")
@section("title", "Kezdőoldal")
@section("content")


<!-- Modal -->
<div class="modal fade" id="eventModal" tabindex="-1" aria-labelledby="eventModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="eventModalLabel"></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p id="dateAndLocation"></p>
                <p id="type"></p>
                <h2 class="fs-5">Leírás</h2>
                <p id="description"></p>
                <img src="#" class="card-img-top" alt="Event image" id="picture">
            </div>
            <div class="modal-footer">
                <form id="inviteeForm">
                    <input type="hidden" id="event_id" class="form-control" name="event_id">
                    <input type="hidden" id="user_id" class="form-control" name="user_id">
                    <input type="hidden" id="event_type" class="form-control" name="event_type">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Bezárás</button>
                    <button type="button" id="inviteeSaveBtn" class="btn btn-primary">Ott leszek</button>
                    <button type="button" id="inviteeNoSaveBtn" class="btn btn-primary" disabled="true" hidden>Nem tudok
                        menni</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row row-cols-1 row-cols-md-2 g-4">
    @foreach ($events as $event)
        <div class="col">
            <div class="card">
                <img src="{{$event->picture}}" class="card-img-top" alt="Event image"
                    style="height: 200px;object-fit: cover;object-position: center; width: 100%;">
                <div class="card-body">
                    <h5 class="card-title text-truncate">{{$event->name}}</h5>
                    <p class="card-text text-truncate">{{$event->description}}</p>
                    <p class="card-text"><small class="text-body-secondary">{{$event->date}}, {{$event->location}}</small>
                    </p>
                </div>
                <div class="card-footer">
                    <small class="text-body-secondary">
                        <a class="click" data-id="{{$event->id}}" href="#" data-bs-toggle="modal"
                            data-bs-target="#eventModal">
                            Kattints további részletekért
                        </a>
                    </small>
                </div>
            </div>
        </div>
    @endforeach
</div>

<script>
    $(document).ready(function () {

        //Binding the datas into the modal
        $('body').on('click', '.click', function () {
            var event_id = $(this).data("id");
            var user_id = {{Auth::user()->id}};

            $.ajax({
                url: '{{url("invitees", '')}}' + '/' + user_id + '/' + event_id + '/getone',
                method: 'GET',
                success: function (response) {
                    if (response.confirmed === 'yes') {
                        $('#inviteeSaveBtn').attr('disabled', true);
                        $('#inviteeSaveBtn').attr('hidden', true);
                        $('#inviteeNoSaveBtn').attr('disabled', false);
                        $('#inviteeNoSaveBtn').attr('hidden', false);
                    } else {
                        $('#inviteeSaveBtn').attr('disabled', false);
                        $('#inviteeSaveBtn').attr('hidden', false);
                        $('#inviteeNoSaveBtn').attr('disabled', true);
                        $('#inviteeNoSaveBtn').attr('hidden', true);
                    }
                },
                error: function (error) {
                    console.log(error)
                }
            });

            $.ajax({
                url: '{{url("events", '')}}' + '/' + event_id + '/edit',
                method: 'GET',
                success: function (response) {
                    $('.eventModal').modal('show');
                    $('#eventModalLabel').html(response.name);
                    $('#event_id').val(response.id);
                    $('#event_type').val(response.type);
                    $('#user_id').val(user_id);
                    $('#dateAndLocation').html(response.date + ", " + response.location);
                    document.getElementById("picture").src = response.picture;
                    $('#type').html(response.type === 'private' ? 'Magán rendezvény' : 'Közösségi rendezvény');
                    $('#description').html(response.description);
                    if(response.creator_id===user_id){
                        $('#inviteeNoSaveBtn').attr('disabled', true);
                        $('#inviteeSaveBtn').attr('disabled', true);
                    }
                },
                error: function (error) {
                    console.log(error)
                }
            });


        });

        //Saving 
        var form = $('#inviteeForm')[0];
        $('#inviteeSaveBtn').click(function () {

            //Disabling the save button during action
            $('#inviteeSaveBtn').attr('disabled', true);
            $('#inviteeSaveBtn').html('Folyamatban...');

            var formData = new FormData(form);

            // Saving the datas
            savingData(formData);
        });

        //delete 
        $('#inviteeNoSaveBtn').click(function () {

            //Disabling the save button during action
            $('#inviteeNoSaveBtn').attr('disabled', true);
            $('#inviteeNoSaveBtn').html('Folyamatban...');

            var formData = new FormData(form);
            var event_id = formData.get('event_id');
            var user_id = {{Auth::user()->id}};

            // Deletes the datas if public
            if (confirm("Biztos hogy törölni akarod?")) {
                if (formData.get('event_type') === 'public') {
                    $.ajax({
                        url: '{{url("invitees", '')}}' + '/' + user_id + '/' + event_id + '/delete',
                        method: 'DELETE',
                        success: function (response) {
                            $('#eventModal').modal('hide');
                            $('#inviteeNoSaveBtn').attr('disabled', false);
                            $('#inviteeNoSaveBtn').html('Nem tudok menni');
                            swal("Sikeres!", "Elmentve", "success");
                        },
                        error: function (error) {
                            swal("Sikertelen!", 'Próbáld újra', "error");
                        }
                    });
                }else{
                    var formData = new FormData(form);
                    formData.append("confirmed",'no');
                    formData.append("edit",'yes');
                    savingData(formData);
                }
            }
        });
    });

    function savingData(formData) {
        $.ajax({
            url: '{{route("invitees.store")}}',
            method: 'POST',
            processData: false,
            contentType: false,
            data: formData,
            success: function (response) {
                $('#eventModal').modal('hide');
                $('#inviteeSaveBtn').attr('disabled', false);
                $('#inviteeSaveBtn').html('Ott leszek');
                if (response) {
                    swal("Sikeres mentés!", response.success, "success");
                }
            },
            error: function (error) {
                swal("Sikertelen!", 'Nem jeleztél már vissza?', "error");
            }
        });
    }
</script>

@endsection