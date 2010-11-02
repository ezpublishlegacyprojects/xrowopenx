<?php

/*
 * Some xrowopenxServerFunctions
 */

class xrowopenxServerFunctions extends ezjscServerFunctions
{
    /**
     * Generates the JavaScript needed to add the adserverbannerzones
     *
     * @param array $args
     * @return string JavaScript OA_zones...
     */
    public static function oa_zones()
    {
        $xrowopenxIni = eZINI::instance( 'xrowopenx.ini' );
        $serverURL = eZSys::serverURL();
        $adserverDomain = $xrowopenxIni->variable( 'AdserverSettings', 'AdserverURL' );

        // get the content of the spcjs.php (var OA_output = new Array(); OA_output['zone_5'] = ''; OA_output['zone_6'] = ''; OA_output['zone_7'] = ''; OA_output['zone_7'] += "<"+"!--Java....)
        $url = $adserverDomain . '/delivery/spcjs.php';
        if ( $xrowopenxIni->variable( 'AdserverSettings', 'SiteID' ) > 0 )
        {
            $url .= '?id=' . $xrowopenxIni->variable( 'AdserverSettings', 'SiteID' );
        }
        if ( function_exists( 'curl_init' ) )
        {
            $ch = curl_init();
            curl_setopt( $ch, CURLOPT_URL, $url );
            curl_setopt( $ch, CURLOPT_HEADER, 0 );
            curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
            curl_setopt( $ch, CURLOPT_TIMEOUT, 10 );

            $spcjsContent = curl_exec( $ch );

            $info = curl_getinfo( $ch );

            if ( $info['http_code'] != 200 )
            {
                $spcjsContent = false;
                eZDebug::writeError( "Adserver URL ($url) is not avialable ", __METHOD__ );
            }
            curl_close( $ch );
            eZDebug::writeDebug( "Adserver URL ($url) included", __METHOD__ );
        }
        else
        {
            $spcjsContent = file_get_contents( $url );
            eZDebug::writeDebug( "Adserver URL ($url) included", __METHOD__ );
        }
        // @see xrowopenxServerFunctions::swf Speed trick
        $spcjsContent = preg_replace( '/OA_fo\s*\+=.*fl\.js.*;/m', '', $spcjsContent );

        // get the banner ids
        $bannerZones = $xrowopenxIni->variable( 'AdserverSettings', 'BannerZones' );
        $index = 1;
        $bannerOAString = '';
        foreach ( $bannerZones as $bannerZone => $zoneid )
        {
            $bannerOAString .= "'" . $bannerZone . "'" . ' : ' . $zoneid;
            if ( count( $bannerZones ) > $index )
            {
                $bannerOAString .= ', ';
            }
            $index ++;
        }
        $return = '';
        if ( $xrowopenxIni->variable( 'AdserverSettings', 'SiteID' ) > 0 )
        {
            $return .= '// Using OpenX Website ID #' . $xrowopenxIni->variable( 'AdserverSettings', 'SiteID' ) . "\n";
        }
        $return .= "var OA_zones = {" . $bannerOAString . "};\n";
        $return .= $spcjsContent;
        return $return;
    }


    public static function swf()
    {
        $serverURL = eZSys::serverURL();
        $xrowopenxIni = eZINI::instance( 'xrowopenx.ini' );
        $adserverDomain = $xrowopenxIni->variable( 'AdserverSettings', 'AdserverURL' );
        // get the content of the fl.js
        $url = $adserverDomain . '/delivery/fl.js';
        if ( function_exists( 'curl_init' ) )
        {
            $ch = curl_init();
            curl_setopt( $ch, CURLOPT_URL, $url );
            curl_setopt( $ch, CURLOPT_HEADER, 0 );
            curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
            curl_setopt( $ch, CURLOPT_TIMEOUT, 10 );
            $flContent = curl_exec( $ch );
            $info = curl_getinfo( $ch );

            if ( $info['http_code'] != 200 )
            {
                $spcjsContent = false;
                eZDebug::writeError( "Adserver URL ($url) is not avialable ", __METHOD__ );
            }
            curl_close( $ch );
            eZDebug::writeDebug( "Adserver URL ($url) included", __METHOD__ );
        }
        else
        {
            $flContent = file_get_contents( $url );
            eZDebug::writeDebug( "Adserver URL ($url) included", __METHOD__ );
        }
        return $flContent;
    }
}

?>