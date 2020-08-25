<div class="ColunaCentral">
    <!--  XXXXXXXXXXXXXX INDICES  XXXXXXXXXXX -->
    <div id="divIndice">
        <h2 class="titulo02">Apoio</h2>
        <script type="text/javascript">
            AC_FL_RunContent('codebase', 'http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,28,0', 'width', '220', 'height', '235', 'title', 'apoio', 'src', 'img/logo', 'quality', 'high', 'pluginspage', 'http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash', 'movie', 'img/logo'); //end AC code
        </script><noscript><object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,28,0" width="220" height="235" title="apoio">
            <param name="movie" value="img/logo.swf" />
            <param name="quality" value="high" />
            <embed src="img/logo.swf" quality="high" pluginspage="http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash" type="application/x-shockwave-flash" width="190" height="235"></embed>
        </object>
        </noscript>
    </div>
    <!-- XXXXXXXXXX  TOTAL XXXXXXXXXXXXXXX -->
    <div id="divTotal">
        <?php
        if (($login == "admin")) {
            $link["admin"] = 1;

            apresentaMenuAdmin($dd);
        }
        ?>
    </div>
</div>