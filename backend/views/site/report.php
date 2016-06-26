<?php

/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>
<div class="site-report">
    <script type="text/javascript">
        function iframeLoaded() {
            var iFrameID = document.getElementById('idIframe');
            if(iFrameID) {
                // here you can make the height, I delete it first, then I make it again
                iFrameID.height = "";
                iFrameID.height = iFrameID.contentWindow.document.body.scrollHeight + "px";
            }
        }
    </script>

    <iframe id="idIframe" onload="iframeLoaded()" width="100%" scrolling="no" frameborder="0" src="http://report.psi.m-hasan.my.id"></iframe>
</div>
