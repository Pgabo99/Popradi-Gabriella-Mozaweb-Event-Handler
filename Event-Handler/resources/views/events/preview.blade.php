<!-- Modal -->
<div class="modal fade" id="eventPreviewModal" tabindex="-1" aria-labelledby="eventPreviewModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="eventPreviewModalLabel"></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p id="dateAndLocation"></p>
                <p id="event_preview_type"></p>
                <h2 class="fs-5">Leírás</h2>
                <p id="previewDescription"></p>
                <img src="#" class="card-img-top" alt="Event image" id="previewPicture">
            </div>
            <div class="modal-footer">
                <form id="inviteeForm">
                    <input type="hidden" id="previewEvent_id" class="form-control" name="event_id">
                    <input type="hidden" id="user_id" class="form-control" name="user_id">
                    <input type="hidden" id="preview_event_type" class="form-control" name="preview_event_type">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Bezárás</button>
                    <button type="button" id="inviteeSaveBtn" class="btn btn-primary">Ott leszek</button>
                    <button type="button" id="inviteeNoSaveBtn" class="btn btn-primary" disabled="true" hidden>Mégse megyek</button>
                </form>
            </div>
        </div>
    </div>
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
                    $('.eventPreviewModal').modal('show');
                    $('#eventPreviewModalLabel').html(response.name);
                    $('#previewEvent_id').val(response.id);
                    $('#preview_event_type').val(response.type);
                    $('#user_id').val(user_id);
                    $('#dateAndLocation').html(response.date + ", " + response.location);
                    document.getElementById("previewPicture").src = "/images/"+response.picture;
                    $('#event_preview_type').html(response.type === 'private' ? 'Magán rendezvény' : 'Közösségi rendezvény');
                    $('#previewDescription').html(response.description);
                    if (response.creator_id === user_id || response.date < new Date().toISOString().slice(0, 10)) {
                        $('#inviteeSaveBtn').attr('disabled', true);
                        $('#inviteeSaveBtn').attr('hidden', false);
                        $('#inviteeNoSaveBtn').attr('hidden', true);
                        $('#inviteeSaveBtn').html('Mégse megyek');
                    }
                },
                error: function (error) {
                    console.log(error)
                }
            });
        });
    });
</script>