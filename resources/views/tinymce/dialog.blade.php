<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="csrf_token" value="<?php echo csrf_token(); ?>">
    <title>Upload an image</title>
    <link rel="stylesheet" href="/packages/semantic-ui/dist/semantic.min.css"/>
    <link href="css/dialog-v4.css" rel="stylesheet" type="text/css">
    <script>
        var jbImagesDialog = {

            resized : false,
            iframeOpened : false,
            timeoutStore : false,

            inProgress : function() {
                console.log("inProgress");
                document.getElementById("upload_infobar").style.display = 'none';
                document.getElementById("upload_additional_info").innerHTML = '';
                document.getElementById("upload_form_container").style.display = 'none';
                document.getElementById("upload_in_progress").style.display = 'block';
                this.timeoutStore = window.setTimeout(function(){
                    document.getElementById("upload_additional_info").innerHTML = 'This is taking longer than usual.' + '<br />' + 'An error may have occurred.' + '<br /><a href="#" onClick="jbImagesDialog.showIframe()">' + 'View script\'s output' + '</a>';
                    // tinyMCEPopup.editor.windowManager.resizeBy(0, 30, tinyMCEPopup.id);
                }, 20000);

                this.uploadFinish("test");
            },

            showIframe : function() {
                console.log("showIframe");
                if (this.iframeOpened == false)
                {
                    document.getElementById("upload_target").className = 'upload_target_visible';
                    // tinyMCEPopup.editor.windowManager.resizeBy(0, 190, tinyMCEPopup.id);
                    this.iframeOpened = true;
                }
            },

            uploadFinish : function(result) {
                console.log("uploadFinish");
                var w = this.getWin();
                tinymce = w.tinymce;
                tinymce.EditorManager.activeEditor.insertContent('XXXXXXX');
                this.close();
                return;

                if (result.resultCode == 'failed')
                {
                    window.clearTimeout(this.timeoutStore);
                    document.getElementById("upload_in_progress").style.display = 'none';
                    document.getElementById("upload_infobar").style.display = 'block';
                    document.getElementById("upload_infobar").innerHTML = result.result;
                    document.getElementById("upload_form_container").style.display = 'block';

                    if (this.resized == false)
                    {
                        // tinyMCEPopup.editor.windowManager.resizeBy(0, 30, tinyMCEPopup.id);
                        this.resized = true;
                    }
                }
                else
                {
                    document.getElementById("upload_in_progress").style.display = 'none';
                    document.getElementById("upload_infobar").style.display = 'block';
                    document.getElementById("upload_infobar").innerHTML = 'Upload Complete';

                    var w = this.getWin();
                    tinymce = w.tinymce;
                    var mybaseurl = result.base_url;

                    tinymce.EditorManager.activeEditor.insertContent('<img src="' + mybaseurl+result.filename +'">');

                    this.close();
                }
            },

            getWin : function() {
                console.log("getWin");
                return (!window.frameElement && window.dialogArguments) || opener || parent || top;
            },

            close : function() {
                console.log("close");
                var t = this;

                // To avoid domain relaxing issue in Opera
                function close() {
                    tinymce.EditorManager.activeEditor.windowManager.close(window);
                    tinymce = tinyMCE = t.editor = t.params = t.dom = t.dom.doc = null; // Cleanup
                };

                if (tinymce.isOpera)
                    this.getWin().setTimeout(close, 0);
                else
                    close();
            }

        };
    </script>
</head>
<body>

<form class="form-inline" id="upl" name="upl" action="/tinymce-upload" method="post" enctype="multipart/form-data"
      target="upload_target" onsubmit="jbImagesDialog.inProgress();">

    <div id="upload_in_progress" class="upload_infobar">
        <img src="img/spinner.gif" width="16" height="16" class="spinner">Upload in progress&hellip;
        <div id="upload_additional_info"></div>
    </div>
    <div id="upload_infobar" class="upload_infobar"></div>

    <p id="upload_form_container">
        <input id="uploader" name="userfile" type="file" class="jbFileBox" onChange="document.upl.submit(); jbImagesDialog.inProgress();">
    </p>

    <p id="the_plugin_name"><a href="http://justboil.me/" target="_blank"
                               title="JustBoil.me &mdash; a TinyMCE Images Upload Plugin">JustBoil.me Images Plugin</a>
    </p>

</form>

<iframe id="upload_target" name="upload_target" src="ci/index.php?blank"></iframe>

</body>
</html>