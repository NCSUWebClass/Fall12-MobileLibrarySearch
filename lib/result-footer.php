    <!--Footer Displaying results and pages statictis-->
    <div id="footer" data-role="footer">
    <div id="scroll-top"><a href="#" onclick="javascript:window.scrollTo(0,0); return false;"><img src="../lib/images/up.png" /></a></div>
    <img src="../lib/images/library-logo-subpage.png" class="subpageLogo" alt="NCSU Libraries Logo">
    <?php echo '<p style="text-align:center;font-size: 0.9em;line-height: 1em;">
    <span style="text-align:center;font-size: 0.9em;line-height: 1em;">Results: 1 to ' . $loadedResults . ' of ' . $totalResults . ' results</span></p>';?>
    </div><!-- /footer -->