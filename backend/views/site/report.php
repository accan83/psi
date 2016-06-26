<?php

/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>
<div class="site-report">

    <iframe id="idIframe" width="100%" scrolling="no" frameborder="0" src="../../report"></iframe>
    <script type="text/javascript">
        (function() {
            // your page initialization code here
            // the DOM will be available here
            var iFrameID = document.getElementById('idIframe');
            if(iFrameID) {
                iFrameID.height = "0";
            }

            window.addEventListener('message', function(event) {

                // IMPORTANT: Check the origin of the data!
                if (~event.origin.indexOf('http://report.psi.m-hasan.my.id')) {
                    // The data has been sent from your site
                    if(iFrameID) {
                        iFrameID.height = "";
                        iFrameID.height = event.data + "px";
                    }
                } else {
                    // The data hasn't been sent from your site!
                    // Be careful! Do not use it.
                    return;
                }
            });

        })();
    </script>
</div>
