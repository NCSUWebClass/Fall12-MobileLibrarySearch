    <!--Footer Displaying results and pages statictis-->
    <div id="scroll-top"><a href="#" onclick="javascript:window.scrollTo(0,0); return false;"><img src="../lib/images/up.png" /></a></div>
    <div id="footer" data-role="footer">
        <style type="text/css">	
            #footer{
                position:fixed;
                left:0px;
                bottom:0px;
                height:30px;
                width:100%;
                background: none;
                clear: both;
                padding: 0 0 0px;
            }
        </style>
    <img src="../lib/images/library-logo-subpage-red.png" class="subpageLogo" alt="NCSU Libraries Logo">
    <?php echo '<p style="text-align:center;font-size: 0.9em;color:#B80000">
    <span id="results-display">Results: 1 to <span id="num-items">' . $loadedResults . '</span> of ' . $totalResults . ' results</span></p>';?>
    </div><!-- /footer -->