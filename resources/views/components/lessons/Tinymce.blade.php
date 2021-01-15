{{$a}}
<!-- The Modal to add audio -->
<button id="add_audio" type="button" class="btn btn-primary" data-toggle="modal" data-target="#linkconverter"
    style="display: none;">
    Add Audio
</button>
<div class="modal fade " id="linkconverter">
    <div class="modal-dialog modal-dialog-centered ">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Cloud audio <span style="color: red">embededer</span></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <div class="container">
                    <div class="row" id="main">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="username">Google drive shared file:</label>
                                <input type="text" class="form-control" id="google_link" placeholder="Google link">
                            </div>
                            <div class="form-group">
                                <label for="username">OneDrive embed link:</label>
                                <input type="text" class="form-control" id="onedrive_link"
                                    placeholder="OneDrive embed link">
                            </div>
                            <div class="form-group">
                                <label for="username">DropBox shared file:</label>
                                <input type="text" class="form-control" id="dropbox_link" placeholder="DropBox link">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button onClick="convert()" type="button" class="btn btn-primary" data-dismiss="modal">Add</button>
            </div>

        </div>
    </div>
</div>

<script>
    tinymce.init({
        selector: 'textarea',
        menubar: "table",
        plugins: 'lists wordcount autosave image media fullscreen preview directionality hr legacyoutput table link code',
        toolbar: 'undo redo | bold italic underline strikethrough | numlist bullist | alignleft aligncenter alignright alignjustify | ltr rtl | forecolor backcolor | fontsizeselect formatselect | image media cloudlinksconverter  link | hr | restoredraft preview fullscreen code',

        contextmenu: "link cut copy paste image imagetools table spellchecker lists",
        media_live_embeds: true,
        setup: function(editor) {
            editor.on('change redo undo input', function(e) {
                editor.save();
            });

            editor.ui.registry.addButton('cloudlinksconverter', {

                text: "audio",
                tooltip: 'cloud_link_converter',
                onAction: () => $("#add_audio").click()
            });
        },

        audio_template_callback: function(data) {
            return '<audio preload="auto" controls>' + '\n<source src="' + data.source + '" />\n' +
                '</audio>';
        }

    });

    function convert() {
        var google = $("#google_link").val();
        var microsoft = $("#onedrive_link").val();
        microsoft = microsoft.replace(/embed?/g, 'download?');
        var dropbox = $("#dropbox_link").val();
        dropbox = dropbox.replace(/www/g, 'dl');
        dropbox = dropbox.replace(/dl=0/g, 'dl=1');
        var res = google.match(/https:\/\/drive.google.com\/file\/d\/([a-zA-Z0-9_]+)\//)
        var googleDriveFileID = res[1];
        var sources = "";
        if ($("#google_link").val() !== "") {
            sources = sources + '<source src="http://docs.google.com/uc?export=open&id=' + googleDriveFileID +
                '#audio_lewaf.mp3" type="audio/mp3">';
        }
        if ($("#onedrive_link").val() !== "") {
            sources = sources + '<source src="' + microsoft + '#audio_lewaf.mp3" type="audio/mp3">';
        }
        if ($("#dropbox_link").val() !== "") {
            sources = sources + '<source src="' + dropbox + '#audio_lewaf.mp3" type="audio/mp3">';
        }

        var audio_embed_code = "<audio  class='audio_theme' preload='auto' controls>" + sources + "</audio>";

        tinymce.activeEditor.execCommand('mceInsertContent', false, audio_embed_code);
    }

</script>
