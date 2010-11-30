<?php

class xrowOpenxAdOperator
{

    function xrowOpenxAdOperator()
    {
    }

    function operatorList()
    {
        return array( 
            'show_ad' 
        );
    }

    function namedParameterPerOperator()
    {
        return true;
    }

    function namedParameterList()
    {
        return array( 
            'show_ad' => array( 
                'type' => array( 
                    'type' => 'string' , 
                    'required' => true , 
                    'default' => '' 
                ) , 
                'position' => array( 
                    'type' => 'integer' , 
                    'required' => false , 
                    'default' => 3 
                ) ,
                'heading' => array( 
                    'type' => 'string' , 
                    'required' => false , 
                    'default' => '' 
                ) 
            ) 
        );
    }

    function modify( $tpl, $operatorName, $operatorParameters, &$rootNamespace, &$currentNamespace, &$operatorValue, &$namedParameters )
    {
        switch ( $operatorName )
        {
            case 'show_ad':
                {
                    
                    $xml = '<?xml version="1.0" encoding="UTF-8"?><body>' . $operatorValue . '</body>';
                    
                    $banner_type = $namedParameters['type'];
                    $doc = new DOMDocument( '1.0', 'UTF-8' );                

                    if ( $doc->loadXML( $xml ) )
                    {
                        
                        $div = $doc->createElement( 'div' );
                        $div->setAttribute( 'class', 'banner openxad ' . $banner_type );
                        $js = $doc->createElement( 'script' );
                        $js->setAttribute( 'type', 'text/javascript' );
                        $ad = $doc->createComment( "// <![CDATA[ \n OA_show('" . $banner_type . "'); \n // ]]> " );
                        $js->appendChild( $ad );
	                      if ( $namedParameters['heading'] )
	                        {
	                            $h = $doc->createElement( 'div' );
	                            $h->setAttribute( 'class', 'heading' );
	                            $h_text = $doc->createTextNode($namedParameters['heading']);
	                            $h->appendChild( $h_text );
	                            $div->appendChild( $h );
	                        }
                        $div->appendChild( $js );
                        
                        $findnode = $doc->getElementsByTagName( 'p' )->item( $namedParameters['position'] );
                        if ( $findnode )
                        {
                            $doc->documentElement->insertBefore( $div, $findnode );
                            $operatorValue = '';
                            foreach ( $doc->documentElement->childNodes as $node )
                            {
                                $operatorValue .= $doc->saveXML( $node );
                            }
                        }
                    }
                    else
                    {
                        eZDebug::writeError( 'Couldn`t load XML injecting AD "' . $namedParameters['type'] . '"', __METHOD__ );
                    }
                }
                break;
        }
    }
}

?>