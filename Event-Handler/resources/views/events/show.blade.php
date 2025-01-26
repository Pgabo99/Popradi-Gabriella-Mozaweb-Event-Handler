<p class="d-inline-flex gap-1">
    <a class="btn btn-primary" data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false"
        aria-controls="collapseExample">
        Szűrés
    </a>
</p>
<div class="collapse" id="collapseExample">
    <div class="card card-body">
        <form method="GET" action="{{ route('home') }}" class="searchForm">
            <div class="mb-3">
                <label for="searchLocation" class="form-label">Helyszín</label>
                <input type="text" class="form-control" id="searchLocation" name="searchLocation"
                    value="{{ request()->get('searchLocation', '') }}">
            </div>
            <button type="submit" class="btn btn-primary">Keresés</button>
        </form>
    </div>
</div>

<div class="events-container">
    @if($events->isEmpty())
        <div class="alert alert-warning" role="alert">
            Nem találtam eseményt
        </div>
    @else
        <div class="row row-cols-1 row-cols-md-2 g-4">
            @foreach ($events as $event)
                <div class="col">
                    <div
                        class="card {{$event->date < date('Y-m-d') ? "text-bg-secondary" : ($event->type === "private" ? "text-bg-dark text-white" : "")}}">
                        <img src="{{$event->picture}}" class="card-img-top" alt="Event image"
                            style="height: 200px;object-fit: cover;object-position: center; width: 100%;">
                        <div class="card-body">
                            <h5 class="card-title text-truncate">{{$event->name}}</h5>
                            <p class="card-text text-truncate">{{$event->description}}</p>
                            <p class="card-text"><small>{{$event->date}}, {{$event->location}}</small>
                            </p>
                        </div>
                        <div class="card-footer">
                            <small class="text-body-secondary">
                                <a class=" link-info click" data-id="{{$event->id}}" href="#" data-bs-toggle="modal"
                                    data-bs-target="#eventPreviewModal">
                                    Kattints további részletekért
                                </a>
                            </small>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

<script>
    $(document).ready(function () {

        $('#searchBtn').click(function () {
            var searchLocation = $('#searchLocation').val();

            $.ajax({
                url: '{{ route("home") }}',
                method: 'GET',
                data: { searchLocation: searchLocation },
                success: function (response) {
                    // Itt frissítheted a megjelenített eseményeket
                    $('#eventsContainer').html(response); // Események frissítése
                },
                error: function (xhr, status, error) {
                    console.error(error);
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
                if (formData.get('preview_event_type') === 'public') {
                    $.ajax({
                        url: '{{url("invitees", '')}}' + '/' + user_id + '/' + event_id + '/delete',
                        method: 'DELETE',
                        success: function (response) {
                            $('#eventPreviewModal').modal('hide');
                            $('#inviteeNoSaveBtn').attr('disabled', false);
                            $('#inviteeNoSaveBtn').html('Nem tudok menni');
                            swal("Sikeres!", "Elmentve", "success");
                        },
                        error: function (error) {
                            swal("Sikertelen!", 'Próbáld újra', "error");
                        }
                    });
                } else {
                    var formData = new FormData(form);
                    formData.append("confirmed", 'no');
                    formData.append("edit", 'yes');
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
                $('#eventPreviewModal').modal('hide');
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