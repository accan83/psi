<?php

/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>
<div class="site-report">

    <h3 class="text-center" id="loading">Loading Page...</h3>
    <iframe id="idIframe" width="100%" scrolling="no" frameborder="0" src="http://report.psi.m-hasan.my.id">Loading</iframe>
    <script type="text/javascript">
        (function() {
            // your page initialization code here
            // the DOM will be available here
            var iFrameID = document.getElementById('idIframe');
            var loading = document.getElementById('loading');
            if(iFrameID) {
                iFrameID.height = "0";
            }

            window.addEventListener('message', function(event) {

                // IMPORTANT: Check the origin of the data!
                if (~event.origin.indexOf('http://report.psi.m-hasan.my.id')) {
                    // The data has been sent from your site
                    if(iFrameID) {
                        iFrameID.height = event.data + "px";
                        loading.style.display = 'none';
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
